<?php
@session_start();
require_once __DIR__ . '/text.php';

require_once __DIR__ . '/utils/mailer.php';
require_once __DIR__ . '/utils/captcha.php';

// --- DATA LOGIC: Handle Form Submission & Load Reviews ---

// Reseñas aprobadas: agregarlas a data/reviews.json (Vercel no permite escribir archivos,
// por eso las reseñas nuevas se envían por correo para aprobación).
$jsonFile = __DIR__ . '/data/reviews.json';

// 1. Handle POST (New Review) -> email to the owner for approval
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $back = static function (string $query): void {
        header('Location: reviews.php?' . $query . '#review-form-section');
        exit;
    };

    if (!empty($_POST['honeypot'])) $back('success=1');

    $name  = formField('name', 100);
    $city  = formField('city', 100);
    $text  = formField('text', 2000);
    $stars = max(1, min(5, (int) ($_POST['stars'] ?? 5)));

    if (!captchaValid((string) ($_POST['captcha'] ?? ''))) $back('error=captcha');
    if ($name === '' || $city === '' || $text === '') $back('error=required');

    $sent = sendFormEmail([
        'name' => $name,
        'city' => $city,
        'rating' => str_repeat('★', $stars) . ' (' . $stars . '/5)',
        'review' => $text,
    ], 'New Website Review - ' . $Company . ' - ' . $stars . ' stars');

    setcookie('qw_captcha', '', ['expires' => 1, 'path' => '/']);
    $back($sent ? 'success=1' : 'error=send');
}

// 2. Load Reviews for Display (Verified + user submissions)
$Reviews = $DetailedReviewItems ?? ($DirectoryReviewItems ?? ($GoogleReviewItems ?? []));
if (!empty($ReviewSourceSummaries) && is_array($ReviewSourceSummaries)) {
    $ReviewSources = $ReviewSourceSummaries;
}
if (file_exists($jsonFile)) {
    $userReviews = json_decode(file_get_contents($jsonFile), true) ?? [];
    if (!empty($userReviews)) {
        foreach ($userReviews as &$ur) {
            if (empty($ur['source'])) $ur['source'] = 'Website Review';
            if (empty($ur['date'])) $ur['date'] = 'Recently posted';
        }
        unset($ur);
        $Reviews = array_merge($Reviews, $userReviews);
    }
}


// --- VIEW LOGIC ---

// SEO basics
$PageTitle = ($NavCopy['reviews'] ?? '') . ' | ' . ($Company ?? '');
$PageDescription = $ReviewsPageCopy['list_desc'] ?? '';
$PageCanonical = rtrim($BaseURL ?? '', '/') . '/reviews.php';
$BodyClass = 'reviews-page';

include __DIR__ . '/header.php';
?>

<style>
body.reviews-page,
body.reviews-page main,
body.reviews-page .page-content {
  overflow-x: hidden;
  overflow-x: clip;
}

body.reviews-page .review-submit,
body.reviews-page .reviews-verified,
body.reviews-page .section-contact-premium,
body.reviews-page .cta-forge {
  overflow-x: hidden;
  overflow-x: clip;
}

body.reviews-page .review-submit__grid > *,
body.reviews-page .reviews-verified__grid > *,
body.reviews-page .reviews-verified__sources > *,
body.reviews-page .ct-grid > *,
body.reviews-page .cta-forge__layout > * {
  min-width: 0;
}
</style>

<main class="page-content">
  <!-- Reusing Page Hero -->
  <?php 
    $pageHeroTitle = $ReviewsPageCopy['hero_title'] ?? '';
    $pageHeroSubtitle = $ReviewsPageCopy['hero_subtitle'] ?? '';
    $pageHeroImage = $ReviewsPageCopy['hero_image'] ?? "assets/img/hero/hero2.jpg";
    if(!file_exists($pageHeroImage)) $pageHeroImage = "assets/img/fallback.jpg"; // fallback

    include __DIR__ . '/partials/shared/page-hero.php'; 
  ?>
 <?php include __DIR__ . '/partials/reviews/review-form.php'; ?>
  <!-- Reviews List (Uses $Reviews variable loaded above) -->
  <?php include __DIR__ . '/partials/reviews/reviews-list.php'; ?>

  <!-- Submission Form -->
 
  
</main>

<?php include('partials/shared/trusted-partners.php'); ?>
<?php include('partials/shared/contact-form.php'); ?>          
<?php include('partials/shared/cta.php'); ?>
<?php include __DIR__ . '/footer.php'; ?>
