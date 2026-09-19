<?php
// Get the URL path after the domain
$request_uri = $_SERVER['REQUEST_URI'];
$path = parse_url($request_uri, PHP_URL_PATH);
$path = trim($path, '/');

// Extract the page name from the path
// For dracristinabarata.pt/something, get "something"
$segments = explode('/', $path);
$page = end($segments);

// Remove .php extension if present
$page = preg_replace('/\.php$/', '', $page);

// Default to quem_sou if no page specified or if it's the root
if (empty($page) || $page == 'PsicoAngola' || $page == 'index.php') {
    $page = 'quem_sou';
}

// Sanitize the page name to prevent directory traversal
$page = preg_replace('/[^a-zA-Z0-9_-]/', '', $page);

// Build the page file path
$page_file = __DIR__ . '/pages/' . $page . '.php';

// If the page doesn't exist, default to quem_sou
if (!file_exists($page_file)) {
    $page = 'quem_sou';
    $page_file = __DIR__ . '/pages/quem_sou.php';
}
?>
<!DOCTYPE html>
<!--This webpage was made by Gabor Bacsi. www.bachey.eu-->
<html lang="pt">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
<title>Dra. Cristina Barata - Psicóloga Clínica | PsicoAngola - Consultas Online e Presenciais</title>
<meta name="description" content="Dra. Cristina Barata, psicóloga clínica especializada em terapia cognitivo-comportamental. Consultas online e presenciais. Especialista em ansiedade, depressão e desenvolvimento pessoal. PsicoAngola - serviços de psicologia de qualidade.">
<meta name="keywords" content="Dra Cristina Barata, Cristina Barata, psicóloga, psicologia clínica, PsicoAngola, terapia online, consultas psicológicas, ansiedade, depressão, terapia cognitivo-comportamental, psicólogo Angola, psicólogo Portugal">
<meta name="author" content="Dra. Cristina Barata">
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
<link rel="canonical" href="https://dracristinabarata.pt/">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="https://dracristinabarata.pt/">
<meta property="og:title" content="Dra. Cristina Barata - Psicóloga Clínica | PsicoAngola">
<meta property="og:description" content="Psicóloga clínica especializada em terapia cognitivo-comportamental. Consultas online e presenciais para ansiedade, depressão e desenvolvimento pessoal.">
<meta property="og:locale" content="pt_PT">
<meta property="og:site_name" content="Dra. Cristina Barata - PsicoAngola">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="https://dracristinabarata.pt/">
<meta name="twitter:title" content="Dra. Cristina Barata - Psicóloga Clínica | PsicoAngola">
<meta name="twitter:description" content="Psicóloga clínica especializada em terapia cognitivo-comportamental. Consultas online e presenciais.">

<!-- Geo Tags -->
<meta name="geo.region" content="PT">
<meta name="geo.placename" content="Portugal">

<!-- Language Alternatives -->
<link rel="alternate" hreflang="pt" href="https://dracristinabarata.pt/">
<link rel="alternate" hreflang="en" href="https://dracristinabarata.pt/international">
<link rel="alternate" hreflang="es" href="https://dracristinabarata.pt/international">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Scope+One%7CThasadith&amp;display=swap" rel="stylesheet">

<style>
@font-face {
    font-family: 'Timeless';
    src: url('font/Timeless.ttf') format('opentype');
}
@font-face {
    font-family: 'Champignon';
    src: url('font/Champignon.otf') format('opentype');
}
</style>

<!--<link rel="shortcut icon" type="image/x-icon" href="/ico/favicon.ico">-->
<link rel="stylesheet" type="text/css" href="https://dracristinabarata.pt/css/style.css?version=60">

<script type="application/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</head>

<body>

<!-- Schema.org Structured Data -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "Psychologist",
      "@id": "https://dracristinabarata.pt/#psychologist",
      "name": "Dra. Cristina Barata",
      "url": "https://dracristinabarata.pt/",
      "image": "https://dracristinabarata.pt/images/profile.jpg",
      "description": "Psicóloga clínica especializada em terapia cognitivo-comportamental, oferecendo consultas online e presenciais para ansiedade, depressão e desenvolvimento pessoal.",
      "priceRange": "$$",
      "knowsAbout": [
        "Terapia Cognitivo-Comportamental",
        "Ansiedade",
        "Depressão",
        "Desenvolvimento Pessoal",
        "Psicologia Clínica"
      ],
      "knowsLanguage": ["pt", "en", "es"],
      "areaServed": [
        {
          "@type": "Country",
          "name": "Portugal"
        },
        {
          "@type": "Country",
          "name": "Angola"
        },
        {
          "@type": "Country",
          "name": "United States"
        },
        {
          "@type": "Country",
          "name": "United Kingdom"
        },
        {
          "@type": "Country",
          "name": "Brazil"
        },
        {
          "@type": "Country",
          "name": "Spain"
        }
      ],
      "availableService": {
        "@type": "Service",
        "name": "Consultas de Psicologia",
        "serviceType": "Psicologia Clínica",
        "provider": {
          "@type": "Psychologist",
          "name": "Dra. Cristina Barata"
        }
      }
    },
    {
      "@type": "WebSite",
      "@id": "https://dracristinabarata.pt/#website",
      "url": "https://dracristinabarata.pt/",
      "name": "Dra. Cristina Barata - PsicoAngola",
      "description": "Psicóloga clínica - Consultas online e presenciais",
      "publisher": {
        "@id": "https://dracristinabarata.pt/#psychologist"
      },
      "inLanguage": "pt-PT",
      "potentialAction": {
        "@type": "SearchAction",
        "target": "https://dracristinabarata.pt/?s={search_term_string}",
        "query-input": "required name=search_term_string"
      }
    },
    {
      "@type": "WebPage",
      "@id": "https://dracristinabarata.pt/#webpage",
      "url": "https://dracristinabarata.pt/",
      "name": "Dra. Cristina Barata - Psicóloga Clínica | PsicoAngola",
      "isPartOf": {
        "@id": "https://dracristinabarata.pt/#website"
      },
      "about": {
        "@id": "https://dracristinabarata.pt/#psychologist"
      },
      "description": "Dra. Cristina Barata, psicóloga clínica especializada em terapia cognitivo-comportamental. Consultas online e presenciais.",
      "inLanguage": "pt-PT"
    },
    {
      "@type": "Organization",
      "@id": "https://dracristinabarata.pt/#organization",
      "name": "PsicoAngola",
      "url": "https://dracristinabarata.pt/",
      "description": "Serviços de psicologia clínica de qualidade",
      "founder": {
        "@id": "https://dracristinabarata.pt/#psychologist"
      }
    }
  ]
}
</script>

<header class="header" role="banner">
<!--This header has an SVG in background-->
<h1 class="header-text" style="text-transform: none; font-weight: normal;">Dra. Cristina Barata</h1>
</header>
<nav class="menu-container" role="navigation" aria-label="Menu principal">
    <a class="menu-button" href="/quem_sou#main" title="Conheça a Dra. Cristina Barata">Quem sou eu</a>
    <a class="menu-button" href="/psicoangola#main" title="Sobre o PsicoAngola">PsicoAngola</a>
    <a class="menu-button" href="/consultas#main" title="Consultas e planos disponíveis">Consultas e Planos</a>
    <a class="menu-button" href="/media#main" title="Artigos e media">Media</a>
    <a class="menu-button" href="/international#main" title="English and Spanish sessions" lang="en">English/Spanish sessions</a>
    <a class="menu-button" href="/feedback#main" title="Testemunhos de pacientes">Testemunhos</a>
</nav>
<main id="content" class="light-background content-normal-padding" role="main">
<?php
    echo "<div id='main'></div>\n";
    // scroll here on any button click above...
    include $page_file;
?>
</main>
<br>
<footer class="footer" role="contentinfo">
	<br>
	<div class="whiten" style="margin: auto;"> &nbsp;<?php echo date("Y");?> - Dra. Cristina Barata - Psicóloga Clínica | PsicoAngola
	</div>
</footer>
</body>
</html>
