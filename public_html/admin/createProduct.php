<?php
/* Загрузка общих функций и данных */
require_once $_SERVER['DOCUMENT_ROOT'] . '/../engine/functions.php';
if (!user_is_admin()) {
    header('Location: ' . $named_routes['auth.login']);
    exit;
}


if (!empty($_POST)){
    /* Если получен запрос POST, то сохраняем новую запись */

    /* Проверка наличия файла изображения */
    if (empty($_FILES['file'])) die('Не указан файл изображения');

    $path = image_store($_FILES['file']);
    if (!$path) die('название файла изображения не прошло валидацию');

    /* Обновление данных о продукте */
    dbhelper_create_product($_POST['name'], $_POST['price'], $path, filesize($_SERVER['DOCUMENT_ROOT'] . $path));

    /* Перенаправление на страницу администрирования */
    header("Location: {$named_routes['products.index']}");
}
?>

<!--Загрузка шапки-->
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../templates/header.php';
?>

<form action="<?= $named_routes['products.create'] ?>" method="post" enctype="multipart/form-data">

    <label for="name_value">Название: </label>
    <input type="text" id="name_value" name="name"><br>

    <label for="price_value">Цена: </label>
    <input type="number" step="0.01" id="price_value" name="price"><br>

    <br>
    Файл изображения:
    <input type="file" name="file" id="file_value" accept="image/png, image/jpeg" >
    <br>
    <button type="submit">Отправить</button>
</form>

<!--Загрузка подвала-->
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../templates/footer.php'; ?>
