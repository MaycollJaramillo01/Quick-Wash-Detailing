<?php
$missionTitle = trim((string) ($MissionCopy['mission_title'] ?? 'Our Mission'));
$visionTitle = trim((string) ($MissionCopy['vision_title'] ?? 'Our Vision'));

$missionText = trim((string) ($Mission ?? ''));
$visionText = trim((string) ($Vision ?? ''));

if ($missionText === '') {
  $missionText = 'Deliver reliable towing and roadside assistance with clear communication, safe handling, and consistent response.';
}
if ($visionText === '') {
  $visionText = 'Be the trusted towing company for drivers across Palm Beach County through consistency and dependable service.';
}

$missionIntro = trim((string) ($About[0] ?? ''));
if ($missionIntro === '') {
  $missionIntro = 'We handle each service call around fast response, accountable support, and practical communication.';
}

$serviceCount = count($ServicesDisplayList ?? []);
if ($serviceCount <= 0) $serviceCount = count($ServicesList ?? []);
if ($serviceCount <= 0) $serviceCount = count($SN ?? []);

$areaCount = count($Areas ?? []);
$experienceLabel = trim((string) ($Experience ?? '15 Years'));
$licenseLabel = trim((string) ($LicenseNote ?? 'Licensed and Insured'));
$estimateLabel = trim((string) ($Estimates ?? 'Free Estimates'));
$typeLabel = trim((string) ($TypeOfService ?? 'Residential and Commercial'));
$coverageLabel = trim((string) ($Coverage ?? 'Serving Palm Beach County and nearby communities'));
$bilingualLabel = trim((string) ($BilingualNote ?? 'Bilingual Attention Available'));
?>

<section class="mission-forge" id="mission-vision">
  <div class="mission-forge__backdrop" aria-hidden="true"></div>

  <div class="container mission-forge__container">
    <header class="mission-forge__header" data-aos="fade-up">
      <span class="mission-forge__eyebrow"><?php echo htmlspecialchars($MissionCopy['eyebrow'] ?? 'Purpose and Direction', ENT_QUOTES, 'UTF-8'); ?></span>
      <h2><?php echo htmlspecialchars($MissionCopy['title'] ?? 'Mission and Vision', ENT_QUOTES, 'UTF-8'); ?></h2>
      <p><?php echo htmlspecialchars($missionIntro, ENT_QUOTES, 'UTF-8'); ?></p>
      <div class="mission-forge__badges">
        <span><?php echo htmlspecialchars($experienceLabel, ENT_QUOTES, 'UTF-8'); ?></span>
        <span><?php echo $serviceCount; ?> <?php echo htmlspecialchars($MissionCopy['services_badge'] ?? 'Core Services', ENT_QUOTES, 'UTF-8'); ?></span>
        <span><?php echo $areaCount; ?>+ Areas Covered</span>
        <span><?php echo htmlspecialchars($licenseLabel, ENT_QUOTES, 'UTF-8'); ?></span>
      </div>
    </header>

    <div class="mission-forge__layout">
      <article class="mission-forge__card mission-forge__card--mission" data-aos="fade-right">
        <div class="mission-forge__card-head">
          <div class="mission-forge__icon">
            <i class="fas <?php echo htmlspecialchars($MissionCopy['mission_icon'] ?? 'fa-bullseye', ENT_QUOTES, 'UTF-8'); ?>" aria-hidden="true"></i>
          </div>
          <h3><?php echo htmlspecialchars($missionTitle, ENT_QUOTES, 'UTF-8'); ?></h3>
        </div>

        <p><?php echo htmlspecialchars($missionText, ENT_QUOTES, 'UTF-8'); ?></p>

        <ul class="mission-forge__points">
          <?php foreach (($MissionCopy['mission_points'] ?? []) as $point): ?>
          <li><?php echo htmlspecialchars($point, ENT_QUOTES, 'UTF-8'); ?></li>
          <?php endforeach; ?>
        </ul>
      </article>

      <article class="mission-forge__card mission-forge__card--vision" data-aos="fade-left">
        <div class="mission-forge__card-head">
          <div class="mission-forge__icon">
            <i class="fas <?php echo htmlspecialchars($MissionCopy['vision_icon'] ?? 'fa-eye', ENT_QUOTES, 'UTF-8'); ?>" aria-hidden="true"></i>
          </div>
          <h3><?php echo htmlspecialchars($visionTitle, ENT_QUOTES, 'UTF-8'); ?></h3>
        </div>

        <p><?php echo htmlspecialchars($visionText, ENT_QUOTES, 'UTF-8'); ?></p>

        <ul class="mission-forge__points">
          <?php foreach (($MissionCopy['vision_points'] ?? []) as $point): ?>
          <li><?php echo htmlspecialchars($point, ENT_QUOTES, 'UTF-8'); ?></li>
          <?php endforeach; ?>
        </ul>
      </article>

      <aside class="mission-forge__panel" data-aos="fade-up" data-aos-delay="120">
        <h3><?php echo htmlspecialchars($MissionCopy['panel_title'] ?? 'Our Commitments', ENT_QUOTES, 'UTF-8'); ?></h3>
        <dl>
          <div>
            <dt>Service Type</dt>
            <dd><?php echo htmlspecialchars($typeLabel, ENT_QUOTES, 'UTF-8'); ?></dd>
          </div>
          <div>
            <dt>Coverage</dt>
            <dd><?php echo htmlspecialchars($coverageLabel, ENT_QUOTES, 'UTF-8'); ?></dd>
          </div>
          <div>
            <dt>Estimates</dt>
            <dd><?php echo htmlspecialchars($estimateLabel, ENT_QUOTES, 'UTF-8'); ?></dd>
          </div>
          <div>
            <dt>Support</dt>
            <dd><?php echo htmlspecialchars($bilingualLabel, ENT_QUOTES, 'UTF-8'); ?></dd>
          </div>
        </dl>

        <a href="contact.php" class="mission-forge__cta"><?php echo htmlspecialchars($MissionCopy['cta'] ?? 'Request Service', ENT_QUOTES, 'UTF-8'); ?></a>
      </aside>
    </div>
  </div>
</section>

<style>
.mission-forge {
  --mf-dark: var(--brand-secondary);
  --mf-dark-2: color-mix(in srgb, var(--brand-secondary) 86%, #000 14%);
  --mf-accent: var(--brand-accent);
  --mf-ink: var(--site-dark-text);
  --mf-muted: var(--site-dark-muted);
  --mf-panel: rgba(255, 255, 255, 0.05);
  --mf-line: var(--site-dark-line);
  position: relative;
  padding: clamp(78px, 8vw, 128px) 0;
  overflow: hidden;
  background:
    var(--mf-dark-2);
}

.mission-forge__backdrop {
  position: absolute;
  inset: 0;
  pointer-events: none;
  background:
    transparent;
}

.mission-forge__container {
  position: relative;
  z-index: 1;
}

.mission-forge__header {
  max-width: 920px;
}

.mission-forge__eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  font-size: 11px;
  letter-spacing: 1.9px;
  text-transform: uppercase;
  font-weight: 700;
  color: var(--mf-muted);
}

.mission-forge__eyebrow::before {
  content: '';
  width: 30px;
  height: 2px;
  background: var(--mf-accent);
}

.mission-forge__header h2 {
  margin: 14px 0 0;
  color: var(--mf-ink);
  font-size: clamp(2rem, 4.8vw, 3.8rem);
  line-height: 0.92;
  letter-spacing: 0.3px;
  max-width: 18ch;
}

.mission-forge__header p {
  margin: 16px 0 0;
  max-width: 72ch;
  color: var(--mf-muted);
  font-size: clamp(0.99rem, 1.3vw, 1.08rem);
  line-height: 1.75;
}

.mission-forge__badges {
  margin-top: 18px;
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
}

.mission-forge__badges span {
  display: inline-flex;
  align-items: center;
  min-height: 32px;
  border-radius: 999px;
  border: 1px solid rgba(255, 255, 255, 0.2);
  background: rgba(255, 255, 255, 0.08);
  color: #fff;
  font-size: 10px;
  letter-spacing: 1.1px;
  text-transform: uppercase;
  padding: 0 12px;
  font-weight: 700;
}

.mission-forge__layout {
  margin-top: clamp(26px, 4vw, 44px);
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr)) minmax(0, 0.86fr);
  gap: 14px;
  align-items: stretch;
}

.mission-forge__card,
.mission-forge__panel {
  border-radius: 18px;
  border: 1px solid var(--mf-line);
  backdrop-filter: blur(5px);
}

.mission-forge__card {
  padding: clamp(18px, 2.6vw, 28px);
  background: rgba(255, 255, 255, 0.1);
  box-shadow: 0 18px 34px rgba(0, 0, 0, 0.2);
}

.mission-forge__card--vision {
  background: rgba(255, 255, 255, 0.14);
}

.mission-forge__card-head {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 14px;
}

.mission-forge__icon {
  width: 46px;
  height: 46px;
  border-radius: 12px;
  border: 1px solid rgba(255, 255, 255, 0.24);
  background: rgba(var(--brand-accent-rgb), 0.48);
  display: inline-flex;
  align-items: center;
  justify-content: center;
  color: #111;
  font-size: 1.1rem;
}

.mission-forge__card h3 {
  margin: 0;
  color: #ffffff;
  font-size: clamp(1.3rem, 2.5vw, 1.9rem);
  line-height: 1;
  letter-spacing: 0.3px;
}

.mission-forge__card p {
  margin: 0;
  color: rgba(255, 255, 255, 0.88);
  font-size: 1rem;
  line-height: 1.72;
}

.mission-forge__points {
  margin: 16px 0 0;
  padding: 0;
  list-style: none;
  display: grid;
  gap: 8px;
}

.mission-forge__points li {
  position: relative;
  padding-left: 18px;
  color: var(--mf-muted);
  font-size: 0.94rem;
  line-height: 1.55;
}

.mission-forge__points li::before {
  content: '';
  position: absolute;
  top: 8px;
  left: 0;
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: var(--mf-accent);
}

.mission-forge__panel {
  padding: clamp(18px, 2.4vw, 24px);
  background: var(--mf-panel);
}

.mission-forge__panel h3 {
  margin: 0;
  color: #fff;
  font-size: clamp(1.25rem, 2.3vw, 1.75rem);
  line-height: 1.04;
}

.mission-forge__panel dl {
  margin: 16px 0 0;
  display: grid;
  gap: 10px;
}

.mission-forge__panel dl div {
  padding: 12px 10px;
  border-radius: 12px;
  border: 1px solid rgba(255, 255, 255, 0.14);
  background: rgba(255, 255, 255, 0.03);
}

.mission-forge__panel dt {
  margin: 0;
  color: rgba(255, 255, 255, 0.68);
  font-size: 10px;
  letter-spacing: 1.1px;
  text-transform: uppercase;
  font-weight: 700;
}

.mission-forge__panel dd {
  margin: 4px 0 0;
  color: #fff;
  font-size: 0.95rem;
  line-height: 1.55;
}

.mission-forge__cta {
  margin-top: 14px;
  width: 100%;
  min-height: 45px;
  border-radius: 999px;
  border: 1px solid var(--mf-accent);
  background: var(--mf-accent);
  color: #050505;
  text-transform: uppercase;
  font-size: 10px;
  letter-spacing: 1.5px;
  font-weight: 800;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  transition: transform 0.22s ease, background-color 0.22s ease;
}

.mission-forge__cta:hover {
  transform: translateY(-2px);
  background: #e1cd3b;
}

@media (max-width: 1150px) {
  .mission-forge__layout {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }

  .mission-forge__panel {
    grid-column: 1 / -1;
  }
}

@media (max-width: 760px) {
  .mission-forge {
    padding: 62px 0 76px;
  }

  .mission-forge__header h2 {
    max-width: none;
    font-size: clamp(1.85rem, 9vw, 2.8rem);
    line-height: 0.98;
  }

  .mission-forge__layout {
    grid-template-columns: minmax(0, 1fr);
  }

  .mission-forge__badges span {
    min-height: 30px;
    font-size: 9px;
    letter-spacing: 1px;
  }
}
</style>
