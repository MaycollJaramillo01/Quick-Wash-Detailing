<?php
require_once __DIR__ . '/../text.php';

/*
  Captcha sin sesiones: en Vercel cada request puede caer en otra instancia,
  así que el código se guarda firmado (HMAC) en una cookie y se verifica con captchaValid().
  ponytail: el token se puede reutilizar hasta que expire (10 min); suficiente contra bots simples.
*/

function captchaSecret(): string
{
    return getenv('CAPTCHA_SECRET') ?: hash('sha256', __DIR__ . ($GLOBALS['Mail'] ?? ''));
}

function captchaSign(string $code, int $expires): string
{
    return hash_hmac('sha256', strtoupper($code) . '|' . $expires, captchaSecret());
}

function captchaValid(string $input): bool
{
    [$expires, $sig] = array_pad(explode('.', (string) ($_COOKIE['qw_captcha'] ?? ''), 2), 2, '');
    return ctype_digit($expires) && (int) $expires >= time()
        && hash_equals($sig, captchaSign(trim($input), (int) $expires));
}

// Solo se dibuja la imagen cuando se pide este archivo directamente.
if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') !== __FILE__) return;

$code = '';
$characters = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
for ($i = 0; $i < 5; $i++) {
    $code .= $characters[random_int(0, strlen($characters) - 1)];
}
$expires = time() + 600;
setcookie('qw_captcha', $expires . '.' . captchaSign($code, $expires), [
    'expires' => $expires,
    'path' => '/',
    'httponly' => true,
    'samesite' => 'Lax',
    'secure' => str_starts_with((string) ($BaseURL ?? ''), 'https://'),
]);

header('Content-Type: image/svg+xml');
header('Cache-Control: no-store, no-cache, must-revalidate');

$width = 150;
$height = 50;
$bgColor   = $BrandColors['neutral']  ?? '#F1F7FA';
$textColor = $BrandColors['primary']  ?? '#113A5A';
$lineColor = $BrandColors['accent']   ?? '#0CC0DF';
?>
<svg width="<?php echo $width; ?>" height="<?php echo $height; ?>" xmlns="http://www.w3.org/2000/svg">
  <rect width="100%" height="100%" fill="<?php echo $bgColor; ?>"/>
  <?php for ($i = 0; $i < 5; $i++): ?>
  <line x1="<?php echo random_int(0, $width); ?>" y1="<?php echo random_int(0, $height); ?>" x2="<?php echo random_int(0, $width); ?>" y2="<?php echo random_int(0, $height); ?>" stroke="<?php echo $lineColor; ?>" stroke-opacity="0.35" stroke-width="1" />
  <?php endfor; ?>
  <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" font-family="Arial, sans-serif" font-size="24" font-weight="bold" fill="<?php echo $textColor; ?>" letter-spacing="4"><?php echo $code; ?></text>
</svg>
