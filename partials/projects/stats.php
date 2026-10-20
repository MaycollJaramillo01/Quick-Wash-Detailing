<?php 
// Preparación de datos (Misma lógica)
$ExperienceYears = (int) filter_var($Experience, FILTER_SANITIZE_NUMBER_INT); 
$TradeCount = count($ServicesList); 
$CityCount = count($Areas); 
?>

<style>
    .section-stats-bar {
        --st-bg: var(--brand-secondary);
        --st-accent: var(--brand-accent);
        --st-text: var(--brand-white);
        background-color: var(--st-bg);
        padding: 80px 0;
        position: relative;
        font-family: var(--font-body);
        color: var(--st-text);
        border-top: 1px solid rgba(255,255,255,0.08);
        border-bottom: 1px solid rgba(255,255,255,0.08);
    }

    /* Fondo de textura sutil */
    .section-stats-bar::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background-image: none;
        background-size: 40px 40px;
        opacity: 0.3;
        pointer-events: none;
    }

    .st-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 25px;
        position: relative;
        z-index: 2;
    }

    .st-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 40px;
        align-items: center;
    }

    .st-item {
        text-align: center;
        position: relative;
        padding: 20px 0;
        transition: transform 0.3s ease;
    }

    .st-item:hover {
        transform: translateY(-5px);
    }

    /* Divisor vertical elegante */
    .st-item:not(:last-child)::after {
        content: '';
        position: absolute;
        right: -20px;
        top: 20%;
        height: 60%;
        width: 1px;
        background: rgba(255,255,255,0.15);
    }

    .st-icon {
        font-size: 2rem;
        color: var(--st-accent);
        margin-bottom: 15px;
        opacity: 0.8;
        display: inline-block;
        transition: 0.3s;
    }

    .st-item:hover .st-icon {
        transform: scale(1.1);
        opacity: 1;
        color: var(--st-text);
    }

    .st-number {
        display: block;
        font-size: 3.5rem;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 10px;
        color: var(--st-text);
    }

    .st-label {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: rgba(255,255,255,0.6);
        font-weight: 600;
    }

    /* RESPONSIVE */
    @media (max-width: 991px) {
        .st-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 60px 30px;
        }
        .st-item:nth-child(2)::after { display: none; } /* Quitar borde en la fila 1 */
        .section-stats-bar { padding: 60px 0; }
    }

    @media (max-width: 576px) {
        .st-grid { grid-template-columns: 1fr; gap: 40px; }
        .st-item::after { display: none !important; }
        .st-number { font-size: 3rem; }
    }
</style>

<section class="section-stats-bar">
    <div class="st-container">
        <div class="st-grid">
            <?php foreach (($ProjectsStatsCopy['items'] ?? []) as $index => $item): ?>
            <div class="st-item" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                <i class="fas <?php echo htmlspecialchars($item['icon'] ?? ''); ?> st-icon"></i>
                <span class="st-number"><?php echo htmlspecialchars($item['value'] ?? ''); ?></span>
                <span class="st-label"><?php echo htmlspecialchars($item['label'] ?? ''); ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

