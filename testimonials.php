<?php
require_once __DIR__ . '/text.php';

$PageTitle = ($Company ?? '') . ' | ' . ($NavCopy['reviews'] ?? '');
$PageDescription = $ReviewsPageCopy['list_desc'] ?? '';
$PageCanonical = ($BaseURL ?? '') . 'reviews.php';
$Breadcrumb = [
  ["name" => ($NavCopy['home'] ?? ''), "url" => $BaseURL ?? '/'],
  ["name" => ($NavCopy['reviews'] ?? ''), "url" => $PageCanonical]
];

include('header.php');
?>

<section class="hero-services">
    <div class="container hero-services-grid">
        <div class="hero-services-text">
            <span class="eyebrow"><?php echo htmlspecialchars($TestimonialsPageCopy['eyebrow'] ?? ''); ?></span>
            <h1><?php echo htmlspecialchars($TestimonialsPageCopy['title'] ?? ''); ?></h1>
            <p class="hero-services-desc"><?php echo htmlspecialchars($TestimonialsPageCopy['desc'] ?? ''); ?></p>
            <div class="hero-services-meta">
                <span class="meta-chip"><?php echo $Experience; ?></span>
                <span class="meta-chip"><?php echo $Coverage; ?></span>
            </div>
        </div>
        <div class="hero-services-card">
            <div class="services-card-head">
                <h3><?php echo htmlspecialchars($TestimonialsPageCopy['card_title'] ?? ''); ?></h3>
                <p><?php echo htmlspecialchars($TestimonialsPageCopy['card_desc'] ?? ''); ?></p>
                <div class="hero-services-actions">
                    <a class="btn btn-primary" href="<?php echo htmlspecialchars($TestimonialsPageCopy['card_link'] ?? $GoogleReviews); ?>" target="_blank"><?php echo htmlspecialchars($TestimonialsPageCopy['card_button'] ?? ''); ?></a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include('partials/shared/testimonials.php'); ?>
<?php include 'partials/shared/trusted-partners.php'; ?>
<?php include('partials/shared/cta.php'); ?>
<?php include('footer.php'); ?>
