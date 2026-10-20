<?php
@session_start();
if (!isset($Company)) include_once __DIR__ . '/../../text.php';

if (!function_exists('vdHeroLabelFromFile')) {
  function vdHeroLabelFromFile($filename)
  {
    $base = pathinfo($filename, PATHINFO_FILENAME);
    $base = preg_replace('/[-_]+/', ' ', (string) $base);
    $base = preg_replace('/([a-z])([A-Z])/', '$1 $2', (string) $base);
    $base = trim((string) $base);
    if ($base === '') return 'Project';
    return ucwords($base);
  }
}

if (!function_exists('vdHeroTitleHtml')) {
  function vdHeroTitleHtml($label)
  {
    $clean = trim((string) $label);
    if ($clean === '') return 'Project';
    return htmlspecialchars($clean, ENT_QUOTES, 'UTF-8');
  }
}

if (!function_exists('vdHeroPosterForVideo')) {
  function vdHeroPosterForVideo($videoFile, $heroDirAbs, $heroDirRel, $defaultPoster)
  {
    $base = pathinfo($videoFile, PATHINFO_FILENAME);
    $candidates = [
      $base . '.jpg',
      $base . '.jpeg',
      $base . '.png',
      $base . '.webp',
      $base . '.avif'
    ];

    if (ctype_digit((string) $base)) {
      $candidates[] = 'hero' . $base . '.jpg';
      $candidates[] = 'hero' . $base . '.jpeg';
      $candidates[] = 'hero' . $base . '.png';
      $candidates[] = 'hero' . $base . '.webp';
      $candidates[] = 'hero' . $base . '.avif';
    }

    foreach ($candidates as $candidate) {
      $abs = $heroDirAbs . DIRECTORY_SEPARATOR . $candidate;
      if (is_file($abs)) return $heroDirRel . '/' . $candidate;
    }
    return $defaultPoster;
  }
}

$headline = trim((string) ($HomeHeroCopy['headline'] ?? ($Company ?? 'V&D Contractors')));
$sub = trim((string) ($HomeHeroCopy['sub'] ?? ''));
$ctaPrimary = trim((string) ($HomeHeroCopy['cta_primary'] ?? 'Request Estimate'));
$ctaSecondary = trim((string) ($HomeHeroCopy['cta_secondary'] ?? 'View Projects'));
$ctaPrimaryHref = trim((string) ($HomeHeroCopy['cta_primary_href'] ?? 'contact.php'));
$ctaSecondaryHref = trim((string) ($HomeHeroCopy['cta_secondary_href'] ?? 'projects.php'));
$slideAltPrefix = trim((string) ($HomeHeroCopy['slide_alt_prefix'] ?? 'Project Slide'));

$heroCompany = trim((string) ($Company ?? $headline));
if ($heroCompany === '') $heroCompany = 'V&D Contractors';

$heroTitleLabel = trim((string) ($HomeHeroCopy['title'] ?? $heroCompany));
if ($heroTitleLabel === '') $heroTitleLabel = $heroCompany;
$heroTitleHtml = vdHeroTitleHtml($heroTitleLabel);

$customSlideStatuses = [];
if (!empty($HomeHeroCopy['slide_statuses']) && is_array($HomeHeroCopy['slide_statuses'])) {
  foreach ($HomeHeroCopy['slide_statuses'] as $statusLine) {
    $statusLine = trim((string) $statusLine);
    if ($statusLine !== '') $customSlideStatuses[] = $statusLine;
  }
}

$customSlideDescriptions = [];
if (!empty($HomeHeroCopy['slide_descriptions']) && is_array($HomeHeroCopy['slide_descriptions'])) {
  foreach ($HomeHeroCopy['slide_descriptions'] as $descLine) {
    $descLine = trim((string) $descLine);
    if ($descLine !== '') $customSlideDescriptions[] = $descLine;
  }
}

$heroStatusPool = $customSlideStatuses;
if (empty($heroStatusPool)) {
  $heroStatusPool = array_values(array_filter([
    trim((string) ($Experience ?? '20 Years')),
    'Licensed & Insured',
    trim((string) ($Address ?? 'Central Maryland')),
    trim((string) ($Estimates ?? 'Free Estimates'))
  ], static function ($line) {
    return $line !== '';
  }));
}
if (empty($heroStatusPool)) $heroStatusPool = ['Experience'];

$heroDescriptionPool = $customSlideDescriptions;
if (empty($heroDescriptionPool)) {
  $heroDescriptionPool = array_values(array_filter([
    trim((string) ($sub ?? '')),
    trim((string) ($Home[0] ?? '')),
    trim((string) ($Home[1] ?? '')),
    trim((string) ($LicenseNote ?? ''))
  ], static function ($line) {
    return $line !== '';
  }));
}
if (empty($heroDescriptionPool)) $heroDescriptionPool = ['Professional contractor services across Central Maryland.'];

$heroDirAbs = __DIR__ . '/../../assets/img/hero';
$heroDirRel = 'assets/img/hero';
$imageExts = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'avif'];
$videoExts = ['mp4', 'webm', 'ogg', 'mov'];
$heroFiles = [];

if (is_dir($heroDirAbs)) {
  $scanned = scandir($heroDirAbs);
  if (is_array($scanned)) {
    foreach ($scanned as $file) {
      if ($file === '.' || $file === '..') continue;
      $absPath = $heroDirAbs . DIRECTORY_SEPARATOR . $file;
      if (!is_file($absPath)) continue;
      $heroFiles[] = $file;
    }
  }
}

natsort($heroFiles);
$heroFiles = array_values($heroFiles);

// When enhanced hero assets exist, keep the original low-resolution files as
// non-destructive source material without exposing duplicate slides.
$enhancedHeroFiles = array_values(array_filter($heroFiles, static function ($file) {
  return str_contains(strtolower((string) pathinfo($file, PATHINFO_FILENAME)), '-hd');
}));
if (!empty($enhancedHeroFiles)) {
  $heroFiles = $enhancedHeroFiles;
}

$imageFiles = [];
foreach ($heroFiles as $file) {
  $ext = strtolower((string) pathinfo($file, PATHINFO_EXTENSION));
  if (in_array($ext, $imageExts, true)) $imageFiles[] = $file;
}

$defaultPoster = !empty($imageFiles) ? $heroDirRel . '/' . $imageFiles[0] : 'assets/img/fallback.jpg';
$slides = [];

foreach ($heroFiles as $index => $file) {
  $ext = strtolower((string) pathinfo($file, PATHINFO_EXTENSION));
  $label = vdHeroLabelFromFile($file);
  $statusText = $heroStatusPool[$index % count($heroStatusPool)];
  $descriptionText = $heroDescriptionPool[$index % count($heroDescriptionPool)];

  if (in_array($ext, $imageExts, true)) {
    $src = $heroDirRel . '/' . $file;
    $slides[] = [
      'type' => 'image',
      'src' => $src,
      'poster' => '',
      'texture_src' => $src,
      'title_html' => $heroTitleHtml,
      'status' => $statusText,
      'description' => $descriptionText,
      'alt' => $slideAltPrefix . ' - ' . $label
    ];
    continue;
  }

  if (in_array($ext, $videoExts, true)) {
    $src = $heroDirRel . '/' . $file;
    $poster = vdHeroPosterForVideo($file, $heroDirAbs, $heroDirRel, $defaultPoster);
    $slides[] = [
      'type' => 'video',
      'src' => $src,
      'poster' => $poster,
      'texture_src' => $poster,
      'title_html' => $heroTitleHtml,
      'status' => $statusText,
      'description' => $descriptionText,
      'alt' => $slideAltPrefix . ' - ' . $label
    ];
  }
}

if (empty($slides)) {
  $slides[] = [
    'type' => 'image',
    'src' => $defaultPoster,
    'poster' => '',
    'texture_src' => $defaultPoster,
    'title_html' => $heroTitleHtml,
    'status' => $heroStatusPool[0],
    'description' => $heroDescriptionPool[0],
    'alt' => $slideAltPrefix . ' - Featured Project'
  ];
}

$firstSlide = $slides[0];
$slidesPayload = [];
foreach ($slides as $slide) {
  $slidesPayload[] = [
    'title_html' => $slide['title_html'],
    'status' => $slide['status'],
    'description' => $slide['description'],
    'type' => $slide['type'],
    'texture_src' => $slide['texture_src']
  ];
}
?>

<section class="hero-displace is-loading" id="hero-displace">
  <div class="hero-displace__stage" id="hero-media-stage">
    <?php foreach ($slides as $i => $slide): ?>
      <figure class="hero-displace__media<?php echo $i === 0 ? ' is-active' : ''; ?>"
              data-slide-index="<?php echo $i; ?>"
              data-slide-type="<?php echo htmlspecialchars($slide['type'], ENT_QUOTES, 'UTF-8'); ?>"
              data-texture-src="<?php echo htmlspecialchars($slide['texture_src'], ENT_QUOTES, 'UTF-8'); ?>">
        <?php if ($slide['type'] === 'video'): ?>
          <video class="hero-displace__asset"
                 muted
                 loop
                 playsinline
                 preload="metadata"
                 poster="<?php echo htmlspecialchars($slide['poster'], ENT_QUOTES, 'UTF-8'); ?>"
                 <?php echo $i === 0 ? 'autoplay' : ''; ?>>
            <source src="<?php echo htmlspecialchars($slide['src'], ENT_QUOTES, 'UTF-8'); ?>" type="video/<?php echo strtolower(pathinfo($slide['src'], PATHINFO_EXTENSION)); ?>">
          </video>
        <?php else: ?>
          <img class="hero-displace__asset"
               src="<?php echo htmlspecialchars($slide['src'], ENT_QUOTES, 'UTF-8'); ?>"
               alt="<?php echo htmlspecialchars($slide['alt'], ENT_QUOTES, 'UTF-8'); ?>"
               loading="<?php echo $i === 0 ? 'eager' : 'lazy'; ?>"
               fetchpriority="<?php echo $i === 0 ? 'high' : 'low'; ?>"
               decoding="async">
        <?php endif; ?>
      </figure>
    <?php endforeach; ?>
  </div>

  <div class="hero-displace__webgl" id="hero-webgl-layer" aria-hidden="true"></div>
  <div class="hero-displace__overlay"></div>

  <div class="hero-displace__inner">
    <div class="hero-displace__content" id="hero-slide-content">
      <div class="hero-displace__meta"><?php echo htmlspecialchars($HomeHeroCopy['company_label'] ?? 'Company', ENT_QUOTES, 'UTF-8'); ?></div>
      <div class="hero-displace__brand"><?php echo htmlspecialchars($heroCompany, ENT_QUOTES, 'UTF-8'); ?></div>

      <h2 id="hero-slide-title"><?php echo $firstSlide['title_html']; ?></h2>

      <div class="hero-displace__meta"><?php echo htmlspecialchars($HomeHeroCopy['status_label'] ?? 'Experience', ENT_QUOTES, 'UTF-8'); ?></div>
      <div id="hero-slide-status"><?php echo htmlspecialchars($firstSlide['status'], ENT_QUOTES, 'UTF-8'); ?></div>
      <p id="hero-slide-desc"><?php echo htmlspecialchars($firstSlide['description'], ENT_QUOTES, 'UTF-8'); ?></p>

      <div class="hero-displace__actions">
        <a href="<?php echo htmlspecialchars($ctaPrimaryHref, ENT_QUOTES, 'UTF-8'); ?>" class="hero-displace__btn hero-displace__btn--solid">
          <?php echo htmlspecialchars($ctaPrimary, ENT_QUOTES, 'UTF-8'); ?>
        </a>
        <a href="<?php echo htmlspecialchars($ctaSecondaryHref, ENT_QUOTES, 'UTF-8'); ?>" class="hero-displace__btn hero-displace__btn--ghost">
          <?php echo htmlspecialchars($ctaSecondary, ENT_QUOTES, 'UTF-8'); ?>
        </a>
      </div>
    </div>
  </div>

  <div class="hero-displace__pagination" id="hero-pagination">
    <?php foreach ($slides as $i => $slide): ?>
      <button type="button"
              class="<?php echo $i === 0 ? 'is-active' : ''; ?>"
              data-slide="<?php echo $i; ?>"
              aria-label="Go to slide <?php echo $i + 1; ?>">
      </button>
    <?php endforeach; ?>
  </div>
</section>

<style>
.hero-displace,
.hero-displace * {
  box-sizing: border-box;
}

.hero-displace {
  position: relative;
  width: 100%;
  min-height: clamp(620px, 86vh, 900px);
  background-color: var(--brand-secondary, #101012);
  overflow: hidden;
  isolation: isolate;
  font-family: var(--font-body, 'Barlow', sans-serif);
}

.hero-displace.is-loading::before {
  content: '';
  position: absolute;
  inset: 0;
  z-index: 60;
  background: color-mix(in srgb, var(--brand-secondary, #101012) 88%, #000 12%);
}

.hero-displace.is-loading::after {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  width: 56px;
  height: 56px;
  margin: -28px 0 0 -28px;
  border-radius: 50%;
  background: var(--brand-white, #ffffff);
  opacity: 0.45;
  z-index: 61;
  animation: hero-displace-loader 0.75s linear infinite alternate;
}

@keyframes hero-displace-loader {
  to {
    opacity: 1;
    transform: scale3d(0.5, 0.5, 1);
  }
}

.hero-displace__stage {
  position: absolute;
  inset: 0;
  z-index: 1;
}

.hero-displace__media {
  position: absolute;
  inset: 0;
  opacity: 0;
  transform: scale(1.05);
  transition: opacity 0.9s ease, transform 1.3s ease;
  will-change: opacity, transform;
  pointer-events: none;
}

.hero-displace__media.is-active {
  opacity: 1;
  transform: scale(1);
}

.hero-displace__asset {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center center;
  display: block;
  image-rendering: auto;
  filter: saturate(1.04) contrast(1.03);
}

.hero-displace__webgl {
  position: absolute;
  inset: 0;
  z-index: 2;
  pointer-events: none;
}

.hero-displace__webgl canvas {
  width: 100% !important;
  height: 100% !important;
  display: block;
}

.hero-displace.has-webgl .hero-displace__media {
  opacity: 0 !important;
  transform: none !important;
}

.hero-displace.has-webgl .hero-displace__media.is-video-active {
  opacity: 1 !important;
  z-index: 3;
}

.hero-displace__overlay {
  position: absolute;
  inset: 0;
  z-index: 4;
  background:
    rgba(var(--brand-secondary-rgb, 16, 16, 18), 0.74);
}

.hero-displace__inner {
  position: relative;
  z-index: 5;
  width: 100%;
  height: 100%;
  min-height: clamp(620px, 86vh, 900px);
  display: flex;
  align-items: center;
}

.hero-displace__content {
  width: min(1080px, 92%);
  margin: 0 auto;
  padding: clamp(20px, 4vw, 34px) 10px;
}

.hero-displace__meta {
  display: inline-block;
  font-family: var(--font-body, 'Barlow', sans-serif);
  font-weight: 600;
  font-size: 11px;
  letter-spacing: 4px;
  color: rgba(var(--brand-accent-rgb, 227, 30, 36), 0.86);
  text-transform: uppercase;
  position: relative;
  margin-bottom: 8px;
}

.hero-displace__meta::after {
  content: '';
  position: absolute;
  top: 5px;
  right: -54px;
  width: 42px;
  height: 2px;
  background: rgba(var(--brand-accent-rgb, 227, 30, 36), 0.55);
}

.hero-displace__brand {
  margin: 10px 0 14px;
  font-family: var(--font-body, 'Barlow', sans-serif);
  font-weight: 600;
  font-size: 12px;
  letter-spacing: 3px;
  text-transform: uppercase;
  color: rgba(255, 255, 255, 0.88);
}

#hero-slide-title {
  font-family: var(--font-display, 'Teko', sans-serif);
  font-weight: 600;
  font-size: clamp(34px, 5vw, 62px);
  letter-spacing: 0.6px;
  color: var(--brand-white, #ffffff);
  line-height: 1;
  margin: 0 0 42px;
  max-width: none;
  white-space: nowrap;
  text-transform: uppercase;
  transition: opacity 0.42s ease, transform 0.42s ease;
}

#hero-slide-status {
  margin-top: 10px;
  font-family: var(--font-display, 'Teko', sans-serif);
  font-weight: 500;
  font-size: clamp(22px, 3.2vw, 34px);
  letter-spacing: 0.5px;
  color: var(--brand-white, #ffffff);
  transition: opacity 0.42s ease, transform 0.42s ease;
}

#hero-slide-desc {
  max-width: 620px;
  margin: 14px 0 0;
  font-family: var(--font-body, 'Barlow', sans-serif);
  color: rgba(255, 255, 255, 0.82);
  font-size: clamp(14px, 1.35vw, 17px);
  line-height: 1.8;
  transition: opacity 0.42s ease, transform 0.42s ease;
}

#hero-slide-title.is-leaving,
#hero-slide-status.is-leaving,
#hero-slide-desc.is-leaving {
  opacity: 0;
  transform: translateY(18px);
}

.hero-displace__actions {
  margin-top: 24px;
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
}

.hero-displace__btn {
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 12px 20px;
  border-radius: 999px;
  font-family: var(--font-body, 'Barlow', sans-serif);
  font-weight: 700;
  font-size: 11px;
  letter-spacing: 2px;
  text-transform: uppercase;
  transition: transform 0.25s ease, background 0.25s ease, color 0.25s ease;
}

.hero-displace__btn:hover {
  transform: translateY(-2px);
}

.hero-displace__btn--solid {
  background: var(--brand-accent, #E31E24);
  color: var(--brand-secondary, #101012);
  border: 1px solid var(--brand-accent, #E31E24);
}

.hero-displace__btn--solid:hover {
  background: color-mix(in srgb, var(--brand-accent, #E31E24) 84%, #fff 16%);
}

.hero-displace__btn--ghost {
  color: var(--brand-white, #ffffff);
  border: 1px solid rgba(var(--brand-accent-rgb, 227, 30, 36), 0.70);
  background: rgba(var(--brand-secondary-rgb, 16, 16, 18), 0.24);
}

.hero-displace__btn--ghost:hover {
  background: rgba(var(--brand-accent-rgb, 227, 30, 36), 0.18);
}

.hero-displace__pagination {
  position: absolute;
  top: 50%;
  right: clamp(14px, 2.8vw, 34px);
  transform: translateY(-50%);
  z-index: 7;
}

.hero-displace__pagination button {
  display: block;
  width: 15px;
  height: 15px;
  border-radius: 50%;
  border: 0;
  padding: 0;
  margin: 24px 0;
  cursor: pointer;
  background: var(--brand-accent, #E31E24);
  opacity: 0.24;
  position: relative;
  transition: opacity 0.25s ease;
}

.hero-displace__pagination button:hover {
  opacity: 0.56;
}

.hero-displace__pagination button.is-active {
  opacity: 1;
}

.hero-displace__pagination button.is-active::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 250%;
  height: 250%;
  border-radius: 50%;
  border: 1px solid rgba(var(--brand-accent-rgb, 227, 30, 36), 0.45);
}

@media (max-width: 900px) {
  .hero-displace__pagination {
    right: 12px;
  }
}

@media (max-width: 768px) {
  .hero-displace {
    min-height: calc(100vh - 82px);
  }

  .hero-displace__inner {
    align-items: flex-end;
    min-height: calc(100vh - 82px);
    padding-bottom: 48px;
  }

  .hero-displace__content {
    width: 94%;
    background: rgba(var(--brand-secondary-rgb, 16, 16, 18), 0.72);
    border: 1px solid rgba(var(--brand-accent-rgb, 227, 30, 36), 0.35);
    border-radius: 16px;
    padding: 16px 14px;
    backdrop-filter: blur(6px);
  }

  .hero-displace__meta {
    font-size: 10px;
    letter-spacing: 2.1px;
    margin-bottom: 6px;
  }

  .hero-displace__meta::after {
    right: -42px;
    width: 24px;
  }

  .hero-displace__brand {
    margin: 6px 0 10px;
    font-size: 11px;
    letter-spacing: 2px;
  }

  #hero-slide-title {
    margin-bottom: 16px;
    font-size: clamp(28px, 10vw, 50px);
    line-height: 0.95;
    max-width: 100%;
    white-space: normal;
  }

  #hero-slide-status {
    margin-top: 6px;
    font-size: clamp(16px, 6vw, 27px);
  }

  #hero-slide-desc {
    margin-top: 10px;
    font-size: clamp(13px, 3.6vw, 15px);
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .hero-displace__pagination {
    top: auto;
    bottom: 12px;
    left: 50%;
    right: auto;
    transform: translateX(-50%);
    display: flex;
    align-items: center;
    gap: 14px;
  }

  .hero-displace__pagination button {
    margin: 0;
  }

  .hero-displace__actions {
    margin-top: 14px;
    flex-direction: column;
    align-items: stretch;
  }

  .hero-displace__btn {
    width: 100%;
    padding: 11px 14px;
    font-size: 10px;
    letter-spacing: 1.7px;
  }
}
</style>

<script>
(function () {
  'use strict';

  const root = document.getElementById('hero-displace');
  if (!root) return;

  const webglLayer = document.getElementById('hero-webgl-layer');
  const slides = Array.from(root.querySelectorAll('.hero-displace__media'));
  const buttons = Array.from(root.querySelectorAll('#hero-pagination button'));

  const titleEl = document.getElementById('hero-slide-title');
  const statusEl = document.getElementById('hero-slide-status');
  const descEl = document.getElementById('hero-slide-desc');

  const slideData = <?php echo json_encode($slidesPayload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
  const reducedMotionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');

  let activeSlide = 0;
  let isAnimating = false;
  let autoTimer = null;
  let heroRevealed = false;
  const autoDelay = 5000;

  const webglState = {
    ready: false,
    renderer: null,
    scene: null,
    camera: null,
    material: null,
    mesh: null,
    textures: []
  };

  function shouldDisableWebGL() {
    return reducedMotionQuery.matches;
  }

  function loadScript(src) {
    return new Promise(function (resolve, reject) {
      const existing = document.querySelector('script[data-hero-lib="' + src + '"]');
      if (existing) {
        if (existing.getAttribute('data-loaded') === '1') return resolve();
        existing.addEventListener('load', function () { resolve(); }, { once: true });
        existing.addEventListener('error', function () { reject(new Error('Script load error')); }, { once: true });
        return;
      }

      const script = document.createElement('script');
      script.src = src;
      script.async = true;
      script.setAttribute('data-hero-lib', src);
      script.addEventListener('load', function () {
        script.setAttribute('data-loaded', '1');
        resolve();
      }, { once: true });
      script.addEventListener('error', function () {
        reject(new Error('Script load error'));
      }, { once: true });
      document.head.appendChild(script);
    });
  }

  function ensureThreeLoaded() {
    if (window.THREE) return Promise.resolve();

    return loadScript('assets/js/three.min.js').catch(function () {
      return loadScript('https://cdn.jsdelivr.net/npm/three@0.155.0/build/three.min.js');
    });
  }

  function revealHero() {
    if (heroRevealed) return;
    heroRevealed = true;
    root.classList.remove('is-loading');
    setButtonState(activeSlide);
    setVideoPlayback(activeSlide);
    startAuto();
  }

  function waitForFirstSlideReady(timeoutMs) {
    const firstSlide = slides[0] || null;
    const firstAsset = firstSlide ? firstSlide.querySelector('.hero-displace__asset') : null;

    return new Promise(function (resolve) {
      if (!firstAsset) return resolve();

      let done = false;
      const timer = window.setTimeout(finish, timeoutMs || 1800);

      function finish() {
        if (done) return;
        done = true;
        window.clearTimeout(timer);
        resolve();
      }

      if (firstAsset.tagName === 'IMG') {
        if (firstAsset.complete) return finish();
        firstAsset.addEventListener('load', finish, { once: true });
        firstAsset.addEventListener('error', finish, { once: true });
        return;
      }

      if (firstAsset.tagName === 'VIDEO') {
        if (firstAsset.readyState >= 2) return finish();
        firstAsset.addEventListener('loadeddata', finish, { once: true });
        firstAsset.addEventListener('canplay', finish, { once: true });
        firstAsset.addEventListener('error', finish, { once: true });
        return;
      }

      finish();
    });
  }

  function setButtonState(index) {
    buttons.forEach(function (button, i) {
      button.classList.toggle('is-active', i === index);
    });
  }

  function setVideoPlayback(index) {
    slides.forEach(function (slideEl, i) {
      const video = slideEl.querySelector('video');
      const isVideoSlide = (slideData[i] && slideData[i].type === 'video');
      const shouldShow = (i === index && isVideoSlide);

      slideEl.classList.toggle('is-video-active', shouldShow);

      if (!video) return;
      if (shouldShow) {
        const playPromise = video.play();
        if (playPromise && typeof playPromise.catch === 'function') {
          playPromise.catch(function () {});
        }
      } else {
        video.pause();
      }
    });
  }

  function animateTextChange(targetIndex) {
    [titleEl, statusEl, descEl].forEach(function (el) {
      if (!el) return;
      el.classList.add('is-leaving');
    });

    window.setTimeout(function () {
      if (titleEl) titleEl.innerHTML = slideData[targetIndex].title_html || '';
      if (statusEl) statusEl.textContent = slideData[targetIndex].status || '';
      if (descEl) descEl.textContent = slideData[targetIndex].description || '';

      [titleEl, statusEl, descEl].forEach(function (el) {
        if (!el) return;
        el.classList.remove('is-leaving');
      });
    }, 240);
  }

  function easeExpoInOut(t) {
    if (t === 0) return 0;
    if (t === 1) return 1;
    if (t < 0.5) return Math.pow(2, 20 * t - 10) / 2;
    return (2 - Math.pow(2, -20 * t + 10)) / 2;
  }

  function tweenValue(from, to, duration, onUpdate, onComplete) {
    const start = performance.now();

    function frame(now) {
      const raw = Math.min((now - start) / duration, 1);
      const eased = easeExpoInOut(raw);
      const value = from + (to - from) * eased;
      onUpdate(value);

      if (raw < 1) {
        requestAnimationFrame(frame);
      } else if (typeof onComplete === 'function') {
        onComplete();
      }
    }

    requestAnimationFrame(frame);
  }

  function initWebGL() {
    if (slides.length < 2 || shouldDisableWebGL()) return Promise.resolve(false);

    return new Promise(async function (resolve) {
      try {
        if (!window.THREE) await ensureThreeLoaded();

        if (!window.THREE) return resolve(false);

        const THREE = window.THREE;

        const vertex = `
          varying vec2 vUv;
          void main() {
            vUv = uv;
            gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
          }
        `;

        const fragment = `
          varying vec2 vUv;

          uniform sampler2D currentImage;
          uniform sampler2D nextImage;
          uniform float dispFactor;
          uniform vec2 resolution;
          uniform vec2 currentImageSize;
          uniform vec2 nextImageSize;

          vec2 coverUv(vec2 uv, vec2 screenSize, vec2 imageSize) {
            float screenRatio = screenSize.x / screenSize.y;
            float imageRatio = imageSize.x / imageSize.y;
            vec2 ratio = vec2(
              min(screenRatio / imageRatio, 1.0),
              min(imageRatio / screenRatio, 1.0)
            );
            return uv * ratio + (1.0 - ratio) * 0.5;
          }

          void main() {
            vec2 uvCurrent = coverUv(vUv, resolution, currentImageSize);
            vec2 uvNext = coverUv(vUv, resolution, nextImageSize);
            vec4 _currentImage;
            vec4 _nextImage;
            float intensity = 0.28;

            vec4 orig1 = texture2D(currentImage, uvCurrent);
            vec4 orig2 = texture2D(nextImage, uvNext);

            vec2 dispCurrent = vec2(orig2.r, orig2.g) * intensity;
            vec2 dispNext = vec2(orig1.r, orig1.g) * intensity;
            vec2 currentUvDistorted = clamp(uvCurrent + (dispFactor * dispCurrent), vec2(0.001), vec2(0.999));
            vec2 nextUvDistorted = clamp(uvNext + ((1.0 - dispFactor) * dispNext), vec2(0.001), vec2(0.999));

            _currentImage = texture2D(currentImage, currentUvDistorted);
            _nextImage = texture2D(nextImage, nextUvDistorted);

            vec4 finalTexture = mix(_currentImage, _nextImage, dispFactor);
            gl_FragColor = finalTexture;
          }
        `;

        const width = root.clientWidth || window.innerWidth;
        const height = root.clientHeight || window.innerHeight;

        const renderer = new THREE.WebGLRenderer({ antialias: false, alpha: true });
        renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
        renderer.setClearColor(0x000000, 0);
        renderer.setSize(width, height);

        webglLayer.innerHTML = '';
        webglLayer.appendChild(renderer.domElement);

        const scene = new THREE.Scene();
        const camera = new THREE.OrthographicCamera(width / -2, width / 2, height / 2, height / -2, 1, 1000);
        camera.position.z = 1;

        const loader = new THREE.TextureLoader();
        function loadTexture(url) {
          return new Promise(function (resolveTexture) {
            loader.load(
              (url || ''),
              function (texture) {
                texture.magFilter = texture.minFilter = THREE.LinearFilter;
                texture.anisotropy = renderer.capabilities.getMaxAnisotropy();
                resolveTexture(texture);
              },
              undefined,
              function () {
                resolveTexture(null);
              }
            );
          });
        }

        function textureSize(texture) {
          if (texture && texture.image && texture.image.width && texture.image.height) {
            return new THREE.Vector2(texture.image.width, texture.image.height);
          }
          return new THREE.Vector2(width, height);
        }

        const loadedTextures = await Promise.all(
          slideData.map(function (slide) {
            return loadTexture(slide.texture_src || '');
          })
        );

        const fallbackTexture = loadedTextures.find(function (texture) {
          return !!texture;
        });

        if (!fallbackTexture) return resolve(false);

        const textures = loadedTextures.map(function (texture) {
          return texture || fallbackTexture;
        });

        const firstTexture = textures[0];
        const secondTexture = textures[Math.min(1, textures.length - 1)];
        const firstSize = textureSize(firstTexture);
        const secondSize = textureSize(secondTexture);

        const material = new THREE.ShaderMaterial({
          uniforms: {
            dispFactor: { value: 0.0 },
            currentImage: { value: firstTexture },
            nextImage: { value: secondTexture },
            resolution: { value: new THREE.Vector2(width, height) },
            currentImageSize: { value: firstSize },
            nextImageSize: { value: secondSize }
          },
          vertexShader: vertex,
          fragmentShader: fragment,
          transparent: true,
          opacity: 1.0
        });

        const geometry = new THREE.PlaneGeometry(width, height, 1);
        const mesh = new THREE.Mesh(geometry, material);
        mesh.position.set(0, 0, 0);
        scene.add(mesh);

        function renderLoop() {
          renderer.render(scene, camera);
          requestAnimationFrame(renderLoop);
        }
        renderLoop();

        webglState.ready = true;
        webglState.renderer = renderer;
        webglState.scene = scene;
        webglState.camera = camera;
        webglState.material = material;
        webglState.mesh = mesh;
        webglState.textures = textures;

        root.classList.add('has-webgl');

        function onResize() {
          if (!webglState.ready) return;
          const w = root.clientWidth || window.innerWidth;
          const h = root.clientHeight || window.innerHeight;

          webglState.renderer.setSize(w, h);
          webglState.camera.left = w / -2;
          webglState.camera.right = w / 2;
          webglState.camera.top = h / 2;
          webglState.camera.bottom = h / -2;
          webglState.camera.updateProjectionMatrix();
          webglState.material.uniforms.resolution.value.set(w, h);

          webglState.mesh.geometry.dispose();
          webglState.mesh.geometry = new THREE.PlaneGeometry(w, h, 1);
        }

        window.addEventListener('resize', onResize);
        resolve(true);
      } catch (error) {
        resolve(false);
      }
    });
  }

  function setSlide(targetIndex) {
    if (isAnimating || targetIndex === activeSlide) return;
    if (!slides[targetIndex]) return;

    isAnimating = true;
    setButtonState(targetIndex);
    animateTextChange(targetIndex);

    if (webglState.ready && webglState.material && webglState.textures[targetIndex]) {
      setVideoPlayback(-1);

      function safeTextureSize(texture) {
        if (
          texture &&
          texture.image &&
          texture.image.width &&
          texture.image.height &&
          window.THREE
        ) {
          return new window.THREE.Vector2(texture.image.width, texture.image.height);
        }
        return window.THREE ? new window.THREE.Vector2(root.clientWidth, root.clientHeight) : null;
      }

      const currentSize = safeTextureSize(webglState.textures[activeSlide]);
      const nextSize = safeTextureSize(webglState.textures[targetIndex]);

      webglState.material.uniforms.currentImage.value = webglState.textures[activeSlide];
      webglState.material.uniforms.currentImage.needsUpdate = true;
      webglState.material.uniforms.nextImage.value = webglState.textures[targetIndex];
      webglState.material.uniforms.nextImage.needsUpdate = true;
      if (currentSize) webglState.material.uniforms.currentImageSize.value.copy(currentSize);
      if (nextSize) webglState.material.uniforms.nextImageSize.value.copy(nextSize);
      webglState.material.uniforms.dispFactor.value = 0;

      tweenValue(0, 1, 1000, function (value) {
        webglState.material.uniforms.dispFactor.value = value;
      }, function () {
        webglState.material.uniforms.currentImage.value = webglState.textures[targetIndex];
        webglState.material.uniforms.currentImage.needsUpdate = true;
        if (nextSize) webglState.material.uniforms.currentImageSize.value.copy(nextSize);
        webglState.material.uniforms.dispFactor.value = 0;

        slides.forEach(function (slideEl, i) {
          slideEl.classList.toggle('is-active', i === targetIndex);
        });

        activeSlide = targetIndex;
        setVideoPlayback(activeSlide);
        isAnimating = false;
      });
      return;
    }

    slides[activeSlide].classList.remove('is-active');
    slides[targetIndex].classList.add('is-active');
    activeSlide = targetIndex;
    setVideoPlayback(activeSlide);

    window.setTimeout(function () {
      isAnimating = false;
    }, 650);
  }

  function nextSlide() {
    const next = (activeSlide + 1) % slides.length;
    setSlide(next);
  }

  function startAuto() {
    stopAuto();
    if (slides.length <= 1) return;
    autoTimer = window.setInterval(nextSlide, autoDelay);
  }

  function stopAuto() {
    if (!autoTimer) return;
    window.clearInterval(autoTimer);
    autoTimer = null;
  }

  buttons.forEach(function (button) {
    button.addEventListener('click', function () {
      const slideId = parseInt(button.getAttribute('data-slide') || '0', 10);
      if (Number.isNaN(slideId)) return;
      setSlide(slideId);
      startAuto();
    });
  });

  waitForFirstSlideReady(1200).finally(revealHero);
  window.setTimeout(revealHero, 1500);

  const bootWebGL = function () {
    initWebGL().catch(function () {});
  };
  if ('requestIdleCallback' in window) {
    window.requestIdleCallback(bootWebGL, { timeout: 1400 });
  } else {
    window.setTimeout(bootWebGL, 180);
  }

  document.addEventListener('visibilitychange', function () {
    if (document.hidden) stopAuto();
    else startAuto();
  });
})();
</script>
