<?php
$submittedReviews = [];
$reviewJsonFile = __DIR__ . '/../../data/reviews.json';

if (is_file($reviewJsonFile)) {
    $decodedReviews = json_decode((string) file_get_contents($reviewJsonFile), true);
    if (is_array($decodedReviews)) {
        foreach ($decodedReviews as $row) {
            if (!is_array($row)) continue;

            $name = trim((string) ($row['name'] ?? 'Client'));
            $city = trim((string) ($row['city'] ?? ''));
            $text = trim((string) ($row['text'] ?? ''));
            $date = trim((string) ($row['date'] ?? 'Recently posted'));
            $stars = (int) ($row['stars'] ?? 5);
            if ($stars < 1) $stars = 1;
            if ($stars > 5) $stars = 5;

            if ($text === '') continue;

            $submittedReviews[] = [
                'name' => $name !== '' ? $name : 'Client',
                'city' => $city,
                'text' => $text,
                'date' => $date !== '' ? $date : 'Recently posted',
                'stars' => $stars
            ];
        }
    }
}

$submittedReviews = array_slice($submittedReviews, 0, 8);
?>

<section class="review-submit section-padding" id="review-form-section">
    <div class="container">
        <div class="review-submit__grid">
            <div class="review-submit__panel review-submit__panel--form">
                <div class="review-submit__head">
                    <h3><?php echo htmlspecialchars($ReviewFormCopy['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?></h3>
                    <p><?php echo htmlspecialchars($ReviewFormCopy['subtitle'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                </div>

                <?php if (isset($_GET['success'])): ?>
                    <div class="review-submit__alert review-submit__alert--success" role="alert">
                        <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                        <div>
                            <strong><?php echo htmlspecialchars($ReviewFormCopy['success_title'] ?? '', ENT_QUOTES, 'UTF-8'); ?></strong>
                            <span><?php echo htmlspecialchars($ReviewFormCopy['success_message'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                    </div>
                <?php endif; ?>

                <?php
                $reviewErrors = [
                    'captcha' => $ReviewFormCopy['captcha_error'] ?? '',
                    'required' => $ReviewFormCopy['required_error'] ?? '',
                    'send' => $ReviewFormCopy['send_error'] ?? '',
                ];
                $reviewError = $reviewErrors[(string) ($_GET['error'] ?? '')] ?? '';
                ?>
                <?php if ($reviewError !== ''): ?>
                    <div class="review-submit__alert review-submit__alert--error" role="alert">
                        <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
                        <div>
                            <strong><?php echo htmlspecialchars($ReviewFormCopy['error_title'] ?? '', ENT_QUOTES, 'UTF-8'); ?></strong>
                            <span><?php echo htmlspecialchars($reviewError, ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                    </div>
                <?php endif; ?>

                <form action="reviews.php#review-form-section" method="POST" class="review-submit__form">
                    <div class="review-submit__row">
                        <div class="review-submit__field">
                            <label for="name"><?php echo htmlspecialchars($ReviewFormCopy['labels']['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?></label>
                            <input type="text" id="name" name="name" maxlength="100" required placeholder="<?php echo htmlspecialchars($ReviewFormCopy['placeholders']['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                        <div class="review-submit__field">
                            <label for="city"><?php echo htmlspecialchars($ReviewFormCopy['labels']['city'] ?? '', ENT_QUOTES, 'UTF-8'); ?></label>
                            <input type="text" id="city" name="city" maxlength="100" required placeholder="<?php echo htmlspecialchars($ReviewFormCopy['placeholders']['city'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                    </div>

                    <div class="review-submit__field">
                        <label><?php echo htmlspecialchars($ReviewFormCopy['labels']['rating'] ?? '', ENT_QUOTES, 'UTF-8'); ?></label>
                        <div class="review-submit__rating">
                            <div class="review-submit__star-group" data-rating-group>
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <input type="radio" class="btn-check" name="stars" id="star<?php echo $i; ?>" value="<?php echo $i; ?>" <?php echo $i === 5 ? 'checked' : ''; ?>>
                                    <label class="review-submit__star" data-value="<?php echo $i; ?>" for="star<?php echo $i; ?>">
                                        <i class="fa-solid fa-star" aria-hidden="true"></i>
                                    </label>
                                <?php endfor; ?>
                            </div>
                            <span class="review-submit__hint"><?php echo htmlspecialchars($ReviewFormCopy['labels']['rating_hint'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                    </div>

                    <div class="review-submit__field">
                        <label for="text"><?php echo htmlspecialchars($ReviewFormCopy['labels']['review'] ?? '', ENT_QUOTES, 'UTF-8'); ?></label>
                        <textarea id="text" name="text" rows="4" maxlength="2000" required placeholder="<?php echo htmlspecialchars($ReviewFormCopy['placeholders']['review'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"></textarea>
                    </div>

                    <div class="review-submit__field">
                        <label><?php echo htmlspecialchars($ReviewFormCopy['labels']['security'] ?? '', ENT_QUOTES, 'UTF-8'); ?></label>
                        <div class="review-submit__captcha-row">
                            <div class="review-submit__captcha-box">
                                <img src="utils/captcha.php" alt="<?php echo htmlspecialchars($ReviewFormCopy['captcha_alt'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" id="captchaSvg">
                            </div>
                            <button
                                type="button"
                                class="review-submit__captcha-refresh"
                                onclick="document.getElementById('captchaSvg').src='utils/captcha.php?'+Math.random();">
                                <i class="fa-solid fa-rotate" aria-hidden="true"></i>
                                <?php echo htmlspecialchars($ReviewFormCopy['labels']['refresh'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                            </button>
                        </div>
                        <input type="text" name="captcha" required autocomplete="off" maxlength="5" autocapitalize="characters" placeholder="<?php echo htmlspecialchars($ReviewFormCopy['labels']['captcha'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    </div>

                    <div style="position:absolute; left:-9999px;" aria-hidden="true">
                        <label for="review-honeypot">Leave this field empty</label>
                        <input type="text" id="review-honeypot" name="honeypot" tabindex="-1" autocomplete="off">
                    </div>

                    <button type="submit" class="review-submit__button">
                        <?php echo htmlspecialchars($ReviewFormCopy['submit'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                    </button>
                </form>
            </div>

            <aside class="review-submit__panel review-submit__panel--feed" aria-label="Latest website reviews">
                <div class="review-feed__head">
                    <h4>Latest Website Reviews</h4>
                    <span><?php echo count($submittedReviews); ?> Posted</span>
                </div>

                <?php if (!empty($submittedReviews)): ?>
                    <div class="review-feed__list">
                        <?php foreach ($submittedReviews as $item): ?>
                            <?php
                            $reviewText = trim((string) ($item['text'] ?? ''));
                            $reviewPreview = mb_strlen($reviewText) > 180 ? mb_substr($reviewText, 0, 180) . '...' : $reviewText;
                            $reviewName = trim((string) ($item['name'] ?? 'Client'));
                            $reviewCity = trim((string) ($item['city'] ?? ''));
                            $reviewDate = trim((string) ($item['date'] ?? 'Recently posted'));
                            $reviewStars = (int) ($item['stars'] ?? 5);
                            ?>
                            <article class="review-feed__item">
                                <div class="review-feed__top">
                                    <strong><?php echo htmlspecialchars($reviewName, ENT_QUOTES, 'UTF-8'); ?></strong>
                                    <small><?php echo htmlspecialchars($reviewDate, ENT_QUOTES, 'UTF-8'); ?></small>
                                </div>
                                <div class="review-feed__stars" aria-label="<?php echo (int) $reviewStars; ?> stars">
                                    <?php for ($s = 1; $s <= 5; $s++): ?>
                                        <i class="fa-solid fa-star<?php echo $s <= $reviewStars ? ' is-filled' : ''; ?>" aria-hidden="true"></i>
                                    <?php endfor; ?>
                                </div>
                                <p><?php echo htmlspecialchars($reviewPreview, ENT_QUOTES, 'UTF-8'); ?></p>
                                <?php if ($reviewCity !== ''): ?>
                                    <span class="review-feed__city"><?php echo htmlspecialchars($reviewCity, ENT_QUOTES, 'UTF-8'); ?></span>
                                <?php endif; ?>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="review-feed__empty">
                        <p><?php echo htmlspecialchars($ReviewsPageCopy['empty'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                    </div>
                <?php endif; ?>
            </aside>
        </div>
    </div>
</section>

<style>
.review-submit {
    background:
        #e6edf6;
}

.review-submit__grid {
    display: grid;
    grid-template-columns: minmax(0, 0.88fr) minmax(0, 1.12fr);
    gap: 18px;
    align-items: start;
}

.review-submit__panel {
    background: rgba(255, 255, 255, 0.9);
    border: 1px solid rgba(31, 42, 54, 0.12);
    border-radius: 16px;
    box-shadow: 0 16px 34px rgba(12, 21, 34, 0.08);
    min-width: 0;
}

.review-submit__panel--form {
    padding: 22px;
}

.review-submit__panel--feed {
    padding: 18px;
}

.review-submit__head h3 {
    margin: 0;
    font-size: clamp(1.5rem, 2.2vw, 2rem);
    color: #050505;
}

.review-submit__head p {
    margin: 8px 0 0;
    color: #5f7388;
    font-size: 0.96rem;
    line-height: 1.6;
}

.review-submit__alert {
    margin-top: 14px;
    border-radius: 12px;
    padding: 10px 12px;
    display: flex;
    gap: 10px;
    align-items: flex-start;
    font-size: 0.9rem;
}

.review-submit__alert strong {
    display: block;
    font-size: 0.86rem;
    line-height: 1.2;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.review-submit__alert span {
    color: #33465b;
}

.review-submit__alert i {
    margin-top: 2px;
}

.review-submit__alert--success {
    border: 1px solid rgba(44, 124, 90, 0.25);
    background: rgba(237, 249, 243, 0.95);
    color: #1d6e4d;
}

.review-submit__alert--error {
    border: 1px solid rgba(177, 63, 63, 0.28);
    background: rgba(255, 238, 238, 0.95);
    color: #9d2f2f;
}

.review-submit__form {
    margin-top: 16px;
    display: grid;
    gap: 12px;
}

.review-submit__row {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 10px;
}

.review-submit__field > label {
    display: block;
    margin-bottom: 6px;
    font-size: 0.72rem;
    letter-spacing: 1.3px;
    text-transform: uppercase;
    font-weight: 800;
    color: #5d6f82;
}

.review-submit__field input,
.review-submit__field textarea {
    width: 100%;
    border: 1px solid rgba(31, 42, 54, 0.15);
    border-radius: 11px;
    background: #f6f9fc;
    color: #050505;
    padding: 11px 12px;
    font-size: 0.93rem;
    transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
}

.review-submit__field input:focus,
.review-submit__field textarea:focus {
    outline: none;
    border-color: rgba(48, 79, 124, 0.6);
    background: #ffffff;
    box-shadow: 0 0 0 4px rgba(48, 79, 124, 0.12);
}

.review-submit__rating {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
}

.review-submit__star-group {
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.review-submit__star {
    width: 35px;
    height: 35px;
    border-radius: 10px;
    border: 1px solid rgba(31, 42, 54, 0.14);
    background: #f6f9fc;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #b5bfcc;
    cursor: pointer;
    transition: transform 0.2s ease, border-color 0.2s ease, color 0.2s ease, background-color 0.2s ease;
}

.review-submit__star i {
    font-size: 16px;
    line-height: 1;
    pointer-events: none;
}

.review-submit__star:hover {
    color: #1c1c1c;
    border-color: rgba(48, 79, 124, 0.45);
    background: #ffffff;
}

.review-submit__rating .btn-check:checked + .review-submit__star {
    color: #1c1c1c;
    border-color: rgba(48, 79, 124, 0.52);
    transform: translateY(-1px);
    background: #ffffff;
}

.review-submit__star.is-active {
    color: #1c1c1c;
    border-color: rgba(48, 79, 124, 0.52);
    background: #ffffff;
}

.review-submit__hint {
    margin-left: 8px;
    font-size: 0.76rem;
    color: #62778e;
    font-weight: 600;
}

.review-submit__captcha-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 9px;
}

.review-submit__captcha-box {
    border: 1px solid rgba(31, 42, 54, 0.16);
    border-radius: 10px;
    background: #fff;
    padding: 4px;
}

.review-submit__captcha-box img {
    display: block;
    width: 118px;
    height: 42px;
    object-fit: contain;
}

.review-submit__captcha-refresh {
    border: 0;
    background: transparent;
    color: #1c1c1c;
    font-size: 0.8rem;
    font-weight: 800;
    letter-spacing: 1px;
    text-transform: uppercase;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 0;
}

.review-submit__button {
    margin-top: 2px;
    border: 1px solid rgba(31, 42, 54, 0.2);
    border-radius: 999px;
    min-height: 44px;
    padding: 10px 18px;
    background: var(--brand-primary);
    color: #eef3fb;
    font-size: 0.76rem;
    letter-spacing: 2px;
    text-transform: uppercase;
    font-weight: 800;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.review-submit__button:hover {
    transform: translateY(-1px);
    box-shadow: 0 10px 20px rgba(31, 42, 54, 0.24);
}

.review-feed__head {
    display: flex;
    align-items: baseline;
    justify-content: space-between;
    gap: 8px;
    padding: 4px 2px 12px;
    border-bottom: 1px solid rgba(31, 42, 54, 0.12);
}

.review-feed__head h4 {
    margin: 0;
    color: #050505;
    font-size: 1.15rem;
    letter-spacing: -0.1px;
}

.review-feed__head span {
    color: #607589;
    font-size: 0.72rem;
    letter-spacing: 1.4px;
    text-transform: uppercase;
    font-weight: 800;
}

.review-feed__list {
    margin-top: 12px;
    display: grid;
    gap: 10px;
    max-height: 640px;
    overflow: auto;
    padding-right: 4px;
}

.review-feed__item {
    border: 1px solid rgba(31, 42, 54, 0.14);
    border-radius: 12px;
    background: rgba(248, 251, 255, 0.9);
    padding: 10px 11px;
}

.review-feed__top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
}

.review-feed__top strong {
    color: #050505;
    font-size: 0.88rem;
    line-height: 1.2;
}

.review-feed__top small {
    color: #657b90;
    font-size: 0.72rem;
    white-space: nowrap;
}

.review-feed__stars {
    margin-top: 5px;
    display: inline-flex;
    gap: 2px;
}

.review-feed__stars i {
    color: #c4cdd8;
    font-size: 11px;
}

.review-feed__stars i.is-filled {
    color: #1c1c1c;
}

.review-feed__item p {
    margin: 7px 0 0;
    color: #405367;
    font-size: 0.84rem;
    line-height: 1.55;
}

.review-feed__city {
    margin-top: 8px;
    display: inline-block;
    color: #4f657a;
    font-size: 0.72rem;
    letter-spacing: 1.1px;
    text-transform: uppercase;
    font-weight: 700;
}

.review-feed__empty {
    margin-top: 14px;
    border-radius: 12px;
    border: 1px dashed rgba(31, 42, 54, 0.22);
    background: rgba(250, 252, 255, 0.8);
    padding: 16px;
}

.review-feed__empty p {
    margin: 0;
    color: #607589;
    font-size: 0.9rem;
}

@media (max-width: 991px) {
    .review-submit__grid {
        grid-template-columns: 1fr;
    }

    .review-submit__panel--feed {
        order: 2;
    }

    .review-submit__panel--form {
        order: 1;
    }
}

@media (max-width: 640px) {
    .review-submit__panel--form,
    .review-submit__panel--feed {
        padding: 14px;
    }

    .review-submit__row {
        grid-template-columns: 1fr;
    }

    .review-submit__captcha-row {
        flex-direction: column;
        align-items: flex-start;
    }

    .review-submit__button {
        width: 100%;
    }
}
</style>

<script>
(function () {
    'use strict';
    var ratingGroups = document.querySelectorAll('[data-rating-group]');
    if (!ratingGroups.length) return;

    function setStars(group, value) {
        var stars = group.querySelectorAll('.review-submit__star');
        stars.forEach(function (star) {
            var starValue = parseInt(star.getAttribute('data-value') || '0', 10);
            star.classList.toggle('is-active', starValue <= value);
        });
    }

    ratingGroups.forEach(function (group) {
        var radios = group.querySelectorAll('input[type="radio"]');
        var stars = group.querySelectorAll('.review-submit__star');
        var checked = group.querySelector('input[type="radio"]:checked');
        setStars(group, checked ? parseInt(checked.value || '0', 10) : 0);

        radios.forEach(function (radio) {
            radio.addEventListener('change', function () {
                setStars(group, parseInt(radio.value || '0', 10));
            });
        });

        stars.forEach(function (star) {
            star.addEventListener('mouseenter', function () {
                var value = parseInt(star.getAttribute('data-value') || '0', 10);
                setStars(group, value);
            });
        });

        group.addEventListener('mouseleave', function () {
            var selected = group.querySelector('input[type="radio"]:checked');
            setStars(group, selected ? parseInt(selected.value || '0', 10) : 0);
        });
    });
})();
</script>

