<?php
require_once 'text.php';
$page_name = $NavCopy['about'] ?? '';
include 'header.php';
?>

<?php include 'partials/shared/page-hero.php'; ?>

<?php include 'partials/home/about-section.php'; ?>




<?php include 'partials/shared/mission.php'; ?>

<?php include 'partials/shared/why.php'; ?>

<?php include 'partials/shared/testimonials.php'; ?>

<?php // include 'partials/shared/trusted-partners.php'; ?>

<?php include 'partials/shared/cta.php'; ?>

<?php include 'partials/shared/map.php'; ?>
<?php include 'footer.php'; ?>
