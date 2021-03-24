<?php
/* Загрузка общих функций и данных */
require_once $_SERVER['DOCUMENT_ROOT'] . '/../engine/functions.php';
?>


<!--Загрузка шапки-->
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../templates/header.php'; ?>

<!--Отображение уменьшенных изображений-->
<?php

$rows = dbhelper_get_array("SELECT * FROM products ORDER BY views_count DESC");
if (count($rows) == 0) die('записи в базе данных не найдены');

?>
<div class="container-thumbnails">
    <?php foreach ($rows as $row): ?>
        <form action="<?=$named_routes['cart.store']?>" method="post">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <input type="hidden" name="image_uri" value="<?= $row['image_uri'] ?>">
            <input type="hidden" name="name" value="<?= $row['name'] ?>">
            <input type="hidden" name="price" value="<?= $row['price'] ?>">
            <div class="card">
                <a class="thumbnail-effects" href="/product.php?id=<?= $row['id'] ?>">
                    <img class="thumbnail" src="<?= $row['image_uri'] ?>" alt="image">
                </a>
                <button type="submit" class="button">
                    Добавить в корзину
                </button>
                <div>Число просмотров: <?= $row['views_count'] ?></div>
                <div><?= $row['price']?></div>
            </div>
        </form>
    <?php endforeach; ?>
</div>

<!--Загрузка подвала-->
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../templates/footer.php'; ?>


