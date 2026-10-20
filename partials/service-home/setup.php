<?php
$serviceHomeCopy = (isset($HomeServicesCopy) && is_array($HomeServicesCopy)) ? $HomeServicesCopy : [];

$serviceHomeEyebrow = trim((string) ($serviceHomeCopy['eyebrow'] ?? ($NavCopy['services'] ?? 'Services')));
$serviceHomeTitle = trim((string) ($serviceHomeCopy['title'] ?? 'Built for Residential'));
$serviceHomeTitleStrong = trim((string) ($serviceHomeCopy['title_strong'] ?? 'and Commercial Properties'));
$serviceHomeDesc = trim((string) ($serviceHomeCopy['desc'] ?? ''));
$serviceHomeMoreTitle = trim((string) ($serviceHomeCopy['more_title'] ?? 'Need a Custom Scope?'));
$serviceHomeMoreDesc = trim((string) ($serviceHomeCopy['more_desc'] ?? 'Tell us your goals and we will provide a clear plan.'));
$serviceHomeMoreButton = trim((string) ($serviceHomeCopy['more_button'] ?? 'Request Free Estimate'));
$serviceHomeMoreHref = trim((string) ($serviceHomeCopy['more_href'] ?? 'contact.php'));
$serviceHomeLinkLabel = trim((string) ($serviceHomeCopy['link_label'] ?? 'View Service'));

$serviceHomeServicesMap = (isset($ServicesList) && is_array($ServicesList)) ? $ServicesList : [];
$serviceHomeServices = array_values($serviceHomeServicesMap);
usort($serviceHomeServices, static function ($a, $b) {
  return (int) ($a['id'] ?? 0) <=> (int) ($b['id'] ?? 0);
});

$serviceHomeServicesCount = count($serviceHomeServices);
$serviceHomeExperienceYears = max(1, (int) ($ExperienceYears ?? 0));
if ($serviceHomeExperienceYears <= 0) {
  $serviceHomeExperienceYears = max(1, (int) filter_var((string) ($Experience ?? '1'), FILTER_SANITIZE_NUMBER_INT));
}

$serviceHomeCoverage = trim((string) ($Coverage ?? 'Coverage within 80 miles.'));
$serviceHomeSchedule = trim((string) ($Schedule ?? 'Monday to Saturday'));
$serviceHomeLicense = trim((string) ($LicenseNote ?? 'Fully Insured & Licensed'));
$serviceHomeType = trim((string) ($TypeOfService ?? 'Residential and Commercial'));

$serviceHomePhoneMain = trim((string) ($Phone ?? ''));
$serviceHomePhoneMainRef = trim((string) ($PhoneRef ?? ''));
$serviceHomePhoneMainLabel = trim((string) ($PhoneName ?? 'English'));
$serviceHomePhoneAlt = trim((string) ($Phone2 ?? ''));
$serviceHomePhoneAltRef = trim((string) ($PhoneRef2 ?? ''));
$serviceHomePhoneAltLabel = trim((string) ($Phone2Name ?? 'Spanish'));
$serviceHomeWhatsapp = trim((string) ($whatsapp ?? ''));

if (!function_exists('serviceHomeSlugify')) {
  function serviceHomeSlugify($text)
  {
    $text = trim((string) $text);
    if ($text === '') return 'service';
    if (function_exists('slugify')) return slugify($text);
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    $text = trim((string) $text, '-');
    return $text !== '' ? $text : 'service';
  }
}

if (!function_exists('serviceHomeFilterKey')) {
  function serviceHomeFilterKey($label)
  {
    $label = trim((string) $label);
    if ($label === '') return 'general-services';
    return serviceHomeSlugify($label);
  }
}

if (!function_exists('serviceHomeIcon')) {
  function serviceHomeIcon($slug)
  {
    $icons = [
      'full-detail-sedans' => 'fa-solid fa-car-side',
      'full-detail-suvs' => 'fa-solid fa-car',
      'full-detail-trucks-pickups' => 'fa-solid fa-truck-pickup',
      'interior-detail' => 'fa-solid fa-spray-can-sparkles'
    ];

    $slug = trim((string) $slug);
    return $icons[$slug] ?? 'fa-solid fa-car';
  }
}

if (!function_exists('serviceHomeImage')) {
  function serviceHomeImage(array $service)
  {
    $slug = trim((string) ($service['slug'] ?? ''));
    $serviceId = (int) ($service['id'] ?? 0);
    $serviceName = trim((string) ($service['name'] ?? ''));
    $categorySlug = trim((string) ($service['category_slug'] ?? ''));

    $sources = [
      ['rel' => 'assets/img/services', 'abs' => __DIR__ . '/../../assets/img/services'],
      ['rel' => 'assets/img/gallery/services', 'abs' => __DIR__ . '/../../assets/img/gallery/services'],
      ['rel' => 'assets/img/gallery', 'abs' => __DIR__ . '/../../assets/img/gallery'],
      ['rel' => 'assets/img/service', 'abs' => __DIR__ . '/../../assets/img/service']
    ];
    $exts = ['png', 'jpg', 'jpeg', 'webp', 'avif'];

    $aliasMap = [
      'local-towing' => ['towing', 'tow-truck'],
      'long-distance-towing' => ['long-distance-tow', 'vehicle-transport'],
      'we-buy-junk-cars' => ['junk-cars', 'junk-car-removal'],
      'jump-start-vehicles' => ['jump-start', 'battery-jump'],
      'locked-car-services' => ['lockout', 'car-lockout'],
      'roadside-assistance' => ['roadside-help'],
      '24-hour-towing' => ['emergency-towing', '24-hour-service']
    ];

    $labels = [];
    if ($serviceName !== '') $labels[] = $serviceName;
    if ($slug !== '') {
      $labels[] = str_replace('-', ' ', $slug);
      $labels[] = ucwords(str_replace('-', ' ', $slug));
      $labels[] = str_replace('-', '_', $slug);
    }

    $slugTargets = [];
    if ($slug !== '') $slugTargets[] = $slug;
    if ($serviceName !== '') $slugTargets[] = serviceHomeSlugify($serviceName);
    if (isset($aliasMap[$slug])) {
      foreach ($aliasMap[$slug] as $alias) $slugTargets[] = trim((string) $alias);
    }
    $slugTargets = array_values(array_unique(array_filter($slugTargets)));

    $candidates = [];
    if ($categorySlug !== '' && $slug !== '') {
      foreach ($exts as $ext) $candidates[] = $categorySlug . '/' . $slug . '.' . $ext;
    }
    if ($slug !== '') {
      foreach ($exts as $ext) $candidates[] = $slug . '.' . $ext;
    }
    foreach ($labels as $label) {
      $label = trim((string) $label);
      if ($label === '') continue;
      foreach ($exts as $ext) $candidates[] = $label . '.' . $ext;
    }
    if (isset($aliasMap[$slug])) {
      foreach ($aliasMap[$slug] as $alias) {
        foreach ($exts as $ext) $candidates[] = $alias . '.' . $ext;
      }
    }
    if ($serviceId > 0) {
      foreach ($exts as $ext) $candidates[] = $serviceId . '.' . $ext;
    }
    $candidates = array_values(array_unique($candidates));

    foreach ($sources as $source) {
      foreach ($candidates as $candidate) {
        $abs = $source['abs'] . '/' . $candidate;
        if (!is_file($abs)) continue;
        $version = (string) @filemtime($abs);
        if ($version === '' || $version === '0') return $source['rel'] . '/' . $candidate;
        return $source['rel'] . '/' . $candidate . '?v=' . $version;
      }
    }

    if (!empty($slugTargets)) {
      foreach ($sources as $source) {
        if (!is_dir($source['abs'])) continue;

        $root = realpath($source['abs']);
        if ($root === false) continue;
        $rootNorm = rtrim(str_replace('\\', '/', $root), '/');

        try {
          $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rootNorm, FilesystemIterator::SKIP_DOTS)
          );
        } catch (Throwable $e) {
          continue;
        }

        foreach ($iterator as $fileInfo) {
          if (!$fileInfo->isFile()) continue;
          $ext = strtolower((string) $fileInfo->getExtension());
          if (!in_array($ext, $exts, true)) continue;

          $baseName = (string) $fileInfo->getBasename('.' . $fileInfo->getExtension());
          $normalized = serviceHomeSlugify($baseName);
          if (!in_array($normalized, $slugTargets, true)) continue;

          $fullPath = str_replace('\\', '/', $fileInfo->getPathname());
          $rel = ltrim(substr($fullPath, strlen($rootNorm)), '/');
          if ($rel === '') continue;

          $version = (string) @filemtime($fileInfo->getPathname());
          $url = $source['rel'] . '/' . $rel;
          if ($version === '' || $version === '0') return $url;
          return $url . '?v=' . $version;
        }
      }
    }

    return 'assets/img/fallback.jpg';
  }
}

$serviceHomeFilterOptions = [
  ['key' => 'all', 'label' => 'All Services', 'count' => $serviceHomeServicesCount]
];
$serviceHomeFilterLookup = ['all' => 0];

foreach ($serviceHomeServices as &$service) {
  $slug = trim((string) ($service['slug'] ?? ''));
  $name = trim((string) ($service['name'] ?? 'Service'));
  $desc = trim((string) (($service['description'] ?? '') !== '' ? $service['description'] : ($service['excerpt'] ?? '')));

  if ($desc === '' && !empty($ServiceDetails[$slug]['paragraphs'][0])) {
    $desc = trim((string) $ServiceDetails[$slug]['paragraphs'][0]);
  }

  $group = trim((string) ($service['category_label'] ?? 'General Services'));
  if ($group === '' || strcasecmp($group, 'general') === 0) $group = 'General Services';
  $groupKey = serviceHomeFilterKey($group);

  $bullets = [];
  if (!empty($ServiceDetails[$slug]['bullets']) && is_array($ServiceDetails[$slug]['bullets'])) {
    $bullets = array_slice($ServiceDetails[$slug]['bullets'], 0, 3);
  }
  if (empty($bullets)) {
    $bullets = [
      'Licensed and insured execution',
      'Clear scope and timeline planning',
      'Final quality walkthrough'
    ];
  }

  $searchIndex = strtolower($name . ' ' . $desc . ' ' . $group . ' ' . $slug . ' ' . implode(' ', $bullets));
  $serviceCode = 'SVC-' . str_pad((string) max(1, (int) ($service['id'] ?? 0)), 2, '0', STR_PAD_LEFT);

  $service['ui_group'] = $group;
  $service['ui_group_key'] = $groupKey;
  $service['ui_icon'] = serviceHomeIcon($slug);
  $service['ui_image'] = serviceHomeImage($service);
  $service['ui_bullets'] = $bullets;
  $service['ui_desc'] = $desc;
  $service['ui_code'] = $serviceCode;
  $service['ui_search'] = $searchIndex;
  $service['ui_href'] = 'contact.php?service=' . rawurlencode($name);
  $service['ui_hash'] = $slug !== '' ? $slug : serviceHomeSlugify($name);

  if (!isset($serviceHomeFilterLookup[$groupKey])) {
    $serviceHomeFilterLookup[$groupKey] = count($serviceHomeFilterOptions);
    $serviceHomeFilterOptions[] = ['key' => $groupKey, 'label' => $group, 'count' => 0];
  }
  $idx = (int) $serviceHomeFilterLookup[$groupKey];
  $serviceHomeFilterOptions[$idx]['count'] = (int) ($serviceHomeFilterOptions[$idx]['count'] ?? 0) + 1;
}
unset($service);

$serviceHomeCategoryPanels = [];
if (!empty($ServicesByCategory) && is_array($ServicesByCategory)) {
  foreach ($ServicesByCategory as $category) {
    if (!is_array($category)) continue;

    $label = trim((string) ($category['label'] ?? 'Service Group'));
    if ($label === '') continue;

    $panelId = 'group-' . serviceHomeFilterKey($label);
    $summarySlug = trim((string) ($category['summary_slug'] ?? ''));
    $summary = '';
    if ($summarySlug !== '' && isset($serviceHomeServicesMap[$summarySlug])) {
      $summaryService = $serviceHomeServicesMap[$summarySlug];
      $summary = trim((string) (($summaryService['description'] ?? '') !== '' ? $summaryService['description'] : ($summaryService['excerpt'] ?? '')));
    }
    if ($summary === '') $summary = $serviceHomeDesc;

    $items = [];
    $serviceSlugs = $category['service_slugs'] ?? [];
    if (is_array($serviceSlugs)) {
      foreach ($serviceSlugs as $serviceSlug) {
        $serviceSlug = trim((string) $serviceSlug);
        if ($serviceSlug === '' || !isset($serviceHomeServicesMap[$serviceSlug])) continue;
        $serviceData = $serviceHomeServicesMap[$serviceSlug];
        $serviceName = trim((string) ($serviceData['name'] ?? 'Service'));
        $items[] = [
          'slug' => $serviceSlug,
          'name' => $serviceName,
          'href' => '#' . $serviceSlug
        ];
      }
    }

    if (empty($items)) continue;

    $serviceHomeCategoryPanels[] = [
      'id' => $panelId,
      'label' => $label,
      'summary' => $summary,
      'items' => $items
    ];
  }
}

if (empty($serviceHomeCategoryPanels) && !empty($serviceHomeServices)) {
  $fallbackItems = [];
  foreach ($serviceHomeServices as $service) {
    $fallbackItems[] = [
      'slug' => trim((string) ($service['ui_hash'] ?? '')),
      'name' => trim((string) ($service['name'] ?? 'Service')),
      'href' => '#' . trim((string) ($service['ui_hash'] ?? ''))
    ];
  }

  $serviceHomeCategoryPanels[] = [
    'id' => 'group-all-services',
    'label' => 'All Services',
    'summary' => $serviceHomeDesc,
    'items' => $fallbackItems
  ];
}

