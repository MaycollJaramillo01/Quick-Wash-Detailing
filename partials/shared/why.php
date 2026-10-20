<?php
$whyCopy = (isset($WhyCopy) && is_array($WhyCopy)) ? $WhyCopy : [];

$whyBadge = trim((string) ($whyCopy['badge'] ?? 'Trusted Choice'));
$whyTitlePrefix = trim((string) ($whyCopy['title_prefix'] ?? 'Why Clients Choose'));
$whyDescription = trim((string) ($whyCopy['description'] ?? ''));
$whyServiceAreaLabel = trim((string) ($whyCopy['service_area_label'] ?? 'Coverage and Credentials'));
$whyCtaLabel = trim((string) ($whyCopy['cta_label'] ?? 'Request Free Estimate'));

$companyName = trim((string) ($Company ?? 'Familia Towing'));
$coverageText = trim((string) ($Coverage ?? 'Serving nearby communities.'));
$phoneMain = trim((string) ($Phone ?? ''));
$phoneMainRef = trim((string) ($PhoneRef ?? '#'));
$phoneMainLabel = trim((string) ($PhoneName ?? 'Main'));
$phoneAlt = trim((string) ($Phone2 ?? ''));
$phoneAltRef = trim((string) ($PhoneRef2 ?? '#'));
$phoneAltLabel = trim((string) ($Phone2Name ?? 'Secondary'));

if ($whyDescription === '') {
  $whyDescription = 'Our process blends disciplined planning, clear communication, and consistent quality control from estimate to delivery.';
}

$experienceLabel = trim((string) ($Experience ?? '6 Years'));
$servicesCount = count($ServicesDisplayList ?? []);
if ($servicesCount <= 0) $servicesCount = count($ServicesList ?? []);
$areasCount = count($Areas ?? []);

$stats = [];
if (!empty($whyCopy['stats']) && is_array($whyCopy['stats'])) {
  foreach ($whyCopy['stats'] as $item) {
    if (!is_array($item)) continue;
    $value = trim((string) ($item['value'] ?? ''));
    $label = trim((string) ($item['label'] ?? ''));
    if ($value === '' && $label === '') continue;
    $stats[] = ['value' => $value, 'label' => $label];
  }
}

if (empty($stats)) {
  $stats = [
    ['value' => $experienceLabel, 'label' => 'Experience'],
    ['value' => $servicesCount . '+', 'label' => 'Service Lines'],
    ['value' => max(1, $areasCount) . '+', 'label' => 'Areas Covered'],
    ['value' => trim((string) ($LicenseNote ?? 'Fully Insured & Licensed')), 'label' => 'Protection']
  ];
}

$features = [];
if (!empty($whyCopy['features']) && is_array($whyCopy['features'])) {
  foreach ($whyCopy['features'] as $item) {
    if (!is_array($item)) continue;
    $title = trim((string) ($item['title'] ?? ''));
    $text = trim((string) ($item['text'] ?? ''));
    $icon = trim((string) ($item['icon'] ?? 'fa-circle-check'));
    if ($title === '' && $text === '') continue;

    $iconClass = $icon;
    if (strpos($iconClass, 'fa-') === 0) $iconClass = 'fa-solid ' . $iconClass;
    if (strpos($iconClass, 'fa-') === false) $iconClass = 'fa-solid fa-circle-check';

    $features[] = [
      'title' => $title,
      'text' => $text,
      'icon' => $iconClass
    ];
  }
}

if (empty($features)) {
  $features = [
    [
      'title' => 'Clear Communication',
      'text' => 'You get direct updates and bilingual support throughout each project stage.',
      'icon' => 'fa-solid fa-comments'
    ],
    [
      'title' => 'Transparent Proposals',
      'text' => 'Every estimate is detailed, practical, and aligned with your project goals.',
      'icon' => 'fa-solid fa-file-invoice-dollar'
    ],
    [
      'title' => 'Licensed Execution',
      'text' => trim((string) ($LicenseNote ?? 'Fully Insured & Licensed')) . ' with reliable scheduling.',
      'icon' => 'fa-solid fa-shield-halved'
    ],
    [
      'title' => 'Quality Control',
      'text' => 'Each phase is reviewed to keep workmanship consistent from start to finish.',
      'icon' => 'fa-solid fa-clipboard-check'
    ]
  ];
}

$licensePills = [];
if (!empty($AreasCopy['license_pills']) && is_array($AreasCopy['license_pills'])) {
  foreach ($AreasCopy['license_pills'] as $pill) {
    $pill = trim((string) $pill);
    if ($pill !== '') $licensePills[] = $pill;
  }
}
if (empty($licensePills)) {
  $licensePills = [
    trim((string) ($LicenseNote ?? 'Fully Insured & Licensed')),
    trim((string) ($Estimates ?? 'Free Estimates')),
    trim((string) ($BilingualNote ?? 'Bilingual Support'))
  ];
}
?>

<section class="why-lattice" id="why-lattice">
  <div class="why-lattice__noise" aria-hidden="true"></div>

  <div class="container why-lattice__shell">
    <header class="why-lattice__header" data-aos="fade-up">
      <span class="why-lattice__badge"><?php echo htmlspecialchars($whyBadge, ENT_QUOTES, 'UTF-8'); ?></span>
      <h2>
        <?php echo htmlspecialchars($whyTitlePrefix, ENT_QUOTES, 'UTF-8'); ?>
        <strong><?php echo htmlspecialchars($companyName, ENT_QUOTES, 'UTF-8'); ?></strong>
      </h2>
      <p><?php echo htmlspecialchars($whyDescription, ENT_QUOTES, 'UTF-8'); ?></p>
    </header>

    <div class="why-lattice__layout">
      <article class="why-lattice__left" data-aos="fade-right">
        <div class="why-lattice__stats">
          <?php foreach ($stats as $item): ?>
            <article>
              <strong><?php echo htmlspecialchars((string) ($item['value'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></strong>
              <span><?php echo htmlspecialchars((string) ($item['label'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></span>
            </article>
          <?php endforeach; ?>
        </div>

        <div class="why-lattice__coverage">
          <h3><?php echo htmlspecialchars($whyServiceAreaLabel, ENT_QUOTES, 'UTF-8'); ?></h3>
          <p>
            <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
            <?php echo htmlspecialchars($coverageText, ENT_QUOTES, 'UTF-8'); ?>
          </p>
          <div class="why-lattice__pills">
            <?php foreach (array_slice($licensePills, 0, 4) as $pill): ?>
              <span><?php echo htmlspecialchars($pill, ENT_QUOTES, 'UTF-8'); ?></span>
            <?php endforeach; ?>
          </div>
        </div>
      </article>

      <div class="why-lattice__features" data-aos="fade-left">
        <?php foreach ($features as $index => $feature): ?>
          <article class="why-lattice__feature">
            <span class="why-lattice__num"><?php echo str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT); ?></span>
            <div class="why-lattice__icon">
              <i class="<?php echo htmlspecialchars($feature['icon'], ENT_QUOTES, 'UTF-8'); ?>" aria-hidden="true"></i>
            </div>
            <div class="why-lattice__copy">
              <h3><?php echo htmlspecialchars($feature['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
              <p><?php echo htmlspecialchars($feature['text'], ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>

    <footer class="why-lattice__footer" data-aos="fade-up">
      <a href="contact.php" class="why-lattice__btn why-lattice__btn--primary">
        <?php echo htmlspecialchars($whyCtaLabel, ENT_QUOTES, 'UTF-8'); ?>
      </a>

      <div class="why-lattice__phones">
        <?php if ($phoneMain !== '' && $phoneMainRef !== ''): ?>
          <a href="<?php echo htmlspecialchars($phoneMainRef, ENT_QUOTES, 'UTF-8'); ?>" class="why-lattice__btn why-lattice__btn--ghost">
            <?php echo htmlspecialchars($phoneMain, ENT_QUOTES, 'UTF-8'); ?>
            <?php if ($phoneMainLabel !== ''): ?>
              (<?php echo htmlspecialchars($phoneMainLabel, ENT_QUOTES, 'UTF-8'); ?>)
            <?php endif; ?>
          </a>
        <?php endif; ?>

        <?php if ($phoneAlt !== '' && $phoneAltRef !== ''): ?>
          <a href="<?php echo htmlspecialchars($phoneAltRef, ENT_QUOTES, 'UTF-8'); ?>" class="why-lattice__btn why-lattice__btn--ghost">
            <?php echo htmlspecialchars($phoneAlt, ENT_QUOTES, 'UTF-8'); ?>
            <?php if ($phoneAltLabel !== ''): ?>
              (<?php echo htmlspecialchars($phoneAltLabel, ENT_QUOTES, 'UTF-8'); ?>)
            <?php endif; ?>
          </a>
        <?php endif; ?>
      </div>
    </footer>
  </div>
</section>

<style>
.why-lattice {
  --wl-primary: var(--brand-primary);
  --wl-secondary: var(--brand-secondary);
  --wl-accent: var(--brand-accent);
  --wl-ink: var(--site-dark-text);
  --wl-muted: var(--site-dark-muted);
  --wl-line: var(--site-dark-line);
  position: relative;
  overflow: hidden;
  padding: clamp(82px, 9vw, 132px) 0;
  background:
    color-mix(in srgb, var(--wl-primary) 78%, #000 22%);
}

.why-lattice__noise {
  position: absolute;
  inset: 0;
  pointer-events: none;
  background:
    transparent;
}

.why-lattice__shell {
  position: relative;
  z-index: 1;
}

.why-lattice__header {
  max-width: 900px;
}

.why-lattice__badge {
  display: inline-flex;
  align-items: center;
  min-height: 32px;
  padding: 6px 12px;
  border-radius: 999px;
  border: 1px solid rgba(var(--brand-accent-rgb), 0.55);
  background: rgba(var(--brand-accent-rgb), 0.14);
  color: color-mix(in srgb, var(--brand-white) 82%, var(--brand-accent) 18%);
  font-size: 11px;
  letter-spacing: 1.3px;
  text-transform: uppercase;
  font-weight: 800;
}

.why-lattice__header h2 {
  margin: 18px 0 0;
  color: var(--wl-ink);
  font-size: clamp(2rem, 4.8vw, 4rem);
  line-height: 0.9;
  letter-spacing: 0.3px;
}

.why-lattice__header h2 strong {
  display: block;
  color: #ffffff;
}

.why-lattice__header p {
  margin: 18px 0 0;
  max-width: 72ch;
  color: var(--wl-muted);
  line-height: 1.75;
}

.why-lattice__layout {
  margin-top: clamp(26px, 4vw, 42px);
  display: grid;
  grid-template-columns: minmax(0, 0.88fr) minmax(0, 1.12fr);
  gap: 14px;
}

.why-lattice__left {
  display: grid;
  gap: 14px;
}

.why-lattice__stats {
  border-radius: 18px;
  border: 1px solid var(--wl-line);
  background: rgba(255, 255, 255, 0.07);
  backdrop-filter: blur(5px);
  padding: clamp(14px, 2.2vw, 20px);
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 10px;
}

.why-lattice__stats article {
  border-radius: 12px;
  border: 1px solid rgba(255, 255, 255, 0.16);
  background: rgba(0, 0, 0, 0.18);
  min-height: 92px;
  padding: 12px;
}

.why-lattice__stats strong {
  display: block;
  color: #ffffff;
  font-size: clamp(1.08rem, 1.8vw, 1.28rem);
  line-height: 1.18;
}

.why-lattice__stats span {
  display: block;
  margin-top: 5px;
  font-size: 10px;
  letter-spacing: 1px;
  text-transform: uppercase;
  color: rgba(255, 255, 255, 0.68);
  font-weight: 700;
}

.why-lattice__coverage {
  border-radius: 18px;
  border: 1px solid rgba(var(--brand-accent-rgb), 0.42);
  background: rgba(0, 0, 0, 0.22);
  padding: clamp(14px, 2.2vw, 22px);
}

.why-lattice__coverage h3 {
  margin: 0;
  color: #ffffff;
  font-size: clamp(1.15rem, 2.2vw, 1.5rem);
}

.why-lattice__coverage p {
  margin: 12px 0 0;
  color: rgba(255, 255, 255, 0.86);
  line-height: 1.65;
}

.why-lattice__coverage p i {
  color: color-mix(in srgb, var(--brand-accent) 74%, var(--brand-white) 26%);
  margin-right: 8px;
}

.why-lattice__pills {
  margin-top: 14px;
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
}

.why-lattice__pills span {
  display: inline-flex;
  align-items: center;
  min-height: 30px;
  border-radius: 999px;
  border: 1px solid rgba(255, 255, 255, 0.2);
  background: rgba(0, 0, 0, 0.24);
  color: #ffffff;
  padding: 0 12px;
  font-size: 10px;
  letter-spacing: 1px;
  text-transform: uppercase;
  font-weight: 700;
}

.why-lattice__features {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 10px;
}

.why-lattice__feature {
  position: relative;
  border-radius: 16px;
  border: 1px solid rgba(255, 255, 255, 0.18);
  background: rgba(255, 255, 255, 0.94);
  padding: 16px 14px;
  color: #111111;
  min-height: 180px;
  transition: transform 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
}

.why-lattice__feature:hover {
  transform: translateY(-3px);
  border-color: rgba(var(--brand-accent-rgb), 0.7);
  box-shadow: 0 18px 32px rgba(0, 0, 0, 0.18);
}

.why-lattice__num {
  position: absolute;
  top: 12px;
  right: 12px;
  font-size: 10px;
  letter-spacing: 1.3px;
  text-transform: uppercase;
  color: rgba(16, 16, 16, 0.35);
  font-weight: 800;
}

.why-lattice__icon {
  width: 42px;
  height: 42px;
  border-radius: 11px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  background: rgba(var(--brand-accent-rgb), 0.14);
  border: 1px solid rgba(var(--brand-accent-rgb), 0.35);
  color: var(--brand-accent);
  font-size: 15px;
}

.why-lattice__copy h3 {
  margin: 14px 0 0;
  font-size: 1.18rem;
  line-height: 1.08;
  color: #121212;
}

.why-lattice__copy p {
  margin: 10px 0 0;
  color: #4b4f59;
  font-size: 0.96rem;
  line-height: 1.62;
}

.why-lattice__footer {
  margin-top: 14px;
  border-radius: 18px;
  border: 1px solid var(--wl-line);
  background: rgba(255, 255, 255, 0.08);
  padding: 12px;
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 10px;
  justify-content: space-between;
}

.why-lattice__phones {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
}

.why-lattice__btn {
  min-height: 42px;
  border-radius: 999px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  text-decoration: none;
  text-transform: uppercase;
  letter-spacing: 1.1px;
  font-size: 10px;
  font-weight: 800;
  padding: 0 16px;
  transition: transform 0.2s ease, background-color 0.2s ease, color 0.2s ease;
}

.why-lattice__btn:hover {
  transform: translateY(-2px);
}

.why-lattice__btn--primary {
  background: var(--brand-accent);
  border: 1px solid var(--brand-accent);
  color: #050505;
}

.why-lattice__btn--primary:hover {
  background: color-mix(in srgb, var(--brand-accent) 84%, #fff 16%);
}

.why-lattice__btn--ghost {
  background: rgba(255, 255, 255, 0.09);
  border: 1px solid rgba(255, 255, 255, 0.28);
  color: #ffffff;
}

.why-lattice__btn--ghost:hover {
  background: rgba(255, 255, 255, 0.16);
}

@media (max-width: 1050px) {
  .why-lattice__layout {
    grid-template-columns: minmax(0, 1fr);
  }
}

@media (max-width: 760px) {
  .why-lattice {
    padding: 64px 0 78px;
  }

  .why-lattice__stats {
    grid-template-columns: minmax(0, 1fr);
  }

  .why-lattice__features {
    grid-template-columns: minmax(0, 1fr);
  }

  .why-lattice__footer {
    justify-content: stretch;
  }

  .why-lattice__btn--primary,
  .why-lattice__phones {
    width: 100%;
  }

  .why-lattice__phones .why-lattice__btn {
    width: 100%;
  }
}
</style>
