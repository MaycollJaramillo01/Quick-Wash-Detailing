<?php
require_once __DIR__ . '/text.php';
$PageTitle = ($Company ?? '') . ' | ' . ($ThankYouCopy['title'] ?? '');
$PageDescription = $ThankYouCopy['description'] ?? '';
$PageCanonical = rtrim($BaseURL ?? '', '/') . '/thank-you.php';
include 'header.php';
?>

<section class="section-padding bg-light">
    <div class="container text-center" style="max-width: 760px;">
        <span class="eyebrow"><?php echo htmlspecialchars($ThankYouCopy['eyebrow'] ?? ''); ?></span>
        <h1><?php echo htmlspecialchars($ThankYouCopy['headline'] ?? ''); ?></h1>
        <p><?php echo htmlspecialchars($ThankYouCopy['body'] ?? ''); ?></p>
        <div style="margin-top: 25px;">
            <a class="btn btn-primary" href="<?php echo $PhoneRef; ?>"><?php echo htmlspecialchars($ThankYouCopy['cta_call'] ?? ''); ?></a>
            <a class="btn btn-outline" href="<?php echo $BaseURL; ?>" style="margin-left: 10px;"><?php echo htmlspecialchars($ThankYouCopy['cta_home'] ?? ''); ?></a>
        </div>
    </div>
</section>

<?php include 'partials/shared/trusted-partners.php'; ?>
<?php include 'footer.php'; ?>
