<?php if (!empty($serviceHomeCategoryPanels)): ?>
<section class="shm-groups" aria-label="Service groups">
  <div class="shm-shell">
    <div class="shm-groups__grid">
      <?php foreach ($serviceHomeCategoryPanels as $panel): ?>
        <article class="shm-groups__card" id="<?php echo htmlspecialchars((string) ($panel['id'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>" data-aos="fade-up">
          <div class="shm-groups__head">
            <h3><?php echo htmlspecialchars((string) ($panel['label'] ?? 'Group'), ENT_QUOTES, 'UTF-8'); ?></h3>
            <a href="#service-directory">Explore</a>
          </div>

          <?php if (!empty($panel['summary'])): ?>
            <p><?php echo htmlspecialchars((string) $panel['summary'], ENT_QUOTES, 'UTF-8'); ?></p>
          <?php endif; ?>

          <?php if (!empty($panel['items']) && is_array($panel['items'])): ?>
            <div class="shm-groups__links">
              <?php foreach ($panel['items'] as $item): ?>
                <a href="<?php echo htmlspecialchars((string) ($item['href'] ?? '#service-directory'), ENT_QUOTES, 'UTF-8'); ?>">
                  <?php echo htmlspecialchars((string) ($item['name'] ?? 'Service'), ENT_QUOTES, 'UTF-8'); ?>
                </a>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>
