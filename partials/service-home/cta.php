<section class="shm-cta">
  <div class="shm-shell">
    <div class="shm-cta__wrap" data-aos="fade-up">
      <div class="shm-cta__copy">
        <h2>
          <?php echo htmlspecialchars($serviceHomeMoreTitle, ENT_QUOTES, 'UTF-8'); ?>
          <strong><?php echo htmlspecialchars((string) ($HomeServicesCopy['more_title_strong'] ?? 'Start Your Project'), ENT_QUOTES, 'UTF-8'); ?></strong>
        </h2>

        <p><?php echo htmlspecialchars($serviceHomeMoreDesc, ENT_QUOTES, 'UTF-8'); ?></p>

        <ul class="shm-cta__meta" aria-label="Service details">
          <li>
            <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
            <span><?php echo htmlspecialchars($serviceHomeCoverage, ENT_QUOTES, 'UTF-8'); ?></span>
          </li>
          <li>
            <i class="fa-solid fa-clock" aria-hidden="true"></i>
            <span><?php echo htmlspecialchars($serviceHomeSchedule, ENT_QUOTES, 'UTF-8'); ?></span>
          </li>
          <li>
            <i class="fa-solid fa-briefcase" aria-hidden="true"></i>
            <span><?php echo htmlspecialchars($serviceHomeType, ENT_QUOTES, 'UTF-8'); ?></span>
          </li>
          <li>
            <i class="fa-solid fa-shield-halved" aria-hidden="true"></i>
            <span><?php echo htmlspecialchars($serviceHomeLicense, ENT_QUOTES, 'UTF-8'); ?></span>
          </li>
        </ul>
      </div>

      <div class="shm-cta__actions">
        <a class="shm-btn shm-btn--solid" href="<?php echo htmlspecialchars($serviceHomeMoreHref, ENT_QUOTES, 'UTF-8'); ?>">
          <?php echo htmlspecialchars($serviceHomeMoreButton, ENT_QUOTES, 'UTF-8'); ?>
        </a>
        <a class="shm-btn shm-btn--line" href="services.php">View All Services</a>

        <?php if ($serviceHomePhoneMain !== '' && $serviceHomePhoneMainRef !== ''): ?>
          <a class="shm-btn shm-btn--ghost" href="<?php echo htmlspecialchars($serviceHomePhoneMainRef, ENT_QUOTES, 'UTF-8'); ?>">
            <?php echo htmlspecialchars($serviceHomePhoneMain, ENT_QUOTES, 'UTF-8'); ?>
            <?php if ($serviceHomePhoneMainLabel !== '') echo '(' . htmlspecialchars($serviceHomePhoneMainLabel, ENT_QUOTES, 'UTF-8') . ')'; ?>
          </a>
        <?php endif; ?>

        <?php if ($serviceHomePhoneAlt !== '' && $serviceHomePhoneAltRef !== ''): ?>
          <a class="shm-btn shm-btn--ghost" href="<?php echo htmlspecialchars($serviceHomePhoneAltRef, ENT_QUOTES, 'UTF-8'); ?>">
            <?php echo htmlspecialchars($serviceHomePhoneAlt, ENT_QUOTES, 'UTF-8'); ?>
            <?php if ($serviceHomePhoneAltLabel !== '') echo '(' . htmlspecialchars($serviceHomePhoneAltLabel, ENT_QUOTES, 'UTF-8') . ')'; ?>
          </a>
        <?php endif; ?>

        <?php if ($serviceHomeWhatsapp !== ''): ?>
          <a class="shm-btn shm-btn--line" target="_blank" rel="noopener" href="<?php echo htmlspecialchars($serviceHomeWhatsapp, ENT_QUOTES, 'UTF-8'); ?>">
            WhatsApp
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
