<style>
    .founder-section {
        padding: 100px 0;
        background-color: #fff;
        position: relative;
    }

    .founder-grid {
        display: grid;
        grid-template-columns: 0.8fr 1.2fr;
        gap: 60px;
        align-items: center;
        max-width: 1100px;
        margin: 0 auto;
    }

    .founder-img-frame {
        position: relative;
        padding: 20px;
        border: 1px solid rgba(0,0,0,0.1);
    }

    .founder-img-frame img {
        width: 100%;
        height: auto;
        display: block;
        filter: grayscale(100%);
        transition: 0.5s;
    }
    
    .founder-img-frame:hover img { filter: grayscale(0%); }

    /* Marco dorado decorativo */
    .founder-img-frame::after {
        content: '';
        position: absolute;
        top: -10px; left: -10px;
        width: 100%; height: 100%;
        border: 2px solid <?php echo $BrandColors['accent']; ?>;
        z-index: -1;
    }

    .founder-content h3 {
        font-size: 2.5rem;
        color: <?php echo $BrandColors['secondary']; ?>;
        margin-bottom: 20px;
        font-weight: 300;
    }

    .founder-content h3 strong { font-weight: 800; }

    .founder-quote {
        font-size: 1.1rem;
        font-style: italic;
        color: #555;
        line-height: 1.8;
        margin-bottom: 30px;
        border-left: 4px solid <?php echo $BrandColors['accent']; ?>;
        padding-left: 25px;
    }

    .signature-area {
        margin-top: 30px;
    }

    .founder-name {
        font-size: 1.2rem;
        font-weight: 700;
        color: <?php echo $BrandColors['secondary']; ?>;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .founder-role {
        font-size: 0.9rem;
        color: <?php echo $BrandColors['accent']; ?>;
        font-weight: 600;
    }

    @media (max-width: 991px) {
        .founder-grid { grid-template-columns: 1fr; text-align: center; }
        .founder-quote { border-left: none; border-top: 4px solid <?php echo $BrandColors['accent']; ?>; padding-top: 20px; padding-left: 0; }
    }
</style>

<section class="founder-section">
    <div class="container">
        <div class="founder-grid">
            <div class="founder-img" data-aos="fade-right">
                <div class="founder-img-frame">
                    <img src="assets/img/fallback.jpg" alt="<?php echo htmlspecialchars($FounderCopy['image_alt'] ?? $CustomerName); ?>">
                </div>
            </div>
            <div class="founder-content" data-aos="fade-left">
                <h3><?php echo htmlspecialchars($FounderCopy['title'] ?? ''); ?> <br><strong><?php echo htmlspecialchars($FounderCopy['title_strong'] ?? ''); ?></strong></h3>
                
                <div class="founder-quote">
                    "<?php echo htmlspecialchars($FounderCopy['quote'] ?? ''); ?>"
                </div>

                <div class="signature-area">
                    <div class="founder-name"><?php echo htmlspecialchars($CustomerName); ?></div>
                    <span class="founder-role"><?php echo htmlspecialchars($FounderCopy['role'] ?? ''); ?></span>
                </div>
            </div>
        </div>
    </div>
</section>
