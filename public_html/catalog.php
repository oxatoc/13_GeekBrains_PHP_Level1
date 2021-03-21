<!--Загрузка шапки-->
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../templates/header.php'; ?>

<!--Отображение уменьшенных изображений-->
<?php

$rows = dbhelper_get_array("SELECT * FROM products ORDER BY views_count DESC");
if (count($rows) == 0) die('записи в базе данных не найдены');

?>
<div class="container-thumbnails">
    <?php foreach ($rows as $row): ?>
        <div>
            <a class="thumbnail-effects" href="/product.php?id=<?= $row['id'] ?>">
                <img class="thumbnail" src="<?= $row['image_uri'] ?>" alt="image">
            </a>
            <div>Число просмотров: <?= $row['views_count'] ?></div>
            <div><?= $row['price']?></div>
        </div>
    <?php endforeach; ?>
</div>

<!--Загрузка подвала-->
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../templates/footer.php'; ?>


