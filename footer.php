<?php
$footerSocialLogoDirAbs = __DIR__ . '/assets/img/brands/social';
$footerSocialLogoDirRel = 'assets/img/brands/social';
$footerSocialLogos = [];
$footerSocialLogoFiles = [
    'facebook' => 'facebook.svg',
    'messenger' => 'messenger.svg',
    'instagram' => 'instagram.svg',
    'google' => 'google.svg',
    'tiktok' => 'tiktok.svg',
    'whatsapp' => 'whatsapp.svg'
];

foreach ($footerSocialLogoFiles as $key => $file) {
    $abs = $footerSocialLogoDirAbs . '/' . $file;
    if (is_file($abs)) {
        $footerSocialLogos[$key] = $footerSocialLogoDirRel . '/' . $file;
    }
}

$footerSocialMeta = [
    'facebook' => ['title' => 'Facebook', 'icon' => 'fab fa-facebook-f'],
    'messenger' => ['title' => 'Messenger', 'icon' => 'fab fa-facebook-messenger'],
    'instagram' => ['title' => 'Instagram', 'icon' => 'fab fa-instagram'],
    'google' => ['title' => 'Google', 'icon' => 'fa-brands fa-google'],
    'tiktok' => ['title' => 'TikTok', 'icon' => 'fa-brands fa-tiktok'],
    'whatsapp' => ['title' => 'WhatsApp', 'icon' => 'fab fa-whatsapp']
];

$footerSocialUrls = [
    'facebook' => trim((string) ($facebook ?? '')),
    'messenger' => trim((string) ($messenger ?? '')),
    'instagram' => trim((string) ($instagram ?? '')),
    'google' => trim((string) ($google ?? '')),
    'tiktok' => trim((string) ($tiktok ?? '')),
    'whatsapp' => trim((string) ($whatsapp ?? ''))
];

$footerSocialItems = [];
foreach ($footerSocialMeta as $key => $meta) {
    $url = trim((string) ($footerSocialUrls[$key] ?? ''));
    if ($url === '' || $url === '#') continue;
    $footerSocialItems[] = [
        'key' => $key,
        'url' => $url,
        'title' => $meta['title'],
        'icon' => $meta['icon']
    ];
}

$footerServicesMenu = [];
if (!empty($ServicesDisplayList) && is_array($ServicesDisplayList)) {
    $footerServicesMenu = $ServicesDisplayList;
} elseif (!empty($ServicesList) && is_array($ServicesList)) {
    $footerServicesMenu = array_values($ServicesList);
}

$footerPhoneLabel1 = trim((string) ($PhoneName ?? 'Main'));
$footerPhoneLabel2 = trim((string) ($Phone2Name ?? 'Secondary'));
?>

<style>
    :root {
        /* Variables dinámicas desde PHP */
        --f-bg: var(--brand-secondary);
        --f-text: var(--brand-accent);
        --f-accent: var(--brand-accent);
        --f-border: rgba(var(--brand-accent-rgb), 0.24);
    }

    .site-footer {
        background-color: var(--f-bg);
        color: var(--f-text);
        padding: 80px 0 30px;
        font-family: var(--font-body);
        position: relative;
        overflow: hidden;
        border-top: 1px solid var(--f-border); /* Línea sólida premium arriba */
    }

    .footer-container {
        max-width: 1300px;
        margin: 0 auto;
        padding: 0 25px;
    }

    /* GRID PRINCIPAL */
    .footer-grid {
        display: grid;
        /* Desktop: 4 columnas desiguales para mejor balance */
        grid-template-columns: 1.4fr 0.8fr 1fr 1.2fr;
        gap: 50px;
        margin-bottom: 60px;
        grid-template-areas: 
            "brand links1 links2 contact";
    }

    /* --- COLUMNA MARCA --- */
    .f-brand { grid-area: brand; }

    .f-logo-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 14px;
        margin-bottom: 25px;
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid rgba(var(--brand-accent-rgb), 0.16);
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.18);
    }
    
    .f-logo {
        max-width: 180px;
        display: block;
    }

    .f-desc {
        font-size: 0.95rem;
        line-height: 1.6;
        color: rgba(255, 255, 255, 0.72);
        margin-bottom: 30px;
        max-width: 300px;
    }

    .f-socials {
        display: flex;
        gap: 12px;
    }

    .f-social-btn {
        width: 40px; height: 40px;
        background: rgba(var(--brand-accent-rgb), 0.08);
        display: flex; align-items: center; justify-content: center;
        border-radius: 4px; /* Cuadrado redondeado para look construcción */
        color: var(--f-text);
        text-decoration: none;
        transition: 0.3s;
        border: 1px solid rgba(var(--brand-accent-rgb), 0.2);
    }

    .f-social-btn img {
        width: 18px;
        height: 18px;
        object-fit: contain;
        display: block;
    }

    .f-social-btn--facebook,
    .f-social-btn--google {
        background: #ffffff;
        border-color: rgba(255, 255, 255, 0.72);
    }

    .f-social-btn:hover {
        background: rgba(var(--brand-accent-rgb), 0.14);
        border-color: var(--f-accent);
        color: #fff;
        transform: translateY(-3px);
    }

    /* --- COLUMNAS ENLACES --- */
    .f-links-1 { grid-area: links1; }
    .f-links-2 { grid-area: links2; }

    .f-title {
        color: var(--f-text);
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 25px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .f-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .f-list li { margin-bottom: 12px; }

    .f-list a {
        color: rgba(255, 255, 255, 0.78);
        text-decoration: none;
        transition: 0.3s;
        font-size: 0.95rem;
        display: inline-block;
    }

    .f-list a:hover {
        color: var(--f-accent);
        transform: translateX(5px);
    }

    /* --- COLUMNA CONTACTO --- */
    .f-contact { grid-area: contact; }

    .contact-row {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        margin-bottom: 20px;
    }

    .c-icon {
        color: var(--f-accent);
        font-size: 1.1rem;
        margin-top: 3px; /* Ajuste óptico */
    }

    .c-text span, .c-text a {
        display: block;
        color: rgba(255, 255, 255, 0.82);
        text-decoration: none;
        line-height: 1.5;
        font-size: 0.95rem;
        transition: 0.3s;
    }

    .c-text a:hover { color: var(--f-accent); }
    .c-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        color: rgba(var(--brand-accent-rgb), 0.82);
        margin-bottom: 2px;
        display: block;
    }

    /* --- COPYRIGHT BAR --- */
    .footer-bar {
        border-top: 1px solid var(--f-border);
        padding-top: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
        font-size: 0.85rem;
        color: rgba(255, 255, 255, 0.68);
    }

    .legal-badges {
        display: flex;
        gap: 15px;
    }

    .legal-badges span {
        color: var(--f-accent);
        font-weight: 600;
        background: rgba(var(--brand-accent-rgb), 0.12);
        padding: 4px 10px;
        border-radius: 4px;
    }

    /* =========================================
       OPTIMIZACIÓN MOBILE
       ========================================= */
    @media (max-width: 991px) {
        .footer-grid {
            /* Tablet: 2 filas, 2 columnas */
            grid-template-columns: 1fr 1fr;
            grid-template-areas: 
                "brand contact"
                "links1 links2";
            gap: 40px;
        }
        .f-desc { max-width: 100%; }
    }

    @media (max-width: 600px) {
        .site-footer { padding: 50px 0 30px; }
        
        .footer-grid {
            /* Mobile: Layout híbrido */
            grid-template-columns: 1fr 1fr; /* Mantenemos 2 columnas para los enlaces */
            gap: 30px;
            grid-template-areas: 
                "brand brand"   /* Marca ocupa todo el ancho arriba */
                "links1 links2" /* Enlaces lado a lado (Ahorra espacio vertical) */
                "contact contact"; /* Contacto ocupa todo el ancho abajo */
        }

        /* 1. Brand Section Centrada */
        .f-brand { 
            text-align: center; 
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .f-logo { margin: 0 auto 20px auto; }
        .f-socials { justify-content: center; }

        /* 2. Enlaces alineados a la izquierda pero en grilla */
        .f-title { font-size: 1rem; margin-bottom: 15px; }

        /* 3. Contacto alineado a la izquierda (Mejor legibilidad) */
        .f-contact { 
            margin-top: 10px; 
            padding-top: 20px;
            border-top: 1px solid var(--f-border);
        }

        .footer-bar {
            flex-direction: column;
            text-align: center;
        }
    }
</style>

<footer class="site-footer">
    <div class="footer-container">
        
        <div class="footer-grid">
            
            <div class="f-brand">
                <a href="<?php echo $BaseURL; ?>" class="f-logo-link">
                    <img src="assets/img/logos.png" alt="<?php echo $Company; ?>" class="f-logo">
                </a>
                <p class="f-desc">
                    <?php echo htmlspecialchars($FooterCopy['desc'] ?? ''); ?>
                </p>
                <?php if (!empty($footerSocialItems)): ?>
                    <div class="f-socials">
                        <?php foreach ($footerSocialItems as $item): ?>
                            <a href="<?php echo htmlspecialchars($item['url'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener" class="f-social-btn f-social-btn--<?php echo htmlspecialchars($item['key'], ENT_QUOTES, 'UTF-8'); ?>" title="<?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?>">
                                <?php if (!empty($footerSocialLogos[$item['key']])): ?>
                                    <img src="<?php echo htmlspecialchars($footerSocialLogos[$item['key']], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?>">
                                <?php else: ?>
                                    <i class="<?php echo htmlspecialchars($item['icon'], ENT_QUOTES, 'UTF-8'); ?>"></i>
                                <?php endif; ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="f-links-1">
                <h4 class="f-title"><?php echo $FooterCopy['titles']['company'] ?? ''; ?></h4>
                <ul class="f-list">
                    <li><a href="<?php echo $BaseURL; ?>" translate="no" class="notranslate"><?php echo $NavCopy['home'] ?? ''; ?></a></li>
                    <li><a href="about.php"><?php echo $NavCopy['about'] ?? ''; ?></a></li>
                    <li><a href="projects.php"><?php echo $NavCopy['projects'] ?? ''; ?></a></li>
                    <li><a href="contact.php"><?php echo $NavCopy['contact'] ?? ''; ?></a></li>
                </ul>
            </div>

            <div class="f-links-2">
                <h4 class="f-title"><?php echo $FooterCopy['titles']['services'] ?? ''; ?></h4>
                <ul class="f-list">
                    <?php foreach ($footerServicesMenu as $svc): ?>
                        <li>
                            <a href="<?php echo htmlspecialchars($svc['url'] ?? 'services.php', ENT_QUOTES, 'UTF-8'); ?>">
                                <?php echo htmlspecialchars($svc['name'] ?? 'Service', ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                    <?php if (empty($footerServicesMenu)): ?>
                        <li><a href="services.php"><?php echo htmlspecialchars($NavCopy['view_services'] ?? 'View Services', ENT_QUOTES, 'UTF-8'); ?></a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="f-contact">
                <h4 class="f-title"><?php echo $FooterCopy['titles']['contact'] ?? ''; ?></h4>
                
                <div class="contact-row">
                    <i class="fas fa-map-marker-alt c-icon"></i>
                    <div class="c-text">
                        <span class="c-label"><?php echo $FooterCopy['labels']['location'] ?? ''; ?></span>
                        <span><?php echo $Address; ?></span>
                    </div>
                </div>

                <div class="contact-row">
                    <i class="fas fa-phone-alt c-icon"></i>
                    <div class="c-text">
                        <span class="c-label"><?php echo $FooterCopy['labels']['phone'] ?? ''; ?></span>
                        <a href="<?php echo $PhoneRef; ?>">
                            <?php echo $Phone; ?>
                            <?php if ($footerPhoneLabel1 !== ''): ?>
                                (<?php echo htmlspecialchars($footerPhoneLabel1, ENT_QUOTES, 'UTF-8'); ?>)
                            <?php endif; ?>
                        </a>
                        <?php if (!empty($Phone2) && !empty($PhoneRef2)): ?>
                            <a href="<?php echo $PhoneRef2; ?>">
                                <?php echo $Phone2; ?>
                                <?php if ($footerPhoneLabel2 !== ''): ?>
                                    (<?php echo htmlspecialchars($footerPhoneLabel2, ENT_QUOTES, 'UTF-8'); ?>)
                                <?php endif; ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="contact-row">
                    <i class="fas fa-clock c-icon"></i>
                    <div class="c-text">
                        <span class="c-label"><?php echo $FooterCopy['labels']['hours'] ?? ''; ?></span>
                        <span><?php echo $Schedule; ?></span>
                    </div>
                </div>
            </div>

        </div>

        <div class="footer-bar">
            <div class="copyright">
                &copy; <?php echo date('Y'); ?> <strong><?php echo $Company; ?></strong>. <?php echo $FooterCopy['copyright_suffix'] ?? ''; ?>
            </div>
            <div class="legal-badges">
                <?php if (!empty($LicenseNumber)): ?>
                    <span><?php echo $LicenseNumber; ?></span>
                <?php endif; ?>
                <span><?php echo $LicenseNote; ?></span>
                <span><?php echo $BilingualNote; ?></span>
            </div>
        </div>

    </div>
</footer>

<style>
    .floating-actions {
        position: fixed;
        right: 18px;
        bottom: 18px;
        z-index: 40;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .fabtn {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        text-decoration: none;
        box-shadow: 0 12px 30px rgba(0,0,0,0.2);
        border: 1px solid rgba(255,255,255,0.2);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        animation: floatingBubble 3.5s ease-in-out infinite;
    }

    .fabtn:hover {
        transform: translateY(-2px);
        box-shadow: 0 16px 36px rgba(0,0,0,0.25);
    }

    .fabtn.call { background: var(--brand-primary); }
    .fabtn.call-alt { background: var(--brand-accent); color: var(--brand-secondary); }
    .fabtn.whatsapp { background: #25D366; }
    @keyframes floatingBubble {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }
</style>
<div class="floating-actions" aria-label="<?php echo htmlspecialchars($FooterCopy['titles']['contact'] ?? ''); ?>">
    <a class="fabtn call" href="<?php echo $PhoneRef; ?>" aria-label="<?php echo htmlspecialchars($AriaCopy['call'] ?? ''); ?>">
        <i class="fas fa-phone-alt"></i>
    </a>
    <?php if(!empty($Phone2) && !empty($PhoneRef2)): ?>
        <a class="fabtn call-alt" href="<?php echo $PhoneRef2; ?>" aria-label="<?php echo htmlspecialchars(($AriaCopy['call'] ?? 'Click to call') . ' ' . ($Phone2Name ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
            <i class="fas fa-phone-volume"></i>
        </a>
    <?php endif; ?>
    <?php if(!empty($whatsapp)): ?>
        <a class="fabtn whatsapp" href="<?php echo $whatsapp; ?>" target="_blank" aria-label="<?php echo htmlspecialchars($AriaCopy['whatsapp'] ?? ''); ?>">
            <i class="fab fa-whatsapp"></i>
        </a>
    <?php endif; ?>
</div>
<script>
    // El nombre de la marca no se traduce (Google Translate lo convertía en "Lavado rápido...").
    (function () {
        var brand = /Quick Wash/;
        var walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT);
        var nodes = [];
        while (walker.nextNode()) if (brand.test(walker.currentNode.nodeValue)) nodes.push(walker.currentNode);
        nodes.forEach(function (node) {
            if (node.parentNode.closest('script,style,.notranslate')) return;
            var frag = document.createDocumentFragment();
            node.nodeValue.split(/(Quick Wash Detailing|Quick Wash)/).forEach(function (part) {
                if (!part) return;
                if (/^Quick Wash/.test(part)) {
                    var span = document.createElement('span');
                    span.className = 'notranslate'; span.setAttribute('translate', 'no'); span.textContent = part;
                    frag.appendChild(span);
                } else frag.appendChild(document.createTextNode(part));
            });
            node.parentNode.replaceChild(frag, node);
        });
    })();
</script>
<script src="assets/js/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

