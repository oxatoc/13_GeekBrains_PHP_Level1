<?php

/* Загрузка именованных маршрутов */
if (empty($named_routes)) {
    $named_routes = require_once $_SERVER['DOCUMENT_ROOT'] . '/../config/named_routes.php';
}

/* Общие функции */

/* Увеличение счетчика просмотров */
function dbhelper_count_view($id){
    $product_id = validate_id($id);
    if (!$product_id) die('id продукта не прошел валидацию');

    /* Читаем текущее значение счетчика просмотров */
    $product_array = dbhelper_get_product($product_id);

    /* Увеличиваем значение счетчика */
    $dbconfig = include $_SERVER['DOCUMENT_ROOT'] . '/../config/db.php';
    $link = mysqli_connect($dbconfig['servername'], $dbconfig['username'], $dbconfig['password'], $dbconfig['database']);

    $sql = 'UPDATE products SET views_count = '.($product_array['views_count'] + 1).' WHERE id = '.$product_id;
    $result = mysqli_query($link, $sql);
    if (!$result) die(mysqli_error($link));

    mysqli_close($link);
    return true;
}

/* Создание записи о продукте */
function dbhelper_create_product($name, $price, $file, $file_size)
{
    $product_price = validate_float($price);
    if (!$product_price) die('значение цены продукта не прошло валидацию');

    $dbconfig = include $_SERVER['DOCUMENT_ROOT'] . '/../config/db.php';
    $link = mysqli_connect($dbconfig['servername'], $dbconfig['username'], $dbconfig['password'], $dbconfig['database']);

    $product_name = dbhelper_escape_string($link, $name);
    if (!$product_name) die('название продукта не прошло валидацию');

    $product_file = dbhelper_escape_string($link, $file);
    if (!$product_file) die('название файла продукта не прошло валидацию');


    $sql = "INSERT INTO products (name, price, image_uri, size) 
VALUES ('$product_name', $product_price, '$product_file', $file_size)";
    $result = mysqli_query($link, $sql);
    if (!$result) die(mysqli_error($link));

    mysqli_close($link);
    return true;
}

/* Удаление записи из БД продуктов */
function dbhelper_delete_product($id)
{
    $product_id = validate_id($id);
    if (!$product_id) die('id продукта не прошел валидацию');

    $dbconfig = include $_SERVER['DOCUMENT_ROOT'] . '/../config/db.php';
    $link = mysqli_connect($dbconfig['servername'], $dbconfig['username'], $dbconfig['password'], $dbconfig['database']);
    $result = mysqli_query($link, "DELETE FROM products WHERE id = $product_id");
    if (!$result) die(mysqli_error($link));

    mysqli_close($link);
    return true;
}

/* Чтение из БД массива строк */
function dbhelper_get_array($sql)
{
    $dbconfig = include $_SERVER['DOCUMENT_ROOT'] . '/../config/db.php';
    $link = mysqli_connect($dbconfig['servername'], $dbconfig['username'], $dbconfig['password'], $dbconfig['database']);
    $result = mysqli_query($link, $sql);
    if (!$result) die(mysqli_error($link));

    mysqli_close($link);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/* Получение записи одного продукта */
function dbhelper_get_product($id)
{
    $product_id = validate_id($id);
    if (!$product_id) die('id продукта не прошел валидацию');

    $rows = dbhelper_get_array("SELECT id, name, price, image_uri, views_count FROM products WHERE id = $product_id LIMIT 1");
    if (count($rows) == 0) return false;

    /* Если запись товара найдена, то возвращаем массив */
    return $rows[0];
}

/* Обновление записи товара в базе данных */
function dbhelper_update_product($id, $name, $price, $file = false)
{
    /* Валидация данных */
    $product_id = validate_id($id);
    if (!$product_id) die('id продукта не прошел валидацию');

    $product_price = validate_float($price);
    if (!$product_price) die('значение цены продукта не прошло валидацию');

    $dbconfig = include $_SERVER['DOCUMENT_ROOT'] . '/../config/db.php';
    $link = mysqli_connect($dbconfig['servername'], $dbconfig['username'], $dbconfig['password'], $dbconfig['database']);

    $product_name = dbhelper_escape_string($link, $name);
    if (!$product_name) die('название продукта не прошло валидацию');

    $sql = "UPDATE products SET name = '$product_name', price = $product_price";

    if ($file) {
        /* Если файл изображения изменился */
        $product_file = dbhelper_escape_string($link, $file);
        if (!$product_file) die('название файла продукта не прошло валидацию');
        $sql .= ", image_uri = '$product_file'";
    }

    $sql .= " WHERE id = $product_id";

    $result = mysqli_query($link, $sql);

    if (!$result) die(mysqli_error($link));

    mysqli_close($link);
    return true;
}

/* Экранирование строковых значений */
function dbhelper_escape_string($db_link, $str = false)
{
    if (!$str) return false;

    $result = mysqli_real_escape_string($db_link
        , (string)htmlspecialchars(strip_tags($str)));
    if (strlen($result) == 0) return false;
    return $result;
}

/* Валидация числа с плавающей точкой */
function validate_float($value)
{
    $f = (float)$value;
    if ($f === 0) return false;
    return $f;
}

/* Валидация значения первичного ключа */
function validate_id($value)
{
    $id = (int)$value;
    if ($id === 0) {
        return false;
    }
    return $id;
}

/**
 * Сохранение файла
 *
 * @return string возвращает путь к сохраненному файлу
 */
function image_store($file_array)
{
    /* Если файл получен, то сохраняем на диске, добавляем запись в базу данных и перенаправляем на ту же страницу*/
    if (empty($file_array['tmp_name'])) return false;
    $image = basename($file_array['name']);
    $address = '/img/' . $image;
    move_uploaded_file($file_array['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $address);
    return $address;
}

