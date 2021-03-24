<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../engine/functions.php';
?>

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

<div class="main-menu">
    <a class="main-menu-item" href="<?= $named_routes['index'] ?>">На главную</a>

    <?php if (!user_is_admin()): ?>
        <a class="main-menu-item" href="<?= $named_routes['catalog.index'] ?>">Каталог товаров</a>
        <a class="main-menu-item" href="<?= $named_routes['cart.index'] ?>">Корзина товаров</a>
    <?php endif; ?>

    <?php if (user_is_admin()): ?>
        <a class="main-menu-item" href="<?= $named_routes['products.index'] ?>">Администрирование</a>
    <?php endif; ?>

    <?php if (!user_is_authenticated()): ?>
        <a class="main-menu-item" href="<?= $named_routes['auth.login'] ?>">Войти в учетную запись</a>
    <?php endif; ?>

    <?php if (user_is_authenticated()): ?>
        <a class="main-menu-item" href="<?= $named_routes['auth.logoff'] ?>">Выйти из учетной записи</a>
    <?php endif; ?>


</div>




