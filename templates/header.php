<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/css/app.css">

</head>
<body>

<?php
/* Загрузка общих функций и данных */
require_once $_SERVER['DOCUMENT_ROOT'] . '/../engine/functions.php';
?>


<div class="main-menu">
    <a class="main-menu-item" href="<?= $named_routes['index'] ?>">На главную</a>
    <a class="main-menu-item" href="<?= $named_routes['catalog.index'] ?>">Каталог товаров</a>
    <a class="main-menu-item" href="<?= $named_routes['products.index'] ?>">Администрирование</a>
</div>




