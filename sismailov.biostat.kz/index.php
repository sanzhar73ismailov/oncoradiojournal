<?php
session_start();

$startTime = microtime(true);
require_once 'functions.php';
require_once 'sismailov_config.php';
$pdo = new PDO(
    "mysql:host=localhost;dbname=" . DB_NAME . ";charset=utf8mb4",
    DB_USER,
    DB_PASS,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]
);


// Список поддерживаемых языков
$allowed_langs = ['ru', 'en', 'kk'];
$default_lang = 'ru';

// Определяем текущий язык
$lang = isset($_GET['lang']) ? $_GET['lang'] : ($_SESSION['lang'] ?? $default_lang);
if (!in_array($lang, $allowed_langs)) {
    $lang = $default_lang;
}
$_SESSION['lang'] = $lang;
$photoUrl = 'https://' . $_SERVER['HTTP_HOST']. '/img/sismailov_photo.png';;
// ======================== ТЕКСТЫ ДЛЯ КАЖДОГО ЯЗЫКА ========================
$translations = [
    'ru' => [
        'page_title' => 'Исмаилов Санжар — Биостатистика, онкология, публикации, программирование',
        'meta_description' => 'Кандидат медицинских наук, специалист по биостатистике и онкологии. Публикации в международных журналах, опыт в клинических исследованиях и программировании (Java, Python, R, SPSS). Создатель сайта архива журнала.',
        'meta_keywords' => 'биостатистика, онкология, медицинская информатика, публикации, международные журналы, HPV, клинические исследования, статистика, программирование, Java, R, Python, SPSS, сайт архива журнала',
        'og_title' => 'О себе — Биостатистика, онкология, публикации, программирование',
        'og_description' => 'Кандидат медицинских наук, специалист по биостатистике и онкологии. Публикации в международных журналах, опыт в клинических исследованиях и программировании. Создатель сайта архива журнала.',
        'twitter_title' => 'О себе — Биостатистика, онкология, публикации, программирование',
        'twitter_description' => 'Кандидат медицинских наук, специалист по биостатистике и онкологии. Публикации в международных журналах, опыт в клинических исследованиях и программировании. Создатель сайта архива журнала.',
        'heading_main' => 'О себе',
        'full_name' => 'Исмаилов Санжар Булатович',
        'text_intro' => 'Я — <strong>кандидат медицинских наук</strong>, специалист в области <strong>биостатистики, онкологии и медицинской информатики</strong> с многолетним опытом научной и практической работы.',
        'text_dissertation' => 'В 2006 году защитил диссертацию на тему <strong>«Генетические факторы предрасположенности к развитию рака шейки матки в Казахстане»</strong> по специальностям <strong>14.00.14 — онкология</strong> и <strong>03.00.15 — генетика</strong>.',
        'highlights' => [
            '🧬 Работаю в <strong>онкологии и биостатистике</strong>',
            '📊 Имею публикации, включая международные',
            '💻 Совмещаю это с программированием',
            '📚 Создал и веду сайт архива журнала:'
        ],
        'interests_text' => 'Моя основная область интересов — <strong>применение статистических методов в клинических и эпидемиологических исследованиях</strong>, особенно в онкологии.',
        'interests_list' => [
            'рак шейки матки и вирус папилломы человека (HPV)',
            'молекулярная онкология и канцерогенез',
            'эпидемиология онкологических заболеваний',
            'клинические исследования и анализ данных'
        ],
        'skills_title' => 'Навыки биостатистики',
        'skills_list' => [
            '<strong>Статистические методы:</strong> t-критерий Стьюдента, χ²-тест, регрессия, корреляция',
            '<strong>Клинические исследования:</strong> дизайн, анализ, интерпретация',
            '<strong>Инструменты:</strong> R, SPSS, Python, Java, SQL',
            '<strong>Данные:</strong> очистка, подготовка, визуализация',
            '<strong>Методология:</strong> эпидемиология, биомедицинская статистика'
        ],
        'profiles_title' => 'Профили / Идентификаторы исследователя',
        'publications_title' => 'Избранные публикации',
        'publications' => [
            // Публикации оставляем без изменений (они на языках оригинала)
        ]
    ],
    'en' => [
        'page_title' => 'Sanzhar Ismailov — Biostatistics, Oncology, Publications, Programming',
        'meta_description' => 'Candidate of Medical Sciences (PhD), specialist in biostatistics and oncology. Publications in international journals, experience in clinical research and programming (Java, Python, R, SPSS). Creator of the journal archive website.',
        'meta_keywords' => 'biostatistics, oncology, medical informatics, publications, international journals, HPV, clinical research, statistics, programming, Java, R, Python, SPSS, journal archive website',
        'og_title' => 'About Me — Biostatistics, Oncology, Publications, Programming',
        'og_description' => 'Candidate of Medical Sciences (PhD), specialist in biostatistics and oncology. Publications in international journals, experience in clinical research and programming. Creator of the journal archive website.',
        'twitter_title' => 'About Me — Biostatistics, Oncology, Publications, Programming',
        'twitter_description' => 'Candidate of Medical Sciences (PhD), specialist in biostatistics and oncology. Publications in international journals, experience in clinical research and programming. Creator of the journal archive website.',
        'heading_main' => 'About Me',
        'full_name' => 'Sanzhar Ismailov',
        'text_intro' => 'I am a <strong>Candidate of Medical Sciences (PhD)</strong>, a specialist in <strong>biostatistics, oncology, and medical informatics</strong> with many years of experience in scientific and practical work.',
        'text_dissertation' => 'In 2006, I defended my dissertation on the topic <strong>“Genetic predisposition factors for the development of cervical cancer in Kazakhstan”</strong> in the specialties <strong>14.00.14 — oncology</strong> and <strong>03.00.15 — genetics</strong>.',
        'highlights' => [
            '🧬 Working in <strong>oncology and biostatistics</strong>',
            '📊 Have publications, including international ones',
            '💻 Combine this with programming',
            '📚 Created and maintain the journal archive website:'
        ],
        'interests_text' => 'My main area of interest is <strong>the application of statistical methods in clinical and epidemiological research</strong>, especially in oncology.',
        'interests_list' => [
            'cervical cancer and human papillomavirus (HPV)',
            'molecular oncology and carcinogenesis',
            'epidemiology of cancer',
            'clinical trials and data analysis'
        ],
        'skills_title' => 'Biostatistics Skills',
        'skills_list' => [
            '<strong>Statistical methods:</strong> Student\'s t-test, χ²-test, regression, correlation',
            '<strong>Clinical research:</strong> design, analysis, interpretation',
            '<strong>Tools:</strong> R, SPSS, Python, Java, SQL',
            '<strong>Data:</strong> cleaning, preparation, visualization',
            '<strong>Methodology:</strong> epidemiology, biomedical statistics'
        ],
        'profiles_title' => 'Researcher Profiles / Identifiers',
        'publications_title' => 'Selected Publications',
        'publications' => [] // same as ru
    ],
    'kk' => [
        'page_title' => 'Санжар Исмаилов — Биостатистика, онкология, жарияланымдар, бағдарламалау',
        'meta_description' => 'Медицина ғылымдарының кандидаты, биостатистика және онкология саласының маманы. Халықаралық журналдардағы жарияланымдар, клиникалық зерттеулер және бағдарламалау тәжірибесі (Java, Python, R, SPSS). Журнал архивінің сайтын жасаушы.',
        'meta_keywords' => 'биостатистика, онкология, медициналық информатика, жарияланымдар, халықаралық журналдар, HPV, клиникалық зерттеулер, статистика, бағдарламалау, Java, R, Python, SPSS, журнал архивінің сайты',
        'og_title' => 'Өзім туралы — Биостатистика, онкология, жарияланымдар, бағдарламалау',
        'og_description' => 'Медицина ғылымдарының кандидаты, биостатистика және онкология саласының маманы. Халықаралық журналдардағы жарияланымдар, клиникалық зерттеулер және бағдарламалау тәжірибесі. Журнал архивінің сайтын жасаушы.',
        'twitter_title' => 'Өзім туралы — Биостатистика, онкология, жарияланымдар, бағдарламалау',
        'twitter_description' => 'Медицина ғылымдарының кандидаты, биостатистика және онкология саласының маманы. Халықаралық журналдардағы жарияланымдар, клиникалық зерттеулер және бағдарламалау тәжірибесі. Журнал архивінің сайтын жасаушы.',
        'heading_main' => 'Өзім туралы',
        'full_name' => 'Исмаилов Санжар Болатұлы', // (можете изменить на Санжар Болатұлы Исмаилов, если нужно)
        'text_intro' => 'Мен — <strong>медицина ғылымдарының кандидаты</strong>, <strong>биостатистика, онкология және медициналық информатика</strong> саласында ғылыми-практикалық жұмыста ұзақ жылдық тәжірибесі бар маманмын.',
        'text_dissertation' => '2006 жылы <strong>«Қазақстанда жатыр мойны обырының дамуына бейімділіктің генетикалық факторлары»</strong> тақырыбында <strong>14.00.14 — онкология</strong> және <strong>03.00.15 — генетика</strong> мамандықтары бойынша диссертация қорғадым.',
        'highlights' => [
            '🧬 <strong>Онкология және биостатистика</strong> саласында жұмыс істеймін',
            '📊 Халықаралық деңгейдегі жарияланымдарым бар',
            '💻 Осыны бағдарламалаумен ұштастырамын',
            '📚 Журнал архивінің сайтын құрдым және жүргіземін:'
        ],
        'interests_text' => 'Менің негізгі қызығушылығым — <strong>клиникалық және эпидемиологиялық зерттеулерде статистикалық әдістерді қолдану</strong>, әсіресе онкология саласында.',
        'interests_list' => [
            'жатыр мойны обыры және адам папилломавирусы (HPV)',
            'молекулярлық онкология және канцерогенез',
            'онкологиялық аурулардың эпидемиологиясы',
            'клиникалық зерттеулер және деректерді талдау'
        ],
        'skills_title' => 'Биостатистика дағдылары',
        'skills_list' => [
            '<strong>Статистикалық әдістер:</strong> Стьюдент t-критериі, χ²-тест, регрессия, корреляция',
            '<strong>Клиникалық зерттеулер:</strong> дизайн, талдау, интерпретация',
            '<strong>Құралдар:</strong> R, SPSS, Python, Java, SQL',
            '<strong>Деректер:</strong> тазарту, дайындау, визуализация',
            '<strong>Әдіснама:</strong> эпидемиология, биомедициналық статистика'
        ],
        'profiles_title' => 'Зерттеуші профильдері / Идентификаторлар',
        'publications_title' => 'Таңдаулы жарияланымдар',
        'publications' => [] // same as ru
    ]
];

// Публикации (не переводятся, остаются в оригинале)
$publications_list = [
    '<li>Lyu B.N., Lyu M.B., Ismailov B.I., <strong>Ismailov S.B.</strong> (2007). Four hypotheses on mitochondria\'s role in the development and regulation of oxidative stress in the normal state, cell pathology and reversion of tumor cells. <em>Medical Hypotheses</em>.<br>PubMed: <a href="https://pubmed.ncbi.nlm.nih.gov/17207937/" target="_blank">17207937</a></li>',
    '<li>Brás A., Cotrim C.Z., Vasconcelos I., Mexia J., Léonard A., <strong>Sanzhar I.</strong>, Akhmatullina N., Rueff J. (2008). Asynchronous DNA replication detected by fluorescence in situ hybridisation as a possible indicator of genetic damage in human lymphocytes. <em>Oncology Reports</em>.<br>PubMed: <a href="https://pubmed.ncbi.nlm.nih.gov/18202783/" target="_blank">18202783</a></li>',
    '<li>Lyu B.N., <strong>Ismailov S.B.</strong>, Ismailov B., Lyu M.B. (2008). Mitochondrial concept of leukemogenesis: key role of oxygen-peroxide effects. <em>Theoretical Biology and Medical Modelling</em>.<br>PubMed: <a href="https://pubmed.ncbi.nlm.nih.gov/19014456/" target="_blank">19014456</a></li>',
    '<li>Нургазиев К.Ш., Байпеисов Д.М., <strong>Исмаилов С.Б.</strong>, Камхен В.Б. (2014). Информационно-аналитический сборник «Статистика злокачественных новообразований в 2004–2013 годах и прогноз до 2020 года».<br>PDF: <a href="pdfs/27_sbornik2014.pdf" target="_blank">27_sbornik2014.pdf</a></li>',
    '<li><strong>Исмаилов С.Б.</strong> (2013). Выбор статистического метода для анализа результатов клинических исследований.<br>PDF: <a href="pdfs/25_2013.4.30_01.pdf" target="_blank">25_2013.4.30_01.pdf</a><br>www.elibrary.ru: <a href="https://www.elibrary.ru/item.asp?id=32575883" target="_blank">17207937</a></li>',
    '<li><strong>Исмаилов С.Б.</strong> (2014). Практическое использование критерия Стьюдента.<br>PDF: <a href="pdfs/26_2014.1.31_01.pdf" target="_blank">26_2014.1.31_01.pdf</a><br>www.elibrary.ru: <a href="https://www.elibrary.ru/item.asp?id=32601757" target="_blank">17207937</a></li>',
    '<li>Kaidarova D., Kairbayev M., Kim H., Han B.D., <strong>Ismailov S.</strong>, Shibanova A., Kukubassov Y., Shalbayeva R., Yeleubayeva Zh., Bolatbekova R., Park H.J., Kim H.J. (2018). Prevalence of high-risk human papillomaviruses and abnormal PAP smears among women visiting gynaecological outpatient units in Kazakhstan: A cross sectional study. <em>Journal of Clinical Oncology</em>.<br>DOI: <a href="https://doi.org/10.1200/JCO.2018.36.15_suppl.e13596" target="_blank">10.1200/JCO.2018.36.15_suppl.e13596</a></li>',
    '<li>Uteulova A., Janbayeva A., Assimov M., Vasko T. and <strong>Ismailov S</strong> (2026). Psychological rehabilitation of women with breast diseases: dynamics of quality of life before and after a psychotherapeutic program. <em>Front. Psychol.</em> 17:1795902. doi: <a href="https://doi.org/10.3389/fpsyg.2026.1795902" target="_blank">10.3389/fpsyg.2026.1795902</a><br>Full text: <a href="https://www.frontiersin.org/journals/psychology/articles/10.3389/fpsyg.2026.1795902/full" target="_blank">frontiersin.org</a></li>'
];

$t = $translations[$lang];
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($t['page_title']); ?></title>

    <!-- SEO метатеги -->
    <meta name="description" content="<?php echo htmlspecialchars($t['meta_description']); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($t['meta_keywords']); ?>">

    <!-- Open Graph для соцсетей -->
    <meta property="og:title" content="<?php echo htmlspecialchars($t['og_title']); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($t['og_description']); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://oncoarchive2010to2017.biostat.kz/">
    <meta property="og:image" content="<?php echo $photoUrl; ?>">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($t['twitter_title']); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($t['twitter_description']); ?>">
    <meta name="twitter:image" content="<?php echo $photoUrl; ?>">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="canonical" href="https://sismailov.biostat.kz/">
    <link rel="alternate" hreflang="ru" href="https://sismailov.biostat.kz/?lang=ru">
    <link rel="alternate" hreflang="en" href="https://sismailov.biostat.kz/?lang=en">
    <link rel="alternate" hreflang="kk" href="https://sismailov.biostat.kz/?lang=kk">

    <style>
        body {
            padding: 20px;
            background-color: #f8f9fa;
        }
        .card {
            padding: 30px;
        }
        ol, ul {
            margin-left: 25px;
        }
        a {
            word-break: break-all;
        }
        .lang-switcher {
            text-align: right;
            margin-bottom: 20px;
        }
        .lang-switcher a {
            margin-left: 10px;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
            background-color: #e9ecef;
            color: #0d6efd;
        }
        .lang-switcher a.active {
            background-color: #0d6efd;
            color: white;
        }
        .full-name {
            font-size: 1.5rem;
            font-weight: 300;
            margin-top: -0.5rem;
            margin-bottom: 1rem;
            color: #6c757d;
        }

        /* Responsive adjustments for mobile */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            .card {
                padding: 20px;
            }
            .full-name {
                font-size: 1.2rem;
            }
            h2 {
                font-size: 1.5rem;
            }
            h3 {
                font-size: 1.25rem;
            }
        }
    </style>
    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "Person",
          "name": "Sanzhar Ismailov",
          "url": "https://sismailov.biostat.kz/",
          "image": "<?php echo $photoUrl; ?>",
  "jobTitle": "Biostatistician, Oncology Researcher",
  "sameAs": [
    "https://orcid.org/0000-0001-8907-5874",
    "https://linkedin.com/in/sanzhar-ismailov-53033377",
    "https://github.com/sanzhar73ismailov",
    "https://scholar.google.com/citations?user=m6oeeG0AAAAJ",
    "https://www.scopus.com/authid/detail.uri?authorId=16304383300"
  ],
  "knowsAbout": [
    "Biostatistics",
    "Oncology",
    "Clinical Research",
    "HPV",
    "Medical Informatics"
  ]
}
    </script>
</head>
<body>

<div class="container">
    <div class="lang-switcher">
        <a href="?lang=kk" class="<?php echo $lang == 'kk' ? 'active' : ''; ?>">Қазақша</a>
        <a href="?lang=ru" class="<?php echo $lang == 'ru' ? 'active' : ''; ?>">Русский</a>
        <a href="?lang=en" class="<?php echo $lang == 'en' ? 'active' : ''; ?>">English</a>
    </div>

    <div class="card shadow-sm">
        <h1 class="mb-1"><?php echo $t['heading_main']; ?></h1>
        <div class="full-name"><?php echo htmlspecialchars($t['full_name']); ?></div>

        <p><?php echo $t['text_intro']; ?></p>
        <p><?php echo $t['text_dissertation']; ?></p>

        <ul class="profile-highlights list-unstyled">
            <?php foreach ($t['highlights'] as $item): ?>
                <li><?php echo $item; ?></li>
            <?php endforeach; ?>
            <?php if (end($t['highlights']) === $t['highlights'][3]): ?>
                <a href="https://oncoarchive2010to2017.biostat.kz/" target="_blank">oncoarchive2010to2017.biostat.kz</a></li>
            <?php endif; ?>
        </ul>

        <p><?php echo $t['interests_text']; ?></p>
        <ul>
            <?php foreach ($t['interests_list'] as $item): ?>
                <li><?php echo $item; ?></li>
            <?php endforeach; ?>
        </ul>

        <hr>

        <h3><?php echo $t['skills_title']; ?></h3>
        <ul>
            <?php foreach ($t['skills_list'] as $item): ?>
                <li><?php echo $item; ?></li>
            <?php endforeach; ?>
        </ul>

        <hr>

        <h3><?php echo $t['profiles_title']; ?></h3>
        <p>
            ORCID: <a href="https://orcid.org/0000-0001-8907-5874" target="_blank">0000-0001-8907-5874</a><br>
            LinkedIn: <a href="https://linkedin.com/in/sanzhar-ismailov-53033377" target="_blank">linkedin.com/in/sanzhar-ismailov-53033377</a><br>
            GitHub: <a href="https://github.com/sanzhar73ismailov" target="_blank">github.com/sanzhar73ismailov</a><br>
            Scopus: <a href="https://www.scopus.com/authid/detail.uri?authorId=16304383300" target="_blank">16304383300</a><br>
            Google Scholar: <a href="https://scholar.google.com/citations?user=m6oeeG0AAAAJ" target="_blank">m6oeeG0AAAAJ</a>
        </p>

        <hr>

        <h3><?php echo $t['publications_title']; ?></h3>
        <ul>
            <?php foreach ($publications_list as $pub): ?>
                <?php echo $pub; ?>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

</body>
</html>
<?php
logVisit($pdo, $startTime, $lang);
?>