<?php
/*
  Servidor SMTP falso para probar los formularios sin mandar correos reales.
  php tests/smtp-mock.php            -> escucha en 127.0.0.1:2525 y guarda cada correo en tests/received.log
  MOCK_FAIL=1 php tests/smtp-mock.php -> rechaza el login (simula contraseña incorrecta)
  El sitio debe correr con SMTP_HOST=127.0.0.1 SMTP_PORT=2525 SMTP_PASS=<cualquier valor de prueba>.
*/
$server = stream_socket_server('tcp://127.0.0.1:' . (getenv('MOCK_PORT') ?: 2525), $errno, $errstr);
if (!$server) exit("Cannot listen: $errstr\n");
echo 'SMTP mock on 127.0.0.1:' . (getenv('MOCK_PORT') ?: 2525) . "\n";

while ($conn = stream_socket_accept($server, -1)) {
    $say = fn(string $line) => fwrite($conn, $line . "\r\n");
    $say('220 smtp-mock ESMTP');
    $authStep = 0;
    $mail = ['from' => '', 'to' => []];
    while (($line = fgets($conn)) !== false) {
        $line = rtrim($line, "\r\n");
        if ($authStep === 1) { $mail['user'] = base64_decode($line); $authStep = 2; $say('334 UGFzc3dvcmQ6'); continue; }
        if ($authStep === 2) { $authStep = 0; $say(getenv('MOCK_FAIL') ? '535 5.7.8 Bad credentials' : '235 2.7.0 Accepted'); continue; }
        $cmd = strtoupper(substr($line, 0, 4));
        if ($cmd === 'EHLO' || $cmd === 'HELO') { $say('250-smtp-mock'); $say('250 AUTH LOGIN'); }
        elseif ($line === 'AUTH LOGIN') { $authStep = 1; $say('334 VXNlcm5hbWU6'); }
        elseif ($cmd === 'MAIL') { $mail['from'] = $line; $say('250 OK'); }
        elseif ($cmd === 'RCPT') { $mail['to'][] = $line; $say('250 OK'); }
        elseif ($cmd === 'DATA') {
            $say('354 End data with <CR><LF>.<CR><LF>');
            $data = '';
            while (($l = fgets($conn)) !== false && rtrim($l, "\r\n") !== '.') $data .= $l;
            [$head, $body] = array_pad(explode("\r\n\r\n", $data, 2), 2, '');
            $headers = [];
            foreach (explode("\r\n", $head) as $h) {
                [$k, $v] = array_pad(explode(':', $h, 2), 2, '');
                $headers[strtolower(trim($k))] = iconv_mime_decode(trim($v), 0, 'UTF-8');
            }
            file_put_contents(__DIR__ . '/received.log', json_encode([
                'time' => date('c'),
                'envelope' => $mail,
                'subject' => $headers['subject'] ?? '',
                'from' => $headers['from'] ?? '',
                'reply_to' => $headers['reply-to'] ?? '',
                'body' => base64_decode(str_replace("\r\n", '', $body)),
            ], JSON_UNESCAPED_UNICODE) . "\n", FILE_APPEND);
            $say('250 OK queued');
        }
        elseif ($cmd === 'QUIT') { $say('221 Bye'); break; }
        else { $say('250 OK'); }
    }
    fclose($conn);
}
