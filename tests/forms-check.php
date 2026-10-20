<?php
/*
  Verificación de formularios (cotización + reseñas) contra un servidor corriendo.
  Uso:  php tests/forms-check.php http://localhost:8000
  Para no mandar correos reales, levantar el sitio con FORM_ENDPOINT apuntando a un mock
  que responda {"success":"true"} (ver .claude/launch.json).
*/
$base = rtrim($argv[1] ?? 'http://localhost:8000', '/');
$jar = tempnam(sys_get_temp_dir(), 'qw');
$fails = 0;

function req(string $url, ?array $post = null): array
{
    global $jar;
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_COOKIEJAR => $jar,
        CURLOPT_COOKIEFILE => $jar,
        CURLOPT_HEADER => false,
    ]);
    if ($post !== null) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
    }
    $body = (string) curl_exec($ch);
    $location = (string) curl_getinfo($ch, CURLINFO_REDIRECT_URL);
    curl_close($ch);
    return [$body, $location];
}

function check(string $label, string $location, string $expected): void
{
    global $fails;
    $ok = str_contains($location, $expected);
    if (!$ok) $fails++;
    echo ($ok ? 'PASS' : 'FAIL') . "  $label -> " . ($location ?: '(no redirect)') . "\n";
}

$quote = ['name' => 'Forms Check', 'phone' => '(914) 555-0123', 'email' => 'check@example.com',
          'service' => 'Full Detail – SUVs', 'vehicle' => 'SUV', 'message' => 'Automated check – ñ'];

check('quote valid', req("$base/send-mail.php", $quote)[1], 'thank-you');
check('quote no phone', req("$base/send-mail.php", ['phone' => ''] + $quote)[1], 'error=required');
check('quote bad email', req("$base/send-mail.php", ['email' => 'nope'] + $quote)[1], 'error=required');
check('quote fake service', req("$base/send-mail.php", ['service' => 'Hack'] + $quote)[1], 'error=required');
check('quote honeypot', req("$base/send-mail.php", ['honeypot' => 'x'] + $quote)[1], 'thank-you');

[$svg] = req("$base/utils/captcha.php");
preg_match('/<text[^>]*>\s*([A-Z0-9]{5})\s*</', $svg, $m);
$code = $m[1] ?? '';
$review = ['name' => 'Forms Check', 'city' => 'New Rochelle, NY', 'stars' => '5', 'text' => 'Automated review check'];
check('captcha image has code', $code !== '' ? 'code' : '', 'code');
check('review wrong captcha', req("$base/reviews.php", ['captcha' => 'ZZZZZ'] + $review)[1], 'error=captcha');
check('review missing text', req("$base/reviews.php", ['captcha' => $code, 'text' => ''] + $review)[1], 'error=required');
check('review valid', req("$base/reviews.php", ['captcha' => strtolower($code)] + $review)[1], 'success=1');

[$page] = req("$base/contact.php?error=required");
check('contact shows error alert', str_contains($page, 'ct-alert') ? 'alert' : '', 'alert');
[$page] = req("$base/contact.php?service=" . rawurlencode('Interior Detail'));
check('contact preselects service', preg_match('/value="Interior Detail" selected/', $page) ? 'selected' : '', 'selected');

@unlink($jar);
echo $fails === 0 ? "\nAll form checks passed.\n" : "\n$fails check(s) failed.\n";
exit($fails === 0 ? 0 : 1);
