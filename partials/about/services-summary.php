<?php
$summary = $AboutServicesSummaryCopy ?? [];
$summaryLink = $summary['link_label'] ?? ($NavCopy['explore_service'] ?? '');
$servicesForDisplay = (!empty($ServicesDisplayList) && is_array($ServicesDisplayList))
    ? $ServicesDisplayList
    : ((isset($ServicesList) && is_array($ServicesList)) ? array_values($ServicesList) : []);
?>

<section class="section-padding services-summary">
    <div class="container">
        <div class="section-title">
            <span class="eyebrow"><?php echo htmlspecialchars($summary['eyebrow'] ?? ''); ?></span>
            <h2><?php echo htmlspecialchars($summary['title'] ?? ''); ?></h2>
            <p><?php echo htmlspecialchars($summary['desc'] ?? ''); ?></p>
        </div>
        <div class="services-summary-grid">
            <?php foreach ($servicesForDisplay as $svc): ?>
            <div class="services-summary-card">
                <h3><?php echo htmlspecialchars($svc['name']); ?></h3>
                <p><?php echo htmlspecialchars($svc['description']); ?></p>
                <a href="<?php echo $svc['url']; ?>" class="read-more"><?php echo htmlspecialchars($summaryLink); ?></a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
