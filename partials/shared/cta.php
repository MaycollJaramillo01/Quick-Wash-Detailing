<?php
$cta = (isset($CtaCopy) && is_array($CtaCopy)) ? $CtaCopy : [];

$ctaBadge = trim((string) ($cta['badge'] ?? 'Trusted Team'));
$ctaTitle = trim((string) ($cta['title'] ?? 'Ready to Upgrade'));
$ctaTitleStrong = trim((string) ($cta['title_strong'] ?? 'Your Property?'));
$ctaParagraph = trim((string) ($cta['paragraph'] ?? ''));
$ctaButton = trim((string) ($cta['button'] ?? 'Request Your Estimate'));
$ctaCardTitle = trim((string) ($cta['card_title'] ?? 'Speak With Our Team'));
$ctaCardSubtitle = trim((string) ($cta['card_subtitle'] ?? 'Fast responses for new project requests'));
$ctaCallLabel = trim((string) ($cta['row_call_label'] ?? 'Call for a project quote'));
$ctaLicenseLabel = trim((string) ($cta['row_license_label'] ?? 'License and insurance'));
$ctaLicenseTitle = trim((string) ($cta['row_license_title'] ?? 'Maryland Contractor Credentials'));
$ctaServiceLabel = trim((string) ($cta['row_service_label'] ?? 'Coverage Area'));
$ctaWhatsAppLabel = trim((string) ($cta['whatsapp_button'] ?? 'WhatsApp Us'));
$ctaBookLabel = trim((string) ($cta['book_button'] ?? 'Start Request'));
$phonePrimaryLabel = trim((string) ($PhoneName ?? 'Main'));
$phoneSecondaryLabel = trim((string) ($Phone2Name ?? 'Secondary'));

$ctaFeatures = [];
if (!empty($cta['features']) && is_array($cta['features'])) {
  foreach ($cta['features'] as $feature) {
    $feature = trim((string) $feature);
    if ($feature !== '') $ctaFeatures[] = $feature;
  }
}
if (empty($ctaFeatures)) {
  $ctaFeatures = ['Licensed and Insured', 'Bilingual Team', 'Free Detailed Estimates'];
}

$licensePills = [];
if (!empty($AreasCopy['license_pills']) && is_array($AreasCopy['license_pills'])) {
  foreach ($AreasCopy['license_pills'] as $pill) {
    $pill = trim((string) $pill);
    if ($pill !== '') $licensePills[] = $pill;
  }
}
if (empty($licensePills)) {
  $licensePills = [trim((string) ($LicenseNote ?? 'Licensed and Insured'))];
}

$serviceAreasShort = [];
if (!empty($Areas) && is_array($Areas)) {
  foreach (array_slice($Areas, 0, 6) as $area) {
    $area = trim((string) $area);
    if ($area !== '') $serviceAreasShort[] = $area;
  }
}
if (empty($serviceAreasShort) && !empty($Coverage)) {
  foreach (array_slice(array_map('trim', explode(',', (string) $Coverage)), 0, 6) as $area) {
    if ($area !== '') $serviceAreasShort[] = $area;
  }
}

$whatsAppHref = trim((string) ($whatsapp ?? ''));
if ($whatsAppHref === '') $whatsAppHref = 'contact.php';
?>

<section class="cta-forge" id="cta-forge">
  <div class="container cta-forge__container">
    <div class="cta-forge__layout">
      <article class="cta-forge__message" data-aos="fade-right">
        <span class="cta-forge__badge"><?php echo htmlspecialchars($ctaBadge, ENT_QUOTES, 'UTF-8'); ?></span>

        <h2 class="cta-forge__title">
          <?php echo htmlspecialchars($ctaTitle, ENT_QUOTES, 'UTF-8'); ?>
          <strong><?php echo htmlspecialchars($ctaTitleStrong, ENT_QUOTES, 'UTF-8'); ?></strong>
        </h2>

        <?php if ($ctaParagraph !== ''): ?>
          <p class="cta-forge__paragraph"><?php echo htmlspecialchars($ctaParagraph, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>

        <div class="cta-forge__feature-line">
          <?php foreach ($ctaFeatures as $feature): ?>
            <span>
              <i class="fas fa-check-circle" aria-hidden="true"></i>
              <?php echo htmlspecialchars($feature, ENT_QUOTES, 'UTF-8'); ?>
            </span>
          <?php endforeach; ?>
        </div>

        <div class="cta-forge__actions">
          <a href="contact.php" class="cta-forge__btn cta-forge__btn--primary">
            <?php echo htmlspecialchars($ctaButton, ENT_QUOTES, 'UTF-8'); ?>
          </a>
          <a href="<?php echo htmlspecialchars((string) ($PhoneRef ?? '#'), ENT_QUOTES, 'UTF-8'); ?>" class="cta-forge__btn cta-forge__btn--ghost">
            <?php echo htmlspecialchars((string) ($Phone ?? ''), ENT_QUOTES, 'UTF-8'); ?>
            <?php if ($phonePrimaryLabel !== ''): ?>
              (<?php echo htmlspecialchars($phonePrimaryLabel, ENT_QUOTES, 'UTF-8'); ?>)
            <?php endif; ?>
          </a>
          <?php if (!empty($Phone2) && !empty($PhoneRef2)): ?>
            <a href="<?php echo htmlspecialchars((string) ($PhoneRef2 ?? '#'), ENT_QUOTES, 'UTF-8'); ?>" class="cta-forge__btn cta-forge__btn--ghost">
              <?php echo htmlspecialchars((string) ($Phone2 ?? ''), ENT_QUOTES, 'UTF-8'); ?>
              <?php if ($phoneSecondaryLabel !== ''): ?>
                (<?php echo htmlspecialchars($phoneSecondaryLabel, ENT_QUOTES, 'UTF-8'); ?>)
              <?php endif; ?>
            </a>
          <?php endif; ?>
        </div>
      </article>

      <article class="cta-forge__contact" data-aos="fade-left">
        <header class="cta-forge__contact-head">
          <h3><?php echo htmlspecialchars($ctaCardTitle, ENT_QUOTES, 'UTF-8'); ?></h3>
          <p><?php echo htmlspecialchars($ctaCardSubtitle, ENT_QUOTES, 'UTF-8'); ?></p>
        </header>

        <div class="cta-forge__info-grid">
          <div class="cta-forge__info-block">
            <span class="cta-forge__label"><?php echo htmlspecialchars($ctaCallLabel, ENT_QUOTES, 'UTF-8'); ?></span>
            <strong>
              <a href="<?php echo htmlspecialchars((string) ($PhoneRef ?? '#'), ENT_QUOTES, 'UTF-8'); ?>">
                <?php echo htmlspecialchars((string) ($Phone ?? ''), ENT_QUOTES, 'UTF-8'); ?>
                <?php if ($phonePrimaryLabel !== ''): ?>
                  (<?php echo htmlspecialchars($phonePrimaryLabel, ENT_QUOTES, 'UTF-8'); ?>)
                <?php endif; ?>
              </a>
            </strong>
            <?php if (!empty($Phone2) && !empty($PhoneRef2)): ?>
              <strong>
                <a href="<?php echo htmlspecialchars((string) ($PhoneRef2 ?? '#'), ENT_QUOTES, 'UTF-8'); ?>">
                  <?php echo htmlspecialchars((string) ($Phone2 ?? ''), ENT_QUOTES, 'UTF-8'); ?>
                  <?php if ($phoneSecondaryLabel !== ''): ?>
                    (<?php echo htmlspecialchars($phoneSecondaryLabel, ENT_QUOTES, 'UTF-8'); ?>)
                  <?php endif; ?>
                </a>
              </strong>
            <?php endif; ?>
          </div>

          <div class="cta-forge__info-block">
            <span class="cta-forge__label"><?php echo htmlspecialchars($ctaLicenseLabel, ENT_QUOTES, 'UTF-8'); ?></span>
            <strong><?php echo htmlspecialchars($ctaLicenseTitle, ENT_QUOTES, 'UTF-8'); ?></strong>
          </div>
        </div>

        <div class="cta-forge__coverage">
          <span class="cta-forge__label"><?php echo htmlspecialchars($ctaServiceLabel, ENT_QUOTES, 'UTF-8'); ?></span>
          <ul>
            <?php foreach ($serviceAreasShort as $area): ?>
              <li><?php echo htmlspecialchars($area, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>

        <div class="cta-forge__pills">
          <?php foreach ($licensePills as $pill): ?>
            <span><?php echo htmlspecialchars($pill, ENT_QUOTES, 'UTF-8'); ?></span>
          <?php endforeach; ?>
        </div>

        <div class="cta-forge__quick-actions">
          <a href="<?php echo htmlspecialchars($whatsAppHref, ENT_QUOTES, 'UTF-8'); ?>">
            <i class="fab fa-whatsapp" aria-hidden="true"></i>
            <?php echo htmlspecialchars($ctaWhatsAppLabel, ENT_QUOTES, 'UTF-8'); ?>
          </a>
          <a href="contact.php">
            <i class="fas fa-calendar-check" aria-hidden="true"></i>
            <?php echo htmlspecialchars($ctaBookLabel, ENT_QUOTES, 'UTF-8'); ?>
          </a>
        </div>
      </article>
    </div>
  </div>
</section>

<style>
.cta-forge {
  position: relative;
  overflow: hidden;
  padding: clamp(84px, 9vw, 140px) 0;
  background:
    var(--site-dark-3);
}

.cta-forge::before {
  content: '';
  position: absolute;
  inset: 0;
  pointer-events: none;
  background-image: none;
  background-size: 44px 44px;
  mask-image: none;
}

.cta-forge__container {
  position: relative;
  z-index: 1;
}

.cta-forge__layout {
  display: grid;
  grid-template-columns: minmax(0, 1.12fr) minmax(0, 0.88fr);
  gap: clamp(18px, 2.7vw, 30px);
  align-items: stretch;
}

.cta-forge__message {
  position: relative;
  border-radius: 22px;
  border: 1px solid var(--site-dark-line);
  background: var(--brand-primary);
  padding: clamp(22px, 3vw, 38px);
  box-shadow: 0 24px 44px rgba(0, 0, 0, 0.24);
}

.cta-forge__message::after {
  content: '';
  position: absolute;
  right: 0;
  top: 0;
  width: 160px;
  height: 160px;
  background: transparent;
  pointer-events: none;
}

.cta-forge__badge {
  display: inline-flex;
  align-items: center;
  min-height: 32px;
  padding: 6px 12px;
  border-radius: 999px;
  border: 1px solid rgba(var(--brand-accent-rgb), 0.42);
  color: color-mix(in srgb, var(--brand-white) 84%, var(--brand-accent) 16%);
  font-size: 11px;
  letter-spacing: 1.2px;
  text-transform: uppercase;
  background: rgba(255, 255, 255, 0.08);
}

.cta-forge__title {
  margin: 18px 0 0;
  color: #ffffff;
  font-size: clamp(2rem, 4vw, 3.4rem);
  line-height: 0.98;
}

.cta-forge__title strong {
  display: block;
  color: var(--brand-accent);
}

.cta-forge__paragraph {
  margin: 20px 0 0;
  max-width: 56ch;
  color: rgba(231, 238, 246, 0.9);
  font-size: clamp(1rem, 1.3vw, 1.12rem);
  line-height: 1.78;
}

.cta-forge__feature-line {
  margin-top: 22px;
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
}

.cta-forge__feature-line span {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  min-height: 32px;
  padding: 6px 11px;
  border-radius: 999px;
  border: 1px solid rgba(183, 190, 200, 0.28);
  background: rgba(255, 255, 255, 0.08);
  color: #f3f7fc;
  font-size: 12px;
}

.cta-forge__feature-line i {
  color: var(--brand-accent);
}

.cta-forge__actions {
  margin-top: 24px;
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
}

.cta-forge__btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-height: 48px;
  padding: 12px 20px;
  border-radius: 999px;
  text-decoration: none;
  text-transform: uppercase;
  font-size: 11px;
  letter-spacing: 1.2px;
  font-weight: 800;
  transition: transform 0.22s ease, box-shadow 0.22s ease, background 0.22s ease, color 0.22s ease;
}

.cta-forge__btn:hover {
  transform: translateY(-2px);
}

.cta-forge__btn--primary {
  background: var(--brand-accent);
  color: #050505;
  border: 1px solid var(--brand-accent);
  box-shadow: 0 12px 24px rgba(0, 0, 0, 0.22);
}

.cta-forge__btn--primary:hover {
  background: color-mix(in srgb, var(--brand-accent) 84%, #fff 16%);
}

.cta-forge__btn--ghost {
  border: 1px solid rgba(183, 190, 200, 0.48);
  color: #f6f9fd;
  background: rgba(255, 255, 255, 0.08);
}

.cta-forge__btn--ghost:hover {
  background: rgba(255, 255, 255, 0.16);
}

.cta-forge__contact {
  border-radius: 22px;
  border: 1px solid rgba(183, 190, 200, 0.3);
  background: rgba(250, 252, 255, 0.97);
  padding: clamp(20px, 2.5vw, 30px);
  box-shadow: 0 20px 36px rgba(8, 14, 22, 0.2);
}

.cta-forge__contact-head h3 {
  margin: 0;
  color: #050505;
  font-size: clamp(1.34rem, 2.3vw, 1.8rem);
}

.cta-forge__contact-head p {
  margin: 7px 0 0;
  color: #4d5d70;
  font-size: 0.96rem;
  line-height: 1.6;
}

.cta-forge__info-grid {
  margin-top: 16px;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 10px;
}

.cta-forge__info-block {
  min-height: 92px;
  padding: 11px 12px;
  border-radius: 12px;
  border: 1px solid rgba(31, 42, 54, 0.14);
  background: rgba(255, 255, 255, 0.88);
}

.cta-forge__label {
  display: block;
  font-size: 10px;
  letter-spacing: 0.95px;
  text-transform: uppercase;
  color: #6b7b8d;
}

.cta-forge__info-block strong,
.cta-forge__coverage strong {
  display: block;
  margin-top: 6px;
  color: #050505;
  font-size: 1rem;
  line-height: 1.45;
}

.cta-forge__info-block strong a {
  color: inherit;
  text-decoration: none;
}

.cta-forge__coverage {
  margin-top: 10px;
  border-radius: 12px;
  border: 1px solid rgba(31, 42, 54, 0.14);
  background: rgba(255, 255, 255, 0.88);
  padding: 11px 12px;
}

.cta-forge__coverage ul {
  margin: 8px 0 0;
  padding: 0;
  list-style: none;
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 6px 8px;
}

.cta-forge__coverage li {
  position: relative;
  padding-left: 12px;
  color: #44576a;
  font-size: 0.86rem;
  line-height: 1.45;
}

.cta-forge__coverage li::before {
  content: '';
  width: 5px;
  height: 5px;
  border-radius: 50%;
  background: var(--brand-primary);
  position: absolute;
  left: 0;
  top: 0.53em;
}

.cta-forge__pills {
  margin-top: 10px;
  display: flex;
  flex-wrap: wrap;
  gap: 7px;
}

.cta-forge__pills span {
  min-height: 30px;
  display: inline-flex;
  align-items: center;
  padding: 6px 10px;
  border-radius: 999px;
  border: 1px solid rgba(31, 42, 54, 0.18);
  background: rgba(31, 42, 54, 0.08);
  color: #050505;
  font-size: 10px;
  letter-spacing: 0.8px;
  text-transform: uppercase;
  font-weight: 700;
}

.cta-forge__quick-actions {
  margin-top: 12px;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 8px;
}

.cta-forge__quick-actions a {
  min-height: 42px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 7px;
  border-radius: 10px;
  text-decoration: none;
  font-size: 11px;
  text-transform: uppercase;
  letter-spacing: 0.95px;
  font-weight: 800;
  border: 1px solid rgba(31, 42, 54, 0.18);
  color: #050505;
  background: rgba(255, 255, 255, 0.9);
  transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
}

.cta-forge__quick-actions a:hover {
  transform: translateY(-1px);
  background: var(--brand-secondary);
  color: #ecf2fa;
}

@media (max-width: 1080px) {
  .cta-forge__layout {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 760px) {
  .cta-forge {
    padding: 68px 0;
  }

  .cta-forge__actions {
    flex-direction: column;
  }

  .cta-forge__btn {
    width: 100%;
  }

  .cta-forge__info-grid,
  .cta-forge__quick-actions,
  .cta-forge__coverage ul {
    grid-template-columns: 1fr;
  }
}
</style>

