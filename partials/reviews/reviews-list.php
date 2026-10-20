<?php
if (!isset($Reviews) || !is_array($Reviews)) {
    $Reviews = $DetailedReviewItems ?? ($GoogleReviewItems ?? []);
    if (empty($Reviews)) {
        $jsonFile = __DIR__ . '/../../data/reviews.json';
        if (file_exists($jsonFile)) {
            $Reviews = json_decode(file_get_contents($jsonFile), true) ?? [];
        } else {
            $Reviews = [];
        }
    }
}

$reviewSources = [];
if (!empty($ReviewSources) && is_array($ReviewSources)) {
    $reviewSources = $ReviewSources;
} elseif (!empty($ReviewSourceSummaries) && is_array($ReviewSourceSummaries)) {
    $reviewSources = $ReviewSourceSummaries;
}

if (empty($reviewSources) && !empty($Reviews)) {
    $grouped = [];
    foreach ($Reviews as $item) {
        $sourceName = trim((string) ($item['source'] ?? 'Client Review'));
        if (!isset($grouped[$sourceName])) {
            $grouped[$sourceName] = [
                'source' => $sourceName,
                'count' => 0,
                'stars_total' => 0,
                'stars_count' => 0
            ];
        }
        $grouped[$sourceName]['count']++;
        $stars = (int) ($item['stars'] ?? 0);
        if ($stars > 0) {
            $grouped[$sourceName]['stars_total'] += $stars;
            $grouped[$sourceName]['stars_count']++;
        }
    }

    foreach ($grouped as $row) {
        $avg = $row['stars_count'] > 0 ? round($row['stars_total'] / $row['stars_count'], 1) : 0;
        $reviewSources[] = [
            'source' => $row['source'],
            'rating' => $avg > 0 ? number_format($avg, 1) . '/5' : 'N/A',
            'count' => $row['count'],
            'label' => 'Based on ' . $row['count'] . ' reviews',
            'url' => ''
        ];
    }
}
?>

<section class="reviews-verified section-padding" id="reviews-list">
    <div class="container reviews-verified__container">
        <header class="reviews-verified__header">
            <span class="reviews-verified__eyebrow"><?php echo htmlspecialchars($ReviewsPageCopy['list_eyebrow'] ?? 'Reviews', ENT_QUOTES, 'UTF-8'); ?></span>
            <h2><?php echo htmlspecialchars($ReviewsPageCopy['list_title'] ?? 'What Our Clients Say', ENT_QUOTES, 'UTF-8'); ?></h2>
            <p><?php echo htmlspecialchars($ReviewsPageCopy['list_desc'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
        </header>

        <?php if (!empty($reviewSources)): ?>
        <div class="reviews-verified__sources">
            <?php foreach ($reviewSources as $source): ?>
                <?php
                $sourceName = trim((string) ($source['source'] ?? 'Review Source'));
                $rating = trim((string) ($source['rating'] ?? ''));
                $count = (int) ($source['count'] ?? 0);
                $label = trim((string) ($source['label'] ?? ''));
                $url = trim((string) ($source['url'] ?? ''));
                ?>
                <article class="rv-source">
                    <div class="rv-source__name"><?php echo htmlspecialchars($sourceName, ENT_QUOTES, 'UTF-8'); ?></div>
                    <div class="rv-source__rating"><?php echo htmlspecialchars($rating, ENT_QUOTES, 'UTF-8'); ?></div>
                    <div class="rv-source__meta">
                        <?php
                        if ($label !== '') {
                            echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8');
                        } elseif ($count > 0) {
                            echo htmlspecialchars('Based on ' . $count . ' reviews', ENT_QUOTES, 'UTF-8');
                        } else {
                            echo 'Verified platform';
                        }
                        ?>
                    </div>
                    <?php if ($url !== ''): ?>
                        <a class="rv-source__link" href="<?php echo htmlspecialchars($url, ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener">View profile</a>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($Reviews)): ?>
        <div class="reviews-verified__grid">
            <?php foreach ($Reviews as $review): ?>
                <?php
                $name = trim((string) ($review['name'] ?? 'Client'));
                $text = trim((string) ($review['text'] ?? ''));
                $source = trim((string) ($review['source'] ?? 'Website Review'));
                $date = trim((string) ($review['date'] ?? ''));
                $city = trim((string) ($review['city'] ?? ''));
                $url = trim((string) ($review['url'] ?? ''));
                $stars = (int) ($review['stars'] ?? 0);
                if ($stars < 0) $stars = 0;
                if ($stars > 5) $stars = 5;
                $initial = mb_strtoupper(mb_substr($name, 0, 1));
                ?>
                <article class="rv-card">
                    <div class="rv-card__top">
                        <span class="rv-card__source"><?php echo htmlspecialchars($source, ENT_QUOTES, 'UTF-8'); ?></span>
                        <?php if ($date !== ''): ?>
                            <span class="rv-card__date"><?php echo htmlspecialchars($date, ENT_QUOTES, 'UTF-8'); ?></span>
                        <?php endif; ?>
                    </div>

                    <?php if ($stars > 0): ?>
                    <div class="rv-card__stars" aria-label="<?php echo htmlspecialchars((string) $stars, ENT_QUOTES, 'UTF-8'); ?> stars">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="fa-solid fa-star<?php echo $i <= $stars ? ' is-filled' : ''; ?>" aria-hidden="true"></i>
                        <?php endfor; ?>
                    </div>
                    <?php endif; ?>

                    <p class="rv-card__text">"<?php echo htmlspecialchars($text, ENT_QUOTES, 'UTF-8'); ?>"</p>

                    <div class="rv-card__footer">
                        <span class="rv-card__avatar"><?php echo htmlspecialchars($initial !== '' ? $initial : 'C', ENT_QUOTES, 'UTF-8'); ?></span>
                        <div class="rv-card__author">
                            <strong><?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?></strong>
                            <small>
                                <?php echo htmlspecialchars($city !== '' ? $city : $source, ENT_QUOTES, 'UTF-8'); ?>
                            </small>
                        </div>
                    </div>

                    <?php if ($url !== ''): ?>
                    <div class="rv-card__actions">
                        <a href="<?php echo htmlspecialchars($url, ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener">View on <?php echo htmlspecialchars($source, ENT_QUOTES, 'UTF-8'); ?></a>
                    </div>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="rv-empty">
            <p>No reviews have been published yet.</p>
        </div>
        <?php endif; ?>

        <div class="reviews-verified__cta">
            <a href="contact.php" class="reviews-verified__btn">
                <?php echo htmlspecialchars($ReviewsPageCopy['list_cta'] ?? 'Leave a Review', ENT_QUOTES, 'UTF-8'); ?>
            </a>
        </div>
    </div>
</section>

<style>
.reviews-verified {
    background:
        #e5edf6;
}

.reviews-verified__container {
    position: relative;
    z-index: 1;
}

.reviews-verified__header {
    text-align: center;
    max-width: 820px;
    margin: 0 auto 34px;
}

.reviews-verified__eyebrow {
    display: inline-block;
    margin-bottom: 8px;
    color: #1c1c1c;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 2px;
    text-transform: uppercase;
}

.reviews-verified__header h2 {
    margin: 0;
    color: #050505;
    font-size: clamp(2rem, 4vw, 3rem);
    line-height: 1.04;
}

.reviews-verified__header p {
    margin: 14px auto 0;
    max-width: 68ch;
    color: #4f6175;
    font-size: clamp(1rem, 1.35vw, 1.1rem);
    line-height: 1.7;
}

.reviews-verified__sources {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 14px;
    margin-bottom: 20px;
}

.rv-source {
    border: 1px solid rgba(31, 42, 54, 0.15);
    border-radius: 14px;
    background: rgba(255, 255, 255, 0.86);
    box-shadow: 0 12px 24px rgba(15, 24, 37, 0.08);
    padding: 16px 18px;
}

.rv-source__name {
    color: #1c1c1c;
    font-size: 12px;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    font-weight: 800;
}

.rv-source__rating {
    margin-top: 6px;
    color: #050505;
    font-size: clamp(1.55rem, 2vw, 1.95rem);
    line-height: 1;
    font-weight: 800;
}

.rv-source__meta {
    margin-top: 4px;
    color: #596c80;
    font-size: 0.92rem;
}

.rv-source__link {
    margin-top: 10px;
    display: inline-flex;
    text-decoration: none;
    color: #1c1c1c;
    font-size: 0.78rem;
    font-weight: 800;
    letter-spacing: 1px;
    text-transform: uppercase;
}

.reviews-verified__grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 14px;
}

.rv-card {
    border: 1px solid rgba(31, 42, 54, 0.15);
    border-radius: 14px;
    background: rgba(255, 255, 255, 0.9);
    box-shadow: 0 12px 24px rgba(15, 24, 37, 0.08);
    padding: 15px;
    display: flex;
    flex-direction: column;
    min-height: 100%;
    transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
}

.rv-card:hover {
    transform: translateY(-4px);
    border-color: rgba(48, 79, 124, 0.28);
    box-shadow: 0 16px 30px rgba(15, 24, 37, 0.14);
}

.rv-card__top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
}

.rv-card__source {
    padding: 4px 10px;
    border-radius: 999px;
    background: rgba(31, 42, 54, 0.08);
    color: #050505;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 1.1px;
    text-transform: uppercase;
}

.rv-card__date {
    color: #5b6f83;
    font-size: 12px;
    font-weight: 600;
}

.rv-card__stars {
    margin-top: 10px;
    display: inline-flex;
    gap: 4px;
}

.rv-card__stars i {
    color: #c2c9d2;
    font-size: 12px;
}

.rv-card__stars i.is-filled {
    color: #1c1c1c;
}

.rv-card__text {
    margin: 10px 0 14px;
    color: #2f4154;
    font-size: 0.95rem;
    line-height: 1.65;
    flex-grow: 1;
}

.rv-card__footer {
    display: flex;
    align-items: center;
    gap: 10px;
    padding-top: 10px;
    border-top: 1px solid rgba(31, 42, 54, 0.1);
}

.rv-card__avatar {
    width: 38px;
    height: 38px;
    border-radius: 999px;
    background: var(--brand-primary);
    color: #fff;
    font-size: 0.9rem;
    font-weight: 800;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.rv-card__author strong {
    display: block;
    color: #050505;
    font-size: 0.93rem;
    line-height: 1.2;
}

.rv-card__author small {
    color: #607487;
    font-size: 0.78rem;
}

.rv-card__actions {
    margin-top: 10px;
}

.rv-card__actions a {
    text-decoration: none;
    font-size: 0.76rem;
    font-weight: 800;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: #1c1c1c;
}

.reviews-verified__cta {
    margin-top: 24px;
    text-align: center;
}

.reviews-verified__btn {
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 46px;
    padding: 12px 24px;
    border-radius: 999px;
    color: #eef3fb;
    background: var(--brand-primary);
    border: 1px solid rgba(31, 42, 54, 0.22);
    font-size: 11px;
    letter-spacing: 2px;
    text-transform: uppercase;
    font-weight: 800;
}

.rv-empty {
    padding: 22px 18px;
    border-radius: 14px;
    border: 1px dashed rgba(31, 42, 54, 0.2);
    background: rgba(255, 255, 255, 0.78);
    text-align: center;
    color: #52667a;
}

@media (max-width: 1080px) {
    .reviews-verified__grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 760px) {
    .reviews-verified__sources {
        grid-template-columns: 1fr;
    }

    .reviews-verified__grid {
        grid-template-columns: 1fr;
    }
}
</style>

