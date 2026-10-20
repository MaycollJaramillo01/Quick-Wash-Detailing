<?php
/*
  Envío de formularios por FormSubmit (https://formsubmit.co).
  PHP mail() no funciona en Vercel, así que el servidor reenvía los datos a FormSubmit,
  que los entrega por correo a $Mail.

  - La PRIMERA vez que se usa, FormSubmit manda un correo "Activate Form" a $Mail.
    Hasta que el cliente haga clic en "Activate", los envíos devuelven error.
  - Después de activar, FormSubmit da un alias aleatorio: se puede poner en la variable
    de entorno FORM_ENDPOINT (https://formsubmit.co/ajax/<alias>) para no exponer el correo.
*/

function formEndpoint(): string
{
    global $Mail;
    return getenv('FORM_ENDPOINT') ?: 'https://formsubmit.co/ajax/' . rawurlencode((string) $Mail);
}

/** Envía $fields por correo. Devuelve true solo si FormSubmit confirma el envío. */
function sendFormEmail(array $fields, string $subject): bool
{
    global $BaseURL, $Company;

    $payload = $fields + [
        '_subject' => $subject,
        '_template' => 'table',
        '_captcha' => 'false',
    ];
    if (!empty($fields['email'])) $payload['_replyto'] = $fields['email'];

    $ch = curl_init(formEndpoint());
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 15,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Accept: application/json',
            // FormSubmit asocia el formulario al sitio por Referer/Origin.
            'Referer: ' . $BaseURL,
            'Origin: ' . rtrim((string) $BaseURL, '/'),
        ],
        CURLOPT_USERAGENT => ($Company ?? 'Website') . ' contact form',
    ]);
    $response = curl_exec($ch);
    $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    $json = is_string($response) ? json_decode($response, true) : null;
    $ok = $status === 200 && is_array($json) && in_array($json['success'] ?? null, [true, 'true'], true);
    if (!$ok) {
        error_log('[form] send failed: HTTP ' . $status . ' ' . ($curlError ?: (string) $response));
    }
    return $ok;
}

/** Normaliza texto de un campo de formulario (sin etiquetas, recortado). */
function formField(string $key, int $max = 200): string
{
    $value = trim(strip_tags((string) ($_POST[$key] ?? '')));
    return mb_substr($value, 0, $max);
}
