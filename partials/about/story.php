<?php
$story = $AboutStoryCopy ?? [];
$storyPoints = $story['points'] ?? [];
$storyActions = $story['actions'] ?? [];
$storyStats = $story['stats'] ?? [];
$areasSeparator = $storyStats['areas_separator'] ?? ', ';
$areasPreviewCount = (int) ($storyStats['areas_preview_count'] ?? 5);
if ($areasPreviewCount <= 0) {
    $areasPreviewCount = 5;
}
$serviceNames = array_map(function ($s) { return $s['name']; }, $ServicesList);
$areasPreview = implode($areasSeparator, array_slice($Areas, 0, $areasPreviewCount));
?>

<section class="section-padding story-section" id="story">
    <div class="container story-grid">
        <div class="story-copy">
            <span class="eyebrow"><?php echo htmlspecialchars($story['eyebrow'] ?? ''); ?></span>
            <h2><?php echo htmlspecialchars($story['title'] ?? ''); ?></h2>
            <p><?php echo htmlspecialchars($About[0] ?? ''); ?></p>
            <?php if (isset($About[1])): ?>
            <p><?php echo htmlspecialchars($About[1]); ?></p>
            <?php endif; ?>
            <div class="story-points">
                <?php foreach ($storyPoints as $point): ?>
                <div class="point">
                    <h4><?php echo htmlspecialchars($point['title'] ?? ''); ?></h4>
                    <p><?php echo htmlspecialchars($point['text'] ?? ''); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="story-actions">
                <a href="<?php echo htmlspecialchars($storyActions['primary_href'] ?? 'contact.php'); ?>" class="btn btn-primary"><?php echo htmlspecialchars($storyActions['primary_text'] ?? ''); ?></a>
                <a href="<?php echo $PhoneRef; ?>" class="link-underline"><?php echo htmlspecialchars($storyActions['secondary_prefix'] ?? ($LabelsCopy['call'] ?? '')); ?>: <?php echo htmlspecialchars($Phone); ?><?php if (!empty($PhoneName)): ?> (<?php echo htmlspecialchars($PhoneName, ENT_QUOTES, 'UTF-8'); ?>)<?php endif; ?></a>
                <?php if (!empty($Phone2) && !empty($PhoneRef2)): ?>
                    <a href="<?php echo $PhoneRef2; ?>" class="link-underline"><?php echo htmlspecialchars($storyActions['secondary_prefix'] ?? ($LabelsCopy['call'] ?? '')); ?>: <?php echo htmlspecialchars($Phone2); ?><?php if (!empty($Phone2Name)): ?> (<?php echo htmlspecialchars($Phone2Name, ENT_QUOTES, 'UTF-8'); ?>)<?php endif; ?></a>
                <?php endif; ?>
            </div>
        </div>
        <div class="story-card">
            <div class="story-stat">
                <span class="stat-label"><?php echo htmlspecialchars($storyStats['years_label'] ?? ''); ?></span>
                <span class="stat-value"><?php echo htmlspecialchars($Experience); ?></span>
            </div>
            <div class="story-stat">
                <span class="stat-label"><?php echo htmlspecialchars($storyStats['services_label'] ?? ''); ?></span>
                <span class="stat-value"><?php echo count($ServicesList); ?></span>
                <p class="stat-note"><?php echo htmlspecialchars(implode(', ', $serviceNames)); ?></p>
            </div>
            <div class="story-stat">
                <span class="stat-label"><?php echo htmlspecialchars($storyStats['areas_label'] ?? ''); ?></span>
                <span class="stat-value"><?php echo count($Areas); ?>+</span>
                <p class="stat-note"><?php echo htmlspecialchars($areasPreview); ?></p>
            </div>
        </div>
    </div>
</section>
