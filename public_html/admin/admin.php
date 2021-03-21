<!--Загрузка шапки-->
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../templates/header.php'; ?>

<!--Меню добавления товара-->
<div class="sub-menu">
    <a class="sub-menu-item" href="<?=$named_routes['products.create']?>">Добавить товар</a>
</div>

<!--Отображение перечня товаров-->
<table class="excel-table">
    <th>id</th>
    <th>Название</th>
    <th>Изображение</th>
    <th>Цена</th>
    <th></th>
    <th></th>
    <?php
    $sql = 'SELECT id, name, image_uri, price FROM products';
    $rows = dbhelper_get_array($sql);
    foreach ($rows as $row):
        ?>
        <tr>
            <?php foreach ($row as $cell): ?>
                <td><?= $cell ?></td>
            <?php endforeach; ?>
            <td><a href="<?=$named_routes['products.edit'].'?id='.$row['id']?>">редактировать</a></td>
            <td><a href="<?=$named_routes['products.delete'].'?id='.$row['id']?>">удалить</a></td>
        </tr>
    <?php endforeach; ?>
</table>

<!--Загрузка подвала-->
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../templates/footer.php'; ?>