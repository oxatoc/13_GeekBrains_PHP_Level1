<!--Загрузка шапки-->
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../templates/header.php'; ?>

<?php

if (empty($_GET)) die('метод запроса должен быть GET');

/* Валидация полученных данных */
if (empty($_GET['id'])) die('id продукта не задан');

$product_array = dbhelper_get_product($_GET['id']);
if (!$product_array) die("запись продукта для id = '{$_GET['id']}' не найдена");

/* Увеличиваем количество просмотров */
dbhelper_count_view($product_array['id']);

?>

<div class="full-image">
    <img src="<?=$product_array['image_uri']?>" alt="image">
</div>
<br>
<span><?=$product_array['price']?></span>

<!--Загрузка подвала-->
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../templates/footer.php'; ?>