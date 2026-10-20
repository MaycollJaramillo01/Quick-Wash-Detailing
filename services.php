<?php
@session_start();

require_once __DIR__ . '/text.php';

$page_name = $NavCopy['services'] ?? 'Services';
$PageTitle = ($NavCopy['services'] ?? 'Services') . ' | ' . ($Company ?? 'Familia Towing');

$PageDescription = trim((string) ($HomeServicesCopy['desc'] ?? ''));
if ($PageDescription === '') {
  $PageDescription = 'Garage door installation and repair, custom doors, retractable awnings, and motorized screens across Los Angeles and Orange County.';
}

$PageCanonical = rtrim((string) ($BaseURL ?? ''), '/') . '/services.php';
$BodyClass = 'services-home-page';

include __DIR__ . '/partials/service-home/setup.php';
include __DIR__ . '/header.php';
include __DIR__ . '/partials/service-home/styles.php';
include __DIR__ . '/partials/service-home/hero.php';
include __DIR__ . '/partials/service-home/categories.php';
include __DIR__ . '/partials/service-home/directory.php';
include __DIR__ . '/partials/service-home/cta.php';
include __DIR__ . '/partials/service-home/scripts.php';
include __DIR__ . '/footer.php';

