<section class="shm-hero">
  <div class="shm-shell">
    <div class="shm-hero__grid">
      <div class="shm-hero__content" data-aos="fade-up">
        <span class="shm-hero__eyebrow"><?php echo htmlspecialchars($serviceHomeEyebrow, ENT_QUOTES, 'UTF-8'); ?></span>

        <h1 class="shm-hero__title">
          <?php echo htmlspecialchars($serviceHomeTitle, ENT_QUOTES, 'UTF-8'); ?>
          <strong><?php echo htmlspecialchars($serviceHomeTitleStrong, ENT_QUOTES, 'UTF-8'); ?></strong>
        </h1>

        <?php if ($serviceHomeDesc !== ''): ?>
          <p class="shm-hero__desc"><?php echo htmlspecialchars($serviceHomeDesc, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>

        <div class="shm-hero__actions">
          <a class="shm-btn shm-btn--solid" href="<?php echo htmlspecialchars($serviceHomeMoreHref, ENT_QUOTES, 'UTF-8'); ?>">
            <?php echo htmlspecialchars($serviceHomeMoreButton, ENT_QUOTES, 'UTF-8'); ?>
          </a>

          <a class="shm-btn shm-btn--line" href="#service-directory"><?php echo htmlspecialchars((string) ($HomeServicesCopy['browse_label'] ?? 'Browse Services'), ENT_QUOTES, 'UTF-8'); ?></a>

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
        </div>

        <div class="shm-hero__stats">
          <?php foreach (($HomeServicesCopy['stats'] ?? []) as $stat): ?>
            <article>
              <strong><?php echo htmlspecialchars((string) ($stat['value'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></strong>
              <span><?php echo htmlspecialchars((string) ($stat['label'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></span>
            </article>
          <?php endforeach; ?>
        </div>
      </div>

      <aside class="shm-hero__panel" data-aos="fade-left">
        <h2><?php echo htmlspecialchars((string) ($HomeServicesCopy['panel']['title'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></h2>
        <p><?php echo htmlspecialchars((string) ($HomeServicesCopy['panel']['desc'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></p>

        <ul class="shm-hero__panel-list" aria-label="<?php echo htmlspecialchars((string) ($HomeServicesCopy['panel']['title'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
          <?php foreach (($HomeServicesCopy['panel']['items'] ?? []) as $panelItem): ?>
          <li>
            <i class="fa-solid <?php echo htmlspecialchars((string) ($panelItem['icon'] ?? 'fa-check'), ENT_QUOTES, 'UTF-8'); ?>" aria-hidden="true"></i>
            <div>
              <strong><?php echo htmlspecialchars((string) ($panelItem['title'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></strong>
              <span><?php echo htmlspecialchars((string) ($panelItem['text'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></span>
            </div>
          </li>
          <?php endforeach; ?>
        </ul>
      </aside>
    </div>
  </div>
</section>
