<?php
$defaultHero = $PageHeroCopy['default'] ?? ['title' => $page_name ?? '', 'desc' => '', 'bg' => ''];
$heroTitle = $pageHeroTitle ?? ($page_name ?? ($defaultHero['title'] ?? ''));
$heroKey = 'default';

if (stripos($heroTitle, 'Project') !== false || stripos($heroTitle, 'Gallery') !== false) {
    $heroKey = 'projects';
} elseif (stripos($heroTitle, 'About') !== false) {
    $heroKey = 'about';
} elseif (stripos($heroTitle, 'Contact') !== false) {
    $heroKey = 'contact';
} elseif (stripos($heroTitle, 'Review') !== false || stripos($heroTitle, 'Testimonial') !== false) {
    $heroKey = 'reviews';
} elseif (stripos($heroTitle, 'Other') !== false) {
    $heroKey = 'other';
}

$heroData = $PageHeroCopy[$heroKey] ?? $defaultHero;
$heroTitle = $pageHeroTitle ?? ($heroData['title'] ?? $heroTitle);
$heroDesc = $pageHeroSubtitle ?? ($heroData['desc'] ?? '');
$heroBg = $pageHeroImage ?? ($heroData['bg'] ?? 'assets/img/hero/hero1.jpg');
?>

<section class="page-hero section" style="background-image: url('<?php echo $heroBg; ?>');">
    <div class="hero-overlay"></div>
    <div class="container hero-content text-center">
        <span class="eyebrow"><?php echo $TypeOfService; ?></span>
        <h1><?php echo $heroTitle; ?></h1>
        <p class="lead"><?php echo $heroDesc; ?></p>
    </div>
</section>

<style>
.page-hero {
    position: relative;
    padding: 160px 0 100px;
    background-size: cover;
    background-position: center;
    color: var(--brand-white);
    margin-bottom: 0;
}

.page-hero .hero-overlay{
  position:absolute;
  inset:0;

  background: rgba(<?php echo $BrandColors['secondary_rgb']; ?>, 0.65);
}


.page-hero .hero-content {
    position: relative;
    z-index: 2;
    max-width: 800px;
    margin: 0 auto;
}

.page-hero h1 {
    color: var(--brand-white);
    font-size: 3.5rem;
    margin-bottom: 20px;
}

.page-hero p {
    color: rgba(255,255,255,0.9);
    font-size: 1.2rem;
}

.page-hero .eyebrow {
    color: var(--brand-accent);
    margin-bottom: 16px;
    justify-content: center;
}
</style>
