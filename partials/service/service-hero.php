<?php
// Enhanced Service Hero
$heroBg = $heroImageMain ?? 'assets/img/fallback.jpg';
if (!file_exists($heroBg) && !strpos($heroBg, 'http')) {
    $heroBg = 'assets/img/fallback.jpg';
}
// Force fallback if empty
if (empty($heroBg)) $heroBg = 'assets/img/fallback.jpg';
?>
<section class="service-hero-nova">
    <div class="service-hero__bg" style="background-image: url('<?php echo $heroBg; ?>');"></div>
    <div class="service-hero__overlay"></div>
    
    <div class="container service-hero__content">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <div class="service-hero__badge animate-up">
                    <i class="fa-solid fa-star"></i> <?php echo htmlspecialchars($ServiceHeroCopy['badge'] ?? ''); ?>
                </div>
                <h1 class="service-hero__title animate-up"><?php echo $serviceName ?? ($NavCopy['services'] ?? ''); ?></h1>
                <p class="service-hero__desc animate-up delay-1"><?php echo $serviceDesc ?? ($HomeServicesCopy['desc'] ?? ''); ?></p>
                
                <div class="service-hero__actions animate-up delay-2">
                    <a href="#contact-us" class="btn-nova btn-nova-primary">
                        <span><?php echo htmlspecialchars($ServiceHeroCopy['cta_primary'] ?? ''); ?></span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <a href="#service-intro" class="btn-nova btn-nova-outline">
                        <span><?php echo htmlspecialchars($ServiceHeroCopy['cta_secondary'] ?? ''); ?></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.service-hero-nova {
    position: relative;
    height: 65vh;
    min-height: 500px;
    display: flex;
    align-items: center;
    overflow: hidden;
    color: var(--white);
    margin-top: 70px;
}

.service-hero__bg {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    transform: scale(1.05);
    z-index: 0;
}

.service-hero__overlay {
    position: absolute;
    inset: 0;
    background: color-mix(in srgb, var(--brand-primary) 85%, #000 15%);
    opacity: 0.85;
    z-index: 1;
}

.service-hero__content {
    position: relative;
    z-index: 2;
}

.service-hero__badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(10px);
    padding: 8px 20px;
    border-radius: 30px;
    font-size: 0.9rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 24px;
    color: var(--accent-green);
    border: 1px solid rgba(255,255,255,0.2);
}

.service-hero__title {
    font-size: clamp(2.5rem, 5vw, 4.5rem);
    font-weight: 800;
    line-height: 1.1;
    margin-bottom: 20px;
    color: var(--white);
    text-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

.service-hero__desc {
    font-size: 1.25rem;
    color: rgba(255,255,255,0.95);
    max-width: 800px;
    margin: 0 auto 40px;
    font-weight: 500;
}

/* Button Nova Styles */
.btn-nova {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 16px 36px;
    border-radius: 4px;
    font-weight: 700;
    text-transform: uppercase;
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    position: relative;
    overflow: hidden;
    letter-spacing: 1px;
}

.btn-nova-primary {
    background: var(--accent-green);
    color: var(--white);
    box-shadow: 0 10px 20px color-mix(in srgb, var(--accent-green) 45%, rgba(0,0,0,0.25));
}

.btn-nova-primary:hover {
    background: var(--white);
    color: var(--accent-green);
    transform: translateY(-3px);
}

.btn-nova-outline {
    border: 2px solid rgba(255,255,255,0.3);
    color: var(--white);
    margin-left: 20px;
}

.btn-nova-outline:hover {
    border-color: var(--white);
    background: rgba(255,255,255,0.1);
    color: var(--white);
}

/* Animations */
.animate-up {
    opacity: 0;
    transform: translateY(30px);
    animation: fadeInUp 0.8s forwards;
}

.delay-1 { animation-delay: 0.2s; }
.delay-2 { animation-delay: 0.4s; }

@keyframes fadeInUp {
    to { opacity: 1; transform: translateY(0); }
}

@media (max-width: 768px) {
    .btn-nova-outline { margin-left: 0; margin-top: 15px; display: flex; justify-content: center; }
}
</style>
