<?php
declare(strict_types=1);

$publicPhpRoutes = [
    'index.php',
    'about.php',
    'services.php',
    'service-page.php',
    'other-services.php',
    'projects.php',
    'reviews.php',
    'testimonials.php',
    'contact.php',
    'send-mail.php',
    'thank-you.php',
    'business-card.php',
    'bussiness-card.php',
    'utils/captcha.php',
];

$requestUri = (string)($_SERVER['REQUEST_URI'] ?? '/');
$path = parse_url($requestUri, PHP_URL_PATH);
$path = is_string($path) ? $path : '/';
$path = '/' . ltrim($path, '/');
$requested = trim($path, '/');

// php -S localhost:8000 api/router.php: let the built-in server serve assets (Vercel does it via vercel.json).
if (PHP_SAPI === 'cli-server' && !str_contains($requested, '..') && preg_match('#^(assets|data)/#', $requested) && is_file(dirname(__DIR__) . '/' . $requested)) {
    return false;
}

if ($requested === '') {
    $requested = 'index.php';
}

$requested = str_replace('\\', '/', $requested);
$requested = preg_replace('#/+#', '/', $requested) ?? $requested;

if (!str_contains($requested, '.')) {
    $extensionless = $requested . '.php';
    if (in_array($extensionless, $publicPhpRoutes, true)) {
        $requested = $extensionless;
    }
}

if (!in_array($requested, $publicPhpRoutes, true)) {
    http_response_code(404);
    header('Content-Type: text/plain; charset=UTF-8');
    echo 'Not Found';
    exit;
}

$projectRoot = dirname(__DIR__);
$targetFile = $projectRoot . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $requested);

if (!is_file($targetFile)) {
    http_response_code(500);
    header('Content-Type: text/plain; charset=UTF-8');
    echo 'Invalid route target';
    exit;
}

chdir($projectRoot);
$_SERVER['SCRIPT_NAME'] = '/' . $requested;
$_SERVER['PHP_SELF'] = '/' . $requested;
$_SERVER['SCRIPT_FILENAME'] = $targetFile;

require $targetFile;
