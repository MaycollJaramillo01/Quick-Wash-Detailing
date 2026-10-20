<section class="hero-services">
    <div class="container hero-services-grid">
        <div class="hero-services-text">
            <span class="eyebrow"><?php echo htmlspecialchars($NavCopy['services'] ?? ''); ?></span>
            <h1><?php echo htmlspecialchars($Services); ?></h1>
            <p class="hero-services-desc"><?php echo htmlspecialchars($HomeServicesCopy['desc'] ?? ''); ?></p>
            <div class="hero-services-meta">
                <span class="meta-chip"><?php echo $Experience; ?></span>
                <span class="meta-chip"><?php echo $Estimates; ?></span>
                <span class="meta-chip"><?php echo $LicenseNote; ?></span>
                <span class="meta-chip"><?php echo $Coverage; ?></span>
            </div>
            <div class="hero-services-actions">
                <a href="#services-list" class="btn btn-primary"><?php echo htmlspecialchars($NavCopy['view_services'] ?? ''); ?></a>
                <a href="<?php echo $PhoneRef; ?>" class="btn btn-outline"><?php echo htmlspecialchars($LabelsCopy['call'] ?? ''); ?>: <?php echo $Phone; ?><?php if (!empty($PhoneName)): ?> (<?php echo htmlspecialchars($PhoneName, ENT_QUOTES, 'UTF-8'); ?>)<?php endif; ?></a>
                <?php if (!empty($Phone2) && !empty($PhoneRef2)): ?>
                    <a href="<?php echo $PhoneRef2; ?>" class="btn btn-outline"><?php echo htmlspecialchars($LabelsCopy['call'] ?? ''); ?>: <?php echo $Phone2; ?><?php if (!empty($Phone2Name)): ?> (<?php echo htmlspecialchars($Phone2Name, ENT_QUOTES, 'UTF-8'); ?>)<?php endif; ?></a>
                <?php endif; ?>
            </div>
        </div>
        <div class="hero-services-card">
            <div class="services-card-head">
                <h3><?php echo htmlspecialchars($LabelsCopy['service_areas'] ?? ''); ?></h3>
                <p><?php echo $Coverage; ?></p>
            </div>
            <ul class="services-area-list">
                <?php foreach (array_slice($Areas, 0, 6) as $area): ?>
                <li><?php echo $area; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>
