
<?php

/*
Выполнены пункты 1-4 домашнего задания урока 5 курса PHP Уровень 1:
- добавлена миграция создания таблицы '20210314_create_tables.sql'
- создан конфигурационный файл 'db.php' с реквизитами подключения к базе данных
- в маршрутизаторе добавлен код записи в базу данных строки с данными загруженного изображения
- изображения предварительного просмотра показываются ссылками на файлы из полей базы данных
- добавлена страница 'images.php' для отображения полноразмерных изображений
- добавлен счетчик количества просмотров
- изображения предварительного просмотра отсортированы по убыванию количества просмотров
 */

$imagesFolder = 'img';

/* Маршрутизатор в зависимости от метода HTTP */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    /* Если файл получен, то сохраняем на диске, добавляем запись в базу данных и перенаправляем на ту же страницу*/
    if (!empty($_FILES['file']['tmp_name'])) {
        $image = basename($_FILES['file']['name']);
        $address = $imagesFolder . '/' . $image;
        move_uploaded_file($_FILES['file']['tmp_name'], $address);
        /* Запись в базу данных */
        $dbconfig = include $_SERVER['DOCUMENT_ROOT'].'/../config/db.php';
        $link = mysqli_connect($dbconfig['servername'], $dbconfig['username'], $dbconfig['password'], $dbconfig['database']);
        if (!$link) {
            die(mysqli_connect_error($link));
        }
        $sql = "INSERT INTO gallery (`address`, `size`, `name`) VALUES ('$address', " . filesize($address) . ", '$image') ON DUPLICATE KEY UPDATE name = '$image'";
        $result = mysqli_query($link, $sql);
        if (!$result) {
            die(mysqli_error($link));
        }
        mysqli_close($link);
    }
    header('Location: /');
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/app.css">

</head>
<body>

<!--Форма загрузки изображений-->
<form action="/" enctype="multipart/form-data" method="post">
    <label for="file-input">Выберите файл</label>
    <input type="file" name="file" id="file-input" accept=".png, .jpg">
    <button type="submit">Отправить</button>
</form>

<!--Отображение уменьшенных изображений-->
<?php

$dbconfig = include $_SERVER['DOCUMENT_ROOT'].'/../config/db.php';
$link = mysqli_connect($dbconfig['servername'], $dbconfig['username'], $dbconfig['password'], $dbconfig['database']);

$result = mysqli_query($link, "SELECT * FROM gallery ORDER BY views_count DESC");
?>
<div class="container-thumbnails">
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div>
            <a href="/images.php?id=<?= $row['id'] ?>">
                <img src="<?= $row['address'] ?>" alt="image">
            </a>
            <div>Число просмотров: <?= $row['views_count'] ?></div>
        </div>
    <?php endwhile; ?>
</div>
<?php mysqli_close($link); ?>

</body>
</html>


