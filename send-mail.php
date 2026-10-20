<?php
require_once __DIR__ . '/text.php';
require_once __DIR__ . '/utils/mailer.php';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    header('Location: contact.php');
    exit;
}

// Bots llenan el campo oculto: se les responde como si todo saliera bien.
if (!empty($_POST['honeypot'])) {
    header('Location: thank-you.php');
    exit;
}

$name    = formField('name', 100);
$phone   = formField('phone', 30);
$email   = formField('email', 150);
$service = formField('service', 100);
$vehicle = formField('vehicle', 50);
$message = formField('message', 2000);

$phoneDigits = preg_replace('/\D+/', '', $phone);
$validServices = array_merge(array_column($ServicesDisplayList, 'name'), ['Other', '']);
$validVehicles = array_merge($ContactFormCopy['vehicles'] ?? [], ['']);

$valid = $name !== ''
    && strlen($phoneDigits) >= 10 && strlen($phoneDigits) <= 15
    && ($email === '' || filter_var($email, FILTER_VALIDATE_EMAIL))
    && in_array($service, $validServices, true)
    && in_array($vehicle, $validVehicles, true);

if (!$valid) {
    header('Location: contact.php?error=required#contact');
    exit;
}

$sent = sendFormEmail([
    'name' => $name,
    'phone' => $phone,
    'email' => $email,
    'service' => $service !== '' ? $service : 'Not specified',
    'vehicle' => $vehicle !== '' ? $vehicle : 'Not specified',
    'message' => $message,
    'page' => (string) ($_SERVER['HTTP_REFERER'] ?? ''),
], 'New Quote Request - ' . $Company . ' - ' . $name);

header('Location: ' . ($sent ? 'thank-you.php' : 'contact.php?error=send#contact'));
exit;
