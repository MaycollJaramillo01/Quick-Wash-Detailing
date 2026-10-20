<?php
@session_start();
require_once dirname(__DIR__, 2) . '/text.php';
$gallery = $GalleryHeroCopy ?? [];
$galleryEyebrow = $gallery['eyebrow'] ?? '';
$galleryTitle = $gallery['title'] ?? '';
$galleryDesc = $gallery['desc'] ?? '';
$galleryCtaText = $gallery['cta_text'] ?? '';
$galleryCtaHref = $gallery['cta_href'] ?? 'contact.php';
?>

<section class="gallery-hero-nova section" id="gallery-hero">
  <style>
    .gallery-hero-nova {
      position: relative;
      min-height: 75vh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      background: url('assets/img/hero/hero1.jpg') center/cover no-repeat fixed;
      color: var(--color-light);
      overflow: hidden;
    }

    /* Overlay using root vars */
    .gallery-hero-nova::before {
      content: "";
      position: absolute;
      inset: 0;
      background:
        rgba(0,0,0,0.85);
      z-index: var(--z-bg);
    }

    .gallery-hero__content {
      position: relative;
      z-index: var(--z-content);
      padding: 0 24px;
      max-width: 880px;
      animation: fadeInUp 1.2s var(--transition-smooth) forwards;
    }

    .gallery-hero__eyebrow {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      font: 700 .95rem/1 var(--body-font);
      color: var(--color-accent);
      text-transform: uppercase;
      letter-spacing: .12em;
      margin-bottom: 14px;
    }

    .gallery-hero__title {
      font: 800 clamp(36px, 6vw, 60px)/1.1 var(--title-font);
      margin-bottom: 18px;
      color: var(--color-light);
      text-shadow: 0 4px 14px rgba(0,0,0,0.6);
    }

    .gallery-hero__desc {
      font: 400 1.1rem/1.8 var(--body-font);
      max-width: 700px;
      margin: 0 auto 34px;
      color: var(--color-ivory-alpha-92);
    }

    .gallery-hero__cta {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      background: var(--color-accent);
      color: var(--accent-contrast);
      font: 700 .95rem/1 var(--body-font);
      text-transform: uppercase;
      border-radius: 50px;
      padding: 14px 36px;
      transition: var(--transition-fast);
      box-shadow: var(--shadow-soft);
      text-decoration: none;
    }

    .gallery-hero__cta:hover {
      background: var(--color-soft);
      color: var(--color-light);
      transform: translateY(-4px);
      box-shadow: 0 10px 28px rgba(0,0,0,0.35);
    }

    .gallery-hero__cta i { transition: transform .3s ease; }
    .gallery-hero__cta:hover i { transform: translateX(6px); }

    @keyframes fadeInUp {
      from {opacity: 0; transform: translateY(40px);}
      to {opacity: 1; transform: translateY(0);}
    }

    @media (max-width: 768px) {
      .gallery-hero-nova {
        min-height: 60vh;
        background-attachment: scroll;
      }
      .gallery-hero__title { font-size: 2.2rem; }
      .gallery-hero__desc { font-size: 1rem; }
    }
  </style>

  <div class="gallery-hero__content container">
    <span class="gallery-hero__eyebrow">
      <i class="fa-solid fa-images"></i> <?php echo htmlspecialchars($galleryEyebrow); ?>
    </span>

    <h1 class="gallery-hero__title"><?php echo htmlspecialchars($galleryTitle); ?></h1>

    <p class="gallery-hero__desc">
      <?php echo htmlspecialchars($galleryDesc); ?>
    </p>

    <a href="<?php echo htmlspecialchars($galleryCtaHref); ?>" class="gallery-hero__cta">
      <i class="fa-solid fa-arrow-right"></i> <?php echo htmlspecialchars($galleryCtaText); ?>
    </a>
  </div>
</section>
