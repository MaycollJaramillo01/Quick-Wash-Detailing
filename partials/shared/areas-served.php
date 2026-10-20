<?php
$areasCopy = (isset($AreasCopy) && is_array($AreasCopy)) ? $AreasCopy : [];

$areasTitle = trim((string) ($areasCopy['title'] ?? 'Serving'));
$areasTitleStrong = trim((string) ($areasCopy['title_strong'] ?? 'Central Maryland'));
$areasSubtitle = trim((string) ($areasCopy['subtitle'] ?? ($Coverage ?? '')));
$areasCtaLabel = trim((string) ($areasCopy['cta_label'] ?? 'Request Service in Your Area'));
$mapOverlayText = trim((string) ($areasCopy['map_overlay'] ?? 'Active Service Coverage'));

$allAreas = [];
if (!empty($Areas) && is_array($Areas)) {
  foreach ($Areas as $area) {
    $area = trim((string) $area);
    if ($area !== '') $allAreas[] = $area;
  }
}

if (empty($allAreas) && !empty($Coverage)) {
  $coverageParts = explode(',', (string) $Coverage);
  foreach ($coverageParts as $area) {
    $area = trim((string) $area);
    if ($area !== '') $allAreas[] = $area;
  }
}

if (empty($allAreas)) {
  $allAreas = ['West Palm Beach, FL', 'Jupiter, FL', 'Boca Raton, FL'];
}

$primaryAreas = array_slice($allAreas, 0, 6);
$extendedAreas = array_slice($allAreas, 6);

$licensePills = [];
if (!empty($areasCopy['license_pills']) && is_array($areasCopy['license_pills'])) {
  foreach ($areasCopy['license_pills'] as $pill) {
    $pill = trim((string) $pill);
    if ($pill !== '') $licensePills[] = $pill;
  }
}

if (empty($licensePills)) {
  $fallbackPills = [
    trim((string) ($LicenseNote ?? 'Licensed and Insured')),
    trim((string) ($Estimates ?? 'Free Estimates')),
    'Residential and Commercial'
  ];
  foreach ($fallbackPills as $pill) {
    if ($pill !== '') $licensePills[] = $pill;
  }
}

$areasSignal = $areasCopy['signal'] ?? ['value' => (int) preg_replace('/[^0-9]/', '', (string) ($Experience ?? '1')) . '+', 'label' => 'Years in Service'];

$cityCount = count($allAreas);
$mapHtml = trim((string) ($GoogleMap ?? ''));
?>

<section class="coverage-atlas" id="areas-served">
  <div class="container coverage-atlas__container">
    <header class="coverage-atlas__header" data-aos="fade-up">
      <div class="coverage-atlas__headline">
        <span class="coverage-atlas__eyebrow"><?php echo htmlspecialchars($areasCopy['eyebrow'] ?? 'Service Footprint', ENT_QUOTES, 'UTF-8'); ?></span>
        <h2>
          <?php echo htmlspecialchars($areasTitle, ENT_QUOTES, 'UTF-8'); ?>
          <strong><?php echo htmlspecialchars($areasTitleStrong, ENT_QUOTES, 'UTF-8'); ?></strong>
        </h2>
        <p><?php echo htmlspecialchars($areasSubtitle, ENT_QUOTES, 'UTF-8'); ?></p>
      </div>

      <div class="coverage-atlas__signal">
        <article>
          <strong><?php echo (int) $cityCount; ?></strong>
          <span>Cities Covered</span>
        </article>
        <article>
          <strong><?php echo htmlspecialchars((string) $areasSignal['value'], ENT_QUOTES, 'UTF-8'); ?></strong>
          <span><?php echo htmlspecialchars((string) $areasSignal['label'], ENT_QUOTES, 'UTF-8'); ?></span>
        </article>
        <a href="contact.php" class="coverage-atlas__cta">
          <?php echo htmlspecialchars($areasCtaLabel, ENT_QUOTES, 'UTF-8'); ?>
        </a>
      </div>
    </header>

    <div class="coverage-atlas__layout">
      <article class="coverage-atlas__map-card" data-aos="fade-right">
        <div class="coverage-atlas__map-wrap">
          <?php if ($mapHtml !== ''): ?>
            <?php echo $mapHtml; ?>
          <?php else: ?>
            <div class="coverage-atlas__map-fallback">Map unavailable.</div>
          <?php endif; ?>
        </div>
        <div class="coverage-atlas__map-badge">
          <i class="fas fa-compass" aria-hidden="true"></i>
          <?php echo htmlspecialchars($mapOverlayText, ENT_QUOTES, 'UTF-8'); ?>
        </div>
      </article>

      <article class="coverage-atlas__zones-card" data-aos="fade-left">
        <div class="coverage-atlas__zone-block">
          <h3><?php echo htmlspecialchars($areasCopy['zones_title'] ?? 'Primary Service Zones', ENT_QUOTES, 'UTF-8'); ?></h3>
          <div class="coverage-atlas__zone-grid">
            <?php foreach ($primaryAreas as $area): ?>
              <div class="coverage-atlas__zone-item">
                <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                <span><?php echo htmlspecialchars($area, ENT_QUOTES, 'UTF-8'); ?></span>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <?php if (!empty($extendedAreas)): ?>
          <div class="coverage-atlas__zone-block coverage-atlas__zone-block--extended">
            <h4>Additional Nearby Areas</h4>
            <ul class="coverage-atlas__extended-list">
              <?php foreach ($extendedAreas as $area): ?>
                <li><?php echo htmlspecialchars($area, ENT_QUOTES, 'UTF-8'); ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

        <div class="coverage-atlas__pill-row">
          <?php foreach ($licensePills as $pill): ?>
            <span><?php echo htmlspecialchars($pill, ENT_QUOTES, 'UTF-8'); ?></span>
          <?php endforeach; ?>
        </div>
      </article>
    </div>
  </div>
</section>

<style>
.coverage-atlas {
  position: relative;
  overflow: hidden;
  padding: clamp(80px, 8vw, 132px) 0;
  background: #e4ebf3;
}

.coverage-atlas::before {
  content: '';
  position: absolute;
  inset: 0;
  pointer-events: none;
  background:
    transparent;
}

.coverage-atlas::after {
  content: '';
  position: absolute;
  inset: 0;
  pointer-events: none;
  background-image: none;
  background-size: 48px 48px;
  mask-image: none;
}

.coverage-atlas__container {
  position: relative;
  z-index: 1;
}

.coverage-atlas__header {
  display: grid;
  grid-template-columns: minmax(0, 1.3fr) minmax(260px, 0.7fr);
  gap: clamp(18px, 3vw, 34px);
  align-items: end;
  margin-bottom: clamp(24px, 4vw, 38px);
}

.coverage-atlas__eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 16px;
  font-size: 11px;
  letter-spacing: 1.7px;
  text-transform: uppercase;
  color: #335175;
  font-weight: 800;
}

.coverage-atlas__eyebrow::before {
  content: '';
  width: 32px;
  height: 2px;
  background: var(--brand-accent);
}

.coverage-atlas__headline h2 {
  margin: 0;
  color: #050505;
  font-size: clamp(2rem, 4vw, 3.4rem);
  line-height: 1.02;
}

.coverage-atlas__headline h2 strong {
  display: block;
  color: #1c1c1c;
}

.coverage-atlas__headline p {
  margin: 18px 0 0;
  max-width: 68ch;
  color: #465769;
  font-size: clamp(1rem, 1.35vw, 1.14rem);
  line-height: 1.78;
}

.coverage-atlas__signal {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 10px;
}

.coverage-atlas__signal article {
  padding: 12px 14px;
  border-radius: 12px;
  border: 1px solid rgba(31, 42, 54, 0.16);
  background: rgba(255, 255, 255, 0.86);
}

.coverage-atlas__signal strong {
  display: block;
  color: #050505;
  font-size: 1.36rem;
  line-height: 1.1;
}

.coverage-atlas__signal span {
  display: block;
  margin-top: 2px;
  color: #5b6b7d;
  font-size: 10px;
  text-transform: uppercase;
  letter-spacing: 0.9px;
}

.coverage-atlas__cta {
  grid-column: 1 / -1;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-height: 46px;
  border-radius: 999px;
  text-decoration: none;
  text-transform: uppercase;
  font-size: 11px;
  letter-spacing: 1.2px;
  font-weight: 800;
  color: #fff;
  background: var(--brand-primary);
  border: 1px solid rgba(31, 42, 54, 0.2);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.coverage-atlas__cta:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 20px rgba(31, 42, 54, 0.2);
}

.coverage-atlas__layout {
  display: grid;
  grid-template-columns: minmax(0, 1.18fr) minmax(0, 0.82fr);
  gap: clamp(16px, 2.5vw, 24px);
}

.coverage-atlas__map-card {
  position: relative;
  border-radius: 18px;
  border: 1px solid rgba(31, 42, 54, 0.15);
  background: rgba(255, 255, 255, 0.9);
  box-shadow: 0 24px 44px rgba(21, 31, 43, 0.14);
  padding: 14px;
}

.coverage-atlas__map-wrap {
  position: relative;
  border-radius: 14px;
  overflow: hidden;
  height: clamp(320px, 46vw, 520px);
  background: #d7dee7;
}

.coverage-atlas__map-wrap iframe {
  display: block;
  width: 100% !important;
  height: 100% !important;
  border: 0 !important;
  filter: grayscale(80%) contrast(0.9) brightness(0.98);
  transition: filter 0.3s ease;
}

.coverage-atlas__map-card:hover .coverage-atlas__map-wrap iframe {
  filter: grayscale(35%) contrast(0.95) brightness(1);
}

.coverage-atlas__map-fallback {
  height: 100%;
  min-height: inherit;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #44576a;
  font-size: 0.95rem;
}

.coverage-atlas__map-badge {
  position: absolute;
  top: 24px;
  left: 24px;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 8px 12px;
  border-radius: 999px;
  background: rgba(31, 42, 54, 0.84);
  border: 1px solid rgba(183, 190, 200, 0.4);
  color: #e6edf6;
  font-size: 10px;
  letter-spacing: 0.9px;
  text-transform: uppercase;
}

.coverage-atlas__zones-card {
  border-radius: 18px;
  border: 1px solid rgba(183, 190, 200, 0.36);
  background: var(--brand-secondary);
  color: #f5f8fc;
  padding: clamp(18px, 2.6vw, 26px);
}

.coverage-atlas__zone-block h3,
.coverage-atlas__zone-block h4 {
  margin: 0 0 12px;
  font-size: 0.95rem;
  letter-spacing: 0.9px;
  text-transform: uppercase;
  color: #d8e2ef;
}

.coverage-atlas__zone-grid {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 8px;
}

.coverage-atlas__zone-item {
  min-height: 42px;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 8px 10px;
  border-radius: 10px;
  border: 1px solid rgba(183, 190, 200, 0.22);
  background: rgba(255, 255, 255, 0.06);
  color: #f6f9fd;
  font-size: 0.9rem;
}

.coverage-atlas__zone-item i {
  color: var(--brand-accent);
  font-size: 0.8rem;
}

.coverage-atlas__zone-block--extended {
  margin-top: 16px;
  padding-top: 14px;
  border-top: 1px solid rgba(183, 190, 200, 0.2);
}

.coverage-atlas__extended-list {
  margin: 0;
  padding: 0;
  list-style: none;
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 8px 10px;
}

.coverage-atlas__extended-list li {
  color: rgba(233, 239, 246, 0.9);
  font-size: 0.88rem;
  line-height: 1.45;
  padding-left: 14px;
  position: relative;
}

.coverage-atlas__extended-list li::before {
  content: '';
  width: 5px;
  height: 5px;
  border-radius: 50%;
  background: rgba(183, 190, 200, 0.85);
  position: absolute;
  left: 0;
  top: 0.52em;
}

.coverage-atlas__pill-row {
  margin-top: 16px;
  padding-top: 14px;
  border-top: 1px solid rgba(183, 190, 200, 0.2);
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
}

.coverage-atlas__pill-row span {
  display: inline-flex;
  align-items: center;
  min-height: 30px;
  padding: 6px 11px;
  border-radius: 999px;
  border: 1px solid rgba(183, 190, 200, 0.32);
  color: #e2eaf4;
  background: rgba(255, 255, 255, 0.05);
  font-size: 10px;
  letter-spacing: 0.8px;
  text-transform: uppercase;
}

@media (max-width: 1120px) {
  .coverage-atlas__header {
    grid-template-columns: 1fr;
  }

  .coverage-atlas__layout {
    grid-template-columns: 1fr;
  }

  .coverage-atlas__map-wrap {
    height: clamp(300px, 52vw, 500px);
  }
}

@media (max-width: 760px) {
  .coverage-atlas {
    padding: 66px 0;
  }

  .coverage-atlas__signal {
    grid-template-columns: 1fr;
  }

  .coverage-atlas__zone-grid,
  .coverage-atlas__extended-list {
    grid-template-columns: 1fr;
  }

  .coverage-atlas__map-badge {
    top: 18px;
    left: 18px;
    max-width: calc(100% - 36px);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
}
</style>

