<?php
/* Загрузка общих функций и данных */
require_once $_SERVER['DOCUMENT_ROOT'] . '/../engine/functions.php';

$actions = ['index', 'destroy', 'store'];

if (isset($_GET['action'])) {
    if (in_array($_GET['action'], $actions)){
        $action = $_GET['action'];
    }
}

if (!isset($action)) {
    $action = 'index';
}

if ($action == 'destroy') {
    cart_delete($_GET['id']);
    header('Location: '.$named_routes['cart.index']);
}

/* Добавление товара в корзину */
if ($action == 'store') {

    $product=[];
    foreach ($_POST as $name => $value){
        $product[$name] = escape_for_html($value);
    }
    cart_add($product);
    header('Location: '.$named_routes['catalog.index']);
}


if ($action == 'index'):
    /* Показываем корзину */
    $products = cart_index();

    $total = 0;
    ?>

    <!--Загрузка шапки-->
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../templates/header.php'; ?>


    <table class="excel-table">
        <tr>
            <th>Изображение</th>
            <th>Название</th>
            <th>Цена</th>
            <th>Количество</th>
            <th>Стоимость</th>
            <th>Удалить</th>
        </tr>

        <?php
        foreach ($products as $product):

            settype($product['quantity'], 'float');
            settype($product['price'], 'float');

            $sum = $product['quantity'] * $product['price'];
            $total += $sum;
            ?>
            <tr>
                <td><img class="thumbnail" src="<?= $product['image_uri'] ?>" alt="image"></td>
                <td><?= $product['name'] ?></td>
                <td><?= $product['price'] ?></td>
                <td><?= $product['quantity'] ?></td>
                <td><?= $sum ?></td>
                <td><a href="<?= $named_routes['cart.destroy'].'&id='.$product['id']?>">Удалить</a></td>
            </tr>
        <?php endforeach ?>
    </table>
    <span>Полная стоимость: <?= $total ?></span>
<?php endif; ?>

    <!--Загрузка подвала-->
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../templates/footer.php'; ?>