<?php
header('Cache-Control: max-age=3600');
header('Content-Type: application/xml; charset=utf-8');

require_once 'includes/global.php';
require_once 'includes/model.php';

$model = new Model();

$server = "https://" . $_SERVER['SERVER_NAME'];

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">

    <!-- Главная -->
    <url>
        <loc><?= $server ?>/index.php</loc>
    </url>

    <!-- Страницы -->
    <url><loc><?= $server ?>/index.php?page=archive</loc></url>
    <url><loc><?= $server ?>/index.php?page=search</loc></url>

    <?php
    // 👉 ВАЖНО: тебе нужен метод получения всех статей
    $publications = $model->getAllPublications(); // если нет — ниже покажу

    foreach ($publications as $p):
        ?>
        <url>
            <loc><?= htmlspecialchars($server . '/index.php?page=abstract&id=' . $p->id, ENT_QUOTES) ?></loc>
        </url>
    <?php endforeach; ?>

</urlset>