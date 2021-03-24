<?php

/* Загрузка общих функций и данных */
require_once $_SERVER['DOCUMENT_ROOT'] . '/../engine/functions.php';
if (!user_is_admin()) {
    header('Location: ' . $named_routes['auth.login']);
    exit;
}

if (empty($_GET)) die('метод запроса должен быть GET');

/* Валидация полученных данных */
if (empty($_GET['id'])) die('id продукта не задан');

$product_array = dbhelper_get_product($_GET['id']);
if (!$product_array) die("запись продукта для id = '{$_GET['id']}' не найдена");

/* Удаление записи из базы данных */
dbhelper_delete_product($_GET['id']);

/* Перенаправление на страницу администрирования */
header("Location: {$named_routes['products.index']}");

