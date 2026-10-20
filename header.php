<?php
$defaultPageName = $namepage ?? ($NavCopy['home'] ?? '');
$PageTitle = $PageTitle ?? sprintf('%s | %s', $Company ?? '', $defaultPageName);
$PageDescription = $PageDescription ?? ($ExHome ?? ($Home[0] ?? ''));
$canonicalPath = basename($_SERVER['SCRIPT_NAME'] ?? '') ?: '';
$PageCanonical = $PageCanonical ?? rtrim($BaseURL ?? '', '/') . ($canonicalPath ? '/' . ltrim($canonicalPath, '/') : '/');

// Aseguramos variables de redes sociales
$fb_url = $facebook ?? '';
$insta_url = $instagram ?? '';
$goo_url = $google ?? '';
$tik_url = $tiktok ?? '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title class="notranslate" translate="no"><?php echo $PageTitle; ?></title>
    <meta name="description" content="<?php echo htmlspecialchars((string) $PageDescription, ENT_QUOTES, 'UTF-8'); ?>">
    <link rel="canonical" href="<?php echo $PageCanonical; ?>">
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <link rel="apple-touch-icon" href="assets/img/favicon.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
    
    <link rel="stylesheet" href="assets/css/style.css">

    
    <style>
        <?php echo $BrandCSSVars; ?>

        .site-header {
            background: #ffffff;
            border-bottom: 1px solid rgba(31, 42, 54, 0.14);
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.08);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .site-header + main {
            margin: 0;
            padding: 0;
        }

        .site-header + main > :first-child {
            margin-top: 0 !important;
        }

        .header-main {
            padding: 8px 0;
            background: #ffffff;
            border-bottom: 1px solid rgba(31, 42, 54, 0.1);
        }

        .header-container {
            display: grid;
            grid-template-columns: auto minmax(0, 1fr) auto;
            align-items: center;
            gap: 20px;
            min-height: 112px;
            max-width: min(1680px, 97vw);
            width: 100%;
            margin: 0 auto;
            padding-left: clamp(14px, 2vw, 34px);
            padding-right: clamp(14px, 2vw, 34px);
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            flex-shrink: 0;
            max-width: 320px;
            min-width: 0;
        }

        .logo-img {
            height: 120px;
            min-height: 120px;
            max-height: 132px;
            max-width: 360px;
            width: auto;
            display: block;
            object-fit: contain;
            transition: all 0.3s ease;
        }

        .brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1;
        }

        .brand-title {
            font-weight: 800;
            letter-spacing: 0.5px;
            color: #ffffff;
            font-size: 1rem;
            text-transform: uppercase;
        }

        .brand-sub {
            font-size: 0.7rem;
            letter-spacing: 3px;
            color: var(--brand-primary);
            text-transform: uppercase;
            margin-top: 4px;
        }

        .main-nav {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-nav ul {
            display: flex;
            align-items: center;
            gap: 20px;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .main-nav > ul > li > a {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            line-height: 1;
            min-height: 40px;
            text-decoration: none;
            color: var(--brand-secondary);
            font-weight: 600;
            font-size: 0.95rem;
            transition: color 0.2s ease;
        }

        .dropdown-arrow {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 0.72rem;
            transform: translateY(-1px);
            margin-left: 2px;
        }

        .main-nav > ul > li > a:hover,
        .main-nav > ul > li > a:focus {
            color: var(--brand-primary);
        }

        .has-dropdown {
            position: relative;
        }

        .dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 220px;
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 12px;
            padding: 8px 0;
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.08);
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.2s ease;
            z-index: 10;
        }

        .has-dropdown:hover .dropdown,
        .has-dropdown:focus-within .dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .has-dropdown.open > a .dropdown-arrow {
            transform: rotate(180deg);
        }

        .dropdown--services {
            min-width: min(760px, 84vw);
            padding: 14px;
            display: grid;
            grid-template-columns: repeat(2, minmax(230px, 1fr));
            gap: 10px;
            max-height: min(68vh, 480px);
            overflow-y: auto;
            overflow-x: hidden;
        }

        .dropdown--services::-webkit-scrollbar {
            width: 8px;
        }

        .dropdown--services::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 999px;
        }

        .dropdown-services__all,
        .dropdown-services__other {
            grid-column: 1 / -1;
            list-style: none;
        }

        .dropdown-services__all > a,
        .dropdown-services__other > a {
            display: block;
            padding: 9px 12px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.83rem;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            background: rgba(31, 42, 54, 0.04);
        }

        .dropdown-group {
            list-style: none;
            border: 1px solid rgba(31, 42, 54, 0.08);
            border-radius: 10px;
            padding: 10px 12px;
            background: #fff;
        }

        .dropdown-group__title {
            display: block;
            margin: 0 0 6px;
            color: #1c1c1c;
            font-size: 0.74rem;
            font-weight: 800;
            letter-spacing: 1.1px;
            text-transform: uppercase;
        }

        .dropdown-group__list {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .dropdown-group__list li {
            list-style: none;
        }

        .dropdown .dropdown-group__list li a {
            display: block;
            padding: 6px 0;
            border-radius: 6px;
            font-size: 0.87rem;
            line-height: 1.35;
        }

        .dropdown .dropdown-group__list li a:hover {
            padding-left: 4px;
        }

        .dropdown li a {
            display: block;
            padding: 10px 16px;
            color: #1f1f1f;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .dropdown li a:hover {
            background: rgba(0, 0, 0, 0.04);
            color: var(--brand-primary);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            justify-self: end;
        }

        /* --- REDES SOCIALES ESTILOS (Global) --- */
        .header-socials {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .social-icon-link {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: rgba(31, 42, 54, 0.06);
            color: var(--brand-secondary);
            display: flex; /* Flex para centrar el icono */
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 1rem;
            flex-shrink: 0; /* Evita que se aplasten */
            border: 1px solid rgba(31, 42, 54, 0.2);
        }

        .social-icon-link:hover {
            background-color: var(--brand-primary);
            color: #ffffff;
            transform: translateY(-2px);
        }

        .btn-estimate {
            background: var(--brand-accent);
            color: var(--brand-secondary);
            padding: 10px 20px;
            border-radius: 999px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.72rem;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
            white-space: nowrap;
        }

        .btn-estimate:hover,
        .btn-estimate:focus {
            transform: translateY(-1px);
            color: var(--brand-secondary);
            box-shadow: 0 16px 30px rgba(0, 0, 0, 0.18);
        }

        .language-switcher {
            display: inline-flex;
            align-items: center;
            gap: 2px;
            padding: 3px;
            border-radius: 999px;
            background: #ffffff;
            border: 1px solid rgba(var(--brand-primary-rgb), 0.22);
        }

        .language-switcher button {
            border: 0;
            border-radius: 999px;
            min-width: 40px;
            padding: 7px 12px;
            background: transparent;
            color: var(--brand-primary);
            font-family: var(--font-body);
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.02em;
            line-height: 1;
            cursor: pointer;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .language-switcher button:hover {
            background: rgba(var(--brand-primary-rgb), 0.08);
        }

        .language-switcher button.active {
            background: var(--brand-primary);
            color: #ffffff;
        }

        .mobile-toggle {
            display: none;
            width: 44px;
            height: 44px;
            border: 1px solid rgba(31, 42, 54, 0.28);
            border-radius: 10px;
            background: #ffffff;
            align-items: center;
            justify-content: center;
            gap: 4px;
            flex-direction: column;
        }

        .mobile-toggle span {
            width: 22px;
            height: 2px;
            background: var(--brand-secondary);
            display: block;
            border-radius: 2px;
        }

        .mobile-menu-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.35);
            z-index: 999;
        }

        body.nav-open .mobile-menu-overlay {
            display: block;
        }

        body.nav-open .floating-actions {
            display: none !important;
        }

        .menu-close {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--brand-secondary);
        }

        @media (max-width: 991px) {
            .header-main {
                padding: 10px 0;
            }

            .brand {
                max-width: min(250px, calc(100vw - 92px));
            }

            .logo-img {
                width: min(240px, 62vw);
                height: auto;
                min-height: 0;
                max-height: 72px;
            }

            .header-container {
                grid-template-columns: minmax(0, 1fr) auto;
                min-height: 78px;
                gap: 12px;
            }

            .brand-text {
                display: none;
            }

            .main-nav {
                position: fixed;
                top: 0;
                right: 0;
                width: 85%;
                height: 100vh;
                background: #ffffff;
                padding: 28px 20px;
                transition: transform 0.3s ease;
                transform: translateX(110%);
                flex-direction: column;
                align-items: flex-start;
                justify-content: flex-start;
                gap: 24px;
                z-index: 1000;
                overflow-y: auto;
            }

            .main-nav.is-open {
                transform: translateX(0);
            }

            .menu-close {
                display: inline-flex;
                align-self: flex-end;
            }

            .main-nav ul {
                flex-direction: column;
                align-items: flex-start;
                width: 100%;
                gap: 0;
                background: transparent;
                height: auto;
                min-height: 0;
                padding: 0;
                overflow: visible;
            }

            .main-nav ul li {
                width: 100%;
            }

            /* Estilos generales para enlaces del menÃº */
            .main-nav ul li > a {
                display: block;
                padding: 14px 4px;
                width: 100%;
                border-bottom: 1px solid rgba(31, 42, 54, 0.14);
                color: var(--brand-secondary) !important;
                opacity: 1 !important;
            }

            .dropdown li a {
                color: var(--brand-secondary);
            }

            .dropdown li a:hover {
                background: rgba(31, 42, 54, 0.06);
                color: var(--brand-primary);
            }

            .dropdown {
                position: static;
                opacity: 1;
                visibility: visible;
                transform: none;
                border: none;
                box-shadow: none;
                padding: 0;
                display: none;
                width: 100%;
            }

            .has-dropdown.open .dropdown {
                display: block;
            }

            .dropdown li a {
                padding-left: 16px;
            }

            .dropdown--services {
                min-width: 100%;
                display: block;
                padding: 2px 0;
                border: none;
            }

            .dropdown-services__all > a,
            .dropdown-services__other > a {
                border-radius: 0;
                background: transparent;
                padding: 10px 0;
                font-size: 0.82rem;
            }

            .dropdown-group {
                border: none;
                border-top: 1px solid rgba(31, 42, 54, 0.14);
                border-radius: 0;
                padding: 10px 0 8px;
                background: transparent;
            }

            .dropdown-group__title {
                margin-bottom: 4px;
                font-size: 0.72rem;
                color: var(--brand-primary);
            }

            .dropdown-group__list li a {
                padding: 9px 0 9px 10px;
                font-size: 0.9rem;
            }

            .header-actions .btn-estimate,
            .header-actions .header-socials {
                display: none;
            }

            .mobile-toggle {
                display: inline-flex;
            }

            .mobile-cta {
                margin-top: 20px;
                display: flex;
                flex-direction: column;
                gap: 20px;
                width: 100%;
                /* Importante: quitamos borde inferior del contenedor CTA */
                border-bottom: none !important; 
            }

            /* CorrecciÃ³n para que el botÃ³n de estimado no herede estilos de enlace de menÃº */
            .mobile-cta a.btn-estimate {
                width: 100%;
                text-align: center;
                display: flex; 
                border-bottom: none;
                padding: 14px;
            }

            .mobile-cta .language-switcher {
                margin: 0 auto 4px;
            }

            /* --- CORRECCIÃ“N DE REDES SOCIALES EN MÃ“VIL --- */
            .mobile-socials {
                display: flex;
                justify-content: center;
                gap: 15px;
                margin-top: 10px;
                padding-bottom: 20px;
            }

            /* Forzamos estilos para los iconos dentro del menÃº mÃ³vil para sobreescribir los estilos generales de 'a' */
            .mobile-socials .social-icon-link {
                display: inline-flex !important; /* Sobreescribe display: block */
                width: 36px !important;         /* Restaura el ancho */
                border-bottom: none !important; /* Quita la l\u00ednea de abajo */
                padding: 0 !important;          /* Quita el padding de men\u00fa */
                background-color: rgba(31, 42, 54, 0.06);
                color: var(--brand-secondary) !important;
                border: 1px solid rgba(31, 42, 54, 0.2) !important;
            }
        }

        @media (max-width: 575px) {
            .brand {
                max-width: min(225px, calc(100vw - 84px));
            }

            .logo-img {
                width: min(220px, 60vw);
                max-height: 64px;
            }

            .header-container {
                min-height: 72px;
                padding-left: 12px;
                padding-right: 12px;
            }

            .mobile-toggle {
                width: 42px;
                height: 42px;
            }
        }
    </style>
    <link rel="stylesheet" href="assets/css/brand.css">
</head>
<?php
$bodyClassAttr = trim((string) ($BodyClass ?? ''));
?>
<body<?php echo $bodyClassAttr !== '' ? ' class="' . htmlspecialchars($bodyClassAttr, ENT_QUOTES, 'UTF-8') . '"' : ''; ?>>

<header class="site-header">
    <div class="header-main">
        <div class="container header-container">
            <?php
            $companyParts = preg_split('/\s+/', trim($Company ?? ''));
            $brandLine1 = implode(' ', array_slice($companyParts, 0, 2));
            $brandLine2 = implode(' ', array_slice($companyParts, 2));
            ?>
            <a href="<?php echo $BaseURL; ?>" class="brand">
                <img src="assets/img/logos.png" alt="<?php echo $Company; ?>" class="logo-img">
            </a>

            <nav class="main-nav" id="mainNav" aria-label="<?php echo htmlspecialchars($AriaCopy['primary_nav'] ?? ''); ?>">
                <button class="menu-close d-lg-none" aria-label="<?php echo htmlspecialchars($HeaderCopy['menu_close'] ?? ''); ?>">
                    <i class="fa-solid fa-xmark"></i>
                </button>

                <ul>
                    <li><a href="<?php echo $BaseURL; ?>" translate="no" class="notranslate"><?php echo $NavCopy['home'] ?? ''; ?></a></li>
                    <li><a href="about.php"><?php echo $NavCopy['about'] ?? ''; ?></a></li>
                    <li><a href="services.php"><?php echo htmlspecialchars($NavCopy['services'] ?? 'Services', ENT_QUOTES, 'UTF-8'); ?></a></li>
                    <li><a href="projects.php"><?php echo $NavCopy['projects'] ?? ''; ?></a></li>
                    
                    <li><a href="contact.php"><?php echo $NavCopy['contact'] ?? ''; ?></a></li>
                    
                    <li class="mobile-cta d-lg-none">
                        <a href="<?php echo $PhoneRef; ?>" class="btn-estimate"><?php echo $NavCopy['cta_mobile'] ?? ''; ?></a>
                        <div class="language-switcher" aria-label="<?php echo htmlspecialchars($LanguageCopy['label'] ?? 'Language', ENT_QUOTES, 'UTF-8'); ?>">
                            <button type="button" data-lang="en" aria-label="<?php echo htmlspecialchars($LanguageCopy['english'] ?? 'English', ENT_QUOTES, 'UTF-8'); ?>">
                                <?php echo htmlspecialchars($LanguageCopy['english_short'] ?? 'EN', ENT_QUOTES, 'UTF-8'); ?>
                            </button>
                            <button type="button" data-lang="es" aria-label="<?php echo htmlspecialchars($LanguageCopy['spanish'] ?? 'Espanol', ENT_QUOTES, 'UTF-8'); ?>">
                                <?php echo htmlspecialchars($LanguageCopy['spanish_short'] ?? 'ES', ENT_QUOTES, 'UTF-8'); ?>
                            </button>
                        </div>
                        
                        <div class="mobile-socials">
                            <?php if(!empty($fb_url)): ?>
                                <a href="<?php echo $fb_url; ?>" target="_blank" class="social-icon-link"><i class="fab fa-facebook-f"></i></a>
                            <?php endif; ?>
                            <?php if(!empty($messenger)): ?>
                                <a href="<?php echo $messenger; ?>" target="_blank" class="social-icon-link"><i class="fab fa-facebook-messenger"></i></a>
                            <?php endif; ?>
                            <?php if(!empty($insta_url)): ?>
                                <a href="<?php echo $insta_url; ?>" target="_blank" class="social-icon-link"><i class="fab fa-instagram"></i></a>
                            <?php endif; ?>
                            <?php if(!empty($goo_url)): ?>
                                <a href="<?php echo $goo_url; ?>" target="_blank" class="social-icon-link"><i class="fab fa-google"></i></a>
                            <?php endif; ?>
                            <?php if(!empty($tik_url)): ?>
                                <a href="<?php echo $tik_url; ?>" target="_blank" class="social-icon-link"><i class="fab fa-tiktok"></i></a>
                            <?php endif; ?>
                            <?php if(!empty($whatsapp)): ?>
                                <a href="<?php echo $whatsapp; ?>" target="_blank" class="social-icon-link"><i class="fab fa-whatsapp"></i></a>
                            <?php endif; ?>
                        </div>
                    </li>
                </ul>
            </nav>

            <div class="header-actions">
                <div class="header-socials d-none d-lg-flex">
                    <?php if(!empty($fb_url)): ?>
                        <a href="<?php echo $fb_url; ?>" target="_blank" class="social-icon-link" title="<?php echo htmlspecialchars($HeaderCopy['social_titles']['facebook'] ?? ''); ?>"><i class="fab fa-facebook-f"></i></a>
                    <?php endif; ?>
                    <?php if(!empty($messenger)): ?>
                        <a href="<?php echo $messenger; ?>" target="_blank" class="social-icon-link" title="<?php echo htmlspecialchars($HeaderCopy['social_titles']['messenger'] ?? ''); ?>"><i class="fab fa-facebook-messenger"></i></a>
                    <?php endif; ?>
                    <?php if(!empty($goo_url)): ?>
                        <a href="<?php echo $goo_url; ?>" target="_blank" class="social-icon-link" title="<?php echo htmlspecialchars($HeaderCopy['social_titles']['google'] ?? ''); ?>"><i class="fab fa-google"></i></a>
                    <?php endif; ?>
                    <?php if(!empty($insta_url)): ?>
                        <a href="<?php echo $insta_url; ?>" target="_blank" class="social-icon-link" title="<?php echo htmlspecialchars($HeaderCopy['social_titles']['instagram'] ?? ''); ?>"><i class="fab fa-instagram"></i></a>
                    <?php endif; ?>
                    <?php if(!empty($tik_url)): ?>
                        <a href="<?php echo $tik_url; ?>" target="_blank" class="social-icon-link" title="<?php echo htmlspecialchars($HeaderCopy['social_titles']['tiktok'] ?? ''); ?>"><i class="fab fa-tiktok"></i></a>
                    <?php endif; ?>
                    <?php if(!empty($whatsapp)): ?>
                        <a href="<?php echo $whatsapp; ?>" target="_blank" class="social-icon-link" title="<?php echo htmlspecialchars($HeaderCopy['social_titles']['whatsapp'] ?? ''); ?>"><i class="fab fa-whatsapp"></i></a>
                    <?php endif; ?>
                </div>

                <div class="language-switcher d-none d-lg-inline-flex" aria-label="<?php echo htmlspecialchars($LanguageCopy['label'] ?? 'Language', ENT_QUOTES, 'UTF-8'); ?>">
                    <button type="button" data-lang="en" aria-label="<?php echo htmlspecialchars($LanguageCopy['english'] ?? 'English', ENT_QUOTES, 'UTF-8'); ?>">
                        <?php echo htmlspecialchars($LanguageCopy['english_short'] ?? 'EN', ENT_QUOTES, 'UTF-8'); ?>
                    </button>
                    <button type="button" data-lang="es" aria-label="<?php echo htmlspecialchars($LanguageCopy['spanish'] ?? 'Espanol', ENT_QUOTES, 'UTF-8'); ?>">
                        <?php echo htmlspecialchars($LanguageCopy['spanish_short'] ?? 'ES', ENT_QUOTES, 'UTF-8'); ?>
                    </button>
                </div>

                <a href="<?php echo $PhoneRef; ?>" class="btn-estimate"><?php echo $NavCopy['cta'] ?? ''; ?></a>
                
                <button class="mobile-toggle" type="button" aria-label="<?php echo htmlspecialchars($HeaderCopy['menu_toggle'] ?? ''); ?>" aria-controls="mainNav" aria-expanded="false">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
        <div class="mobile-menu-overlay"></div>
    </div>
</header>
<div id="google_translate_element" aria-hidden="true"></div>
<script>
    window.googleTranslateElementInit = function () {
        if (!window.google || !google.translate) return;
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: 'en,es',
            autoDisplay: false
        }, 'google_translate_element');
    };

    (function () {
        const buttons = document.querySelectorAll('.language-switcher [data-lang]');
        const current = /googtrans=\/en\/es/.test(document.cookie) ? 'es' : 'en';

        buttons.forEach((button) => {
            button.classList.toggle('active', button.dataset.lang === current);
            button.addEventListener('click', () => {
                const lang = button.dataset.lang === 'es' ? 'es' : 'en';
                const value = '/en/' + lang;
                document.cookie = 'googtrans=' + value + ';path=/';

                const parts = window.location.hostname.split('.');
                if (parts.length > 1) {
                    document.cookie = 'googtrans=' + value + ';path=/;domain=.' + parts.slice(-2).join('.');
                }

                window.location.reload();
            });
        });
    }());
</script>
<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<main>
    




