<?php 
// Aseguramos variables por si acaso
$cta_bg = $BrandColors['secondary'] ?? '#1c1f26';
$cta_accent = $BrandColors['accent'] ?? '#c9a66b';
$cta_text_light = '#FFFFFF';
$cta_subject = strtolower($serviceName ?? ($ServiceCtaCopy['subject_fallback'] ?? ''));
$cta_paragraph = $ServiceCtaCopy['paragraph'] ?? '';
$ctaPhoneLabel1 = trim((string) ($PhoneName ?? 'Main'));
$ctaPhoneLabel2 = trim((string) ($Phone2Name ?? 'Secondary'));
?>

<section class="section-cta-remodel">
    <div class="container">
        <div class="cta-arch-box">
            
            <div class="cta-grid-layout">
                
                <div class="cta-text-col">
                    <div class="cta-tag">
                        <i class="fa-solid fa-hard-hat"></i>
                        <span><?php echo htmlspecialchars($ServiceCtaCopy['tag'] ?? ''); ?></span>
                    </div>
                    
                    <h2 class="cta-heading">
                        <?php echo htmlspecialchars($ServiceCtaCopy['title'] ?? ''); ?> <br>
                        <strong><?php echo htmlspecialchars($ServiceCtaCopy['title_strong'] ?? ''); ?></strong>
                    </h2>
                    
                    <p class="cta-paragraph">
                        <?php echo htmlspecialchars(sprintf($cta_paragraph, $cta_subject)); ?>
                    </p>

                    <div class="cta-features-inline">
                        <?php foreach (($ServiceCtaCopy['features'] ?? []) as $feature): ?>
                            <span><i class="fa-solid fa-check"></i> <?php echo htmlspecialchars($feature); ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="cta-btn-col">
                    <a href="contact.php" class="btn-cta-gold">
                        <?php echo htmlspecialchars($ServiceCtaCopy['primary'] ?? ''); ?> <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    
                    <a href="<?php echo $PhoneRef; ?>" class="btn-cta-outline">
                        <i class="fa-solid fa-phone"></i> <?php echo htmlspecialchars($ServiceCtaCopy['secondary_prefix'] ?? ''); ?>: <?php echo $Phone; ?>
                        <?php if ($ctaPhoneLabel1 !== ''): ?>
                            (<?php echo htmlspecialchars($ctaPhoneLabel1, ENT_QUOTES, 'UTF-8'); ?>)
                        <?php endif; ?>
                    </a>

                    <?php if (!empty($Phone2) && !empty($PhoneRef2)): ?>
                        <a href="<?php echo $PhoneRef2; ?>" class="btn-cta-outline">
                            <i class="fa-solid fa-phone"></i> <?php echo htmlspecialchars($ServiceCtaCopy['secondary_prefix'] ?? ''); ?>: <?php echo $Phone2; ?>
                            <?php if ($ctaPhoneLabel2 !== ''): ?>
                                (<?php echo htmlspecialchars($ctaPhoneLabel2, ENT_QUOTES, 'UTF-8'); ?>)
                            <?php endif; ?>
                        </a>
                    <?php endif; ?>
                </div>

            </div>

            <div class="cta-decor-icon d-icon-1"><i class="fa-solid fa-ruler-combined"></i></div>
            <div class="cta-decor-icon d-icon-2"><i class="fa-solid fa-hammer"></i></div>
            
        </div>
    </div>
</section>

<style>
    :root {
        --cta-dark: <?php echo $cta_bg; ?>;
        --cta-gold: <?php echo $cta_accent; ?>;
        --cta-white: <?php echo $cta_text_light; ?>;
    }

    .section-cta-remodel {
        padding: 80px 0;
        background-color: transparent; /* Opcional si el fondo de la página es blanco */
    }

    .cta-arch-box {
        background-color: var(--cta-dark);
        border-radius: 12px;
        padding: 80px 60px;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.05);
        box-shadow: 0 20px 50px rgba(0,0,0,0.2);
    }

    /* Textura de fondo (Grid técnico) */
    .cta-arch-box::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background-image: 
            none;
        background-size: 40px 40px;
        opacity: 0.4;
        z-index: 1;
        pointer-events: none;
    }

    .cta-grid-layout {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 50px;
        align-items: center;
        position: relative;
        z-index: 2;
    }

    /* Etiqueta Superior */
    .cta-tag {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: rgba(201, 166, 107, 0.15); /* Gold transparente */
        border: 1px solid var(--cta-gold);
        color: var(--cta-gold);
        padding: 8px 16px;
        border-radius: 4px;
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        margin-bottom: 25px;
        letter-spacing: 1px;
    }

    /* Títulos */
    .cta-heading {
        font-size: clamp(2rem, 5vw, 3rem);
        color: var(--cta-white);
        font-weight: 300;
        line-height: 1.1;
        margin-bottom: 20px;
    }

    .cta-heading strong {
        font-weight: 800;
        color: var(--cta-white);
        position: relative;
    }
    
    /* Subrayado de acento */
    .cta-heading strong::after {
        content: '';
        position: absolute;
        bottom: 5px; left: 0; width: 100%; height: 8px;
        background: var(--cta-gold);
        opacity: 0.5;
        z-index: -1;
    }

    .cta-paragraph {
        font-size: 1.15rem;
        color: rgba(255,255,255,0.8);
        line-height: 1.6;
        margin-bottom: 30px;
        max-width: 600px;
    }

    .cta-features-inline {
        display: flex;
        gap: 20px;
        font-size: 0.9rem;
        color: rgba(255,255,255,0.6);
        font-weight: 600;
        text-transform: uppercase;
    }

    .cta-features-inline i { color: var(--cta-gold); margin-right: 5px; }

    /* Botones */
    .cta-btn-col {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 15px;
    }

    .btn-cta-gold {
        background: var(--cta-gold);
        color: var(--cta-dark);
        padding: 18px 45px;
        border-radius: 4px;
        font-weight: 800;
        text-transform: uppercase;
        text-decoration: none;
        letter-spacing: 1px;
        font-size: 1rem;
        transition: 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        max-width: 320px;
        justify-content: center;
    }

    .btn-cta-gold:hover {
        background: var(--cta-white);
        transform: translateY(-3px);
    }

    .btn-cta-outline {
        background: transparent;
        border: 2px solid rgba(255,255,255,0.2);
        color: var(--cta-white);
        padding: 16px 45px;
        border-radius: 4px;
        font-weight: 700;
        text-decoration: none;
        letter-spacing: 1px;
        font-size: 1rem;
        transition: 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        max-width: 320px;
        justify-content: center;
    }

    .btn-cta-outline:hover {
        border-color: var(--cta-gold);
        color: var(--cta-gold);
    }

    /* Decoración Grande */
    .cta-decor-icon {
        position: absolute;
        font-size: 15rem;
        color: rgba(255,255,255,0.02);
        z-index: 1;
        pointer-events: none;
    }

    .d-icon-1 { top: -50px; right: 5%; transform: rotate(-15deg); }
    .d-icon-2 { bottom: -50px; left: 10%; transform: rotate(15deg); font-size: 12rem; }

    /* RESPONSIVE */
    @media (max-width: 991px) {
        .cta-arch-box { padding: 60px 30px; text-align: center; }
        .cta-grid-layout { grid-template-columns: 1fr; gap: 40px; }
        
        .cta-btn-col { align-items: center; }
        .cta-features-inline { justify-content: center; }
        
        .d-icon-1, .d-icon-2 { display: none; /* Ocultar en móvil para limpieza */ }
    }
</style>    
