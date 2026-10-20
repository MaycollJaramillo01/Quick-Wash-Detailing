<?php
@session_start();
// Si la variable $Company no está definida (probablemente viene de 'text.php'), se incluye el archivo.
if (!isset($Company)) include_once __DIR__ . '/../../text.php';

// Aseguramos variables
$ApBg = $BrandColors['secondary'] ?? '#1c1f26';
$ApAccent = $BrandColors['accent'] ?? '#c9a66b';
?>

<style>
    :root {
        --ap-bg: <?php echo $ApBg; ?>;
        --ap-accent: <?php echo $ApAccent; ?>;
        --ap-text: #EFEFEF;
        --ap-border: rgba(255,255,255,0.1);
    }

    .section-approach-dark {
        background-color: var(--ap-bg);
        padding: 140px 0;
        position: relative;
        overflow: hidden;
        font-family: var(--font-body);
        color: var(--ap-text);
    }

    /* Fondo decorativo (Planos Arquitectónicos) */
    .section-approach-dark::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background-image: 
            none;
        background-size: 50px 50px;
        opacity: 0.3;
    }

    .ap-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 25px;
        position: relative;
        z-index: 2;
    }

    /* HEADER */
    .ap-header {
        text-align: center;
        max-width: 700px;
        margin: 0 auto 90px;
    }

    .ap-eyebrow {
        color: var(--ap-accent);
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 20px;
        display: block;
    }

    .ap-header h2 {
        font-size: clamp(2.5rem, 5vw, 3.5rem);
        font-weight: 300;
        line-height: 1.1;
        margin-bottom: 25px;
        color: #fff;
    }

    .ap-header h2 strong {
        font-weight: 700;
        color: #fff;
        position: relative;
    }

    .ap-header p {
        font-size: 1.1rem;
        color: rgba(255,255,255,0.7);
        line-height: 1.7;
    }

    /* TIMELINE GRID */
    .ap-timeline {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 50px;
        position: relative;
    }

    /* Línea conectora */
    .ap-timeline::after {
        content: '';
        position: absolute;
        top: 40px;
        left: 0;
        width: 100%;
        height: 1px;
        background: var(--ap-accent);
        opacity: 0.3;
        z-index: 0;
    }

    .ap-step {
        position: relative;
        z-index: 1;
        padding-top: 20px;
        transition: 0.4s;
    }

    /* Marcador Circular */
    .ap-marker {
        width: 15px; height: 15px;
        background: var(--ap-bg);
        border: 2px solid var(--ap-accent);
        border-radius: 50%;
        margin-bottom: 30px;
        position: relative;
        z-index: 2;
        transition: 0.4s;
        box-shadow: 0 0 0 5px rgba(28, 31, 38, 1); /* Halo oscuro para tapar la línea */
    }

    .ap-step:hover .ap-marker {
        background: var(--ap-accent);
        box-shadow: 0 0 20px rgba(201, 166, 107, 0.5);
    }

    /* Número Grande */
    .ap-number {
        font-size: 4rem;
        font-weight: 900;
        color: rgba(255,255,255,0.03);
        line-height: 1;
        margin-bottom: -20px;
        display: block;
        transition: 0.4s;
    }

    .ap-step:hover .ap-number {
        color: rgba(255,255,255,0.1);
        transform: translateY(-5px);
    }

    /* Contenido del paso */
    .ap-content {
        padding: 30px;
        border: 1px solid var(--ap-border);
        background: rgba(255,255,255,0.02);
        transition: 0.4s;
        position: relative;
    }

    /* Icono pequeño superior */
    .ap-icon {
        font-size: 1.5rem;
        color: var(--ap-accent);
        margin-bottom: 20px;
        opacity: 0.8;
    }

    .ap-content h3 {
        font-size: 1.3rem;
        color: #fff;
        margin-bottom: 15px;
        font-weight: 700;
    }

    .ap-content p {
        font-size: 0.95rem;
        color: rgba(255,255,255,0.6);
        line-height: 1.6;
        margin: 0;
    }

    /* Hover Card */
    .ap-step:hover .ap-content {
        border-color: var(--ap-accent);
        background: rgba(255,255,255,0.05);
        transform: translateY(-10px);
    }

    /* RESPONSIVE */
    @media (max-width: 991px) {
        .ap-timeline {
            grid-template-columns: 1fr;
            gap: 40px;
        }
        
        /* Línea vertical en móvil */
        .ap-timeline::after {
            width: 1px;
            height: 100%;
            left: 26px; /* Ajustar según padding */
            top: 0;
            background: var(--ap-accent);
        }

        .ap-step {
            display: flex;
            gap: 30px;
            padding-top: 0;
        }

        .ap-marker {
            margin-top: 30px; /* Alinear con el contenido */
            flex-shrink: 0;
            margin-bottom: 0;
        }

        .ap-number { display: none; } /* Ocultar números gigantes en móvil para limpieza */
    }
</style>

<section class="section-approach-dark">
    <div class="ap-container">
        
        <div class="ap-header" data-aos="fade-up">
            <span class="ap-eyebrow"><?php echo htmlspecialchars($ServiceIntroCopy['eyebrow'] ?? ''); ?></span>
            <h2><?php echo htmlspecialchars($ServiceIntroCopy['title'] ?? ''); ?> <br><strong><?php echo htmlspecialchars($ServiceIntroCopy['title_strong'] ?? ''); ?></strong></h2>
            <p><?php echo htmlspecialchars($ServiceIntroCopy['desc'] ?? ''); ?></p>
        </div>

        <div class="ap-timeline">
            <?php foreach (($ServiceIntroCopy['steps'] ?? []) as $index => $step): ?>
            <div class="ap-step" data-aos="fade-up" data-aos-delay="<?php echo ($index + 1) * 100; ?>">
                <span class="ap-number"><?php echo str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT); ?></span>
                <div class="ap-marker"></div>
                <div class="ap-content">
                    <div class="ap-icon"><i class="fas <?php echo htmlspecialchars($step['icon'] ?? ''); ?>"></i></div>
                    <h3><?php echo htmlspecialchars($step['title'] ?? ''); ?></h3>
                    <p><?php echo htmlspecialchars($step['text'] ?? ''); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>

