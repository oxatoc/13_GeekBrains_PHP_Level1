<?php
session_start();

/* Инциализация сессии */

/* Загрузка именованных маршрутов */
if (empty($named_routes)) {
    $named_routes = require_once $_SERVER['DOCUMENT_ROOT'] . '/../config/named_routes.php';
}

/* Общие функции */

/**
 * Добавление товара в корзину
 */

function cart_add($product_data){
    /* если в сессии еще не создан массив корзины, то создаем */
    $product_data['quantity'] = 1;
    $id = $product_data['id'];
    if (!isset($_SESSION['cart'])){
        $_SESSION['cart'][$id] = $product_data;
        return;
    }

    /* Если в сессии уже хранится такой товар, то увеличиваем количество на единицу */
    if (isset($_SESSION['cart'][$id])){
        $_SESSION['cart'][$id]['quantity'] += 1;
        return;
    }

    /* Иначе добавляем товар в корзину */
    $_SESSION['cart'][$id] = $product_data;
}

function cart_delete($id){
    unset($_SESSION['cart'][$id]);
    return;
}

/**
 * Получение перечня товаров в корзине
 */
function cart_index(){

    if (isset($_SESSION['cart'])){


        return $_SESSION['cart'];
    }
    return [];
}

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

    $array = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_close($link);
    return $array;
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

/* Поиск записи зарегистрированного пользователя */
function dbhelper_get_user($name){

    $dbconfig = include $_SERVER['DOCUMENT_ROOT'] . '/../config/db.php';
    $link = mysqli_connect($dbconfig['servername'], $dbconfig['username'], $dbconfig['password'], $dbconfig['database']);

    $user_name = dbhelper_escape_string($link, $name);
    if (!$user_name) die('имя пользователя не прошло валидацию');

    $sql = "SELECT * FROM users WHERE name = '{$user_name}' LIMIT 1";

    $result = mysqli_query($link, $sql);
    if (!$result) die(mysqli_error($link));
    $array = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if (count($array) == 0){
        return false;
    }
    return $array[0];
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

/**
 * Экранирование для вывода в браузер пользователя
 */
function escape_for_html($data){
    return htmlentities(strip_tags($data), ENT_QUOTES | ENT_HTML5, 'UTF-8');
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

/* Проверка флага аутентификации администратора */
function user_is_admin(){
    if (!isset($_SESSION['user_role'])){
        return false;
    }

    return $_SESSION['user_role'] == 'admin';
}

/* Проверка флага ввода реквизитов аутентификации */
function user_is_authenticated(){
    return isset($_SESSION['user_role']);
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






?>