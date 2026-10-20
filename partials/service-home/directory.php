<section class="shm-directory" id="service-directory" data-shm-root>
  <div class="shm-shell">
    <header class="shm-directory__head" data-aos="fade-up">
      <h2>Browse Every Service</h2>
      <p>Search by keyword, filter by category, and open the exact service request from one place.</p>
    </header>

    <div class="shm-controls" aria-label="Service controls">
      <div class="shm-controls__top">
        <div class="shm-search" role="search">
          <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
          <input id="shmSearch" type="search" placeholder="Search services..." autocomplete="off" />
          <button type="button" id="shmClear" aria-label="Clear search">
            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
          </button>
        </div>

        <div class="shm-results" id="shmResults">
          Showing: <?php echo (int) $serviceHomeServicesCount; ?> / <?php echo (int) $serviceHomeServicesCount; ?>
        </div>
      </div>

      <div class="shm-filters" role="tablist" aria-label="Service filters">
        <?php foreach ($serviceHomeFilterOptions as $index => $filter): ?>
          <button
            type="button"
            class="shm-filter<?php echo $index === 0 ? ' is-active' : ''; ?>"
            data-shm-filter="<?php echo htmlspecialchars((string) ($filter['key'] ?? 'all'), ENT_QUOTES, 'UTF-8'); ?>"
            aria-pressed="<?php echo $index === 0 ? 'true' : 'false'; ?>">
            <?php echo htmlspecialchars((string) ($filter['label'] ?? 'Group'), ENT_QUOTES, 'UTF-8'); ?>
            <span><?php echo (int) ($filter['count'] ?? 0); ?></span>
          </button>
        <?php endforeach; ?>
      </div>
    </div>

    <?php if (!empty($serviceHomeServices)): ?>
      <div class="shm-grid">
        <?php foreach ($serviceHomeServices as $service): ?>
          <?php
          $serviceName = trim((string) ($service['name'] ?? 'Service'));
          $serviceHash = trim((string) ($service['ui_hash'] ?? ''));
          $serviceDesc = trim((string) ($service['ui_desc'] ?? ''));
          $serviceGroup = trim((string) ($service['ui_group'] ?? 'General Services'));
          $serviceGroupKey = trim((string) ($service['ui_group_key'] ?? 'general-services'));
          $serviceImage = trim((string) ($service['ui_image'] ?? 'assets/img/fallback.jpg'));
          $serviceIcon = trim((string) ($service['ui_icon'] ?? 'fa-solid fa-screwdriver-wrench'));
          $serviceCode = trim((string) ($service['ui_code'] ?? 'SVC-00'));
          $serviceHref = trim((string) ($service['ui_href'] ?? 'contact.php'));
          $serviceSearch = trim((string) ($service['ui_search'] ?? ''));
          $serviceBullets = (!empty($service['ui_bullets']) && is_array($service['ui_bullets'])) ? $service['ui_bullets'] : [];
          ?>
          <article
            class="shm-card"
            id="<?php echo htmlspecialchars($serviceHash, ENT_QUOTES, 'UTF-8'); ?>"
            data-shm-card
            data-shm-group="<?php echo htmlspecialchars($serviceGroupKey, ENT_QUOTES, 'UTF-8'); ?>"
            data-shm-search="<?php echo htmlspecialchars($serviceSearch, ENT_QUOTES, 'UTF-8'); ?>"
            data-aos="fade-up">

            <div class="shm-card__media">
              <img src="<?php echo htmlspecialchars($serviceImage, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($serviceName, ENT_QUOTES, 'UTF-8'); ?>">
              <span class="shm-card__group"><?php echo htmlspecialchars($serviceGroup, ENT_QUOTES, 'UTF-8'); ?></span>
            </div>

            <div class="shm-card__body">
              <div class="shm-card__top">
                <i class="shm-card__icon <?php echo htmlspecialchars($serviceIcon, ENT_QUOTES, 'UTF-8'); ?>" aria-hidden="true"></i>
                <span class="shm-card__code"><?php echo htmlspecialchars($serviceCode, ENT_QUOTES, 'UTF-8'); ?></span>
              </div>

              <h3><?php echo htmlspecialchars($serviceName, ENT_QUOTES, 'UTF-8'); ?></h3>
              <p><?php echo htmlspecialchars($serviceDesc, ENT_QUOTES, 'UTF-8'); ?></p>

              <?php if (!empty($serviceBullets)): ?>
                <ul class="shm-card__points" aria-label="Service points">
                  <?php foreach ($serviceBullets as $bullet): ?>
                    <li>
                      <i class="fa-solid fa-check" aria-hidden="true"></i>
                      <span><?php echo htmlspecialchars((string) $bullet, ENT_QUOTES, 'UTF-8'); ?></span>
                    </li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>

              <a class="shm-card__link" href="<?php echo htmlspecialchars($serviceHref, ENT_QUOTES, 'UTF-8'); ?>">
                <span><?php echo htmlspecialchars($serviceHomeLinkLabel, ENT_QUOTES, 'UTF-8'); ?></span>
                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
              </a>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
