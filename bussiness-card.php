<?php
$query = $_SERVER['QUERY_STRING'] ?? '';
$target = 'business-card.php' . ($query !== '' ? ('?' . $query) : '');
header('Location: ' . $target, true, 301);
exit;
