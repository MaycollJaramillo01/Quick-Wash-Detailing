<?php 
// Variables de ayuda visual
$AccentColor = $BrandColors['accent'] ?? '#C9A66B';
?>

<style>
    /* Hereda variables de la sección anterior si están en el mismo archivo, 
       pero las re-declaramos aquí por seguridad para este bloque */
    :root {
        --proc-dark: <?php echo $BrandColors['secondary']; ?>; 
        --proc-primary: <?php echo $BrandColors['primary']; ?>;
        --proc-accent: <?php echo $BrandColors['accent']; ?>;
        --proc-text: #F5F2EE;
    }

    .section-process {
        padding: 100px 0;
        background-color: var(--proc-primary); /* Un tono ligeramente diferente al anterior para contraste */
        font-family: var(--font-body);
        position: relative;
    }

    .process-container {
        max-width: 1300px;
        margin: 0 auto;
        padding: 0 25px;
    }

    /* HEADER */
    .process-header {
        text-align: center;
        max-width: 800px;
        margin: 0 auto 70px auto;
    }

    .process-header h2 {
        font-size: clamp(2rem, 4vw, 3rem);
        color: #fff;
        margin-bottom: 20px;
        font-weight: 300;
    }

    .process-header h2 span {
        font-weight: 700;
        color: var(--proc-accent);
    }

    .process-header p {
        color: rgba(255,255,255,0.6);
        font-size: 1.1rem;
        line-height: 1.6;
    }

    /* GRID DE PASOS */
    .process-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
        position: relative;
    }

    /* TARJETA DE PASO */
    .process-step {
        background: rgba(28, 31, 38, 0.5); /* Secondary color transparente */
        border: 1px solid rgba(255,255,255,0.05);
        padding: 40px 30px;
        position: relative;
        transition: all 0.4s ease;
        overflow: hidden;
        height: 100%; /* Igualar alturas */
    }

    .process-step:hover {
        background: rgba(28, 31, 38, 0.9);
        border-color: var(--proc-accent);
        transform: translateY(-10px);
    }

    /* NÚMERO DE FONDO (Watermark) */
    .step-number {
        position: absolute;
        top: -15px;
        right: -10px;
        font-size: 8rem;
        font-weight: 900;
        color: rgba(255, 255, 255, 0.03);
        line-height: 1;
        transition: all 0.4s ease;
        z-index: 0;
    }

    .process-step:hover .step-number {
        color: rgba(201, 166, 107, 0.1); /* Gold muy suave al hover */
        transform: scale(1.1);
    }

    /* ICONO Y CONTENIDO */
    .step-icon {
        width: 60px;
        height: 60px;
        background: transparent;
        border: 1px solid var(--proc-accent);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--proc-accent);
        font-size: 1.5rem;
        margin-bottom: 25px;
        position: relative;
        z-index: 1;
    }

    .step-content {
        position: relative;
        z-index: 1;
    }

    .step-content h3 {
        color: #fff;
        font-size: 1.3rem;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .step-content p {
        color: rgba(255,255,255,0.6);
        font-size: 0.95rem;
        line-height: 1.6;
        margin: 0;
    }

    /* RESPONSIVE */
    @media (max-width: 1100px) {
        .process-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .section-process { padding: 60px 0; }
        .process-header { margin-bottom: 40px; text-align: left; }
        
        .process-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .process-step {
            display: flex; /* Layout horizontal en móvil */
            align-items: flex-start;
            padding: 25px;
        }

        .step-number {
            font-size: 4rem;
            top: 10px;
            right: 10px;
        }

        .step-icon {
            width: 40px;
            height: 40px;
            font-size: 1rem;
            margin-right: 20px;
            margin-bottom: 0;
            flex-shrink: 0;
        }
    }
</style>

<section class="section-process">
    <div class="process-container">
        
        <div class="process-header" data-aos="fade-up">
            <h2><?php echo htmlspecialchars($ProcessCopy['title'] ?? ''); ?> <span><?php echo htmlspecialchars($ProcessCopy['title_strong'] ?? ''); ?></span></h2>
            <p><?php echo htmlspecialchars($ProcessCopy['desc'] ?? ''); ?></p>
        </div>

        <div class="process-grid">
            <?php foreach (($ProcessCopy['steps'] ?? []) as $index => $step): ?>
            <div class="process-step" data-aos="fade-up" data-aos-delay="<?php echo ($index + 1) * 100; ?>">
                <span class="step-number"><?php echo str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT); ?></span>
                <div class="step-icon"><i class="fas <?php echo htmlspecialchars($step['icon'] ?? ''); ?>"></i></div>
                <div class="step-content">
                    <h3><?php echo htmlspecialchars($step['title'] ?? ''); ?></h3>
                    <p><?php echo htmlspecialchars($step['text'] ?? ''); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

