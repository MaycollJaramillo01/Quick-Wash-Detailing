<?php
// 1. Data Logic (Igual que antes, pero asegurando variables)
$currentID = $serviceData['id'] ?? 1;
$sName     = $serviceName ?? ($NavCopy['services'] ?? '');
$sDesc     = $serviceDesc ?? ($HomeServicesCopy['desc'] ?? '');
$cardImg   = '';

if (!empty($heroImageMain) && file_exists($heroImageMain)) {
    $cardImg = $heroImageMain;
}
if (empty($cardImg)) {
     $tryImg = "assets/img/service/" . $currentID . ".jpg";
     if (file_exists($tryImg)) $cardImg = $tryImg;
}
if (empty($cardImg)) {
    $cardImg = "assets/img/fallback.jpg";
}

// 2. Features Fallback (Más técnico)
$defaultFeatures = [
    ["title" => $HomeAboutCopy['features'][0]['title'] ?? '', "desc" => $HomeAboutCopy['features'][0]['text'] ?? '', "icon" => $HomeAboutCopy['features'][0]['icon'] ?? 'fa-pencil-ruler'],
    ["title" => $HomeAboutCopy['features'][1]['title'] ?? '', "desc" => $HomeAboutCopy['features'][1]['text'] ?? '', "icon" => $HomeAboutCopy['features'][1]['icon'] ?? 'fa-layer-group'],
    ["title" => $HomeAboutCopy['features'][2]['title'] ?? '', "desc" => $HomeAboutCopy['features'][2]['text'] ?? '', "icon" => $HomeAboutCopy['features'][2]['icon'] ?? 'fa-hammer']
];
$features = $ServiceFeatures[$currentID] ?? $defaultFeatures;
?>

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
        display: block;
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
        align-items: flex-start;
        padding: 20px 0;
        border-bottom: 1px solid rgba(0,0,0,0.1);
        transition: 0.3s;
    }

    .sd-spec-item:hover {
        padding-left: 10px;
        border-bottom-color: var(--sd-accent);
    }

    .sd-spec-icon {
        width: 50px;
        font-size: 1.2rem;
        color: var(--sd-accent);
        padding-top: 5px;
    }

    .sd-spec-info h4 {
        margin: 0 0 5px 0;
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--sd-dark);
    }

    .sd-spec-info p {
        margin: 0;
        font-size: 0.9rem;
        color: #777;
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
            <img src="<?php echo $cardImg; ?>" alt="<?php echo $sName; ?>" class="sd-main-img">
            
            <div class="sd-float-badge">
                <div class="sd-badge-icon"><i class="fas fa-certificate"></i></div>
                <div class="sd-badge-text">
                    <span><?php echo htmlspecialchars($ServiceDetailsCopy['badge_title'] ?? ''); ?></span>
                    <strong><?php echo htmlspecialchars($ServiceDetailsCopy['badge_subtitle'] ?? ''); ?></strong>
                </div>
            </div>
        </div>

        <div class="sd-content" data-aos="fade-left">
            <span class="sd-eyebrow"><?php echo $Coverage ?? ''; ?></span>
            
            <h2 class="sd-title">
                Professional <br><strong><?php echo $sName; ?></strong>
            </h2>
            
            <p class="sd-desc">
                <?php echo $sDesc; ?>
            </p>

            <div class="sd-specs-grid">
                <?php foreach($features as $f): ?>
                <div class="sd-spec-item">
                    <div class="sd-spec-icon">
                        <i class="fa-solid <?php echo $f['icon']; ?>"></i>
                    </div>
                    <div class="sd-spec-info">
                        <h4><?php echo $f['title']; ?></h4>
                        <p><?php echo $f['desc']; ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <a href="contact.php" class="btn-sd-main">
                Get Free Estimate <i class="fas fa-arrow-right"></i>
            </a>
        </div>

    </div>
</section>
