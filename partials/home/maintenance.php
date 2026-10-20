<?php
$maintenanceCopy = (isset($HomeMaintenanceCopy) && is_array($HomeMaintenanceCopy)) ? $HomeMaintenanceCopy : [];

$tagline = trim((string) ($maintenanceCopy['tagline'] ?? 'Reliable Crew'));
$title = trim((string) ($maintenanceCopy['title'] ?? 'Repair, Upgrade,'));
$titleStrong = trim((string) ($maintenanceCopy['title_strong'] ?? 'Maintain'));
$description = trim((string) ($maintenanceCopy['desc'] ?? ''));

$cards = (isset($maintenanceCopy['cards']) && is_array($maintenanceCopy['cards'])) ? $maintenanceCopy['cards'] : [];
$foundation = (isset($maintenanceCopy['foundation']) && is_array($maintenanceCopy['foundation'])) ? $maintenanceCopy['foundation'] : [];

$contactHref = 'contact.php';
$serviceHref = 'services.php';
?>

<section class="home-maint-grid" id="<?php echo htmlspecialchars($maintenanceCopy['id'] ?? 'maintenance', ENT_QUOTES, 'UTF-8'); ?>">
  <div class="container home-maint-grid__shell">
    <header class="home-maint-grid__header" data-aos="fade-up">
      <span class="home-maint-grid__tag"><?php echo htmlspecialchars($tagline, ENT_QUOTES, 'UTF-8'); ?></span>
      <h2>
        <?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?>
        <strong><?php echo htmlspecialchars($titleStrong, ENT_QUOTES, 'UTF-8'); ?></strong>
      </h2>
      <?php if ($description !== ''): ?>
        <p><?php echo htmlspecialchars($description, ENT_QUOTES, 'UTF-8'); ?></p>
      <?php endif; ?>
    </header>

    <div class="home-maint-grid__layout">
      <div class="home-maint-grid__cards">
        <?php foreach ($cards as $index => $card): ?>
          <?php
          $icon = trim((string) ($card['icon'] ?? 'fa-tools'));
          $cardTitle = trim((string) ($card['title'] ?? 'Service'));
          $cardText = trim((string) ($card['text'] ?? ''));
          $cardAction = trim((string) ($card['action'] ?? 'See Details'));
          ?>
          <article class="home-maint-grid__card" data-aos="fade-up" data-aos-delay="<?php echo (int) (($index + 1) * 80); ?>">
            <div class="home-maint-grid__icon" aria-hidden="true">
              <i class="fas <?php echo htmlspecialchars($icon, ENT_QUOTES, 'UTF-8'); ?>"></i>
            </div>

            <h3><?php echo htmlspecialchars($cardTitle, ENT_QUOTES, 'UTF-8'); ?></h3>
            <?php if (!empty($card['price'])): ?>
              <p class="home-maint-grid__price"><?php echo htmlspecialchars($card['price'], ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>
            <?php if ($cardText !== ''): ?>
              <p><?php echo htmlspecialchars($cardText, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>

            <a class="home-maint-grid__action" href="<?php echo htmlspecialchars($serviceHref, ENT_QUOTES, 'UTF-8'); ?>">
              <?php echo htmlspecialchars($cardAction, ENT_QUOTES, 'UTF-8'); ?>
              <i class="fas fa-arrow-right" aria-hidden="true"></i>
            </a>
          </article>
        <?php endforeach; ?>
      </div>

      <aside class="home-maint-grid__panel" data-aos="fade-left">
        <h3><?php echo htmlspecialchars($maintenanceCopy['panel_title'] ?? 'Service Standards', ENT_QUOTES, 'UTF-8'); ?></h3>

        <?php if (!empty($foundation)): ?>
          <div class="home-maint-grid__foundation">
            <?php foreach ($foundation as $item): ?>
              <?php
              $icon = trim((string) ($item['icon'] ?? 'fa-check-circle'));
              $itemTitle = trim((string) ($item['title'] ?? 'Value'));
              $itemSubtitle = trim((string) ($item['subtitle'] ?? ''));
              ?>
              <article class="home-maint-grid__foundation-item">
                <i class="fas <?php echo htmlspecialchars($icon, ENT_QUOTES, 'UTF-8'); ?>" aria-hidden="true"></i>
                <div>
                  <strong><?php echo htmlspecialchars($itemTitle, ENT_QUOTES, 'UTF-8'); ?></strong>
                  <?php if ($itemSubtitle !== ''): ?>
                    <span><?php echo htmlspecialchars($itemSubtitle, ENT_QUOTES, 'UTF-8'); ?></span>
                  <?php endif; ?>
                </div>
              </article>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <a class="home-maint-grid__cta" href="<?php echo htmlspecialchars($contactHref, ENT_QUOTES, 'UTF-8'); ?>">
          <?php echo htmlspecialchars($maintenanceCopy['panel_cta'] ?? 'Request Free Estimate', ENT_QUOTES, 'UTF-8'); ?>
        </a>
      </aside>
    </div>
  </div>
</section>

<style>
.home-maint-grid__price {
  margin: -4px 0 10px;
  font-size: 1.55rem;
  font-weight: 800;
  line-height: 1.1;
  color: var(--brand-primary);
}
.home-maint-grid__price small {
  font-size: .8rem;
  font-weight: 600;
}
.home-maint-grid {
  --hmg-bg: var(--brand-neutral);
  --hmg-surface: var(--brand-white);
  --hmg-ink: var(--brand-secondary);
  --hmg-body: color-mix(in srgb, var(--brand-secondary) 64%, var(--brand-white) 36%);
  --hmg-muted: color-mix(in srgb, var(--brand-secondary) 50%, var(--brand-white) 50%);
  --hmg-line: rgba(var(--brand-secondary-rgb), 0.14);
  --hmg-line-soft: rgba(var(--brand-secondary-rgb), 0.09);
  --hmg-accent: var(--brand-accent);
  padding: clamp(72px, 8vw, 118px) 0;
  background: var(--hmg-bg);
  border-top: 1px solid var(--hmg-line-soft);
  border-bottom: 1px solid var(--hmg-line-soft);
}

.home-maint-grid__shell {
  max-width: min(1500px, 96vw) !important;
  width: min(1500px, 96vw);
}

.home-maint-grid__header {
  max-width: 900px;
}

.home-maint-grid__tag {
  display: inline-flex;
  align-items: center;
  min-height: 30px;
  padding: 0 12px;
  border-radius: 999px;
  border: 1px solid rgba(var(--brand-accent-rgb), 0.35);
  background: color-mix(in srgb, var(--brand-accent) 8%, var(--brand-white) 92%);
  color: var(--hmg-accent);
  text-transform: uppercase;
  letter-spacing: 1px;
  font-size: 10px;
  font-weight: 800;
}

.home-maint-grid__header h2 {
  margin: 14px 0 0;
  color: var(--hmg-ink);
  font-size: clamp(2rem, 4.2vw, 3.5rem);
  line-height: 0.95;
}

.home-maint-grid__header h2 strong {
  display: block;
  color: color-mix(in srgb, var(--brand-primary) 88%, var(--brand-secondary) 12%);
}

.home-maint-grid__header p {
  margin: 14px 0 0;
  max-width: 74ch;
  color: var(--hmg-body);
  line-height: 1.74;
}

.home-maint-grid__layout {
  margin-top: clamp(16px, 2.8vw, 24px);
  display: grid;
  grid-template-columns: minmax(0, 1fr) minmax(280px, 0.38fr);
  gap: 12px;
}

.home-maint-grid__cards {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 10px;
}

.home-maint-grid__card {
  border: 1px solid var(--hmg-line);
  border-radius: 14px;
  background: var(--hmg-surface);
  padding: 14px;
  display: flex;
  flex-direction: column;
  min-height: 220px;
  transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
}

.home-maint-grid__card:hover {
  transform: translateY(-3px);
  border-color: rgba(var(--brand-accent-rgb), 0.45);
  box-shadow: 0 16px 28px rgba(var(--brand-secondary-rgb), 0.12);
}

.home-maint-grid__icon {
  width: 44px;
  height: 44px;
  border-radius: 12px;
  border: 1px solid rgba(var(--brand-accent-rgb), 0.34);
  background: color-mix(in srgb, var(--brand-accent) 10%, var(--brand-white) 90%);
  color: var(--hmg-accent);
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-size: 15px;
}

.home-maint-grid__card h3 {
  margin: 12px 0 0;
  color: var(--hmg-ink);
  font-size: clamp(1.15rem, 1.9vw, 1.4rem);
  line-height: 1.05;
  letter-spacing: 0.2px;
  text-transform: uppercase;
}

.home-maint-grid__card p {
  margin: 10px 0 0;
  color: var(--hmg-body);
  line-height: 1.65;
}

.home-maint-grid__action {
  margin-top: auto;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  min-height: 34px;
  padding: 0 11px;
  border-radius: 999px;
  border: 1px solid var(--hmg-line);
  background: color-mix(in srgb, var(--brand-neutral) 74%, var(--brand-white) 26%);
  color: var(--hmg-ink);
  text-decoration: none;
  text-transform: uppercase;
  letter-spacing: 1px;
  font-size: 10px;
  font-weight: 800;
  width: fit-content;
}

.home-maint-grid__panel {
  border: 1px solid var(--hmg-line);
  border-radius: 14px;
  background: color-mix(in srgb, var(--brand-secondary) 3%, var(--brand-white) 97%);
  padding: 14px;
  display: grid;
  align-content: start;
  gap: 10px;
}

.home-maint-grid__panel h3 {
  margin: 0;
  color: var(--hmg-ink);
  font-size: clamp(1.15rem, 2vw, 1.4rem);
  letter-spacing: 0.2px;
}

.home-maint-grid__foundation {
  display: grid;
  gap: 8px;
}

.home-maint-grid__foundation-item {
  border: 1px solid var(--hmg-line);
  border-radius: 11px;
  background: var(--brand-white);
  padding: 10px;
  display: grid;
  grid-template-columns: auto 1fr;
  gap: 10px;
  align-items: center;
}

.home-maint-grid__foundation-item i {
  width: 34px;
  height: 34px;
  border-radius: 999px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  color: var(--brand-white);
  background: var(--hmg-accent);
  font-size: 12px;
}

.home-maint-grid__foundation-item strong {
  display: block;
  color: var(--hmg-ink);
  font-size: 0.97rem;
  line-height: 1.3;
}

.home-maint-grid__foundation-item span {
  display: block;
  margin-top: 2px;
  color: var(--hmg-muted);
  font-size: 12px;
}

.home-maint-grid__cta {
  min-height: 42px;
  border-radius: 999px;
  border: 1px solid var(--hmg-accent);
  background: var(--hmg-accent);
  color: var(--brand-white);
  text-decoration: none;
  text-transform: uppercase;
  letter-spacing: 1px;
  font-size: 10px;
  font-weight: 800;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 0 14px;
}

@media (max-width: 1040px) {
  .home-maint-grid__layout {
    grid-template-columns: minmax(0, 1fr);
  }
}

@media (max-width: 760px) {
  .home-maint-grid {
    padding: 60px 0;
  }

  .home-maint-grid__cards {
    grid-template-columns: minmax(0, 1fr);
  }

  .home-maint-grid__card {
    min-height: 0;
  }
}
</style>
