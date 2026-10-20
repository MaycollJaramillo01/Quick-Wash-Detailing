<?php
$hero = $AboutHeroCopy ?? [];
$heroMeta = $hero['meta'] ?? [];
$heroList = $hero['list'] ?? [];
$heroPrimaryHref = $hero['cta_primary_href'] ?? '#story';
$heroSecondaryPrefix = $hero['cta_secondary_prefix'] ?? ($LabelsCopy['call'] ?? '');
?>

<section class="hero-about">
    <div class="container hero-about-grid">
        <div class="hero-about-text">
            <span class="eyebrow"><?php echo htmlspecialchars($hero['eyebrow'] ?? (($NavCopy['about'] ?? '') . ' ' . ($Company ?? ''))); ?></span>
            <h1><?php echo htmlspecialchars($hero['title'] ?? ''); ?></h1>
            <p class="hero-about-desc"><?php echo htmlspecialchars($hero['desc'] ?? ($About[0] ?? '')); ?></p>
            <div class="hero-about-meta">
                <?php foreach ($heroMeta as $meta): ?>
                    <?php if (!empty($meta)): ?>
                        <span class="meta-chip"><?php echo htmlspecialchars($meta); ?></span>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div class="hero-about-actions">
                <a href="<?php echo htmlspecialchars($heroPrimaryHref); ?>" class="btn btn-primary"><?php echo htmlspecialchars($hero['cta_primary'] ?? ''); ?></a>
                <a href="<?php echo $PhoneRef; ?>" class="btn btn-outline"><?php echo htmlspecialchars($heroSecondaryPrefix); ?>: <?php echo htmlspecialchars($Phone); ?><?php if (!empty($PhoneName)): ?> (<?php echo htmlspecialchars($PhoneName, ENT_QUOTES, 'UTF-8'); ?>)<?php endif; ?></a>
                <?php if (!empty($Phone2) && !empty($PhoneRef2)): ?>
                    <a href="<?php echo $PhoneRef2; ?>" class="btn btn-outline"><?php echo htmlspecialchars($heroSecondaryPrefix); ?>: <?php echo htmlspecialchars($Phone2); ?><?php if (!empty($Phone2Name)): ?> (<?php echo htmlspecialchars($Phone2Name, ENT_QUOTES, 'UTF-8'); ?>)<?php endif; ?></a>
                <?php endif; ?>
            </div>
        </div>
        <div class="hero-about-card">
            <div class="hero-about-list">
                <?php foreach ($heroList as $item): ?>
                    <div class="hero-about-item">
                        <span class="item-label"><?php echo htmlspecialchars($item['label'] ?? ''); ?></span>
                        <p><?php echo htmlspecialchars($item['value'] ?? ''); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
