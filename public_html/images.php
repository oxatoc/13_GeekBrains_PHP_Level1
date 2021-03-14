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

<a href="/">На клавную страницу</a>

<?php

$dbconfig = include $_SERVER['DOCUMENT_ROOT'].'/../config/db.php';
$link = mysqli_connect($dbconfig['servername'], $dbconfig['username'], $dbconfig['password'], $dbconfig['database']);

/* Читаем запись изоюражения из базы данных */
$result = mysqli_query($link, "SELECT * FROM gallery WHERE id = {$_GET['id']}");
$row = mysqli_fetch_assoc($result);

/* Увеличиваем количество просмотров */
$sql = 'UPDATE gallery SET views_count = '.($row['views_count'] + 1).' WHERE id = '.$_GET['id'];
$result = mysqli_query($link, $sql);

if (!$result){
    die(mysqli_error($link));
}

mysqli_close($link);
?>

<div class="full-image">
    <img src="<?=$row['address']?>" alt="image">
</div>


</body>
</html>


