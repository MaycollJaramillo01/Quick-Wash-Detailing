<?php
if (!isset($BrandColors)) include_once __DIR__ . '/../../text.php';

$galleryDirAbs = __DIR__ . '/../../assets/img/gallery';
$galleryDirRel = 'assets/img/gallery';
$galleryExts = ['jpg', 'jpeg', 'png', 'webp', 'avif'];
$galleryFiles = [];

if (is_dir($galleryDirAbs)) {
    $scanned = scandir($galleryDirAbs);
    if (is_array($scanned)) {
        foreach ($scanned as $file) {
            if ($file === '.' || $file === '..') continue;
            if (!is_file($galleryDirAbs . DIRECTORY_SEPARATOR . $file)) continue;
            $ext = strtolower((string) pathinfo($file, PATHINFO_EXTENSION));
            if (!in_array($ext, $galleryExts, true)) continue;
            $galleryFiles[] = $file;
        }
    }
}
natsort($galleryFiles);

$galleryItems = [];
foreach ($galleryFiles as $file) {
    $galleryItems[] = [
        'src' => $galleryDirRel . '/' . $file,
        'cat' => 'images',
        'type' => 'image',
        'title' => $ProjectsGalleryCopy['image_title'] ?? 'Project Photo'
    ];
}

// Videos: assets/video/*.mp4 (poster = same name .jpg)
foreach (glob(__DIR__ . '/../../assets/video/*.mp4') ?: [] as $videoAbs) {
    $videoBase = pathinfo($videoAbs, PATHINFO_FILENAME);
    $galleryItems[] = [
        'src' => 'assets/video/' . basename($videoAbs),
        'poster' => is_file(dirname($videoAbs) . '/' . $videoBase . '.jpg') ? 'assets/video/' . $videoBase . '.jpg' : '',
        'cat' => 'videos',
        'type' => 'video',
        'title' => $ProjectsGalleryCopy['video_title'] ?? 'Project Video'
    ];
}

$hasImages = false;
foreach ($galleryItems as $item) {
    if (($item['cat'] ?? '') === 'images') $hasImages = true;
}

$defaultFilter = 'images';
$tabLabels = [
    'images' => $ProjectsGalleryCopy['images_label'] ?? 'Images'
];
foreach ($galleryItems as $item) {
    if ($item['cat'] === 'videos') { $tabLabels['videos'] = $ProjectsGalleryCopy['videos_label'] ?? 'Videos'; break; }
}
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />

<style>
    .section-gallery-arch {
        --gal-bg: var(--brand-secondary);
        --gal-accent: var(--brand-accent);
        --gal-text: var(--brand-white);
        --gal-muted: rgba(255, 255, 255, 0.5);
        padding: 120px 0;
        background-color: var(--gal-bg);
        font-family: var(--font-body);
        color: var(--gal-text);
        position: relative;
    }

    .gal-header {
        text-align: center;
        margin-bottom: 60px;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }

    .gal-eyebrow {
        color: var(--gal-accent);
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 3px;
        margin-bottom: 20px;
        display: block;
    }

    .gal-title {
        font-size: clamp(2.5rem, 5vw, 3.5rem);
        font-weight: 300;
        line-height: 1.1;
        color: var(--gal-text);
    }

    .gal-title strong {
        font-weight: 800;
        color: var(--gal-text);
    }

    .gallery-filter-nav {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 10px 30px;
        margin-bottom: 50px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding-bottom: 20px;
    }

    .filter-btn {
        background: transparent;
        border: none;
        color: var(--gal-muted);
        font-size: 0.95rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        padding: 10px 0;
    }

    .filter-btn::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0%;
        height: 2px;
        background-color: var(--gal-accent);
        transition: width 0.3s ease;
    }

    .filter-btn:hover,
    .filter-btn.active {
        color: var(--gal-accent);
    }

    .filter-btn.active::after {
        width: 100%;
    }

    .gallery-masonry {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 20px;
        min-height: 400px;
    }

    .gallery-card {
        position: relative;
        overflow: hidden;
        border-radius: 4px;
        aspect-ratio: 4 / 3;
        cursor: pointer;
        display: none;
        opacity: 0;
        transform: translateY(20px);
    }

    .gallery-card.show {
        display: block;
        animation: revealItem 0.5s forwards;
    }

    @keyframes revealItem {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .gallery-card img,
    .gallery-card .gallery-video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .gallery-card img {
        transition: transform 0.6s ease;
        filter: grayscale(20%);
    }

    .card-overlay {
        position: absolute;
        inset: 0;
        background: rgba(var(--brand-secondary-rgb), 0.92);
        opacity: 0;
        transition: 0.4s ease;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 30px;
        pointer-events: none;
    }

    .gallery-card:hover img {
        transform: scale(1.1);
        filter: grayscale(0%);
    }

    .gallery-card:hover .card-overlay {
        opacity: 1;
    }

    .video-play-badge {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2;
        pointer-events: none;
    }

    .video-play-badge span {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: rgba(var(--brand-secondary-rgb), 0.45);
        border: 1px solid rgba(255, 255, 255, 0.6);
        color: var(--gal-text);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        box-shadow: 0 10px 24px rgba(var(--brand-secondary-rgb), 0.35);
        transition: transform 0.3s ease, background 0.3s ease;
    }

    .gallery-card:hover .video-play-badge span {
        transform: scale(1.05);
        background: rgba(var(--brand-secondary-rgb), 0.62);
    }

    .card-zoom-icon {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 45px;
        height: 45px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(5px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gal-accent);
        transform: translateY(-10px);
        opacity: 0;
        transition: 0.4s ease 0.1s;
    }

    .gallery-card:hover .card-zoom-icon {
        transform: translateY(0);
        opacity: 1;
    }

    .card-info h4 {
        font-size: 1.2rem;
        font-weight: 700;
        margin: 0 0 5px 0;
        color: var(--gal-text);
        transform: translateY(10px);
        transition: 0.4s ease 0.1s;
    }

    .card-info span {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--gal-accent);
        display: block;
        transform: translateY(10px);
        transition: 0.4s ease 0.2s;
    }

    .gallery-card:hover .card-info h4,
    .gallery-card:hover .card-info span {
        transform: translateY(0);
    }

    .glightbox-trigger {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 10;
        cursor: zoom-in;
    }

    .gallery-empty {
        grid-column: 1 / -1;
        text-align: center;
        padding: 60px;
        background: rgba(255, 255, 255, 0.03);
        border: 1px dashed rgba(255, 255, 255, 0.1);
    }

    @media (max-width: 768px) {
        .gallery-filter-nav {
            gap: 15px;
            border-bottom: none;
        }

        .filter-btn {
            font-size: 0.8rem;
            padding: 5px 10px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 4px;
        }

        .filter-btn::after {
            display: none;
        }

        .filter-btn.active {
            background: var(--gal-accent);
            color: var(--gal-bg);
        }

        .gallery-masonry {
            grid-template-columns: 1fr;
        }
    }
</style>

<section class="section-gallery-arch" id="portfolio">
    <div class="container">
        <div class="gal-header" data-aos="fade-up">
            <span class="gal-eyebrow"><?php echo htmlspecialchars($ProjectsGalleryCopy['eyebrow'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
            <h2 class="gal-title"><?php echo htmlspecialchars($ProjectsGalleryCopy['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?> <br><strong><?php echo htmlspecialchars($ProjectsGalleryCopy['title_strong'] ?? '', ENT_QUOTES, 'UTF-8'); ?></strong></h2>
        </div>

        <div class="gallery-filter-nav" data-aos="fade-up" data-aos-delay="100">
            <?php foreach ($tabLabels as $slug => $label): ?>
                <button class="filter-btn<?php echo $slug === $defaultFilter ? ' active' : ''; ?>" data-filter="<?php echo htmlspecialchars($slug, ENT_QUOTES, 'UTF-8'); ?>">
                    <?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?>
                </button>
            <?php endforeach; ?>
        </div>

        <div class="gallery-masonry">
            <?php if (empty($galleryItems)): ?>
                <div class="gallery-empty">
                    <i class="fas fa-camera" style="font-size: 3rem; color: var(--gal-accent); margin-bottom: 20px;"></i>
                    <p style="color: rgba(255,255,255,0.72);"><?php echo htmlspecialchars($ProjectsGalleryCopy['empty'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            <?php else: ?>
                <?php foreach ($galleryItems as $item): ?>
                    <div class="gallery-card<?php echo ($item['cat'] === $defaultFilter) ? ' show' : ''; ?>" data-category="<?php echo htmlspecialchars($item['cat'], ENT_QUOTES, 'UTF-8'); ?>">
                        <?php if ($item['type'] === 'video'): ?>
                            <video class="gallery-video" src="<?php echo htmlspecialchars($item['src'], ENT_QUOTES, 'UTF-8'); ?>#t=0.5" poster="<?php echo htmlspecialchars($item['poster'], ENT_QUOTES, 'UTF-8'); ?>" muted playsinline preload="metadata" aria-label="<?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?>"></video>
                            <div class="video-play-badge" aria-hidden="true"><span><i class="fas fa-play"></i></span></div>
                        <?php else: ?>
                            <img src="<?php echo htmlspecialchars($item['src'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?>" loading="lazy">
                        <?php endif; ?>

                        <div class="card-overlay">
                            <div class="card-zoom-icon">
                                <i class="fas fa-expand"></i>
                            </div>
                            <div class="card-info">
                                <span><?php echo htmlspecialchars(ucfirst((string) $item['cat']), ENT_QUOTES, 'UTF-8'); ?></span>
                                <h4><?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?></h4>
                            </div>
                        </div>

                        <a href="<?php echo htmlspecialchars($item['src'], ENT_QUOTES, 'UTF-8'); ?>"
                           class="glightbox glightbox-trigger"
                           data-gallery="portfolio"
                           data-type="<?php echo htmlspecialchars($item['type'], ENT_QUOTES, 'UTF-8'); ?>">
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    GLightbox({
        touchNavigation: true,
        loop: true,
        autoplayVideos: false,
        selector: '.glightbox'
    });

    const buttons = document.querySelectorAll('.filter-btn');
    const items = document.querySelectorAll('.gallery-card');

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            buttons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const filterValue = btn.getAttribute('data-filter');

            items.forEach(item => {
                item.style.animation = 'none';
                item.offsetHeight; // trigger reflow
                item.style.animation = 'revealItem 0.5s forwards';

                if (item.getAttribute('data-category') === filterValue) {
                    item.classList.add('show');
                } else {
                    item.classList.remove('show');
                }
            });
        });
    });
});
</script>
