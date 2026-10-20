<?php
// Lógica de datos optimizada
$slug = $CurrentServiceSlug ?? null;
$detail = (!empty($slug) && isset($ServicesList[$slug])) ? $ServicesList[$slug] : null;
$detailData = (!empty($slug) && isset($ServiceDetails[$slug])) ? $ServiceDetails[$slug] : [];

// Fallbacks elegantes y especificos de construccion
$detailKicker = $detailData['kicker'] ?? ($detail['kicker'] ?? '');
$detailHeadline = $detailData['headline'] ?? ($detail['name'] ?? '');
$detailParagraphs = $detailData['paragraphs'] ?? (isset($detail['description']) ? [$detail['description']] : []);

// Imagen: prioriza la imagen del servicio (assets/img/service) si existe
$detailImage = $detailImage ?? null;
$detailId = $detail['id'] ?? null;
$serviceImgRel = null;
$serviceImgAbs = null;
$serviceImgExists = false;

if (!empty($detailId)) {
    $serviceImgRel = "assets/img/service/{$detailId}.jpg";
    $serviceImgAbs = __DIR__ . '/../../' . $serviceImgRel;
    $serviceImgExists = file_exists($serviceImgAbs);
}

$detailImageIsService = is_string($detailImage) && strpos($detailImage, 'assets/img/service/') === 0;

if ($serviceImgExists && (!$detailImageIsService || empty($detailImage))) {
    $detailImage = $serviceImgRel;
}

if (empty($detailImage) && !empty($heroImageMain)) {
    $detailImage = $heroImageMain;
}

if (empty($detailImage)) {
    $detailImage = 'assets/img/fallback.jpg';
}

// Features por defecto si no hay específicas
$featuresList = $detailData['bullets'] ?? ($detailBullets ?? [
    'Custom Design Layouts',
    'High-Grade Materials',
    'Licensed Installation',
    'Clean Job Sites'
]);
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    :root {
        --sd-dark: <?php echo $BrandColors['secondary']; ?>; 
        --sd-accent: <?php echo $BrandColors['accent']; ?>;
        --sd-text: #444;
        --sd-bg: #fff;
    }

    .section-service-detail {
        padding: 120px 0;
        background-color: var(--sd-bg);
        overflow: hidden;
        position: relative;
        font-family: var(--font-body);
    }

    /* Fondo decorativo sutil */
    .section-service-detail::before {
        content: '';
        position: absolute;
        top: 0; right: 0; width: 40%; height: 100%;
        background: rgba(201, 166, 107, 0.03); /* Acento muy suave */
        z-index: 0;
    }

    .sd-grid {
        display: grid;
        grid-template-columns: 1.1fr 0.9fr;
        gap: 80px;
        align-items: center;
        position: relative;
        z-index: 2;
        max-width: 1300px;
        margin: 0 auto;
        padding: 0 25px;
    }

    /* --- IMAGEN (Izquierda) --- */
    .sd-image-wrapper {
        position: relative;
        padding: 20px 0 20px 20px;
    }

    .sd-main-img {
        width: 100%;
        height: 600px;
        object-fit: cover;
        position: relative;
        z-index: 2;
        box-shadow: 20px 20px 60px rgba(0,0,0,0.1);
        filter: brightness(0.95); /* Un poco más "moody" */
    }

    /* Marco decorativo trasero */
    .sd-frame-back {
        position: absolute;
        top: 0; left: 0;
        width: 60%; height: 80%;
        border: 2px solid var(--sd-accent);
        z-index: 1;
        opacity: 0.3;
    }

    /* Badge Flotante */
    .sd-float-badge {
        position: absolute;
        bottom: 50px; left: -30px;
        background: var(--sd-dark);
        color: #fff;
        padding: 25px 30px;
        z-index: 3;
        box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        display: flex;
        align-items: center;
        gap: 20px;
        border-right: 5px solid var(--sd-accent);
    }

    .sd-badge-icon {
        font-size: 2rem;
        color: var(--sd-accent);
    }

    .sd-badge-text span {
        display: block;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.7;
    }

    .sd-badge-text strong {
        font-size: 1.1rem;
        font-weight: 700;
        color: #fff;
    }

    /* --- CONTENIDO (Derecha) --- */
    .sd-content {
        padding-right: 20px;
    }

    .sd-eyebrow {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: var(--sd-accent);
        font-weight: 700;
        margin-bottom: 20px;
        display: flex; align-items: center; gap: 10px;
    }
    
    .sd-eyebrow::before {
        content: ''; width: 20px; height: 1px; background: var(--sd-accent);
    }

    .sd-title {
        font-size: clamp(2.5rem, 4vw, 3.5rem);
        line-height: 1.1;
        color: var(--sd-dark);
        margin-bottom: 30px;
        font-weight: 300;
    }

    .sd-title strong { font-weight: 800; }

    .sd-desc {
        font-size: 1.1rem;
        color: #666;
        line-height: 1.7;
        margin-bottom: 45px;
        border-left: 3px solid rgba(0,0,0,0.1);
        padding-left: 20px;
    }

    /* Grid de Features Estilo "Spec Sheet" */
    .sd-specs-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 0;
        border-top: 1px solid rgba(0,0,0,0.1);
        margin-bottom: 45px;
    }

    .sd-spec-item {
        display: flex;
        align-items: center;
        padding: 20px 0;
        border-bottom: 1px solid rgba(0,0,0,0.1);
        transition: 0.3s;
    }

    .sd-spec-item:hover {
        padding-left: 10px;
        border-bottom-color: var(--sd-accent);
    }

    .sd-spec-icon {
        width: 40px;
        font-size: 1rem;
        color: var(--sd-accent);
    }

    .sd-spec-text {
        font-size: 1.05rem;
        font-weight: 600;
        color: var(--sd-dark);
    }

    /* Botón */
    .btn-sd-main {
        padding: 18px 45px;
        background: var(--sd-dark);
        color: #fff;
        text-transform: uppercase;
        font-weight: 700;
        text-decoration: none;
        letter-spacing: 1px;
        display: inline-flex;
        align-items: center;
        gap: 15px;
        transition: 0.3s;
    }

    .btn-sd-main:hover {
        background: var(--sd-accent);
        color: var(--sd-dark);
    }

    /* RESPONSIVE */
    @media (max-width: 991px) {
        .sd-grid { grid-template-columns: 1fr; gap: 60px; }
        .sd-image-wrapper { padding: 0; margin-bottom: 20px; }
        .sd-main-img { height: 400px; }
        .sd-float-badge { bottom: -20px; left: 20px; padding: 15px 20px; }
        .sd-frame-back { display: none; }
    }
</style>

<section class="section-service-detail">
    <div class="sd-grid">
        
        <div class="sd-image-wrapper" data-aos="fade-right">
            <div class="sd-frame-back"></div>
            <img src="<?php echo htmlspecialchars($detailImage); ?>" alt="<?php echo htmlspecialchars($detailHeadline); ?>" class="sd-main-img">
            
            <div class="sd-float-badge">
                <div class="sd-badge-icon"><i class="fas fa-certificate"></i></div>
                <div class="sd-badge-text">
                    <span><?php echo htmlspecialchars($ServiceDetailsCopy['badge_title'] ?? ''); ?></span>
                    <strong><?php echo htmlspecialchars($ServiceDetailsCopy['badge_subtitle'] ?? ''); ?></strong>
                </div>
            </div>
        </div>

        <div class="sd-content" data-aos="fade-left">
            <span class="sd-eyebrow"><?php echo htmlspecialchars($detailKicker); ?></span>
            
            <h2 class="sd-title">
                <?php echo htmlspecialchars($ServiceDetailsCopy['title_prefix'] ?? ''); ?> <br><strong><?php echo htmlspecialchars($detailHeadline); ?></strong>
            </h2>
            
            <div class="sd-desc">
                <?php foreach ($detailParagraphs as $p): ?>
                    <p><?php echo htmlspecialchars($p); ?></p>
                <?php endforeach; ?>
            </div>

            <div class="sd-specs-grid">
                <?php 
                $icons = ['fa-pencil-ruler', 'fa-layer-group', 'fa-hammer', 'fa-broom'];
                foreach(array_slice($featuresList, 0, 4) as $index => $feature): 
                ?>
                <div class="sd-spec-item">
                    <div class="sd-spec-icon">
                        <i class="fa-solid <?php echo $icons[$index] ?? 'fa-check'; ?>"></i>
                    </div>
                    <span class="sd-spec-text"><?php echo htmlspecialchars($feature); ?></span>
                </div>
                <?php endforeach; ?>
            </div>

            <a href="contact.php" class="btn-sd-main">
                <?php echo htmlspecialchars($ServiceDetailsCopy['button'] ?? ''); ?> <i class="fas fa-arrow-right"></i>
            </a>
        </div>

    </div>
</section>

