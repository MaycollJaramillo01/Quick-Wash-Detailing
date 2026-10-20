<section class="section-padding faq-section bg-light">
    <div class="container">
        <div class="section-title">
            <h2 data-anim="fade-up"><?php echo htmlspecialchars($FaqCopy['title'] ?? ''); ?></h2>
        </div>
        <div class="faq-container">
            <?php foreach (($FaqCopy['items'] ?? []) as $item): ?>
            <div class="faq-item">
                <div class="faq-question">
                    <h3><?php echo htmlspecialchars($item['q'] ?? ''); ?></h3>
                    <span class="toggle-icon">+</span>
                </div>
                <div class="faq-answer">
                    <p><?php echo htmlspecialchars($item['a'] ?? ''); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
