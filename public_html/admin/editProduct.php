<?php
/* Загрузка общих функций и данных */
require_once $_SERVER['DOCUMENT_ROOT'] . '/../engine/functions.php';
if (!user_is_admin()) {
    header('Location: ' . $named_routes['auth.login']);
    exit;
}

/* Идентификация действия */
if (empty($_GET) && empty($_POST)) die('действие для выполнения не идентифицировано');

/* Валидация полученных данных */
if (empty($_REQUEST['id'])) die('id продукта не задан');

$product_array = dbhelper_get_product($_REQUEST['id']);
if (!$product_array) die("запись продукта для id = '{$_REQUEST['id']}' не найдена");

if (!empty($_POST)){
    /* Если получен запрос POST, то сохраняем изменения */

    /* Проверка изменения изображения */
    $file = false;
    if (!empty($_FILES['file'])){
        $path = image_store($_FILES['file']);

        if (!$path) die('название файла изображения не прошло валидацию');

        $file = $path;
        /* Если создан путь к новому файлу, то удаляем имеющийся файл */
        if (file_exists($_SERVER['DOCUMENT_ROOT'].$product_array['image_uri'])){
            unlink($_SERVER['DOCUMENT_ROOT'].$product_array['image_uri']);
        }
    }

    /* Обновление данных о продукте */
    dbhelper_update_product($_POST['id'], $_POST['name'], $_POST['price'], $file);

    /* Перенаправление на страницу администрирования */
    header("Location: {$named_routes['products.index']}");
}
?>

<!--Загрузка шапки-->
<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/../templates/header.php';
?>

<form action="<?= $named_routes['products.update'] ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $product_array['id'] ?>">

    <label for="name_value">Название: </label>
    <input type="text" id="name_value" name="name" value="<?=$product_array['name']?>"><br>

    <label for="price_value">Цена: </label>
    <input type="number" step="0.01" id="price_value" name="price" value="<?=$product_array['price']?>"><br>

    <label for="file_valu">Имеющееся изображение: </label>
    <img class="thumbnail" src="<?= $product_array['image_uri'] ?>" alt="image">
    <br>
    Заменить изображение:
    <input type="file" name="file" id="file_value" accept="image/png, image/jpeg" >
    <br>
    <button type="submit">Отправить</button>
</form>

<!--Загрузка подвала-->
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../templates/footer.php'; ?>
