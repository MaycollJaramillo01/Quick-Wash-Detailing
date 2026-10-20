<?php
@session_start();

/*
  =========================================================
  QUICK WASH DETAILING — text.php
  Todo el contenido del sitio sale de este archivo.
  Los campos pendientes de confirmar con el cliente están
  marcados con comentarios "TODO CONFIRMAR".
  =========================================================
*/

/*=========================
   PAGE NAME (Routing simple)
   =========================*/
$full_name  = $_SERVER['PHP_SELF'] ?? '';
$name_array = explode('/', $full_name);
$count      = count($name_array);
$page_name  = $name_array[$count - 1] ?? '';

if      ($page_name == 'index.php')        { $namepage = "Home"; }
elseif ($page_name == 'about.php')        { $namepage = "About"; }
elseif ($page_name == 'services.php')     { $namepage = "Services"; }
elseif ($page_name == 'testimonials.php') { $namepage = "Reviews"; }
elseif ($page_name == 'reviews.php')      { $namepage = "Reviews"; }
elseif ($page_name == 'projects.php')     { $namepage = "Gallery"; }
elseif ($page_name == 'thank-you.php')    { $namepage = "Thank You"; }
elseif ($page_name == '404.php')          { $namepage = "Not Found"; }
elseif ($page_name == 'contact.php')      { $namepage = "Contact"; }
else                                      { $namepage = ucfirst(str_replace('.php', '', $page_name)); }

/*=========================
   INFO GENERAL - QUICK WASH DETAILING
   =========================*/
$Company      = "Quick Wash Detailing";
$CustomerName = "Quick Wash Detailing";

function detectBaseURL() {
  $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
  if (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https') $scheme = 'https';
  $host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
  $script = $_SERVER['SCRIPT_NAME'] ?? '';
  $dir    = rtrim(str_replace('\\', '/', dirname($script)), '/.');
  $path   = $dir ? $dir . '/' : '/';
  return $scheme . '://' . $host . $path;
}

$BaseURL   = rtrim(detectBaseURL(), '/') . '/';
$Domain    = $BaseURL;
$MAVEN     = "go-maven.com";
$Address   = "New Rochelle, NY 10805";
$PhoneName = "";
$Phone2Name = "";

$Phone     = "+1 (509) 205-4653";
$Phone2    = "";

function telRef($p) {
  $clean = str_replace(str_split('()-/\\:?"<>|., '), '', $p);
  return "tel:" . $clean;
}
$PhoneRef  = telRef($Phone);
$PhoneRef2 = $Phone2 !== '' ? telRef($Phone2) : '';

function slugify($text) {
  $text = strtolower(trim($text));
  $text = preg_replace('/[^a-z0-9]+/i', '-', $text);
  return trim($text, '-') ?: 'service';
}

$whatsapp_num = preg_replace('/\D+/', '', $Phone);
if (strpos($whatsapp_num, '1') !== 0) { $whatsapp_num = '1' . $whatsapp_num; }
$whatsapp = "https://api.whatsapp.com/send?phone=$whatsapp_num&text=Hi%20Quick%20Wash%20Detailing!%20I%20would%20like%20a%20quote%20for%20a%20mobile%20car%20detail.";

/* Correo que recibe los formularios (cotizaciones y reseñas). */
$Mail    = "arlesalvarez4783@gmail.com";
$MailRef = "mailto:" . $Mail;

/*=========================
   GENERAL MESSAGES
   =========================*/
$Services       = "Mobile full detailing and interior detailing for sedans, SUVs, trucks, and pickups";
$Estimates      = "Free Quotes";
$Payment        = ""; /* TODO CONFIRMAR: métodos de pago con el cliente */
$Experience     = "Mobile Service";
$Schedule       = "By appointment. Call or WhatsApp to book your detail."; /* TODO CONFIRMAR horario real */
$Coverage       = "Mobile service in New Rochelle, NY and nearby Westchester County communities. We come to your home or office.";
$LicenseNote    = "We Come to You";
$LicenseNumber  = "";
$BilingualNote  = "English & Spanish Spoken"; /* TODO CONFIRMAR */
$TypeOfService  = "Mobile Interior & Exterior Car Detailing";

/*=========================
   BRAND COLORS (tomados por píxel del logo oficial)
   Navy #113A5A y cian #0CC0DF.
   =========================*/
$BrandColors = [
  'primary'       => '#113A5A',
  'primary_rgb'   => '17, 58, 90',
  'secondary'     => '#0A2236',
  'secondary_rgb' => '10, 34, 54',
  'accent'        => '#0CC0DF',
  'accent_rgb'    => '12, 192, 223',
  'neutral'       => '#F1F7FA',
  'white'         => '#FFFFFF'
];

/*=========================
   SERVICE AREAS
   (Base en New Rochelle 10805 + comunidades cercanas de Westchester.
   TODO CONFIRMAR lista final de ciudades con el cliente.)
   =========================*/
$Areas = [
  "New Rochelle, NY",
  "Larchmont, NY",
  "Pelham, NY",
  "Pelham Manor, NY",
  "Mount Vernon, NY",
  "Mamaroneck, NY",
  "Eastchester, NY",
  "Tuckahoe, NY",
  "Bronxville, NY",
  "Scarsdale, NY",
  "White Plains, NY",
  "Yonkers, NY",
  "Rye, NY",
  "Harrison, NY",
  "And nearby communities"
];

/*=========================
   MAPA Y REDES SOCIALES
   =========================*/
$GoogleMap = '<iframe src="https://maps.google.com/maps?q=New%20Rochelle%2C%20NY%2010805&t=&z=13&ie=UTF8&iwloc=&output=embed" width="100%" height="450" style="border:0;" allowfullscreen loading="lazy" title="Quick Wash Detailing service area map"></iframe>';
/* TODO CONFIRMAR: redes sociales del cliente (vacías = no se muestran) */
$facebook  = "";
$instagram = "";
$google    = "";
$tiktok    = "";
$messenger = "";

$GoogleReviews = $google;

/* La empresa es nueva: no se publican reseñas inventadas.
   Agregar aquí reseñas reales aprobadas por el cliente con el mismo formato:
   ['name' => '', 'city' => '', 'stars' => 5, 'text' => '', 'source' => 'Google Review', 'date' => '', 'url' => ''] */
$DirectoryReviewItems  = [];
$GoogleReviewItems     = $DirectoryReviewItems;
$DetailedReviewItems   = $DirectoryReviewItems;
$ReviewSourceSummaries = [];

/*=========================
   SEO & BRANDING SLOGANS
   =========================*/
$Phrase = [
  "Mobile Car Detailing in New Rochelle, NY",
  "We Come to You",
  "Full Detail $160 - $200",
  "Sedans, SUVs, Trucks & Pickups"
];

/*=========================
   PRICING (precios enviados por el cliente)
   TODO CONFIRMAR: el cliente mencionó "interior (150)" y luego
   "Solo Interior: 170 - 250 según la distancia". Se usa el último.
   =========================*/
$PriceFullDetail = '$160 – $200';
$PriceInterior   = '$170 – $250';

/*=========================
   HOME / ABOUT
   =========================*/
$Home = [
  "Quick Wash Detailing is a mobile car detailing service based in New Rochelle, NY. We bring professional interior and exterior detailing to your driveway, home, or office for sedans, SUVs, trucks, and pickups.",
  "Full details run $160 to $200 depending on the size of your vehicle, and interior-only details run $170 to $250 depending on distance. Every vehicle is quoted and charged individually, with no surprises."
];

$About = [
  "Quick Wash Detailing is a new, locally owned mobile detailing business in New Rochelle, NY, built on hard work, attention to detail, and showing up on time.",
  "We bring the equipment and supplies to you, so your car gets a deep, hands-on clean without you losing a morning at the car wash."
];

$Mission = "To give every customer a cleaner, fresher vehicle with honest prices, careful hands-on work, and the convenience of service at their door.";
$Vision  = "To become the most trusted mobile detailing service in New Rochelle and Westchester County, one spotless vehicle at a time.";

/*=========================
   SERVICES SECTION
   =========================*/
$SN = $SD = $ExSD = [];

$SN[1] = "Full Detail – Sedans";
$SD[1] = "Complete interior and exterior detail for sedans and compact cars, done right at your home or office. Starting at $160.";

$SN[2] = "Full Detail – SUVs";
$SD[2] = "Interior and exterior detail sized for SUVs and crossovers, including the cargo area and third row. Priced within $160 – $200 by size.";

$SN[3] = "Full Detail – Trucks & Pickups";
$SD[3] = "Full detail for trucks and pickups, from the cab interior to an exterior hand wash. Up to $200 depending on size.";

$SN[4] = "Interior Detail";
$SD[4] = "Interior-only deep clean: vacuum, seats, carpets, mats, dashboard, console, door panels, and trunk. $170 – $250 depending on distance.";

$OtherServices = [];

$ServicesByCategory = [
  [
    'label' => 'Full Detail',
    'summary_slug' => 'full-detail-sedans',
    'service_slugs' => [
      'full-detail-sedans',
      'full-detail-suvs',
      'full-detail-trucks-pickups'
    ]
  ],
  [
    'label' => 'Interior Only',
    'summary_slug' => 'interior-detail',
    'service_slugs' => [
      'interior-detail'
    ]
  ]
];

$Badges = [
  $Estimates,
  $Experience,
  $Coverage,
  $LicenseNote,
  $BilingualNote
];

$ExAbout = mb_substr($About[0], 0, 145) . '...';
$ExHome  = mb_substr($Home[0],  0, 155) . '...';
for ($i = 1; $i <= count($SN); $i++) {
  if (isset($SD[$i])) $ExSD[$i] = mb_substr($SD[$i], 0, 120) . '...';
}

$ServicesList = [];
for ($i = 1; $i <= count($SN); $i++) {
  if (empty($SN[$i])) continue;
  $slug = slugify($SN[$i]);
  $ServicesList[$slug] = [
    'id'          => $i,
    'name'        => $SN[$i],
    'description' => $SD[$i] ?? '',
    'excerpt'     => $ExSD[$i] ?? '',
    'slug'        => $slug,
    'file'        => 'services.php',
    'url'         => 'services.php#' . $slug
  ];
}

$OtherServicesLandingSlugs = [];

$PrimaryServiceSlugs = [
  'full-detail-sedans',
  'full-detail-suvs',
  'full-detail-trucks-pickups',
  'interior-detail'
];
$AllowedServiceSlugs = array_merge($PrimaryServiceSlugs, $OtherServicesLandingSlugs);
foreach (array_keys($ServicesList) as $serviceSlug) {
  if (!in_array($serviceSlug, $AllowedServiceSlugs, true)) unset($ServicesList[$serviceSlug]);
}

$serviceCategoryMap = [];
foreach ($ServicesByCategory as $category) {
  $categoryLabel = trim((string) ($category['label'] ?? 'General'));
  $categorySlug = trim((string) ($category['summary_slug'] ?? ''));
  if ($categorySlug === '') $categorySlug = slugify($categoryLabel);
  $allSlugs = [];
  if (!empty($category['summary_slug'])) $allSlugs[] = trim((string) $category['summary_slug']);
  foreach (($category['service_slugs'] ?? []) as $serviceSlug) {
    $serviceSlug = trim((string) $serviceSlug);
    if ($serviceSlug !== '') $allSlugs[] = $serviceSlug;
  }
  foreach (array_unique($allSlugs) as $serviceSlug) {
    $serviceCategoryMap[$serviceSlug] = [
      'category_slug' => $categorySlug,
      'category_label' => $categoryLabel
    ];
  }
}

foreach ($ServicesList as $serviceSlug => &$serviceData) {
  if (isset($serviceCategoryMap[$serviceSlug])) {
    $serviceData['category_slug'] = $serviceCategoryMap[$serviceSlug]['category_slug'];
    $serviceData['category_label'] = $serviceCategoryMap[$serviceSlug]['category_label'];
  } else {
    $serviceData['category_slug'] = 'general';
    $serviceData['category_label'] = 'General';
  }
}
unset($serviceData);

$ServicesDisplayList = array_values($ServicesList);
usort($ServicesDisplayList, static function ($a, $b) {
  return (int) ($a['id'] ?? 0) <=> (int) ($b['id'] ?? 0);
});

/* TODO CONFIRMAR: lo incluido en cada paquete (lista estándar de detailing). */
$ServiceDetails = [
  'full-detail-sedans' => [
    'kicker' => 'Sedans · From $160',
    'headline' => 'A full detail for your sedan, at your door',
    'paragraphs' => [
      'We detail sedans and compact cars inside and out, right where they are parked: your driveway, your street, or your office lot.',
      'Pricing starts at $160 and depends on the size and condition of the vehicle. You get your quote before we start.'
    ],
    'bullets' => ['Exterior hand wash and dry', 'Wheels, tires, and windows', 'Full interior vacuum and wipe-down', 'Seats, carpets, and mats cleaned']
  ],
  'full-detail-suvs' => [
    'kicker' => 'SUVs · $160 – $200',
    'headline' => 'More room, same attention to detail',
    'paragraphs' => [
      'SUVs and crossovers get a complete interior and exterior detail, including the third row and the cargo area where everyday mess builds up.',
      'Price ranges from $160 to $200 depending on the size of your SUV.'
    ],
    'bullets' => ['Cargo area and third row', 'Exterior hand wash and dry', 'Seats, carpets, and mats cleaned', 'Dashboard, console, and door panels']
  ],
  'full-detail-trucks-pickups' => [
    'kicker' => 'Trucks & Pickups · Up to $200',
    'headline' => 'Work trucks and pickups, cleaned top to bottom',
    'paragraphs' => [
      'From mud on the floor mats to dust on the dash, we clean truck and pickup cabs inside and out with the same care we give every vehicle.',
      'Full details for trucks and pickups go up to $200 depending on size.'
    ],
    'bullets' => ['Cab interior deep clean', 'Floor liners and mats', 'Exterior hand wash and dry', 'Wheels, tires, and windows']
  ],
  'interior-detail' => [
    'kicker' => 'Interior Only · $170 – $250',
    'headline' => 'A deep interior clean you can feel',
    'paragraphs' => [
      'Our interior detail focuses on everything you touch and breathe inside the car: seats, carpets, mats, dashboard, console, cup holders, door panels, and the trunk.',
      'Interior-only details run $170 to $250 depending on distance, and each vehicle is charged individually.'
    ],
    'bullets' => ['Full vacuum, trunk included', 'Seats and carpets cleaned', 'Dashboard, console, and vents', 'Interior windows and door panels']
  ]
];

/*=========================
  COPY / UI TEXT
  =========================*/
$WhyChoose = [
  'eyebrow' => 'Mobile Detailing You Can Trust',
  'title_pre' => 'Why Choose',
  'intro' => 'Quick Wash Detailing brings a careful, hands-on detail to your door with clear prices and free quotes.',
  'cards' => [
    ['title' => 'Free Quotes', 'text' => 'Tell us your vehicle and location and get a free quote before we start.'],
    ['title' => 'Bilingual Support', 'text' => $BilingualNote . '. Get clear answers in the language you prefer.'],
    ['title' => 'Ready to Book?', 'text' => 'Call or WhatsApp Quick Wash Detailing to schedule your detail.', 'btn' => ['href' => $PhoneRef, 'text' => 'Call Now']],
  ],
];

function paymentList($txt) {
  return array_values(array_filter(array_map('trim', explode(',', $txt))));
}
$PaymentMethods = paymentList($Payment);

$ExperienceYears = 1;

$NavCopy = [
  'home' => 'Home',
  'about' => 'About',
  'services' => 'Services',
  'projects' => 'Gallery',
  'reviews' => 'Reviews',
  'contact' => 'Contact',
  'other_services' => 'More Services',
  'cta' => 'Call Now',
  'cta_mobile' => 'Call Now',
  'explore_service' => 'Explore Service',
  'view_services' => 'View Services',
  'contact_today' => 'Get a Free Quote',
  'leave_review' => 'Leave a Review',
  'read_reviews' => 'Read Reviews'
];

$LanguageCopy = [
  'label' => 'Language',
  'english' => 'English',
  'spanish' => 'Español',
  'english_short' => 'EN',
  'spanish_short' => 'ES'
];

$HeaderCopy = [
  'menu_close' => 'Close Menu',
  'menu_toggle' => 'Toggle Menu',
  'social_titles' => [
    'facebook' => 'Facebook',
    'messenger' => 'Messenger',
    'google' => 'Google Reviews',
    'instagram' => 'Instagram',
    'tiktok' => 'TikTok',
    'whatsapp' => 'WhatsApp'
  ]
];

$FooterCopy = [
  'desc' => 'Mobile car detailing in New Rochelle, NY and nearby Westchester County. Full details and interior details for sedans, SUVs, trucks, and pickups. We come to you.',
  'titles' => ['company' => 'Company', 'services' => 'Services', 'contact' => 'Contact Us'],
  'labels' => ['location' => 'Based in', 'phone' => 'Phone', 'hours' => 'Hours'],
  'copyright_suffix' => 'All Rights Reserved.'
];

$PageHeroCopy = [
  'default' => ['title' => 'Mobile Detailing Services', 'desc' => 'Full details and interior details for sedans, SUVs, trucks, and pickups, done at your door.', 'bg' => 'assets/img/hero/hero1.jpg'],
  'projects' => ['title' => 'Our Work', 'desc' => 'Real cars, real results. Photos and videos from recent Quick Wash Detailing jobs.', 'bg' => 'assets/img/hero/hero2.jpg'],
  'about' => ['title' => 'About ' . $Company, 'desc' => 'A new, locally owned mobile detailing business in New Rochelle, NY.', 'bg' => 'assets/img/hero/hero3.jpg'],
  'contact' => ['title' => 'Get a Free Quote', 'desc' => 'Tell us about your vehicle and where it is parked. We will reply with a quote and the next available time.', 'bg' => 'assets/img/hero/hero1.jpg'],
  'reviews' => ['title' => 'Customer Reviews', 'desc' => 'Had your car detailed by Quick Wash? Tell us how we did.', 'bg' => 'assets/img/hero/hero2.jpg'],
  'other' => ['title' => 'More Services', 'desc' => 'Ask us about anything your vehicle needs.', 'bg' => 'assets/img/hero/hero3.jpg']
];

$HomeHeroCopy = [
  'headline' => $Company,
  'title' => 'Mobile Car Detailing in New Rochelle, NY',
  'company_label' => 'Locally Owned · New Rochelle',
  'status_label' => 'Mobile Service',
  'slide_statuses' => [
    'We Come to You',
    'Full Detail ' . $PriceFullDetail,
    'Interior Detail ' . $PriceInterior
  ],
  'slide_descriptions' => [
    'Professional interior and exterior detailing at your home or office. Sedans, SUVs, trucks, and pickups.',
    'Full details from $160 for sedans up to $200 for trucks and pickups, priced by vehicle size.',
    'Interior-only deep cleans from $170 to $250 depending on distance. Each vehicle is quoted individually.'
  ],
  'sub' => 'Professional interior and exterior detailing at your home or office in New Rochelle and nearby Westchester County.',
  'cta_primary' => 'Get a Free Quote',
  'cta_secondary' => 'WhatsApp Us',
  'cta_primary_href' => 'contact.php',
  'cta_secondary_href' => $whatsapp,
  'prev_label' => 'Previous slide',
  'next_label' => 'Next slide',
  'slide_alt_prefix' => 'Quick Wash Detailing',
  'thumb_alt_prefix' => 'Detailing Thumbnail'
];

$HomeAboutCopy = [
  'eyebrow' => 'Mobile Detailing in New Rochelle',
  'title' => 'A Cleaner Car,',
  'title_strong' => 'Without Leaving Home.',
  'description' => 'Quick Wash Detailing brings professional interior and exterior detailing to your driveway, street, or office parking lot.',
  'caption' => 'New Rochelle · New York',
  'content_label' => 'Sedans · SUVs · Trucks & Pickups',
  'features_label' => 'Our detailing services',
  'images' => [
    'back' => ['src' => 'assets/img/about.jpg', 'alt' => 'Quick Wash Detailing mobile service at a customer driveway'],
    'front' => ['src' => 'assets/img/about.jpg', 'alt' => 'Pickup truck washed by Quick Wash Detailing in New Rochelle']
  ],
  'video' => [
    'src' => 'assets/video/video-1.mp4',
    'poster' => 'assets/video/video-1.jpg',
    'label' => 'Video of Quick Wash Detailing washing an SUV'
  ],
  'features' => [
    ['icon' => 'fa-truck-fast', 'title' => 'We Come to You', 'text' => 'Home, office, or driveway in New Rochelle and nearby.'],
    ['icon' => 'fa-car-side', 'title' => 'Full Detail', 'text' => 'Interior and exterior, ' . $PriceFullDetail . ' by vehicle size.'],
    ['icon' => 'fa-spray-can-sparkles', 'title' => 'Interior Detail', 'text' => 'Seats, carpets, mats, and trunk, ' . $PriceInterior . '.'],
    ['icon' => 'fa-comments', 'title' => 'Bilingual Support', 'text' => $BilingualNote]
  ],
  'proof' => [
    ['value' => 'Mobile', 'label' => 'We bring everything to your location'],
    ['value' => '$160+', 'label' => 'Full detail, priced by vehicle size'],
    ['value' => 'Free', 'label' => 'Quotes before every job']
  ],
  'cta' => 'Learn About Us'
];

$AboutHeroCopy = [
  'eyebrow' => 'About ' . $Company,
  'title' => 'Mobile detailing based in New Rochelle, NY',
  'desc' => $About[0],
  'cta_primary' => 'Our Story',
  'cta_primary_href' => '#story',
  'cta_secondary_prefix' => 'Call',
  'meta' => [$Experience, $Estimates, $LicenseNote, $BilingualNote],
  'list' => [
    ['label' => 'Service area', 'value' => $Coverage],
    ['label' => 'Schedule', 'value' => $Schedule],
    ['label' => 'Core services', 'value' => $TypeOfService],
    ['label' => 'Based in', 'value' => $Address]
  ]
];

$AboutStoryCopy = [
  'eyebrow' => 'Our Story',
  'title' => 'Built on hard work and clean cars',
  'points' => [
    ['title' => 'Free quotes', 'text' => $Estimates . ' on every vehicle, with clear pricing before any work starts'],
    ['title' => 'Bilingual attention', 'text' => $BilingualNote],
    ['title' => 'Mobile service', 'text' => 'We come to you in ' . $Address . ' and nearby']
  ],
  'actions' => ['primary_text' => 'Request a quote', 'primary_href' => 'contact.php', 'secondary_prefix' => 'Call'],
  'stats' => ['years_label' => 'Mobile service', 'services_label' => 'Detail packages', 'areas_label' => 'Service areas', 'areas_separator' => ', ', 'areas_preview_count' => 5]
];

$AboutCredentialsCopy = [
  'eyebrow' => 'Why work with us',
  'title' => 'Careful work on every vehicle',
  'intro' => 'Every job starts with a free quote, honest pricing, and respect for your time and your car.',
  'list' => [
    ['label' => 'Contact', 'value' => $Phone],
    ['label' => 'Hours', 'value' => $Schedule],
    ['label' => 'Core services', 'value' => $TypeOfService],
    ['label' => 'Coverage', 'value' => $Coverage],
    ['text' => $Estimates . ' | ' . $BilingualNote]
  ],
  'cta' => ['title' => 'Ready for a cleaner car?', 'desc' => 'Call or WhatsApp to book a full detail or interior detail.', 'primary_text' => 'Call Now', 'primary_href' => $PhoneRef, 'secondary_prefix' => 'Call']
];

$AboutServicesSummaryCopy = ['eyebrow' => 'Services', 'title' => 'How we help', 'desc' => $TypeOfService . ' in New Rochelle and nearby Westchester County.', 'link_label' => 'Learn more'];
$ServicesListCopy = ['eyebrow' => 'Packages', 'title' => 'Detailing services we provide', 'desc' => $Services, 'link_label' => 'Learn more'];
$BrandsCopy = ['tagline' => 'Detailing Cars Across New Rochelle & Westchester'];

$HomeServicesCopy = [
  'eyebrow' => 'Detail Packages',
  'title' => 'Detailing for Every',
  'title_strong' => 'Size of Vehicle',
  'desc' => 'Full details for sedans, SUVs, trucks, and pickups, plus interior-only deep cleans. Each vehicle is quoted and charged individually.',
  'link_label' => 'Get a Quote',
  'browse_label' => 'Browse Packages',
  'more_title' => 'Not Sure Which Package?',
  'more_title_strong' => 'Ask Us',
  'more_desc' => 'Send us your vehicle type and location and we will recommend the right detail and give you a free quote.',
  'more_button' => 'Get a Free Quote',
  'more_href' => 'contact.php',
  'stats' => [
    ['value' => count($ServicesList), 'label' => 'Detail Packages'],
    ['value' => $PriceFullDetail, 'label' => 'Full Detail'],
    ['value' => $PriceInterior, 'label' => 'Interior Detail'],
    ['value' => 'Mobile', 'label' => 'We Come to You']
  ],
  'panel' => [
    'title' => 'Pricing at a Glance',
    'desc' => 'Final price depends on vehicle size, condition, and distance. Every vehicle is charged individually.',
    'items' => [
      ['icon' => 'fa-car-side', 'title' => 'Sedans · from $160', 'text' => 'Full interior and exterior detail.'],
      ['icon' => 'fa-car', 'title' => 'SUVs · $160 – $200', 'text' => 'Full detail, priced by size.'],
      ['icon' => 'fa-truck-pickup', 'title' => 'Trucks & Pickups · up to $200', 'text' => 'Full detail, cab and exterior.'],
      ['icon' => 'fa-spray-can-sparkles', 'title' => 'Interior Only · ' . $PriceInterior, 'text' => 'Depends on distance.']
    ]
  ]
];

$HomeMaintenanceCopy = [
  'id' => 'pricing',
  'tagline' => 'Simple, Honest Pricing',
  'title' => 'Detail Packages',
  'title_strong' => '& Prices',
  'desc' => 'Prices depend on the size of your vehicle and, for interior-only details, the distance to your location. Each service is charged individually.',
  'cards' => [
    ['icon' => 'fa-car-side', 'title' => 'Sedans', 'price' => 'From $160', 'text' => 'Full interior and exterior detail for sedans and compact cars.', 'action' => 'See Details'],
    ['icon' => 'fa-car', 'title' => 'SUVs', 'price' => '$160 – $200', 'text' => 'Full detail including the cargo area and third row.', 'action' => 'See Details'],
    ['icon' => 'fa-truck-pickup', 'title' => 'Trucks & Pickups', 'price' => 'Up to $200', 'text' => 'Full detail for the cab interior and the exterior.', 'action' => 'See Details'],
    ['icon' => 'fa-spray-can-sparkles', 'title' => 'Interior Only', 'price' => $PriceInterior, 'text' => 'Deep interior clean. Price depends on distance.', 'action' => 'See Details']
  ],
  'panel_title' => 'Every Detail Includes',
  'panel_cta' => 'Get a Free Quote',
  'foundation' => [
    ['icon' => 'fa-truck-fast', 'title' => 'We Come to You', 'subtitle' => 'Home, office, or driveway'],
    ['icon' => 'fa-file-invoice-dollar', 'title' => 'Free Quote', 'subtitle' => 'Know the price before we start'],
    ['icon' => 'fa-language', 'title' => 'Bilingual', 'subtitle' => 'English and Spanish']
  ]
];

$WhyCopy = [
  'badge' => 'Mobile Detailing Done Right',
  'title_prefix' => 'Why Customers Choose',
  'description' => 'We built Quick Wash Detailing around convenience, honest prices, and careful hands-on work on every vehicle.',
  'stats' => [
    ['value' => 'Mobile', 'label' => 'We Come to You'],
    ['value' => count($ServicesList), 'label' => 'Detail Packages'],
    ['value' => '100%', 'label' => 'Free Quotes']
  ],
  'service_area_label' => 'Coverage and Hours',
  'features' => [
    ['icon' => 'fa-truck-fast', 'title' => 'Convenience', 'text' => 'No lines, no waiting rooms. We detail your vehicle where it is parked.'],
    ['icon' => 'fa-file-invoice-dollar', 'title' => 'Clear Pricing', 'text' => 'Full details ' . $PriceFullDetail . ', interior details ' . $PriceInterior . '. You know the price first.'],
    ['icon' => 'fa-hand-sparkles', 'title' => 'Hands-On Care', 'text' => 'Seats, carpets, mats, cup holders, and trunk: every corner gets attention.'],
    ['icon' => 'fa-comments', 'title' => 'Clear Communication', 'text' => $BilingualNote . '. Book by phone, WhatsApp, or the website.']
  ],
  'cta_label' => 'Get a Free Quote'
];

$MissionCopy = [
  'eyebrow' => 'What Drives Us',
  'title' => 'Our mission and vision',
  'services_badge' => 'Detail Packages',
  'mission_title' => 'Our Mission',
  'vision_title' => 'Our Vision',
  'mission_icon' => 'fa-hand-sparkles',
  'vision_icon' => 'fa-car-side',
  'mission_points' => [
    'Clear quotes before any work begins.',
    'Careful, hands-on cleaning inside and out.',
    'Showing up on time, ready to work.'
  ],
  'vision_points' => [
    'The go-to mobile detailer in New Rochelle and Westchester.',
    'Customers who book again and refer their friends.',
    'Growing one spotless vehicle at a time.'
  ],
  'panel_title' => 'Our Commitments',
  'cta' => 'Book Your Detail'
];

$ProcessCopy = [
  'title' => 'How It Works',
  'title_strong' => 'From Quote to Clean',
  'desc' => 'Booking a mobile detail with Quick Wash is simple.',
  'steps' => [
    ['icon' => 'fa-phone', 'title' => 'Contact Us', 'text' => 'Call, WhatsApp, or send the form with your vehicle type and location.'],
    ['icon' => 'fa-file-invoice-dollar', 'title' => 'Free Quote', 'text' => 'We confirm the package and give you a clear price.'],
    ['icon' => 'fa-calendar-check', 'title' => 'Schedule', 'text' => 'Pick a day and time. We come to your home or office.'],
    ['icon' => 'fa-check-circle', 'title' => 'Enjoy', 'text' => 'Your vehicle is detailed on site and ready to drive.']
  ]
];

$FaqCopy = [
  'title' => 'Frequently Asked Questions',
  'items' => [
    ['q' => 'How much does a detail cost?', 'a' => 'Full details run ' . $PriceFullDetail . ' depending on vehicle size (sedan, SUV, truck, or pickup). Interior-only details run ' . $PriceInterior . ' depending on distance. Each vehicle is charged individually.'],
    ['q' => 'Do you come to my home?', 'a' => 'Yes. Quick Wash Detailing is a mobile service. We come to your home, office, or wherever your vehicle is parked.'],
    ['q' => 'What areas do you cover?', 'a' => $Coverage],
    ['q' => 'Do you speak Spanish?', 'a' => 'Yes. ' . $BilingualNote . '.'],
    ['q' => 'How do I book?', 'a' => 'Call or WhatsApp ' . $Phone . ', or send the quote form on this website and we will get back to you.']
  ]
];

$AreasCopy = [
  'eyebrow' => 'Service Area',
  'title' => 'Serving',
  'title_strong' => 'New Rochelle & Westchester',
  'subtitle' => 'Based in New Rochelle, NY 10805. We travel to nearby communities. Interior-only pricing depends on distance.',
  'cta_label' => 'Request Service in Your Area',
  'map_overlay' => 'Mobile Service Area',
  'zones_title' => 'Areas We Serve',
  'signal' => ['value' => 'Mobile', 'label' => 'We Come to You'],
  'license_pills' => ['Free Quotes', 'We Come to You', 'English & Spanish', 'Sedans · SUVs · Trucks']
];

$CtaCopy = [
  'badge' => 'Mobile Car Detailing',
  'title' => 'Ready for a',
  'title_strong' => 'Cleaner Car?',
  'paragraph' => $Company . ' brings full details and interior details to your door in New Rochelle and nearby Westchester County.',
  'features' => ['Free Quotes', 'We Come to You', 'Bilingual Team'],
  'button' => 'Get a Free Quote',
  'card_title' => 'Talk With Quick Wash',
  'card_subtitle' => 'Call or WhatsApp to book your detail',
  'row_call_label' => 'Call or WhatsApp',
  'row_license_label' => 'Prices',
  'row_license_title' => 'Full Detail ' . $PriceFullDetail . ' · Interior ' . $PriceInterior,
  'row_service_label' => 'Service Area',
  'whatsapp_button' => 'WhatsApp Us',
  'book_button' => 'Request a Quote'
];

$ContactFormCopy = [
  'eyebrow' => 'Request a Quote',
  'title' => "Let's Get Your",
  'title_strong' => 'Car Shining Again.',
  'desc' => 'Send your vehicle type, the package you want, and where the car is parked. For faster help, call or WhatsApp.',
  'method_labels' => ['call' => 'Call or WhatsApp', 'hours' => 'Hours', 'email' => 'Email'],
  'form_labels' => ['name' => 'Name', 'phone' => 'Phone', 'email' => 'Email', 'service' => 'Service', 'vehicle' => 'Vehicle Type', 'message' => 'Details (address or area, best day/time)'],
  'vehicles' => ['Sedan', 'SUV', 'Truck / Pickup', 'Other'],
  'placeholders' => ['service' => 'Select a package', 'vehicle' => 'Select vehicle type', 'service_other' => 'Not sure / Other', 'message' => 'Example: 2019 Honda CR-V, New Rochelle 10805, Saturday morning...'],
  'submit' => 'Send Quote Request',
  'sending' => 'Sending...',
  'honeypot_label' => 'Leave this field empty',
  'errors' => [
    'required' => 'Please fill in your name, a valid phone number, and a valid email.',
    'send' => 'We could not send your request right now. Please call or WhatsApp us at ' . $Phone . '.'
  ]
];

$MapCopy = ['title' => 'Based in', 'title_strong' => 'New Rochelle, NY', 'labels' => ['location' => 'Service Base', 'call' => 'Call or WhatsApp', 'hours' => 'Hours']];

$TestimonialsCopy = ['title' => 'Customer Feedback', 'title_strong' => 'From Real Jobs', 'desc' => 'Feedback from Quick Wash Detailing customers.', 'button_label' => 'Leave a Review', 'button_href' => 'reviews.php', 'fallback_name' => 'Verified Client'];

$TrustedDirectoriesCopy = [
  'eyebrow' => 'Find Us Online',
  'title' => 'Quick Wash Detailing',
  'desc' => 'Follow our latest work.',
  'cards' => []
];

$ReviewsPageCopy = [
  'hero_title' => 'Customer Reviews',
  'hero_subtitle' => 'Had your vehicle detailed by Quick Wash? We would love to hear how we did.',
  'hero_image' => 'assets/img/hero/hero2.jpg',
  'list_eyebrow' => 'Reviews',
  'list_title' => 'What Our Customers Say',
  'list_desc' => 'Reviews from Quick Wash Detailing customers.',
  'list_cta' => 'Leave a Review',
  'empty' => 'We are a new business and our first reviews are on the way. Be one of the first to share your experience!'
];

$ReviewFormCopy = [
  'title' => 'Share Your Experience',
  'subtitle' => 'We value your feedback. Reviews are sent to our team and published after approval.',
  'success_title' => 'Thank You!',
  'success_message' => 'Your review was sent to our team. It will appear on the site once approved.',
  'error_title' => 'Error!',
  'captcha_error' => 'Incorrect security code. Please try again.',
  'send_error' => 'We could not send your review right now. Please try again later.',
  'required_error' => 'Please fill in your name, city, and review.',
  'labels' => ['name' => 'Your Name', 'city' => 'City / Location', 'rating' => 'Rating', 'rating_hint' => '(Select stars)', 'review' => 'Your Review', 'security' => 'Security Check', 'refresh' => 'Refresh', 'captcha' => 'Enter the code shown above'],
  'captcha_alt' => 'Captcha image',
  'placeholders' => ['name' => '', 'city' => 'e.g. New Rochelle, NY', 'review' => 'Tell us how we did...'],
  'submit' => 'Submit Review'
];

$GalleryHeroCopy = ['eyebrow' => 'Our Gallery', 'title' => 'Quick Wash Detailing in Action', 'desc' => 'Interior and exterior details from ' . $Company . ' in New Rochelle and nearby.', 'cta_text' => 'Call Now', 'cta_href' => $PhoneRef];

$ProjectsIntroCopy = [
  'label' => 'Our Work',
  'title_line1' => 'Real Cars.',
  'title_line2' => 'Real Results.',
  'outline_line1' => 'Detailed At',
  'outline_line2' => 'Your Door.',
  'desc' => 'Every photo and video here is from a real ' . $Company . ' job: SUVs, sedans, trucks, and pickups, cleaned inside and out where they were parked.',
  'cta_primary' => 'View Gallery',
  'cta_secondary' => 'Get a Free Quote',
  'stats' => [
    ['value' => 'Mobile', 'label' => 'We Come to You'],
    ['value' => count($ServicesList), 'label' => 'Detail Packages'],
    ['value' => count($Areas) - 1 . '+', 'label' => 'Areas Served']
  ]
];

$ProjectsBeforeAfterCopy = ['eyebrow' => 'Results', 'title' => 'Before & After', 'desc' => 'Drag the slider to see the difference a Quick Wash detail makes.', 'before_label' => 'Before', 'after_label' => 'After'];
$ProjectsStatsCopy = ['items' => [
  ['icon' => 'fa-truck-fast', 'value' => 'Mobile', 'label' => 'We Come to You'],
  ['icon' => 'fa-car-side', 'value' => count($ServicesList), 'label' => 'Detail Packages'],
  ['icon' => 'fa-map-location-dot', 'value' => count($Areas) - 1 . '+', 'label' => 'Areas Served'],
  ['icon' => 'fa-file-invoice-dollar', 'value' => '100%', 'label' => 'Free Quotes']
]];

$ProjectsGalleryCopy = ['eyebrow' => 'Gallery', 'title' => 'Recent Details', 'title_strong' => 'Inside & Out', 'images_label' => 'Photos', 'videos_label' => 'Videos', 'empty' => 'Photos coming soon.', 'image_title' => 'Quick Wash Detailing job', 'video_title' => 'Quick Wash Detailing video'];
$ServiceHeroCopy = ['badge' => 'Mobile Detailing', 'cta_primary' => 'Call Now', 'cta_secondary' => 'Explore Service'];
$ServiceIntroCopy = [
  'eyebrow' => 'Our Method',
  'title' => 'How We Deliver',
  'title_strong' => 'Every Detail',
  'desc' => 'We keep it simple so you know what to expect from the first message to the final wipe-down.',
  'steps' => [
    ['icon' => 'fa-comments', 'title' => 'Contact', 'text' => 'We confirm your vehicle, the package, and your location.'],
    ['icon' => 'fa-file-invoice-dollar', 'title' => 'Quote', 'text' => 'You get a free quote with clear pricing.'],
    ['icon' => 'fa-hand-sparkles', 'title' => 'Detail', 'text' => 'We detail your vehicle on site, inside and out.']
  ]
];

$ServiceDetailsCopy = ['badge_title' => 'Quick Wash Promise', 'badge_subtitle' => 'Clean, On Time, Fair Price', 'title_prefix' => 'Professional', 'button' => 'Call Now'];
$ServiceFaqCopy = [
  'eyebrow' => 'Common Questions',
  'title' => 'Info About Our',
  'title_strong' => 'Mobile Detailing',
  'items' => [
    ['icon' => 'fa-hourglass-half', 'question' => 'How soon can you come?', 'answer' => 'It depends on your location and the schedule. Call or WhatsApp with your address for the next available time.'],
    ['icon' => 'fa-file-invoice-dollar', 'question' => 'Are quotes free?', 'answer' => 'Yes. ' . $Company . ' gives free quotes on every vehicle.'],
    ['icon' => 'fa-language', 'question' => 'Do you speak Spanish?', 'answer' => $BilingualNote . '.'],
    ['icon' => 'fa-map', 'question' => 'What areas do you serve?', 'answer' => $Coverage]
  ],
  'footer' => 'Have a different question? Contact us directly'
];

$ServiceCtaCopy = [
  'tag' => 'Ready to Book?',
  'title' => "Let's Get Your",
  'title_strong' => 'Car Shining Again',
  'paragraph' => 'Call for %s in New Rochelle and nearby Westchester County.',
  'subject_fallback' => 'mobile detailing',
  'features' => ['Free Quotes', 'Bilingual', 'We Come to You'],
  'primary' => 'Call Now',
  'secondary_prefix' => 'Call'
];

$OtherServicesCopy = ['label' => 'More Services', 'title' => 'More Ways We Can Help', 'title_strong' => 'With Your Vehicle', 'item_note' => 'Mobile detailing for every vehicle.', 'cta_title' => 'Have a specific request?', 'cta_text' => 'Tell us what your vehicle needs.', 'cta_button' => $Estimates, 'page_desc' => 'Ask us about anything your vehicle needs.'];
$FounderCopy = ['title' => 'A Note from', 'title_strong' => 'The Owner', 'quote' => 'At ' . $Company . ', we believe a great detail is about care, honesty, and showing up on time. Our goal is to hand back every vehicle cleaner than you expected.', 'role' => 'Owner', 'image_alt' => $CustomerName];

$AriaCopy = [
  'call' => 'Click to call',
  'primary_nav' => 'Primary navigation',
  'whatsapp' => 'WhatsApp',
  'messenger' => 'Messenger',
  'facebook' => 'Facebook',
  'instagram' => 'Instagram',
  'google' => 'Google Maps',
  'tiktok' => 'TikTok',
  'email' => 'Email'
];

$TestimonialsPageCopy = ['eyebrow' => $NavCopy['reviews'] ?? 'Reviews', 'title' => 'What Customers Say', 'desc' => 'Feedback from Quick Wash Detailing customers.', 'card_title' => 'Leave a Review', 'card_desc' => 'Had your vehicle detailed by us? Tell us how we did.', 'card_button' => $NavCopy['leave_review'] ?? 'Leave a Review', 'card_link' => 'reviews.php'];
$ThankYouCopy = ['title' => 'Thank You', 'description' => 'Thank you for contacting ' . $Company . '. We will be in touch shortly.', 'eyebrow' => 'Thank You', 'headline' => 'We received your request', 'body' => 'Thank you for contacting ' . $Company . '. We will reach out soon to confirm your quote and schedule your detail.', 'cta_call' => 'Click to Call', 'cta_home' => 'Back to Home'];
$LabelsCopy = ['service_areas' => 'Service Areas', 'call' => 'Call', 'email' => 'Email'];

/*=========================
   CSS VARIABLES
   =========================*/
$BrandCSSVars = sprintf(
  ':root{--brand-primary:%s;--brand-secondary:%s;--brand-white:%s;--brand-accent:%s;--brand-neutral:%s;--brand-primary-rgb:%s;--brand-secondary-rgb:%s;--brand-accent-rgb:%s;}',
  $BrandColors["primary"],
  $BrandColors["secondary"],
  $BrandColors["white"],
  $BrandColors["accent"],
  $BrandColors["neutral"],
  $BrandColors["primary_rgb"],
  $BrandColors["secondary_rgb"],
  $BrandColors["accent_rgb"]
);

$BrandCSSVars .= <<<CSS
:root{
  --site-surface:#ffffff;
  --site-surface-soft:color-mix(in srgb, var(--brand-neutral) 82%, #fff 18%);
  --site-ink:var(--brand-secondary);
  --site-ink-soft:rgba(var(--brand-secondary-rgb),0.76);
  --site-panel:#ffffff;
  --site-panel-soft:rgba(255,255,255,0.78);
  --site-line:rgba(var(--brand-secondary-rgb),0.14);
  --site-dark:#07121c;
  --site-dark-2:#0e1d2b;
  --site-dark-3:#152838;
  --site-dark-line:rgba(var(--brand-accent-rgb),0.26);
  --site-dark-text:#ffffff;
  --site-dark-muted:rgba(255,255,255,0.72);
  --site-accent-soft:rgba(var(--brand-accent-rgb),0.14);
}
body{
  background:
    var(--brand-neutral);
}
#hero-4.hero4{
  background: var(--brand-secondary) !important;
}
#hero-4 .hero4__slides::after{
  background: rgba(1,10,18,0.88) !important;
}
#hero-4 .hero4__content{
  background: rgba(1,10,18,0.92) !important;
  border: 1px solid rgba(var(--brand-accent-rgb),0.55) !important;
}
#hero-4 .hero4__content::before{
  background: transparent !important;
}
#hero-4 .hero4__btn--primary,
.section-about-arch .btn-arch,
.section-remodel-why .btn-gold,
.cta-premium-section .btn-cta-primary,
.section-contact-premium .btn-submit-arch{
  background: var(--brand-accent) !important;
  color: #04121e !important;
  border-color: var(--brand-accent) !important;
}
#hero-4 .hero4__btn--ghost,
#hero-4 .hero4__thumb.active,
#hero-4 .hero4__arrow:hover{
  border-color: var(--brand-accent) !important;
}
.section-about-arch,
.section-services-premium,
.section-maint-pro,
.mission-vision-section,
.faq-section{
  background: var(--brand-neutral) !important;
}
.section-remodel-why,
.section-process,
.section-areas,
.cta-premium-section,
.section-contact-premium,
.section-map-contact{
  background: var(--brand-secondary) !important;
}
.section-about-arch .arch-eyebrow,
.section-services-premium .sv-eyebrow,
.section-maint-pro .tagline,
.section-remodel-why .sub-badge,
.section-process .step-icon,
.section-areas .license-pill,
.section-areas .city-icon,
.cta-premium-section .cta-badge,
.section-contact-premium .ct-eyebrow,
.section-map-contact .info-icon,
.section-remodel-why .why-header h2 strong,
.section-process .process-header h2 span,
.section-areas .areas-content h2 strong,
.cta-premium-section .cta-content h2 strong,
.section-map-contact .contact-card h3 span{
  color: var(--brand-accent) !important;
  border-color: rgba(var(--brand-accent-rgb),0.6) !important;
}
.section-about-arch .arch-eyebrow::before,
.section-services-premium .sv-eyebrow::before,
.section-services-premium .sv-eyebrow::after,
.section-contact-premium .ct-eyebrow::before{
  background: var(--brand-accent) !important;
}
.section-about-arch .content-arch h2 strong,
.section-services-premium .sv-header h2 strong,
.section-maint-pro .pro-header h2 strong{
  color: var(--brand-primary) !important;
}
.section-services-premium .sv-card,
.section-maint-pro .maint-card-dark,
.section-remodel-why .feature-card,
.section-process .process-step,
.section-areas .map-frame-wrapper,
.section-contact-premium .ct-form-wrapper,
.cta-premium-section .contact-glass-card,
.section-map-contact .contact-card{
  border-radius: 18px !important;
}
.section-services-premium .sv-card:hover,
.section-maint-pro .maint-card-dark:hover,
.section-remodel-why .feature-card:hover,
.section-process .process-step:hover{
  box-shadow: 0 22px 48px rgba(1,10,18,0.28) !important;
}
.section-about-arch .btn-arch,
.section-remodel-why .btn-gold,
.section-areas .btn-area,
.cta-premium-section .btn-cta-primary,
.section-contact-premium .btn-submit-arch,
.section-services-premium .btn-sv-accent{
  border-radius: 999px !important;
}
.section-about-arch .btn-arch:hover,
.section-remodel-why .btn-gold:hover,
.cta-premium-section .btn-cta-primary:hover,
.section-contact-premium .btn-submit-arch:hover{
  background: color-mix(in srgb, var(--brand-accent) 84%, #fff 16%) !important;
  color: #04121e !important;
}
.section-areas .btn-area{
  border-color: var(--brand-accent) !important;
  color: var(--brand-accent) !important;
}
.section-areas .btn-area:hover{
  background: var(--brand-accent) !important;
  color: #04121e !important;
}
.section-contact-premium .form-control-arch:focus{
  border-bottom-color: var(--brand-accent) !important;
}
.section-map-contact .map-background iframe{
  filter: grayscale(60%) contrast(0.9) !important;
}
.goog-te-banner-frame,
.skiptranslate iframe{
  display:none !important;
}
body{
  top:0 !important;
}
#google_translate_element{
  width:0;
  height:0;
  overflow:hidden;
  position:absolute;
  pointer-events:none;
}
CSS;
?>
