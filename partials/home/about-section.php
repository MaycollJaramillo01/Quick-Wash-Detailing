<?php
$about = (isset($HomeAboutCopy) && is_array($HomeAboutCopy)) ? $HomeAboutCopy : [];

$aboutEyebrow     = trim((string) ($about['eyebrow'] ?? 'About us'));
$aboutTitle       = trim((string) ($about['title'] ?? 'Built for everyday use,'));
$aboutTitleStrong = trim((string) ($about['title_strong'] ?? 'installed to last.'));
$aboutDesc        = trim((string) ($about['description'] ?? ''));
$features         = (isset($about['features']) && is_array($about['features'])) ? $about['features'] : [];

$yearsValue = max(1, (int) ($ExperienceYears ?? 0));
$yearsLabel = trim((string) ($about['badge_label'] ?? 'Years in the industry'));
$licenseLabel = trim((string) ($LicenseNote ?? ''));
$bilingualLabel = trim((string) ($BilingualNote ?? 'English and Spanish'));

$aboutImg = trim((string) ($about['images']['front']['src'] ?? 'assets/img/fallback.jpg'));
$aboutImgAlt = trim((string) ($about['images']['front']['alt'] ?? 'Garage door installed by Banegas Garage Doors'));
$aboutVideo = trim((string) ($about['video']['src'] ?? ''));
$aboutVideoPoster = trim((string) ($about['video']['poster'] ?? $aboutImg));
$aboutVideoLabel = trim((string) ($about['video']['label'] ?? 'Banegas Garage Doors showroom video'));
$ctaText = trim((string) ($about['cta'] ?? 'Learn about us'));
$ctaHref = 'about.php';
$telHref = trim((string) ($PhoneRef ?? 'contact.php'));
$telText = trim((string) ($Phone ?? 'Call us'));
?>

<style>
.home-about {
  --about-ink: var(--brand-secondary, #07121c);
  --about-muted: var(--site-ink-soft, #5d6b78);
  position: relative;
  overflow: clip;
  padding: clamp(84px, 9vw, 144px) 0 clamp(96px, 10vw, 156px);
  background: #f6f8f9;
  color: var(--about-ink);
}

.home-about::before {
  content: "";
  position: absolute;
  top: 0;
  right: clamp(24px, 8vw, 128px);
  width: 1px;
  height: 100%;
  background: rgba(var(--brand-secondary-rgb, 7, 18, 28), .08);
}

.home-about__shell {
  position: relative;
  z-index: 1;
  width: min(1280px, 90vw);
  margin: 0 auto;
}

.home-about__intro {
  display: grid;
  grid-template-columns: minmax(0, 1.25fr) minmax(280px, .75fr);
  gap: clamp(32px, 7vw, 104px);
  align-items: end;
  margin-bottom: clamp(44px, 6vw, 82px);
}

.home-about__eyebrow {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 22px;
  color: var(--brand-primary, #075985);
  font-size: 11px;
  font-weight: 800;
  letter-spacing: .18em;
  text-transform: uppercase;
}

.home-about__eyebrow::before {
  content: "";
  width: 34px;
  height: 2px;
  background: var(--brand-accent, #09afe8);
}

.home-about h2 {
  max-width: 850px;
  margin: 0;
  color: var(--about-ink);
  font-family: var(--font-display, 'Teko', sans-serif);
  font-size: clamp(3.4rem, 7.2vw, 7rem);
  font-weight: 600;
  letter-spacing: -.025em;
  line-height: .82;
  text-transform: uppercase;
  text-wrap: balance;
}

.home-about h2 strong {
  display: block;
  color: var(--brand-primary, #075985);
  font-weight: inherit;
}

.home-about__summary {
  padding: 0 0 6px clamp(20px, 3vw, 42px);
  border-left: 2px solid var(--brand-accent, #09afe8);
}

.home-about__summary p {
  max-width: 46ch;
  margin: 0;
  color: var(--about-muted);
  font-size: clamp(1rem, 1.25vw, 1.13rem);
  line-height: 1.75;
}

.home-about__body {
  display: grid;
  grid-template-columns: minmax(0, 1.08fr) minmax(360px, .92fr);
  gap: clamp(36px, 7vw, 100px);
  align-items: center;
}

.home-about__media {
  position: relative;
  min-height: 0;
  aspect-ratio: 16 / 9;
  margin: 0;
}

.home-about__media::before {
  content: "";
  position: absolute;
  inset: 28px -22px -28px 56px;
  border: 1px solid rgba(var(--brand-primary-rgb, 7, 89, 133), .22);
}

.home-about__media::after {
  content: "";
  position: absolute;
  left: -12px;
  bottom: -16px;
  width: 46%;
  height: 8px;
  background: var(--brand-accent, #09afe8);
}

.home-about__media img,
.home-about__media video {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  display: block;
  object-fit: cover;
  object-position: center;
  box-shadow: 0 30px 80px rgba(3, 18, 30, .16);
}

.home-about__media video {
  background: #06131f;
}

.home-about__media-caption {
  position: absolute;
  right: -1px;
  top: 0;
  z-index: 2;
  padding: 14px 15px 18px;
  background: var(--about-ink);
  color: #fff;
  font-size: 10px;
  font-weight: 800;
  letter-spacing: .16em;
  text-transform: uppercase;
  writing-mode: vertical-rl;
}

.home-about__content {
  position: relative;
}

.home-about__content-label {
  margin: 0 0 18px;
  color: var(--brand-primary, #075985);
  font-size: 11px;
  font-weight: 800;
  letter-spacing: .18em;
  text-transform: uppercase;
}

.home-about__services {
  border-top: 1px solid rgba(var(--brand-secondary-rgb, 7, 18, 28), .16);
}

.home-about__service {
  display: grid;
  grid-template-columns: 42px 1fr 30px;
  gap: 14px;
  align-items: start;
  padding: 20px 0;
  border-bottom: 1px solid rgba(var(--brand-secondary-rgb, 7, 18, 28), .16);
  transition: padding-left .25s ease, border-color .25s ease;
}

.home-about__service:hover {
  padding-left: 8px;
  border-color: var(--brand-accent, #09afe8);
}

.home-about__service-index {
  padding-top: 2px;
  color: var(--brand-accent, #09afe8);
  font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
  font-size: 12px;
  font-variant-numeric: tabular-nums;
}

.home-about__service h3 {
  margin: 0 0 5px;
  color: var(--about-ink);
  font-family: var(--font-display, 'Teko', sans-serif);
  font-size: clamp(1.4rem, 2vw, 1.8rem);
  font-weight: 600;
  letter-spacing: .01em;
  line-height: 1;
  text-transform: uppercase;
}

.home-about__service p {
  margin: 0;
  color: var(--about-muted);
  font-size: .94rem;
  line-height: 1.55;
}

.home-about__service i {
  margin-top: 4px;
  color: var(--brand-primary, #075985);
  font-size: 15px;
  text-align: right;
}

.home-about__actions {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 14px 22px;
  margin-top: 34px;
}

.home-about__primary {
  min-height: 52px;
  display: inline-flex;
  align-items: center;
  gap: 16px;
  padding: 0 22px;
  background: var(--about-ink);
  color: #fff;
  text-decoration: none;
  font-size: 11px;
  font-weight: 800;
  letter-spacing: .13em;
  text-transform: uppercase;
  transition: background-color .25s ease, transform .25s ease;
}

.home-about__primary:hover {
  background: var(--brand-primary, #075985);
  color: #fff;
  transform: translateY(-2px);
}

.home-about__call {
  color: var(--about-ink);
  font-size: .9rem;
  font-weight: 800;
  text-decoration-color: var(--brand-accent, #09afe8);
  text-underline-offset: 6px;
}

.home-about__primary:focus-visible,
.home-about__call:focus-visible {
  outline: 3px solid rgba(var(--brand-accent-rgb, 9, 175, 232), .4);
  outline-offset: 4px;
}

.home-about__proof {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  margin-top: clamp(68px, 8vw, 112px);
  border-top: 1px solid rgba(var(--brand-secondary-rgb, 7, 18, 28), .16);
  border-bottom: 1px solid rgba(var(--brand-secondary-rgb, 7, 18, 28), .16);
}

.home-about__proof-item {
  min-height: 132px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding: 24px clamp(18px, 3vw, 42px);
}

.home-about__proof-item + .home-about__proof-item {
  border-left: 1px solid rgba(var(--brand-secondary-rgb, 7, 18, 28), .16);
}

.home-about__proof strong {
  color: var(--about-ink);
  font-family: var(--font-display, 'Teko', sans-serif);
  font-size: clamp(2.1rem, 4vw, 3.6rem);
  font-weight: 600;
  line-height: .9;
  text-transform: uppercase;
}

.home-about__proof span {
  margin-top: 10px;
  color: var(--about-muted);
  font-size: 10px;
  font-weight: 800;
  letter-spacing: .14em;
  line-height: 1.45;
  text-transform: uppercase;
}

@media (max-width: 980px) {
  .home-about__intro,
  .home-about__body {
    grid-template-columns: 1fr;
  }

  .home-about__intro {
    gap: 28px;
  }

  .home-about__summary {
    max-width: 680px;
  }

  .home-about__media {
    width: min(720px, 94%);
    min-height: 0;
  }
}

@media (max-width: 640px) {
  .home-about {
    padding-top: 72px;
  }

  .home-about__shell {
    width: min(100% - 36px, 1280px);
  }

  .home-about h2 {
    font-size: clamp(3.05rem, 15vw, 4.8rem);
  }

  .home-about__summary {
    padding-left: 18px;
  }

  .home-about__media {
    width: calc(100% - 14px);
    min-height: 0;
  }

  .home-about__media::before {
    inset: 16px -14px -18px 28px;
  }

  .home-about__proof {
    grid-template-columns: 1fr;
  }

  .home-about__proof-item {
    min-height: 108px;
    padding-left: 0;
  }

  .home-about__proof-item + .home-about__proof-item {
    border-left: 0;
    border-top: 1px solid rgba(var(--brand-secondary-rgb, 7, 18, 28), .16);
  }
}

@media (prefers-reduced-motion: reduce) {
  .home-about__service,
  .home-about__primary {
    transition: none;
  }
}
</style>

<section class="home-about" id="about" aria-labelledby="home-about-title">
  <div class="home-about__shell">
    <header class="home-about__intro">
      <div>
        <div class="home-about__eyebrow"><?php echo htmlspecialchars($aboutEyebrow, ENT_QUOTES, 'UTF-8'); ?></div>
        <h2 id="home-about-title">
          <?php echo htmlspecialchars($aboutTitle, ENT_QUOTES, 'UTF-8'); ?>
          <strong><?php echo htmlspecialchars($aboutTitleStrong, ENT_QUOTES, 'UTF-8'); ?></strong>
        </h2>
      </div>
      <?php if ($aboutDesc !== ''): ?>
        <div class="home-about__summary">
          <p><?php echo htmlspecialchars($aboutDesc, ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
      <?php endif; ?>
    </header>

    <div class="home-about__body">
      <figure class="home-about__media">
        <?php if ($aboutVideo !== '' && is_file(__DIR__ . '/../../' . $aboutVideo)): ?>
          <video autoplay muted loop playsinline controls preload="metadata"
                 poster="<?php echo htmlspecialchars($aboutVideoPoster, ENT_QUOTES, 'UTF-8'); ?>"
                 aria-label="<?php echo htmlspecialchars($aboutVideoLabel, ENT_QUOTES, 'UTF-8'); ?>">
            <source src="<?php echo htmlspecialchars($aboutVideo, ENT_QUOTES, 'UTF-8'); ?>" type="video/mp4">
          </video>
        <?php else: ?>
          <img src="<?php echo htmlspecialchars($aboutImg, ENT_QUOTES, 'UTF-8'); ?>"
               alt="<?php echo htmlspecialchars($aboutImgAlt, ENT_QUOTES, 'UTF-8'); ?>"
               loading="lazy"
               decoding="async">
        <?php endif; ?>
        <figcaption class="home-about__media-caption"><?php echo htmlspecialchars($about['caption'] ?? ($Address ?? ''), ENT_QUOTES, 'UTF-8'); ?></figcaption>
      </figure>

      <div class="home-about__content">
        <p class="home-about__content-label"><?php echo htmlspecialchars($about['content_label'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>

        <?php if (!empty($features)): ?>
          <div class="home-about__services" aria-label="<?php echo htmlspecialchars($about['features_label'] ?? 'Our services', ENT_QUOTES, 'UTF-8'); ?>">
            <?php $featureNumber = 0; ?>
            <?php foreach ($features as $feature): ?>
              <?php
                $featureTitle = trim((string) ($feature['title'] ?? ''));
                $featureText = trim((string) ($feature['text'] ?? ''));
                $featureIcon = trim((string) ($feature['icon'] ?? 'fa-arrow-right'));
                if ($featureTitle === '' && $featureText === '') continue;
                $featureNumber++;
              ?>
              <article class="home-about__service">
                <span class="home-about__service-index"><?php echo str_pad((string) $featureNumber, 2, '0', STR_PAD_LEFT); ?></span>
                <div>
                  <?php if ($featureTitle !== ''): ?><h3><?php echo htmlspecialchars($featureTitle, ENT_QUOTES, 'UTF-8'); ?></h3><?php endif; ?>
                  <?php if ($featureText !== ''): ?><p><?php echo htmlspecialchars($featureText, ENT_QUOTES, 'UTF-8'); ?></p><?php endif; ?>
                </div>
                <i class="fa-solid <?php echo htmlspecialchars($featureIcon, ENT_QUOTES, 'UTF-8'); ?>" aria-hidden="true"></i>
              </article>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <div class="home-about__actions">
          <a class="home-about__primary" href="<?php echo htmlspecialchars($ctaHref, ENT_QUOTES, 'UTF-8'); ?>">
            <?php echo htmlspecialchars($ctaText, ENT_QUOTES, 'UTF-8'); ?>
            <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
          </a>
          <?php if ($telHref !== '' && $telText !== ''): ?>
            <a class="home-about__call" href="<?php echo htmlspecialchars($telHref, ENT_QUOTES, 'UTF-8'); ?>">
              <?php echo htmlspecialchars($telText, ENT_QUOTES, 'UTF-8'); ?>
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="home-about__proof" aria-label="Company highlights">
      <?php foreach (($about['proof'] ?? [['value' => $yearsValue . '+', 'label' => $yearsLabel]]) as $proof): ?>
      <div class="home-about__proof-item">
        <strong><?php echo htmlspecialchars((string) ($proof['value'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></strong>
        <span><?php echo htmlspecialchars((string) ($proof['label'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></span>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
