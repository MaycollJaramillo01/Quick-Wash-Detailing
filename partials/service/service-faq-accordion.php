<?php
@session_start();
if (!isset($Company)) include_once __DIR__ . '/../../text.php';

$faqBg = '#e9eff6';
$faqSurface = '#f6f8fc';
$faqCard = '#ffffff';
$faqInk = $BrandColors['secondary'] ?? '#1f3147';
$faqAccent = $BrandColors['primary'] ?? '#2f4d76';
$faqMuted = '#5f6f82';

$faqEyebrow = trim((string) ($ServiceFaqCopy['eyebrow'] ?? 'Common Questions'));
$faqTitle = trim((string) ($ServiceFaqCopy['title'] ?? 'Questions About Our'));
$faqTitleStrong = trim((string) ($ServiceFaqCopy['title_strong'] ?? 'Service Process'));
$faqItems = $ServiceFaqCopy['items'] ?? [];
$faqFooter = trim((string) ($ServiceFaqCopy['footer'] ?? 'Need more details?'));
$faqContactLabel = trim((string) ($NavCopy['contact'] ?? 'Contact'));
$faqUid = 'service-faq-' . substr(md5((string) __FILE__), 0, 6);
?>

<section class="service-faq-shell" id="faq"
  style="
    --sf-bg: <?php echo htmlspecialchars($faqBg, ENT_QUOTES, 'UTF-8'); ?>;
    --sf-surface: <?php echo htmlspecialchars($faqSurface, ENT_QUOTES, 'UTF-8'); ?>;
    --sf-card: <?php echo htmlspecialchars($faqCard, ENT_QUOTES, 'UTF-8'); ?>;
    --sf-ink: <?php echo htmlspecialchars($faqInk, ENT_QUOTES, 'UTF-8'); ?>;
    --sf-accent: <?php echo htmlspecialchars($faqAccent, ENT_QUOTES, 'UTF-8'); ?>;
    --sf-muted: <?php echo htmlspecialchars($faqMuted, ENT_QUOTES, 'UTF-8'); ?>;
  ">
  <div class="service-faq-wrap">
    <header class="service-faq-head">
      <p class="service-faq-eyebrow"><?php echo htmlspecialchars($faqEyebrow, ENT_QUOTES, 'UTF-8'); ?></p>
      <h2 class="service-faq-title">
        <?php echo htmlspecialchars($faqTitle, ENT_QUOTES, 'UTF-8'); ?>
        <span><?php echo htmlspecialchars($faqTitleStrong, ENT_QUOTES, 'UTF-8'); ?></span>
      </h2>
    </header>

    <?php if (!empty($faqItems) && is_array($faqItems)): ?>
      <div class="service-faq-list" data-service-faq>
        <?php foreach ($faqItems as $index => $item): ?>
          <?php
          $isOpen = ($index === 0);
          $itemId = $faqUid . '-item-' . ((int) $index + 1);
          $question = trim((string) ($item['question'] ?? ''));
          $answer = trim((string) ($item['answer'] ?? ''));
          $iconClass = trim((string) ($item['icon'] ?? 'fa-circle-question'));
          ?>
          <article class="service-faq-item<?php echo $isOpen ? ' is-open' : ''; ?>">
            <h3 class="service-faq-item-title">
              <button
                type="button"
                class="service-faq-question"
                data-faq-toggle
                aria-expanded="<?php echo $isOpen ? 'true' : 'false'; ?>"
                aria-controls="<?php echo htmlspecialchars($itemId, ENT_QUOTES, 'UTF-8'); ?>">
                <span class="service-faq-question-left">
                  <span class="service-faq-icon">
                    <i class="fa-solid <?php echo htmlspecialchars($iconClass, ENT_QUOTES, 'UTF-8'); ?>" aria-hidden="true"></i>
                  </span>
                  <span class="service-faq-question-text"><?php echo htmlspecialchars($question, ENT_QUOTES, 'UTF-8'); ?></span>
                </span>
                <span class="service-faq-toggle-indicator" aria-hidden="true"></span>
              </button>
            </h3>
            <div
              class="service-faq-answer"
              id="<?php echo htmlspecialchars($itemId, ENT_QUOTES, 'UTF-8'); ?>"
              role="region"
              aria-hidden="<?php echo $isOpen ? 'false' : 'true'; ?>">
              <div class="service-faq-answer-inner">
                <p><?php echo htmlspecialchars($answer, ENT_QUOTES, 'UTF-8'); ?></p>
              </div>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="service-faq-empty">
        <p>FAQ content will be available soon.</p>
      </div>
    <?php endif; ?>

    <p class="service-faq-footer">
      <?php echo htmlspecialchars($faqFooter, ENT_QUOTES, 'UTF-8'); ?>
      <a href="contact.php"><?php echo htmlspecialchars($faqContactLabel, ENT_QUOTES, 'UTF-8'); ?></a>
    </p>
  </div>
</section>

<style>
.service-faq-shell,
.service-faq-shell * {
  box-sizing: border-box;
}

.service-faq-shell {
  position: relative;
  overflow: hidden;
  padding: clamp(78px, 10vw, 116px) 0;
  background:
    var(--sf-surface);
}

.service-faq-shell::before {
  content: '';
  position: absolute;
  inset: 0;
  opacity: 0.35;
  background-image:
    none;
  background-size: 44px 44px;
  pointer-events: none;
}

.service-faq-wrap {
  position: relative;
  z-index: 1;
  width: min(1020px, 92%);
  margin: 0 auto;
}

.service-faq-head {
  text-align: center;
  margin-bottom: clamp(26px, 4vw, 44px);
}

.service-faq-eyebrow {
  margin: 0 0 12px;
  font-size: 12px;
  letter-spacing: 2.1px;
  text-transform: uppercase;
  color: color-mix(in srgb, var(--sf-ink) 80%, #667789 20%);
  font-weight: 700;
}

.service-faq-title {
  margin: 0;
  font-family: var(--font-display, 'Oswald', sans-serif);
  font-size: clamp(2.2rem, 5vw, 3.4rem);
  line-height: 0.98;
  letter-spacing: -0.35px;
  color: var(--sf-ink);
}

.service-faq-title span {
  display: block;
  color: color-mix(in srgb, var(--sf-accent) 88%, #7f92a8 12%);
}

.service-faq-list {
  display: grid;
  gap: 14px;
}

.service-faq-item {
  background: color-mix(in srgb, var(--sf-card) 90%, #edf2f8 10%);
  border: 1px solid color-mix(in srgb, var(--sf-ink) 14%, #dce3ec 86%);
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 10px 28px rgba(30, 49, 71, 0.08);
  transition: border-color 0.25s ease, box-shadow 0.25s ease, transform 0.25s ease;
}

.service-faq-item:hover {
  transform: translateY(-1px);
  border-color: color-mix(in srgb, var(--sf-accent) 44%, #c8d3e0 56%);
  box-shadow: 0 16px 34px rgba(30, 49, 71, 0.12);
}

.service-faq-item-title {
  margin: 0;
}

.service-faq-question {
  width: 100%;
  border: 0;
  margin: 0;
  padding: 18px 22px;
  background: transparent;
  color: var(--sf-ink);
  text-align: left;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  cursor: pointer;
  font: inherit;
}

.service-faq-question:focus-visible {
  outline: 2px solid color-mix(in srgb, var(--sf-accent) 70%, #4f6f96 30%);
  outline-offset: -2px;
}

.service-faq-question-left {
  min-width: 0;
  display: flex;
  align-items: center;
  gap: 13px;
}

.service-faq-icon {
  width: 36px;
  height: 36px;
  flex-shrink: 0;
  border-radius: 10px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  background: color-mix(in srgb, var(--sf-accent) 16%, #dce7f3 84%);
  color: color-mix(in srgb, var(--sf-accent) 82%, #5f7da2 18%);
  font-size: 14px;
}

.service-faq-question-text {
  min-width: 0;
  font-size: clamp(1rem, 1.8vw, 1.12rem);
  line-height: 1.45;
  font-weight: 600;
  color: color-mix(in srgb, var(--sf-ink) 88%, #2f445f 12%);
}

.service-faq-toggle-indicator {
  width: 24px;
  height: 24px;
  flex-shrink: 0;
  border-radius: 999px;
  border: 1px solid color-mix(in srgb, var(--sf-accent) 30%, #c4d0de 70%);
  position: relative;
}

.service-faq-toggle-indicator::before,
.service-faq-toggle-indicator::after {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  width: 10px;
  height: 1.5px;
  background: color-mix(in srgb, var(--sf-accent) 82%, #6b83a1 18%);
  transform: translate(-50%, -50%);
  transition: transform 0.25s ease, opacity 0.25s ease;
}

.service-faq-toggle-indicator::after {
  transform: translate(-50%, -50%) rotate(90deg);
}

.service-faq-item.is-open .service-faq-toggle-indicator::after {
  opacity: 0;
}

.service-faq-answer {
  display: grid;
  grid-template-rows: 0fr;
  transition: grid-template-rows 0.3s ease;
}

.service-faq-answer-inner {
  overflow: hidden;
  padding: 0 22px;
}

.service-faq-answer-inner p {
  margin: 0;
  color: var(--sf-muted);
  font-size: 1rem;
  line-height: 1.72;
}

.service-faq-item.is-open .service-faq-answer {
  grid-template-rows: 1fr;
}

.service-faq-item.is-open .service-faq-answer-inner {
  padding: 0 22px 20px;
}

.service-faq-empty {
  border-radius: 16px;
  border: 1px dashed color-mix(in srgb, var(--sf-accent) 40%, #b8c7d8 60%);
  padding: 26px;
  text-align: center;
  background: rgba(255, 255, 255, 0.5);
}

.service-faq-empty p {
  margin: 0;
  color: var(--sf-muted);
}

.service-faq-footer {
  margin: 28px 0 0;
  text-align: center;
  color: color-mix(in srgb, var(--sf-ink) 74%, #5f7387 26%);
  font-size: 0.98rem;
}

.service-faq-footer a {
  color: color-mix(in srgb, var(--sf-accent) 88%, #34557d 12%);
  font-weight: 700;
  text-decoration: none;
  border-bottom: 1px solid color-mix(in srgb, var(--sf-accent) 44%, #94a8bf 56%);
  transition: color 0.2s ease, border-color 0.2s ease;
}

.service-faq-footer a:hover {
  color: color-mix(in srgb, var(--sf-accent) 96%, #25496e 4%);
  border-color: color-mix(in srgb, var(--sf-accent) 72%, #6f88a4 28%);
}

@media (max-width: 767px) {
  .service-faq-wrap {
    width: min(1080px, calc(100% - 24px));
  }

  .service-faq-question {
    padding: 16px;
    gap: 12px;
  }

  .service-faq-icon {
    width: 32px;
    height: 32px;
    border-radius: 9px;
  }

  .service-faq-answer-inner {
    padding: 0 16px;
  }

  .service-faq-item.is-open .service-faq-answer-inner {
    padding: 0 16px 16px;
  }

  .service-faq-footer {
    padding: 0 8px;
  }
}
</style>

<script>
(function () {
  'use strict';
  var faqRoot = document.querySelector('.service-faq-list[data-service-faq]');
  if (!faqRoot) return;

  var items = Array.prototype.slice.call(faqRoot.querySelectorAll('.service-faq-item'));
  if (!items.length) return;

  function setOpenState(item, shouldOpen) {
    var button = item.querySelector('[data-faq-toggle]');
    var panel = item.querySelector('.service-faq-answer');
    if (!button || !panel) return;
    item.classList.toggle('is-open', shouldOpen);
    button.setAttribute('aria-expanded', shouldOpen ? 'true' : 'false');
    panel.setAttribute('aria-hidden', shouldOpen ? 'false' : 'true');
  }

  items.forEach(function (item, index) {
    var button = item.querySelector('[data-faq-toggle]');
    if (!button) return;

    if (index === 0) setOpenState(item, true);

    button.addEventListener('click', function () {
      var isOpen = item.classList.contains('is-open');
      items.forEach(function (other) {
        setOpenState(other, false);
      });
      setOpenState(item, !isOpen);
    });
  });
})();
</script>
