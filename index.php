<?php
require_once __DIR__ . '/text.php';

/*=========================
  CONFIGURACIÓN DE SEO
  =========================*/
$PageTitle       = ($Company ?? '') . ' ';
$PageDescription = $ExHome ?? ($Home[0] ?? '');
$PageCanonical   = $BaseURL ?? ($Domain ?? '');
$Breadcrumb      = [
    ["name" => ($NavCopy['home'] ?? ''), "url" => $PageCanonical]
];

include __DIR__ . '/header.php';
?>

<?php include __DIR__ . '/partials/home/hero.php'; ?>

<?php include __DIR__ . '/partials/home/about-section.php'; ?>
<?php include __DIR__ . '/partials/shared/why.php'; ?>
<?php include __DIR__ . '/partials/shared/mission.php'; ?>
<?php include __DIR__ . '/partials/home/services.php'; ?>
<?php include __DIR__ . '/partials/home/maintenance.php'; ?>


<?php include __DIR__ . '/partials/shared/process.php'; ?>
<?php include 'partials/shared/testimonials.php'; ?>
<?php // include('partials/reviews/reviews-list.php'); 
?>

<?php include __DIR__ . '/partials/shared/areas-served.php'; ?>

<?php include __DIR__ . '/partials/shared/faq.php'; ?>

<?php include __DIR__ . '/partials/shared/cta.php'; ?>

<section id="contact-section" class="bg-light">
    <?php include __DIR__ . '/partials/shared/contact-form.php'; ?>
</section>

<?php include __DIR__ . '/partials/shared/map.php'; ?>

<?php include __DIR__ . '/footer.php'; ?>