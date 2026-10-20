<?php
$slug = trim((string) ($CurrentServiceSlug ?? ($_GET['service'] ?? '')));
$slug = strtolower($slug);
$slug = preg_replace('/[^a-z0-9-]/', '', $slug);

$target = 'services.php';
if ($slug !== '') {
  $target .= '#' . $slug;
}

header('Location: ' . $target, true, 301);
exit;
