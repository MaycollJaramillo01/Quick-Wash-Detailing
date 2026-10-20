<?php
/*
  Envío de formularios por SMTP directo (sin mail() y sin servicios de terceros).
  PHP mail() no funciona en Vercel, así que el sitio inicia sesión en el servidor SMTP
  configurado (SMTP_USER) y envía cada formulario a MAIL_TO.

  Variables de entorno (Vercel → Project → Settings → Environment Variables):
    SMTP_HOST      servidor SMTP (ej. smtp.office365.com; por defecto smtp.gmail.com)
    SMTP_PORT      465 = TLS directo; 587 = STARTTLS (por defecto 465)
    SMTP_USER      cuenta que inicia sesión y envía (por defecto $Mail)
    SMTP_PASSWORD  (obligatoria) contraseña de esa cuenta. Nunca se guarda en el repo.
    MAIL_TO        quién recibe los formularios (por defecto $Mail)
*/

function smtpConfig(): array
{
    global $Mail;
    return [
        'host' => getenv('SMTP_HOST') ?: 'smtp.gmail.com',
        'port' => (int) (getenv('SMTP_PORT') ?: 465),
        'user' => getenv('SMTP_USER') ?: (string) $Mail,
        'pass' => (string) getenv('SMTP_PASSWORD'),
        'to'   => getenv('MAIL_TO') ?: (string) $Mail,
    ];
}

/** Lee una respuesta SMTP (posiblemente multilínea) y verifica el código esperado. */
function smtpExpect($fp, string $code): string
{
    $reply = '';
    while (($line = fgets($fp, 1024)) !== false) {
        $reply .= $line;
        if (strlen($line) < 4 || $line[3] !== '-') break;
    }
    if (strncmp($reply, $code, 3) !== 0) {
        throw new RuntimeException('SMTP expected ' . $code . ', got: ' . trim($reply));
    }
    return $reply;
}

function smtpSend($fp, string $command, string $code): string
{
    fwrite($fp, $command . "\r\n");
    return smtpExpect($fp, $code);
}

/** Codifica un encabezado con UTF-8 y quita saltos de línea (evita inyección de encabezados). */
function mimeHeader(string $value): string
{
    return '=?UTF-8?B?' . base64_encode(str_replace(["\r", "\n"], ' ', $value)) . '?=';
}

/** Envía $fields por correo. Devuelve true solo si el servidor SMTP aceptó el mensaje. */
function sendFormEmail(array $fields, string $subject): bool
{
    global $Company;
    $cfg = smtpConfig();
    if ($cfg['pass'] === '') {
        error_log('[form] SMTP_PASSWORD is not set; message not sent.');
        return false;
    }

    $lines = [];
    foreach ($fields as $label => $value) {
        $lines[] = ucfirst((string) $label) . ': ' . (string) $value;
    }
    $replyTo = filter_var($fields['email'] ?? '', FILTER_VALIDATE_EMAIL) ?: '';
    $headers = [
        'Date: ' . date(DATE_RFC2822),
        'From: ' . mimeHeader(($Company ?? 'Website') . ' Website') . ' <' . $cfg['user'] . '>',
        'To: <' . $cfg['to'] . '>',
        'Subject: ' . mimeHeader($subject),
        'Message-ID: <' . bin2hex(random_bytes(12)) . '@' . (parse_url((string) ($GLOBALS['BaseURL'] ?? ''), PHP_URL_HOST) ?: 'localhost') . '>',
        'MIME-Version: 1.0',
        'Content-Type: text/plain; charset=UTF-8',
        'Content-Transfer-Encoding: base64',
    ];
    if ($replyTo !== '') $headers[] = 'Reply-To: <' . $replyTo . '>';
    // Cuerpo en base64: no hay líneas que empiecen con "." ni problemas de acentos.
    $message = implode("\r\n", $headers) . "\r\n\r\n" . chunk_split(base64_encode(implode("\n", $lines)), 76, "\r\n");

    $tls = $cfg['port'] === 465;
    $fp = @stream_socket_client(($tls ? 'ssl://' : 'tcp://') . $cfg['host'] . ':' . $cfg['port'], $errno, $errstr, 15);
    if (!$fp) {
        error_log('[form] SMTP connect failed: ' . $errno . ' ' . $errstr);
        return false;
    }
    stream_set_timeout($fp, 15);

    try {
        $ehlo = 'EHLO ' . (gethostname() ?: 'localhost');
        smtpExpect($fp, '220');
        $caps = smtpSend($fp, $ehlo, '250');
        if (!$tls && stripos($caps, 'STARTTLS') !== false) {
            smtpSend($fp, 'STARTTLS', '220');
            if (!stream_socket_enable_crypto($fp, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                throw new RuntimeException('STARTTLS negotiation failed');
            }
            smtpSend($fp, $ehlo, '250');
        }
        smtpSend($fp, 'AUTH LOGIN', '334');
        smtpSend($fp, base64_encode($cfg['user']), '334');
        smtpSend($fp, base64_encode($cfg['pass']), '235');
        smtpSend($fp, 'MAIL FROM:<' . $cfg['user'] . '>', '250');
        smtpSend($fp, 'RCPT TO:<' . $cfg['to'] . '>', '250');
        smtpSend($fp, 'DATA', '354');
        smtpSend($fp, $message . "\r\n.", '250');
        fwrite($fp, "QUIT\r\n"); // el mensaje ya fue aceptado; la respuesta a QUIT no importa
        return true;
    } catch (Throwable $e) {
        error_log('[form] ' . $e->getMessage());
        return false;
    } finally {
        fclose($fp);
    }
}

/** Normaliza texto de un campo de formulario (sin etiquetas, recortado). */
function formField(string $key, int $max = 200): string
{
    $value = trim(strip_tags((string) ($_POST[$key] ?? '')));
    return mb_substr($value, 0, $max);
}
