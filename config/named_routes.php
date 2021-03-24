<?php

return [
    'index' => '/'
    , 'catalog.index' => '/catalog.php'
    , 'catalog.images' => '/product.php'
    , 'products.create' => '/admin/createProduct.php'
    , 'products.delete' => '/admin/deleteProduct.php'
    , 'products.edit' => '/admin/editProduct.php'
    , 'products.index' => '/admin/admin.php'
    , 'products.store' => '/admin/editProduct.php'
    , 'products.update' => '/admin/editProduct.php'
    , 'cart.store' => '/cart.php?action=store'
    , 'cart.index' => '/cart.php?action=index'
    , 'cart.destroy' => '/cart.php?action=destroy'
    , 'auth.login' => '/auth.php?action=login' //Показать форму ввода реквизитов
    , 'auth.logoff' => '/auth.php?action=logoff'
    , 'auth.check' => '/auth.php?action=check' //Проверка реквизитов аутентификации
];
