<?php
$cred = $AboutCredentialsCopy ?? [];
$credList = $cred['list'] ?? [];
$credCta = $cred['cta'] ?? [];
?>

<section class="section-padding credentials-section bg-light">
    <div class="container credentials-grid">
        <div class="credentials-card">
            <span class="eyebrow"><?php echo htmlspecialchars($cred['eyebrow'] ?? ''); ?></span>
            <h2><?php echo htmlspecialchars($cred['title'] ?? ''); ?></h2>
            <p class="intro-text"><?php echo htmlspecialchars($cred['intro'] ?? ''); ?></p>
            <ul class="cred-list">
                <?php foreach ($credList as $item): ?>
                    <li>
                        <span class="check-dot"></span>
                        <?php if (isset($item['text'])): ?>
                            <?php echo htmlspecialchars($item['text']); ?>
                        <?php else: ?>
                            <?php echo htmlspecialchars($item['label'] ?? ''); ?>: <?php echo htmlspecialchars($item['value'] ?? ''); ?>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="credentials-cta">
            <h3><?php echo htmlspecialchars($credCta['title'] ?? ''); ?></h3>
            <p class="intro-text"><?php echo htmlspecialchars($credCta['desc'] ?? ''); ?></p>
            <div class="cred-actions">
                <a href="<?php echo htmlspecialchars($credCta['primary_href'] ?? 'contact.php'); ?>" class="btn btn-primary"><?php echo htmlspecialchars($credCta['primary_text'] ?? ''); ?></a>
                <a href="<?php echo $PhoneRef; ?>" class="btn btn-outline"><?php echo htmlspecialchars($credCta['secondary_prefix'] ?? ($LabelsCopy['call'] ?? '')); ?>: <?php echo htmlspecialchars($Phone); ?><?php if (!empty($PhoneName)): ?> (<?php echo htmlspecialchars($PhoneName, ENT_QUOTES, 'UTF-8'); ?>)<?php endif; ?></a>
                <?php if (!empty($Phone2) && !empty($PhoneRef2)): ?>
                    <a href="<?php echo $PhoneRef2; ?>" class="btn btn-outline"><?php echo htmlspecialchars($credCta['secondary_prefix'] ?? ($LabelsCopy['call'] ?? '')); ?>: <?php echo htmlspecialchars($Phone2); ?><?php if (!empty($Phone2Name)): ?> (<?php echo htmlspecialchars($Phone2Name, ENT_QUOTES, 'UTF-8'); ?>)<?php endif; ?></a>
                <?php endif; ?>
            </div>
            <div class="cred-meta">
                <span class="meta-chip"><?php echo htmlspecialchars($Schedule); ?></span>
                <span class="meta-chip"><?php echo htmlspecialchars($Coverage); ?></span>
            </div>
        </div>
    </div>
</section>
