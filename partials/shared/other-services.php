<?php
// Datos de respaldo
$OtherServices = $OtherServices ?? [];
$BrandColors = $BrandColors ?? ['secondary' => '#1c1f26', 'accent' => '#c9a66b']; 
$Estimates = $Estimates ?? '';
$PhoneRef = $PhoneRef ?? '';
$Phone = $Phone ?? '';
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --os-bg: <?php echo $BrandColors['secondary']; ?>;      /* #1c1f26 */
        --os-accent: <?php echo $BrandColors['accent']; ?>;    /* #c9a66b */
        --os-text: #EFEFEF;
        --os-card-bg: rgba(255, 255, 255, 0.03);
        --os-border: rgba(255, 255, 255, 0.08);
    }

    .section-other-services {
        background-color: var(--os-bg);
        padding: 120px 0;
        position: relative;
        font-family: var(--font-body);
        color: var(--os-text);
        overflow: hidden;
    }

    /* Patrón de fondo técnico/arquitectónico */
    .section-other-services::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background-image: 
            none;
        background-size: 60px 60px;
        opacity: 0.5;
        z-index: 1;
    }

    .os-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 25px;
        position: relative;
        z-index: 2;
    }

    /* --- HEADER --- */
    .os-header {
        max-width: 800px;
        margin-bottom: 70px;
    }

    .os-label {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 3px;
        color: var(--os-accent);
        margin-bottom: 20px;
        display: block;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .os-label::before {
        content: ''; width: 30px; height: 1px; background: var(--os-accent);
    }

    .os-title {
        font-size: clamp(2.2rem, 5vw, 3.5rem);
        line-height: 1.1;
        font-weight: 300; /* Thin luxury style */
        color: #fff;
    }

    .os-title strong {
        font-weight: 700;
        color: #fff;
        position: relative;
    }
    
    /* Subrayado de acento */
    .os-title strong::after {
        content: '';
        position: absolute;
        bottom: 5px; left: 0; width: 100%; height: 6px;
        background: var(--os-accent);
        opacity: 0.4;
        z-index: -1;
    }

    /* --- GRID --- */
    .os-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 1px; /* Gap pequeño para efecto de borde */
        background: var(--os-border); /* Color de las líneas del grid */
        border: 1px solid var(--os-border);
    }

    .os-card {
        background: var(--os-bg); /* Fondo sólido sobre el grid */
        padding: 40px;
        transition: all 0.4s ease;
        position: relative;
        display: flex;
        align-items: flex-start;
        gap: 25px;
    }

    .os-card:hover {
        background: var(--os-card-bg); /* Ligeramente más claro al hover */
    }

    /* Icon Box */
    .os-icon-box {
        width: 50px; height: 50px;
        border: 1px solid var(--os-accent);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem;
        color: var(--os-accent);
        flex-shrink: 0;
        transition: 0.4s;
    }

    .os-card:hover .os-icon-box {
        background: var(--os-accent);
        color: var(--os-bg);
        box-shadow: 0 0 20px rgba(201, 166, 107, 0.4);
    }

    .os-content h4 {
        margin: 0 0 8px 0;
        font-size: 1.15rem;
        color: #fff;
        font-weight: 600;
        transition: 0.3s;
    }

    .os-content span {
        font-size: 0.9rem;
        color: rgba(255,255,255,0.5);
        font-weight: 400;
        display: block;
        line-height: 1.5;
    }

    .os-card:hover .os-content h4 {
        color: var(--os-accent);
    }

    /* Decoración de esquina en hover */
    .os-card::before {
        content: '';
        position: absolute;
        top: 0; right: 0;
        width: 0; height: 0;
        border-style: solid;
        border-width: 0 20px 20px 0;
        border-color: transparent var(--os-accent) transparent transparent;
        opacity: 0;
        transition: 0.3s;
    }

    .os-card:hover::before {
        opacity: 1;
    }

    /* --- CTA BLOCK --- */
    .os-cta-block {
        margin-top: 60px;
        background: rgba(255,255,255,0.03);
        border-left: 4px solid var(--os-accent);
        padding: 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 30px;
    }

    .os-cta-text h3 {
        font-size: 1.5rem;
        margin: 0 0 5px 0;
        font-weight: 300;
    }
    .os-cta-text p {
        margin: 0;
        color: rgba(255,255,255,0.6);
        font-size: 0.95rem;
    }

    .btn-os-gold {
        padding: 16px 40px;
        background: var(--os-accent);
        color: var(--os-bg);
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: 0.3s;
        border: 1px solid var(--os-accent);
    }

    .btn-os-gold:hover {
        background: transparent;
        color: var(--os-accent);
    }

    @media (max-width: 768px) {
        .os-grid { grid-template-columns: 1fr; }
        .os-cta-block { flex-direction: column; align-items: flex-start; }
        .btn-os-gold { width: 100%; justify-content: center; }
        .os-title { font-size: 2.2rem; }
    }
</style>

<section class="section-other-services" id="more-services">
    <div class="os-container">
        
        <div class="os-header" data-aos="fade-right">
            <span class="os-label"><?php echo htmlspecialchars($OtherServicesCopy['label'] ?? ''); ?></span>
            <h2 class="os-title"><?php echo htmlspecialchars($OtherServicesCopy['title'] ?? ''); ?> <br><strong><?php echo htmlspecialchars($OtherServicesCopy['title_strong'] ?? ''); ?></strong></h2>
        </div>

        <div class="os-grid">
            <?php 
            // Función auxiliar para iconos inteligentes
            function getServiceIcon($name) {
                $n = strtolower($name);
                if (strpos($n, 'cabinet') !== false) return 'fa-boxes-stacked';
                if (strpos($n, 'counter') !== false) return 'fa-eraser';
                if (strpos($n, 'tile') !== false) return 'fa-border-all';
                if (strpos($n, 'floor') !== false) return 'fa-layer-group';
                if (strpos($n, 'light') !== false || strpos($n, 'elect') !== false) return 'fa-lightbulb';
                if (strpos($n, 'concrete') !== false) return 'fa-trowel-bricks';
                if (strpos($n, 'frame') !== false) return 'fa-ruler-combined';
                return 'fa-screwdriver-wrench';
            }

            foreach ($OtherServices as $index => $service): 
            ?>
            <div class="os-card" data-aos="fade-up" data-aos-delay="<?php echo $index * 50; ?>">
                <div class="os-icon-box">
                    <i class="fa-solid <?php echo getServiceIcon($service); ?>"></i>
                </div>
                <div class="os-content">
                    <h4><?php echo htmlspecialchars($service); ?></h4>
                    <span><?php echo htmlspecialchars($OtherServicesCopy['item_note'] ?? ''); ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="os-cta-block" data-aos="fade-up" data-aos-delay="300">
            <div class="os-cta-text">
                <h3 style="color:#fff"><?php echo htmlspecialchars($OtherServicesCopy['cta_title'] ?? ''); ?></h3>
                <p><?php echo htmlspecialchars($OtherServicesCopy['cta_text'] ?? ''); ?></p>
            </div>
            <div class="os-cta-actions">
                <a href="contact.php" class="btn-os-gold">
                    <?php echo htmlspecialchars($OtherServicesCopy['cta_button'] ?? ''); ?> <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>

    </div>
</section>
