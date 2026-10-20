<?php 
// Aseguramos que las variables de contacto estén disponibles
$MapCode = $GoogleMap ?? '';
$Addr = $Address ?? '';
$Ph = $Phone ?? '';
$PhRef = $PhoneRef ?? '';
$Ph2 = $Phone2 ?? '';
$PhRef2 = $PhoneRef2 ?? '';
$PhName = $PhoneName ?? '';
$Ph2Name = $Phone2Name ?? '';
$Em = $Mail ?? '';
$EmRef = $MailRef ?? '';
$Hrs = $Schedule ?? '';
?>

<style>
    :root {
        --map-overlay-bg: <?php echo $BrandColors['secondary']; ?>; /* Color oscuro de fondo */
        --map-accent: <?php echo $BrandColors['accent']; ?>;    /* Color dorado */
        --map-text: #F5F2EE;
    }

    .section-map-contact {
        position: relative;
        width: 100%;
        min-height: 600px; /* Altura mínima del mapa */
        background: var(--map-overlay-bg);
        overflow: hidden;
        display: flex;
        align-items: center; /* Centrar verticalmente la tarjeta en Desktop */
    }

    /* --- MAPA DE FONDO --- */
    .map-background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .map-background iframe {
        width: 100%;
        height: 100%;
        border: 0;
        /* Filtro para modo oscuro elegante */
        filter: grayscale(100%) invert(92%) contrast(0.83);
        transition: filter 0.5s ease;
    }

    /* Al hacer hover en la sección, el mapa recobra un poco de color */
    .section-map-contact:hover .map-background iframe {
        filter: grayscale(80%) invert(92%) contrast(0.9);
    }

    /* --- TARJETA FLOTANTE --- */
    .map-overlay-container {
        position: relative;
        z-index: 2;
        width: 100%;
        max-width: 1300px;
        margin: 0 auto;
        padding: 0 25px;
        pointer-events: none; /* Permite clickear el mapa a los lados */
    }

    .contact-card {
        background: rgba(28, 31, 38, 0.9); /* Color secundario con transparencia */
        backdrop-filter: blur(10px);
        width: 400px;
        padding: 40px;
        border-radius: 8px;
        border-left: 4px solid var(--map-accent);
        box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        pointer-events: auto; /* Reactiva los clicks dentro de la tarjeta */
        color: var(--map-text);
    }

    .contact-card h3 {
        font-size: 1.8rem;
        margin-bottom: 25px;
        color: #fff;
        font-weight: 300;
    }

    .contact-card h3 span {
        font-weight: 700;
        color: var(--map-accent);
    }

    /* Items de contacto */
    .info-row {
        display: flex;
        align-items: flex-start;
        margin-bottom: 25px;
    }

    .info-row:last-child {
        margin-bottom: 0;
    }

    .info-icon {
        width: 40px;
        height: 40px;
        background: rgba(201, 166, 107, 0.1); /* Gold transparente */
        color: var(--map-accent);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        flex-shrink: 0;
        font-size: 1rem;
    }

    .info-text {
        font-size: 0.95rem;
    }

    .info-text strong {
        display: block;
        color: #fff;
        margin-bottom: 4px;
        font-size: 1rem;
    }

    .info-text a, .info-text p {
        color: rgba(255,255,255,0.7);
        text-decoration: none;
        margin: 0;
        display: block;
        line-height: 1.5;
        transition: color 0.3s;
    }

    .info-text a:hover {
        color: var(--map-accent);
    }

    /* --- RESPONSIVE --- */
    @media (max-width: 991px) {
        .section-map-contact {
            display: block; /* Stack vertical */
            height: auto;
            min-height: auto;
        }

        .map-background {
            position: relative; /* Ya no es absoluto */
            height: 400px; /* Altura fija para el mapa en móvil */
        }
        
        .map-background iframe {
            /* Quitamos el filtro invertido en móvil para mejor visibilidad diurna */
            filter: grayscale(0%) invert(0%); 
        }

        .map-overlay-container {
            padding: 0;
            max-width: 100%;
        }

        .contact-card {
            width: 100%;
            border-radius: 0;
            border-left: none;
            border-top: 4px solid var(--map-accent);
            box-shadow: none;
            background: var(--map-overlay-bg); /* Fondo sólido */
        }
    }
</style>

<section class="section-map-contact">
    
    <div class="map-overlay-container">
        <div class="contact-card" data-aos="fade-right">
            <h3><?php echo htmlspecialchars($MapCopy['title'] ?? ''); ?> <span><?php echo htmlspecialchars($MapCopy['title_strong'] ?? ''); ?></span></h3>
            
            <div class="info-row">
                <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                <div class="info-text">
                    <strong><?php echo htmlspecialchars($MapCopy['labels']['location'] ?? ''); ?></strong>
                    <p><?php echo $Addr; ?></p>
                </div>
            </div>

            <div class="info-row">
                <div class="info-icon"><i class="fas fa-phone-alt"></i></div>
                <div class="info-text">
                    <strong><?php echo htmlspecialchars($MapCopy['labels']['call'] ?? ''); ?></strong>
                    <a href="<?php echo $PhRef; ?>">
                        <?php echo $Ph; ?>
                        <?php if (!empty($PhName)): ?>
                            (<?php echo htmlspecialchars($PhName, ENT_QUOTES, 'UTF-8'); ?>)
                        <?php endif; ?>
                    </a>
                    <?php if (!empty($Ph2) && !empty($PhRef2)): ?>
                        <a href="<?php echo $PhRef2; ?>">
                            <?php echo $Ph2; ?>
                            <?php if (!empty($Ph2Name)): ?>
                                (<?php echo htmlspecialchars($Ph2Name, ENT_QUOTES, 'UTF-8'); ?>)
                            <?php endif; ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="info-row">
                <div class="info-icon"><i class="fas fa-clock"></i></div>
                <div class="info-text">
                    <strong><?php echo htmlspecialchars($MapCopy['labels']['hours'] ?? ''); ?></strong>
                    <p><?php echo $Hrs; ?></p>
                </div>
            </div>

        </div>
    </div>

    <div class="map-background">
        <?php echo $MapCode; ?>
    </div>

</section>
