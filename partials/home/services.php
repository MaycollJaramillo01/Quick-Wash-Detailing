<?php
$sectionEyebrow = trim((string) ($HomeServicesCopy['eyebrow'] ?? 'Our Services'));
$sectionTitle = trim((string) ($HomeServicesCopy['title'] ?? 'Remodeling Services'));
$sectionTitleStrong = trim((string) ($HomeServicesCopy['title_strong'] ?? 'For Homes and Businesses'));
$sectionDesc = trim((string) ($HomeServicesCopy['desc'] ?? ''));
$sectionLinkLabel = trim((string) ($HomeServicesCopy['link_label'] ?? 'View Service'));
$moreTitle = trim((string) ($HomeServicesCopy['more_title'] ?? 'Need a Custom Scope?'));
$moreDesc = trim((string) ($HomeServicesCopy['more_desc'] ?? 'Tell us your project goals and we will prepare a clear plan.'));
$moreButton = trim((string) ($HomeServicesCopy['more_button'] ?? 'Request Free Estimate'));
$moreHref = trim((string) ($HomeServicesCopy['more_href'] ?? 'contact.php'));

$servicesMap = (isset($ServicesList) && is_array($ServicesList)) ? $ServicesList : [];
$servicesDisplay = (!empty($ServicesDisplayList) && is_array($ServicesDisplayList))
  ? $ServicesDisplayList
  : array_values($servicesMap);
$categoryConfig = (isset($ServicesByCategory) && is_array($ServicesByCategory)) ? $ServicesByCategory : [];

if (empty($categoryConfig)) {
  $categoryConfig = [
    [
      'label' => 'Core Services',
      'summary_slug' => 'local-towing',
      'service_slugs' => ['local-towing', 'long-distance-towing', 'we-buy-junk-cars', 'jump-start-vehicles', 'locked-car-services']
    ],
    [
      'label' => 'Other Services',
      'summary_slug' => 'other-services',
      'service_slugs' => ['roadside-assistance', '24-hour-towing']
    ]
  ];
}

if (!function_exists('homeServicesMinimalSlugify')) {
  function homeServicesMinimalSlugify($text)
  {
    $text = strtolower(trim((string) $text));
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    $text = trim((string) $text, '-');
    return $text !== '' ? $text : 'service';
  }
}

if (!function_exists('homeServicesMinimalImage')) {
  function homeServicesMinimalImage($serviceSlug, $serviceId, $categorySlug, $serviceName = '')
  {
    $serviceSlug = trim((string) $serviceSlug);
    $categorySlug = trim((string) $categorySlug);
    $serviceId = (int) $serviceId;
    $serviceName = trim((string) $serviceName);

    $baseDirs = [
      [
        'rel' => 'assets/img/services',
        'abs' => __DIR__ . '/../../assets/img/services'
      ],
      [
        'rel' => 'assets/img/gallery/services',
        'abs' => __DIR__ . '/../../assets/img/gallery/services'
      ],
      [
        'rel' => 'assets/img/gallery',
        'abs' => __DIR__ . '/../../assets/img/gallery'
      ],
      [
        'rel' => 'assets/img/service',
        'abs' => __DIR__ . '/../../assets/img/service'
      ]
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

    $labelCandidates = [];
    if ($serviceName !== '') $labelCandidates[] = $serviceName;
    if ($serviceSlug !== '') {
      $labelCandidates[] = str_replace('-', ' ', $serviceSlug);
      $labelCandidates[] = ucwords(str_replace('-', ' ', $serviceSlug));
      $labelCandidates[] = str_replace('-', '_', $serviceSlug);
    }

    $slugTargets = [];
    if ($serviceSlug !== '') $slugTargets[] = $serviceSlug;
    if ($serviceName !== '') $slugTargets[] = homeServicesMinimalSlugify($serviceName);
    if (isset($aliasMap[$serviceSlug])) {
      foreach ($aliasMap[$serviceSlug] as $aliasSlug) $slugTargets[] = trim((string) $aliasSlug);
    }
    $slugTargets = array_values(array_unique(array_filter($slugTargets)));

    $candidates = [];
    if ($categorySlug !== '' && $serviceSlug !== '') {
      foreach ($exts as $ext) $candidates[] = $categorySlug . '/' . $serviceSlug . '.' . $ext;
    }
    if ($serviceSlug !== '') {
      foreach ($exts as $ext) $candidates[] = $serviceSlug . '.' . $ext;
    }
    foreach ($labelCandidates as $label) {
      $label = trim((string) $label);
      if ($label === '') continue;
      foreach ($exts as $ext) $candidates[] = $label . '.' . $ext;
    }
    if (!empty($aliasMap[$serviceSlug])) {
      foreach ($aliasMap[$serviceSlug] as $aliasSlug) {
        $aliasSlug = trim((string) $aliasSlug);
        if ($aliasSlug === '') continue;
        foreach ($exts as $ext) $candidates[] = $aliasSlug . '.' . $ext;
      }
    }
    if ($serviceId > 0) {
      foreach ($exts as $ext) $candidates[] = $serviceId . '.' . $ext;
    }
    $candidates = array_values(array_unique($candidates));

    foreach ($baseDirs as $base) {
      foreach ($candidates as $candidate) {
        $abs = $base['abs'] . '/' . $candidate;
        if (is_file($abs)) {
          $version = (string) @filemtime($abs);
          if ($version === '' || $version === '0') return $base['rel'] . '/' . $candidate;
          return $base['rel'] . '/' . $candidate . '?v=' . $version;
        }
      }
    }

    // Final pass: match by normalized slug against any image file in each base dir.
    if (!empty($slugTargets)) {
      foreach ($baseDirs as $base) {
        if (!is_dir($base['abs'])) continue;

        $rootReal = realpath($base['abs']);
        if ($rootReal === false) continue;
        $root = rtrim(str_replace('\\', '/', $rootReal), '/');

        try {
          $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS)
          );
        } catch (Throwable $e) {
          continue;
        }

        foreach ($iterator as $fileInfo) {
          if (!$fileInfo->isFile()) continue;

          $ext = strtolower((string) $fileInfo->getExtension());
          if (!in_array($ext, $exts, true)) continue;

          $baseName = (string) $fileInfo->getBasename('.' . $fileInfo->getExtension());
          $normalized = homeServicesMinimalSlugify($baseName);
          if (!in_array($normalized, $slugTargets, true)) continue;

          $fileAbs = str_replace('\\', '/', $fileInfo->getPathname());
          $relative = ltrim(substr($fileAbs, strlen($root)), '/');
          if ($relative === '') continue;

          $version = (string) @filemtime($fileInfo->getPathname());
          $url = $base['rel'] . '/' . $relative;
          if ($version === '' || $version === '0') return $url;
          return $url . '?v=' . $version;
        }
      }
    }

    return 'assets/img/fallback.jpg';
  }
}

$categoryRows = [];
foreach ($categoryConfig as $category) {
  if (!is_array($category)) continue;

  $label = trim((string) ($category['label'] ?? 'Category'));
  if ($label === '') continue;

  $summarySlug = trim((string) ($category['summary_slug'] ?? ''));
  $categorySlug = $summarySlug !== '' ? $summarySlug : homeServicesMinimalSlugify($label);
  $summaryService = ($summarySlug !== '' && isset($servicesMap[$summarySlug])) ? $servicesMap[$summarySlug] : null;

  $items = [];
  $serviceSlugs = $category['service_slugs'] ?? [];
  if (is_array($serviceSlugs)) {
    foreach ($serviceSlugs as $slug) {
      $slug = trim((string) $slug);
      if ($slug === '' || !isset($servicesMap[$slug])) continue;
      $service = $servicesMap[$slug];
      $items[] = [
        'name' => trim((string) ($service['name'] ?? 'Service')),
        'url' => trim((string) ($service['url'] ?? 'services.php'))
      ];
    }
  }

  if (empty($items) && $summaryService) {
    $items[] = [
      'name' => trim((string) ($summaryService['name'] ?? 'Service')),
      'url' => trim((string) ($summaryService['url'] ?? 'services.php'))
    ];
  }

  if (empty($items)) continue;

  $summary = trim((string) (
    ($summaryService['description'] ?? '') !== ''
      ? $summaryService['description']
      : (($summaryService['excerpt'] ?? '') !== '' ? $summaryService['excerpt'] : $sectionDesc)
  ));

  $categoryRows[] = [
    'label' => $label,
    'summary' => $summary,
    'items' => $items,
    'url' => trim((string) ($summaryService['url'] ?? $items[0]['url'] ?? 'services.php'))
  ];
}

$servicesCount = count($servicesDisplay);
if ($servicesCount <= 0) $servicesCount = count($servicesMap);

$experienceLabel = trim((string) ($Experience ?? '6 Years'));
$coverageLabel = trim((string) ($Coverage ?? 'Up to 80 miles'));
$licenseLabel = trim((string) ($LicenseNote ?? 'Fully Insured & Licensed'));
$scheduleLabel = trim((string) ($Schedule ?? 'Monday to Saturday from 8:00 AM to 7:00 PM.'));
$typeLabel = trim((string) ($TypeOfService ?? 'Residential and Commercial'));

$phoneMain = trim((string) ($Phone ?? ''));
$phoneMainRef = trim((string) ($PhoneRef ?? ''));
$phoneMainName = trim((string) ($PhoneName ?? 'English'));
$phoneAlt = trim((string) ($Phone2 ?? ''));
$phoneAltRef = trim((string) ($PhoneRef2 ?? ''));
$phoneAltName = trim((string) ($Phone2Name ?? 'Spanish'));
?>

<?php if (!empty($servicesDisplay)): ?>
<section class="home-services-minimal" id="services">
  <div class="container home-services-minimal__shell">
    <header class="home-services-minimal__header" data-aos="fade-up">
      <div class="home-services-minimal__title">
        <span class="home-services-minimal__eyebrow"><?php echo htmlspecialchars($sectionEyebrow, ENT_QUOTES, 'UTF-8'); ?></span>
        <h2>
          <?php echo htmlspecialchars($sectionTitle, ENT_QUOTES, 'UTF-8'); ?>
          <strong><?php echo htmlspecialchars($sectionTitleStrong, ENT_QUOTES, 'UTF-8'); ?></strong>
        </h2>
        <?php if ($sectionDesc !== ''): ?>
          <p><?php echo htmlspecialchars($sectionDesc, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>
      </div>

      <div class="home-services-minimal__stats">
        <?php foreach (($HomeServicesCopy['stats'] ?? []) as $stat): ?>
          <article>
            <strong><?php echo htmlspecialchars((string) ($stat['value'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></strong>
            <span><?php echo htmlspecialchars((string) ($stat['label'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></span>
          </article>
        <?php endforeach; ?>
      </div>
    </header>

    <?php if (!empty($categoryRows)): ?>
      <div class="home-services-minimal__categories" data-aos="fade-up">
        <?php foreach ($categoryRows as $row): ?>
          <article class="home-services-minimal__category">
            <div class="home-services-minimal__category-head">
              <h3><?php echo htmlspecialchars($row['label'], ENT_QUOTES, 'UTF-8'); ?></h3>
              <a href="<?php echo htmlspecialchars($row['url'], ENT_QUOTES, 'UTF-8'); ?>">Explore</a>
            </div>

            <?php if ($row['summary'] !== ''): ?>
              <p><?php echo htmlspecialchars($row['summary'], ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>

            <div class="home-services-minimal__chips">
              <?php foreach ($row['items'] as $item): ?>
                <a href="<?php echo htmlspecialchars($item['url'], ENT_QUOTES, 'UTF-8'); ?>">
                  <?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>
                </a>
              <?php endforeach; ?>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <div class="home-services-minimal__grid" data-aos="fade-up">
      <?php foreach ($servicesDisplay as $service): ?>
        <?php
        $svcId = (int) ($service['id'] ?? 0);
        $svcName = trim((string) ($service['name'] ?? 'Service'));
        $svcSlug = trim((string) ($service['slug'] ?? ''));
        $svcUrl = trim((string) ($service['url'] ?? 'services.php'));
        $svcCategory = trim((string) ($service['category_label'] ?? 'Core Service'));
        if ($svcCategory === '' || strtolower($svcCategory) === 'general') $svcCategory = 'Core Service';
        if ($svcSlug === 'other-services') $svcCategory = 'Other Services';

        $svcCopy = trim((string) (($service['excerpt'] ?? '') !== '' ? $service['excerpt'] : ($service['description'] ?? '')));
        $svcImage = homeServicesMinimalImage($svcSlug, $svcId, (string) ($service['category_slug'] ?? ''), $svcName);
        ?>
        <article class="home-services-minimal__card">
          <a href="<?php echo htmlspecialchars($svcUrl, ENT_QUOTES, 'UTF-8'); ?>" class="home-services-minimal__media">
            <img src="<?php echo htmlspecialchars($svcImage, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($svcName, ENT_QUOTES, 'UTF-8'); ?>">
          </a>

          <div class="home-services-minimal__body">
            <span class="home-services-minimal__tag"><?php echo htmlspecialchars($svcCategory, ENT_QUOTES, 'UTF-8'); ?></span>
            <h4><a href="<?php echo htmlspecialchars($svcUrl, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($svcName, ENT_QUOTES, 'UTF-8'); ?></a></h4>

            <?php if ($svcCopy !== ''): ?>
              <p><?php echo htmlspecialchars($svcCopy, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>

            <a href="<?php echo htmlspecialchars($svcUrl, ENT_QUOTES, 'UTF-8'); ?>" class="home-services-minimal__link">
              <?php echo htmlspecialchars($sectionLinkLabel, ENT_QUOTES, 'UTF-8'); ?>
            </a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

    <footer class="home-services-minimal__cta" data-aos="fade-up">
      <div class="home-services-minimal__cta-copy">
        <h3><?php echo htmlspecialchars($moreTitle, ENT_QUOTES, 'UTF-8'); ?></h3>
        <p><?php echo htmlspecialchars($moreDesc, ENT_QUOTES, 'UTF-8'); ?></p>
        <ul>
          <li><?php echo htmlspecialchars($typeLabel, ENT_QUOTES, 'UTF-8'); ?></li>
          <li><?php echo htmlspecialchars($scheduleLabel, ENT_QUOTES, 'UTF-8'); ?></li>
        </ul>
      </div>

      <div class="home-services-minimal__cta-actions">
        <a href="<?php echo htmlspecialchars($moreHref, ENT_QUOTES, 'UTF-8'); ?>" class="home-services-minimal__btn home-services-minimal__btn--solid">
          <?php echo htmlspecialchars($moreButton, ENT_QUOTES, 'UTF-8'); ?>
        </a>
        <a href="services.php" class="home-services-minimal__btn home-services-minimal__btn--line">View All Services</a>

        <?php if ($phoneMain !== '' && $phoneMainRef !== ''): ?>
          <a href="<?php echo htmlspecialchars($phoneMainRef, ENT_QUOTES, 'UTF-8'); ?>" class="home-services-minimal__btn home-services-minimal__btn--ghost">
            <?php echo htmlspecialchars($phoneMain, ENT_QUOTES, 'UTF-8'); ?>
            <?php if ($phoneMainName !== '') echo '(' . htmlspecialchars($phoneMainName, ENT_QUOTES, 'UTF-8') . ')'; ?>
          </a>
        <?php endif; ?>

        <?php if ($phoneAlt !== '' && $phoneAltRef !== ''): ?>
          <a href="<?php echo htmlspecialchars($phoneAltRef, ENT_QUOTES, 'UTF-8'); ?>" class="home-services-minimal__btn home-services-minimal__btn--ghost">
            <?php echo htmlspecialchars($phoneAlt, ENT_QUOTES, 'UTF-8'); ?>
            <?php if ($phoneAltName !== '') echo '(' . htmlspecialchars($phoneAltName, ENT_QUOTES, 'UTF-8') . ')'; ?>
          </a>
        <?php endif; ?>
      </div>
    </footer>
  </div>
</section>

<style>
.home-services-minimal {
  background: var(--brand-neutral);
  border-top: 1px solid rgba(15, 15, 15, 0.08);
  border-bottom: 1px solid rgba(15, 15, 15, 0.08);
  padding: clamp(68px, 7vw, 112px) 0;
}

.home-services-minimal__shell {
  max-width: min(1500px, 96vw) !important;
  width: min(1500px, 96vw);
}

.home-services-minimal__header {
  display: grid;
  grid-template-columns: minmax(0, 1.2fr) minmax(280px, 0.8fr);
  gap: clamp(14px, 2vw, 24px);
  align-items: start;
}

.home-services-minimal__eyebrow {
  display: inline-flex;
  min-height: 29px;
  align-items: center;
  padding: 0 11px;
  border-radius: 999px;
  border: 1px solid rgba(var(--brand-accent-rgb), 0.3);
  color: var(--brand-primary);
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 1px;
  text-transform: uppercase;
  background: rgba(var(--brand-accent-rgb), 0.06);
}

.home-services-minimal__title h2 {
  margin: 14px 0 0;
  color: #111111;
  font-size: clamp(2rem, 3.7vw, 3.3rem);
  line-height: 0.96;
}

.home-services-minimal__title h2 strong {
  display: block;
  color: #272727;
}

.home-services-minimal__title p {
  margin: 14px 0 0;
  max-width: 76ch;
  color: #57544d;
  line-height: 1.72;
}

.home-services-minimal__stats {
  border: 1px solid rgba(15, 15, 15, 0.12);
  border-radius: 14px;
  background: #ffffff;
  padding: 10px;
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 8px;
}

.home-services-minimal__stats article {
  border: 1px solid rgba(15, 15, 15, 0.12);
  border-radius: 10px;
  padding: 10px;
  min-height: 84px;
}

.home-services-minimal__stats strong {
  display: block;
  font-size: clamp(0.95rem, 1.4vw, 1.08rem);
  line-height: 1.28;
  color: #141414;
}

.home-services-minimal__stats span {
  display: block;
  margin-top: 4px;
  color: #6a655b;
  font-size: 10px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.9px;
}

.home-services-minimal__categories {
  margin-top: 16px;
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 10px;
}

.home-services-minimal__category {
  border: 1px solid rgba(15, 15, 15, 0.12);
  border-radius: 14px;
  background: #ffffff;
  padding: 14px;
}

.home-services-minimal__category-head {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 8px;
}

.home-services-minimal__category-head h3 {
  margin: 0;
  color: #151515;
  font-size: clamp(1.05rem, 1.7vw, 1.26rem);
}

.home-services-minimal__category-head a {
  color: #111111;
  text-decoration: none;
  text-transform: uppercase;
  font-size: 10px;
  letter-spacing: 1px;
  font-weight: 700;
}

.home-services-minimal__category p {
  margin: 9px 0 0;
  color: #5f5b52;
  line-height: 1.62;
}

.home-services-minimal__chips {
  margin-top: 10px;
  display: flex;
  flex-wrap: wrap;
  gap: 7px;
}

.home-services-minimal__chips a {
  min-height: 28px;
  display: inline-flex;
  align-items: center;
  border-radius: 999px;
  border: 1px solid rgba(15, 15, 15, 0.12);
  padding: 0 10px;
  text-decoration: none;
  color: #151515;
  text-transform: uppercase;
  font-size: 10px;
  letter-spacing: 0.95px;
  font-weight: 700;
}

.home-services-minimal__grid {
  margin-top: 14px;
  display: grid;
  grid-template-columns: repeat(4, minmax(0, 1fr));
  gap: 10px;
}

.home-services-minimal__card {
  border: 1px solid rgba(15, 15, 15, 0.12);
  border-radius: 14px;
  background: #ffffff;
  overflow: hidden;
  transition: border-color 0.2s ease, transform 0.2s ease;
}

.home-services-minimal__card:hover {
  border-color: rgba(var(--brand-accent-rgb), 0.5);
  transform: translateY(-3px);
}

.home-services-minimal__media {
  display: block;
  height: 190px;
  overflow: hidden;
}

.home-services-minimal__media img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.home-services-minimal__body {
  padding: 12px;
}

.home-services-minimal__tag {
  display: inline-flex;
  min-height: 24px;
  align-items: center;
  border-radius: 999px;
  padding: 0 9px;
  color: var(--brand-primary);
  border: 1px solid rgba(var(--brand-accent-rgb), 0.28);
  background: rgba(var(--brand-accent-rgb), 0.06);
  text-transform: uppercase;
  font-size: 9px;
  letter-spacing: 1px;
  font-weight: 700;
}

.home-services-minimal__body h4 {
  margin: 9px 0 0;
  font-size: 1.22rem;
  line-height: 1;
}

.home-services-minimal__body h4 a {
  color: #131313;
  text-decoration: none;
}

.home-services-minimal__body p {
  margin: 9px 0 0;
  color: #5f5c55;
  line-height: 1.65;
  min-height: 4.8em;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.home-services-minimal__link {
  margin-top: 10px;
  display: inline-flex;
  color: #1a1a1a;
  text-decoration: none;
  text-transform: uppercase;
  font-size: 10px;
  letter-spacing: 1px;
  font-weight: 700;
}

.home-services-minimal__cta {
  margin-top: 14px;
  border: 1px solid rgba(15, 15, 15, 0.12);
  border-radius: 14px;
  background: #ffffff;
  padding: 14px;
  display: grid;
  grid-template-columns: minmax(0, 1fr) auto;
  gap: 12px;
  align-items: center;
}

.home-services-minimal__cta-copy h3 {
  margin: 0;
  font-size: clamp(1.2rem, 2vw, 1.6rem);
  color: #111111;
}

.home-services-minimal__cta-copy p {
  margin: 8px 0 0;
  color: #5b5750;
}

.home-services-minimal__cta-copy ul {
  margin: 10px 0 0;
  padding: 0;
  list-style: none;
  display: flex;
  flex-wrap: wrap;
  gap: 6px;
}

.home-services-minimal__cta-copy li {
  min-height: 28px;
  display: inline-flex;
  align-items: center;
  border: 1px solid rgba(15, 15, 15, 0.12);
  border-radius: 999px;
  padding: 0 10px;
  font-size: 10px;
  text-transform: uppercase;
  letter-spacing: 0.95px;
  color: #333333;
}

.home-services-minimal__cta-actions {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  justify-content: flex-end;
}

.home-services-minimal__btn {
  min-height: 40px;
  border-radius: 999px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 0 14px;
  text-decoration: none;
  text-transform: uppercase;
  letter-spacing: 1px;
  font-size: 10px;
  font-weight: 700;
  border: 1px solid transparent;
}

.home-services-minimal__btn--solid {
  background: var(--brand-accent);
  border-color: var(--brand-accent);
  color: #ffffff;
}

.home-services-minimal__btn--line {
  background: #ffffff;
  border-color: rgba(15, 15, 15, 0.2);
  color: #111111;
}

.home-services-minimal__btn--ghost {
  background: #f8f8f8;
  border-color: rgba(15, 15, 15, 0.15);
  color: #111111;
}

@media (max-width: 1200px) {
  .home-services-minimal__grid {
    grid-template-columns: repeat(3, minmax(0, 1fr));
  }
}

@media (max-width: 980px) {
  .home-services-minimal__header {
    grid-template-columns: minmax(0, 1fr);
  }

  .home-services-minimal__categories {
    grid-template-columns: minmax(0, 1fr);
  }

  .home-services-minimal__grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }

  .home-services-minimal__cta {
    grid-template-columns: minmax(0, 1fr);
  }

  .home-services-minimal__cta-actions {
    justify-content: flex-start;
  }
}

@media (max-width: 680px) {
  .home-services-minimal {
    padding: 58px 0;
  }

  .home-services-minimal__stats {
    grid-template-columns: minmax(0, 1fr);
  }

  .home-services-minimal__grid {
    grid-template-columns: minmax(0, 1fr);
  }

  .home-services-minimal__btn {
    width: 100%;
  }
}
</style>
<?php endif; ?>
