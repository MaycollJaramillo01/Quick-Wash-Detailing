<?php
require_once __DIR__ . '/text.php';

$company = trim((string) ($Company ?? 'JP RENOVATION LLC'));
$owner = trim((string) ($CustomerName ?? $company));
$address = trim((string) ($Address ?? ''));
$phone = trim((string) ($Phone ?? ''));
$phone2 = trim((string) ($Phone2 ?? ''));
$phoneLabel = trim((string) ($PhoneName ?? 'English'));
$phone2Label = trim((string) ($Phone2Name ?? 'Spanish'));
$email = trim((string) ($Mail ?? ''));
$schedule = trim((string) ($Schedule ?? ''));
$coverage = trim((string) ($Coverage ?? ''));
$license = trim((string) ($LicenseNote ?? ''));
$licenseNumber = trim((string) ($LicenseNumber ?? ''));
$bilingual = trim((string) ($BilingualNote ?? ''));
$serviceType = trim((string) ($TypeOfService ?? ''));
$about = trim((string) ($Home[0] ?? ''));

$phoneRef = trim((string) ($PhoneRef ?? ''));
$phone2Ref = trim((string) ($PhoneRef2 ?? ''));
$mailRef = trim((string) ($MailRef ?? ($email !== '' ? 'mailto:' . $email : '')));
$whatsappRef = trim((string) ($whatsapp ?? ''));
$facebookRef = trim((string) ($facebook ?? ''));
$instagramRef = trim((string) ($instagram ?? ''));
$tiktokRef = trim((string) ($tiktok ?? ''));
$googleRef = trim((string) ($google ?? ''));
$messengerRef = trim((string) ($messenger ?? ''));
$googleMap = (string) ($GoogleMap ?? '');
$showroomImage = 'assets/video/video-1.jpg';
$showroomVideo = 'assets/video/video-1.mp4';

$logoPath = 'assets/img/logos.png';
$domainRef = trim((string) ($Domain ?? ($BaseURL ?? '')));
if ($domainRef === '') $domainRef = '#';
$domainLabel = preg_replace('#^https?://#i', '', $domainRef);
$domainLabel = rtrim((string) $domainLabel, '/');

$brandPrimary = (string) ($BrandColors['primary'] ?? '#1C1C1C');
$brandSecondary = (string) ($BrandColors['secondary'] ?? '#050505');
$brandAccent = (string) ($BrandColors['accent'] ?? '#F1DE4B');
$brandNeutral = (string) ($BrandColors['neutral'] ?? '#F5F2E8');
$brandWhite = (string) ($BrandColors['white'] ?? '#FFFFFF');
$brandPrimaryRgb = (string) ($BrandColors['primary_rgb'] ?? '28, 28, 28');
$brandSecondaryRgb = (string) ($BrandColors['secondary_rgb'] ?? '5, 5, 5');
$brandAccentRgb = (string) ($BrandColors['accent_rgb'] ?? '241, 222, 75');

if ($phoneRef === '' && $phone !== '') {
    $digits = preg_replace('/\D+/', '', $phone);
    if ($digits !== '') $phoneRef = 'tel:' . $digits;
}

if ($phone2Ref === '' && $phone2 !== '') {
    $digits2 = preg_replace('/\D+/', '', $phone2);
    if ($digits2 !== '') $phone2Ref = 'tel:' . $digits2;
}

$services = [];
if (!empty($ServicesDisplayList) && is_array($ServicesDisplayList)) {
    foreach ($ServicesDisplayList as $service) {
        $name = trim((string) ($service['name'] ?? ''));
        if ($name !== '') $services[] = $name;
    }
} elseif (!empty($SN) && is_array($SN)) {
    foreach ($SN as $name) {
        $name = trim((string) $name);
        if ($name !== '') $services[] = $name;
    }
}
$services = array_values(array_unique($services));

$socials = [];
$socialCandidates = [
    ['key' => 'facebook', 'href' => $facebookRef, 'icon' => 'fa-brands fa-facebook-f', 'label' => 'Facebook'],
    ['key' => 'instagram', 'href' => $instagramRef, 'icon' => 'fa-brands fa-instagram', 'label' => 'Instagram'],
    ['key' => 'whatsapp', 'href' => $whatsappRef, 'icon' => 'fa-brands fa-whatsapp', 'label' => 'WhatsApp'],
    ['key' => 'tiktok', 'href' => $tiktokRef, 'icon' => 'fa-brands fa-tiktok', 'label' => 'TikTok'],
    ['key' => 'google', 'href' => $googleRef, 'icon' => 'fa-brands fa-google', 'label' => 'Google'],
    ['key' => 'messenger', 'href' => $messengerRef, 'icon' => 'fa-brands fa-facebook-messenger', 'label' => 'Messenger'],
];
foreach ($socialCandidates as $item) {
    $href = trim((string) ($item['href'] ?? ''));
    if ($href === '' || $href === '#') continue;
    $socials[] = $item;
}

if (isset($_GET['vcard'])) {
    $contactName = trim($owner !== '' ? $owner : $company);
    $parts = preg_split('/\s+/', $contactName, -1, PREG_SPLIT_NO_EMPTY);
    $firstName = $parts[0] ?? '';
    $lastName = count($parts) > 1 ? implode(' ', array_slice($parts, 1)) : '';
    $phoneClean = preg_replace('/\D+/', '', $phone);
    $phone2Clean = preg_replace('/\D+/', '', $phone2);

    $city = '';
    $region = '';
    if ($address !== '') {
        $addressParts = array_map('trim', explode(',', $address, 2));
        $city = $addressParts[0] ?? '';
        $region = $addressParts[1] ?? '';
    }

    while (ob_get_level() > 0) {
        ob_end_clean();
    }

    header('Content-Type: text/vcard; charset=utf-8');
    header('Content-Disposition: attachment; filename="contact.vcf"');
    header('Content-Transfer-Encoding: binary');
    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Pragma: public');

    $vcard = [
        'BEGIN:VCARD',
        'VERSION:3.0',
        'N:' . $lastName . ';' . $firstName . ';;;',
        'FN:' . $contactName,
        'ORG:' . $company,
        'TITLE:Owner'
    ];

    if ($phoneClean !== '') $vcard[] = 'TEL;TYPE=CELL,VOICE:' . $phoneClean;
    if ($phone2Clean !== '') $vcard[] = 'TEL;TYPE=WORK,VOICE:' . $phone2Clean;
    if ($email !== '') $vcard[] = 'EMAIL;TYPE=INTERNET:' . $email;
    if ($city !== '' || $region !== '') $vcard[] = 'ADR;TYPE=WORK:;;;' . $city . ';' . $region . ';;USA';
    if ($domainRef !== '' && $domainRef !== '#') $vcard[] = 'URL:' . $domainRef;
    $vcard[] = 'END:VCARD';

    echo implode("\r\n", $vcard) . "\r\n";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($company, ENT_QUOTES, 'UTF-8'); ?>  Business Card</title>
    <meta name="description" content="Digital business card for <?php echo htmlspecialchars($company, ENT_QUOTES, 'UTF-8'); ?>">
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <link rel="apple-touch-icon" href="assets/img/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --brand-primary: <?php echo htmlspecialchars($brandPrimary, ENT_QUOTES, 'UTF-8'); ?>;
            --brand-secondary: <?php echo htmlspecialchars($brandSecondary, ENT_QUOTES, 'UTF-8'); ?>;
            --brand-accent: <?php echo htmlspecialchars($brandAccent, ENT_QUOTES, 'UTF-8'); ?>;
            --brand-neutral: <?php echo htmlspecialchars($brandNeutral, ENT_QUOTES, 'UTF-8'); ?>;
            --brand-white: <?php echo htmlspecialchars($brandWhite, ENT_QUOTES, 'UTF-8'); ?>;
            --brand-primary-rgb: <?php echo htmlspecialchars($brandPrimaryRgb, ENT_QUOTES, 'UTF-8'); ?>;
            --brand-secondary-rgb: <?php echo htmlspecialchars($brandSecondaryRgb, ENT_QUOTES, 'UTF-8'); ?>;
            --brand-accent-rgb: <?php echo htmlspecialchars($brandAccentRgb, ENT_QUOTES, 'UTF-8'); ?>;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            font-family: 'Inter', system-ui, sans-serif;
            background:
                var(--brand-neutral);
            color: var(--brand-secondary);
            padding: clamp(16px, 3vw, 28px);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .bcstage {
            width: min(1200px, 100%);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 26px 54px rgba(var(--brand-secondary-rgb), 0.22);
            border: 1px solid rgba(var(--brand-secondary-rgb), 0.15);
            background: var(--brand-white);
        }

        .bclayout {
            display: grid;
            grid-template-columns: minmax(320px, 0.88fr) minmax(0, 1.12fr);
            min-height: 700px;
        }

        .bcbrand {
            position: relative;
            overflow: hidden;
            padding: clamp(20px, 3vw, 30px);
            background:
                color-mix(in srgb, var(--brand-primary) 84%, #000 16%);
            color: var(--brand-white);
            display: grid;
            gap: 14px;
            align-content: start;
        }

        .bcbrand::after {
            content: '';
            position: absolute;
            inset: 0;
            pointer-events: none;
            background-image:
                none;
            background-size: 40px 40px;
            opacity: 0.2;
        }

        .bcbrand > * {
            position: relative;
            z-index: 1;
        }

        .bctag {
            min-height: 30px;
            display: inline-flex;
            align-items: center;
            width: fit-content;
            border-radius: 999px;
            padding: 0 12px;
            border: 1px solid rgba(var(--brand-accent-rgb), 0.46);
            background: rgba(var(--brand-accent-rgb), 0.15);
            color: color-mix(in srgb, var(--brand-white) 88%, var(--brand-accent) 12%);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 10px;
            font-weight: 800;
        }

        .bcbrandtop {
            display: grid;
            gap: 12px;
        }

        .bclogowrap {
            width: 96px;
            height: 96px;
            border-radius: 18px;
            background: var(--brand-white);
            border: 1px solid rgba(var(--brand-secondary-rgb), 0.14);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px;
        }

        .bclogowrap img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            display: block;
        }

        .bcbrand h1 {
            font-family: 'Poppins', sans-serif;
            font-size: clamp(1.9rem, 4.5vw, 2.7rem);
            line-height: 0.92;
            letter-spacing: 0.3px;
            margin: 0;
        }

        .bcbrand h1 span {
            display: block;
            color: color-mix(in srgb, var(--brand-accent) 58%, var(--brand-white) 42%);
            font-size: clamp(1rem, 2vw, 1.25rem);
            margin-top: 6px;
            letter-spacing: 1px;
        }

        .bcowner {
            color: rgba(255, 255, 255, 0.86);
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .bclinks {
            display: grid;
            gap: 8px;
        }

        .bclink {
            min-height: 40px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.24);
            background: rgba(255, 255, 255, 0.1);
            color: var(--brand-white);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 10px;
            font-size: 0.9rem;
            line-height: 1.3;
            transition: transform 0.2s ease, background-color 0.2s ease;
        }

        .bclink:hover {
            transform: translateY(-1px);
            background: rgba(var(--brand-accent-rgb), 0.2);
        }

        .bclink i {
            color: var(--brand-accent);
            width: 18px;
            text-align: center;
        }

        .bcactions {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px;
        }

        .bcbtn {
            min-height: 40px;
            border-radius: 10px;
            border: 1px solid transparent;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.9px;
            font-size: 10px;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 0 12px;
            transition: transform 0.2s ease, background-color 0.2s ease, border-color 0.2s ease;
        }

        .bcbtn:hover {
            transform: translateY(-1px);
        }

        .bcbtnaccent {
            background: var(--brand-accent);
            border-color: var(--brand-accent);
            color: var(--brand-secondary);
        }

        .bcbtnghost {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.24);
            color: var(--brand-white);
        }

        .bcsocial {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .bcsocial a {
            width: 36px;
            height: 36px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.24);
            background: rgba(255, 255, 255, 0.1);
            color: var(--brand-white);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: transform 0.2s ease, background-color 0.2s ease;
        }

        .bcsocial a:hover {
            transform: translateY(-1px);
            background: rgba(var(--brand-accent-rgb), 0.24);
            color: var(--brand-accent);
        }

        .bcsocial .bc-social--facebook {
            background: #1877f2;
            border-color: #1877f2;
            color: #fff;
        }

        .bcsocial .bc-social--google {
            background: #fff;
            border-color: rgba(255, 255, 255, 0.72);
            color: #4285f4;
        }

        .bcnotes {
            margin-top: auto;
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
        }

        .bcnotes span {
            min-height: 28px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.26);
            background: rgba(255, 255, 255, 0.08);
            color: rgba(255, 255, 255, 0.9);
            display: inline-flex;
            align-items: center;
            padding: 0 10px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.9px;
            font-weight: 700;
        }

        .bccontent {
            padding: clamp(20px, 3vw, 30px);
            background: color-mix(in srgb, var(--brand-neutral) 76%, var(--brand-white) 24%);
            display: grid;
            gap: 16px;
            align-content: start;
        }

        .bccontenthead h2 {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            color: var(--brand-secondary);
            font-size: clamp(1.8rem, 4vw, 2.7rem);
            line-height: 0.92;
        }

        .bccontenthead p {
            margin: 10px 0 0;
            color: color-mix(in srgb, var(--brand-secondary) 64%, var(--brand-white) 36%);
            line-height: 1.65;
            max-width: 72ch;
        }

        .bcinfogrid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .bcinfo {
            border: 1px solid rgba(var(--brand-secondary-rgb), 0.14);
            border-radius: 12px;
            background: var(--brand-white);
            min-height: 84px;
            padding: 10px;
            display: grid;
            gap: 6px;
        }

        .bcinfo small {
            color: rgba(var(--brand-secondary-rgb), 0.62);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 10px;
            font-weight: 700;
        }

        .bcinfo span,
        .bcinfo a {
            color: var(--brand-secondary);
            text-decoration: none;
            line-height: 1.45;
            font-weight: 600;
            font-size: 0.92rem;
        }

        .bcshowroom {
            position: relative;
            min-height: 190px;
            border-radius: 12px;
            overflow: hidden;
            background: var(--brand-secondary);
        }

        .bcshowroom img,
        .bcshowroom video {
            width: 100%;
            height: 100%;
            min-height: 190px;
            max-height: 250px;
            object-fit: cover;
            display: block;
        }

        .bcshowroom video {
            background: var(--brand-secondary);
        }

        .bcshowroom figcaption {
            position: absolute;
            left: 12px;
            bottom: 12px;
            padding: 7px 10px;
            border-radius: 6px;
            background: rgba(var(--brand-secondary-rgb), 0.88);
            color: #fff;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        .bcservices h3 {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            color: var(--brand-secondary);
            font-size: 1.35rem;
        }

        .bcservicegrid {
            margin-top: 10px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 8px;
        }

        .bcservicepill {
            min-height: 40px;
            border-radius: 10px;
            border: 1px solid rgba(var(--brand-secondary-rgb), 0.14);
            background: color-mix(in srgb, var(--brand-neutral) 74%, var(--brand-white) 26%);
            color: var(--brand-secondary);
            padding: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 0.83rem;
            font-weight: 600;
            line-height: 1.3;
        }

        .bcmap {
            border: 1px solid rgba(var(--brand-secondary-rgb), 0.14);
            border-radius: 12px;
            overflow: hidden;
            min-height: 240px;
            background: var(--brand-white);
        }

        .bcmap iframe {
            width: 100% !important;
            height: 100% !important;
            min-height: 240px;
            border: 0 !important;
        }

        @media (max-width: 980px) {
            .bclayout {
                grid-template-columns: 1fr;
            }

            .bcbrand {
                padding-bottom: 20px;
            }

            .bcinfogrid {
                grid-template-columns: 1fr;
            }

            .bcservicegrid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            body {
                padding: 10px;
                align-items: flex-start;
            }

            .bcstage {
                border-radius: 14px;
                box-shadow: 0 14px 30px rgba(var(--brand-secondary-rgb), 0.18);
            }

            .bcbrand,
            .bccontent {
                padding: 16px;
                gap: 14px;
            }

            .bclogowrap {
                width: 88px;
                height: 88px;
                border-radius: 14px;
            }

            .bcbrand h1 {
                font-size: clamp(1.8rem, 8.2vw, 2.3rem);
                line-height: 0.98;
            }

            .bcbrand h1 span {
                font-size: 1.05rem;
                margin-top: 8px;
            }

            .bcowner {
                font-size: 1rem;
                line-height: 1.55;
            }

            .bclink {
                min-height: 46px;
                padding: 10px 12px;
                font-size: 0.97rem;
                gap: 10px;
                border-color: rgba(255, 255, 255, 0.28);
            }

            .bclink i {
                width: 20px;
                font-size: 1rem;
            }

            .bcbtn {
                min-height: 44px;
                font-size: 11px;
                letter-spacing: 0.8px;
            }

            .bcsocial a {
                width: 38px;
                height: 38px;
            }

            .bcnotes span {
                min-height: 30px;
                font-size: 10px;
            }

            .bccontenthead h2 {
                font-size: clamp(1.75rem, 9vw, 2.2rem);
            }

            .bccontenthead p {
                margin-top: 8px;
                font-size: 0.97rem;
                line-height: 1.72;
                color: color-mix(in srgb, var(--brand-secondary) 84%, var(--brand-white) 16%);
            }

            .bcinfo {
                min-height: 92px;
                padding: 12px;
            }

            .bcinfo span,
            .bcinfo a {
                font-size: 0.98rem;
                font-weight: 700;
                line-height: 1.5;
            }

            .bcservices h3 {
                font-size: 1.45rem;
            }

            .bcactions {
                grid-template-columns: 1fr;
            }

            .bcservicegrid {
                grid-template-columns: 1fr;
                gap: 9px;
            }

            .bcservicepill {
                min-height: 44px;
                font-size: 0.92rem;
            }

            .bcmap,
            .bcmap iframe {
                min-height: 220px;
            }
        }
    </style>
</head>
<body>
    <div class="bcstage">
        <div class="bclayout">
            <aside class="bcbrand">
                <span class="bctag">Digital Business Card</span>

                <div class="bcbrandtop">
                    <div class="bclogowrap">
                        <img src="<?php echo htmlspecialchars($logoPath, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($company, ENT_QUOTES, 'UTF-8'); ?> logo">
                    </div>
                    <h1>
                        <?php echo htmlspecialchars($company, ENT_QUOTES, 'UTF-8'); ?>
                        <span><?php echo htmlspecialchars($owner, ENT_QUOTES, 'UTF-8'); ?></span>
                    </h1>
                    <?php if ($serviceType !== ''): ?>
                        <p class="bcowner"><?php echo htmlspecialchars($serviceType, ENT_QUOTES, 'UTF-8'); ?></p>
                    <?php endif; ?>
                </div>

                <div class="bclinks">
                    <?php if ($phoneRef !== '' && $phone !== ''): ?>
                        <a class="bclink" href="<?php echo htmlspecialchars($phoneRef, ENT_QUOTES, 'UTF-8'); ?>">
                            <i class="fa-solid fa-phone"></i>
                            <span><?php echo htmlspecialchars($phone, ENT_QUOTES, 'UTF-8'); ?><?php if ($phoneLabel !== ''): ?> (<?php echo htmlspecialchars($phoneLabel, ENT_QUOTES, 'UTF-8'); ?>)<?php endif; ?></span>
                        </a>
                    <?php endif; ?>

                    <?php if ($phone2Ref !== '' && $phone2 !== ''): ?>
                        <a class="bclink" href="<?php echo htmlspecialchars($phone2Ref, ENT_QUOTES, 'UTF-8'); ?>">
                            <i class="fa-solid fa-phone-volume"></i>
                            <span><?php echo htmlspecialchars($phone2, ENT_QUOTES, 'UTF-8'); ?><?php if ($phone2Label !== ''): ?> (<?php echo htmlspecialchars($phone2Label, ENT_QUOTES, 'UTF-8'); ?>)<?php endif; ?></span>
                        </a>
                    <?php endif; ?>

                    <?php if ($mailRef !== '' && $email !== ''): ?>
                        <a class="bclink" href="<?php echo htmlspecialchars($mailRef, ENT_QUOTES, 'UTF-8'); ?>">
                            <i class="fa-solid fa-envelope"></i>
                            <span><?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?></span>
                        </a>
                    <?php endif; ?>

                    <?php if ($domainLabel !== '' && $domainRef !== '#'): ?>
                        <a class="bclink" href="<?php echo htmlspecialchars($domainRef, ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener">
                            <i class="fa-solid fa-globe"></i>
                            <span><?php echo htmlspecialchars($domainLabel, ENT_QUOTES, 'UTF-8'); ?></span>
                        </a>
                    <?php endif; ?>
                </div>

                <div class="bcactions">
                    <?php if ($whatsappRef !== ''): ?>
                        <a href="<?php echo htmlspecialchars($whatsappRef, ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener" class="bcbtn bcbtnaccent">
                            <i class="fa-brands fa-whatsapp"></i> WhatsApp
                        </a>
                    <?php endif; ?>
                    <a href="business-card.php?vcard=1" class="bcbtn bcbtnghost">
                        <i class="fa-solid fa-address-card"></i> Save Contact
                    </a>
                </div>

                <?php if (!empty($socials)): ?>
                    <div class="bcsocial" aria-label="Social links">
                        <?php foreach ($socials as $social): ?>
                            <a class="bc-social--<?php echo htmlspecialchars((string) ($social['key'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>" href="<?php echo htmlspecialchars((string) $social['href'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener" aria-label="<?php echo htmlspecialchars((string) $social['label'], ENT_QUOTES, 'UTF-8'); ?>">
                                <i class="<?php echo htmlspecialchars((string) $social['icon'], ENT_QUOTES, 'UTF-8'); ?>"></i>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="bcnotes">
                    <?php if ($licenseNumber !== ''): ?><span><?php echo htmlspecialchars($licenseNumber, ENT_QUOTES, 'UTF-8'); ?></span><?php endif; ?>
                    <?php if ($license !== ''): ?><span><?php echo htmlspecialchars($license, ENT_QUOTES, 'UTF-8'); ?></span><?php endif; ?>
                    <?php if ($bilingual !== ''): ?><span><?php echo htmlspecialchars($bilingual, ENT_QUOTES, 'UTF-8'); ?></span><?php endif; ?>
                </div>
            </aside>

            <main class="bccontent">
                <header class="bccontenthead">
                    <h2><?php echo htmlspecialchars($company, ENT_QUOTES, 'UTF-8'); ?></h2>
                    <?php if ($about !== ''): ?>
                        <p><?php echo htmlspecialchars($about, ENT_QUOTES, 'UTF-8'); ?></p>
                    <?php endif; ?>
                </header>

                <section class="bcinfogrid">
                    <?php if ($address !== ''): ?>
                    <article class="bcinfo">
                        <small>Location</small>
                        <span><?php echo htmlspecialchars($address, ENT_QUOTES, 'UTF-8'); ?></span>
                    </article>
                    <?php endif; ?>

                    <?php if ($schedule !== ''): ?>
                    <article class="bcinfo">
                        <small>Schedule</small>
                        <span><?php echo htmlspecialchars($schedule, ENT_QUOTES, 'UTF-8'); ?></span>
                    </article>
                    <?php endif; ?>

                    <?php if ($coverage !== ''): ?>
                    <article class="bcinfo">
                        <small>Coverage</small>
                        <span><?php echo htmlspecialchars($coverage, ENT_QUOTES, 'UTF-8'); ?></span>
                    </article>
                    <?php endif; ?>

                    <?php if ($domainLabel !== '' && $domainRef !== '#'): ?>
                    <article class="bcinfo">
                        <small>Website</small>
                        <a href="<?php echo htmlspecialchars($domainRef, ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener"><?php echo htmlspecialchars($domainLabel, ENT_QUOTES, 'UTF-8'); ?></a>
                    </article>
                    <?php endif; ?>
                </section>

                <?php if (is_file(__DIR__ . '/' . $showroomVideo)): ?>
                <figure class="bcshowroom">
                    <video autoplay muted loop playsinline controls preload="metadata" poster="<?php echo htmlspecialchars($showroomImage, ENT_QUOTES, 'UTF-8'); ?>" aria-label="Quick Wash Detailing at work">
                        <source src="<?php echo htmlspecialchars($showroomVideo, ENT_QUOTES, 'UTF-8'); ?>" type="video/mp4">
                    </video>
                    <figcaption>Mobile detailing in New Rochelle, NY</figcaption>
                </figure>
                <?php endif; ?>

                <?php if (!empty($services)): ?>
                <section class="bcservices">
                    <h3>Our Services</h3>
                    <div class="bcservicegrid">
                        <?php foreach (array_slice($services, 0, 9) as $service): ?>
                            <div class="bcservicepill"><?php echo htmlspecialchars((string) $service, ENT_QUOTES, 'UTF-8'); ?></div>
                        <?php endforeach; ?>
                    </div>
                </section>
                <?php endif; ?>

                <?php if ($googleMap !== ''): ?>
                <section class="bcmap">
                    <?php echo $googleMap; ?>
                </section>
                <?php endif; ?>
            </main>
        </div>
    </div>
</body>
</html>
