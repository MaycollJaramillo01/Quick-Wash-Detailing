<?php
// Mock local de FormSubmit para probar formularios sin mandar correos.
// php -S localhost:8099 tests/formsubmit-mock.php   (MOCK_FAIL=1 simula un formulario sin activar)
$body = file_get_contents('php://input');
file_put_contents(__DIR__ . '/received.log', json_encode([
  'time' => date('c'),
  'referer' => $_SERVER['HTTP_REFERER'] ?? '',
  'body' => json_decode($body, true),
], JSON_UNESCAPED_UNICODE) . "\n", FILE_APPEND);
header('Content-Type: application/json');
echo getenv('MOCK_FAIL') ? '{"success":"false","message":"This form needs Activation."}' : '{"success":"true","message":"The form was submitted successfully."}';
