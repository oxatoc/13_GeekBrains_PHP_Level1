<?php

$imagesFolder = 'img';

/* Маршрутизатор в зависимости от метода HTTP */
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    /* Если файл получен, то сохраняем на диске и перенаправляем на ту же страницу*/
    if (!empty($_FILES['file']['tmp_name'])){
        move_uploaded_file($_FILES['file']['tmp_name'], $imagesFolder.'/'.$_FILES['file']['name']);
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
    <script src="/js/app.js" defer></script>

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
/* Поиск всех файлов изображений в каталоге */
$images = array_map(
    function ($path){ return basename($path);}
    , glob($_SERVER['DOCUMENT_ROOT'].'/'.$imagesFolder.'/*.{jpg,png}', GLOB_BRACE)
);
?>
<div class="container-thumbs">
    <?php foreach ($images as $image):?>
        <button type="button" class="button-thumb">
            <img data-href="<?= '/'.$imagesFolder.'/'.$image?>" src="<?='/'.$imagesFolder.'/'.$image?>" alt="image">
        </button>
    <?php endforeach;?>
</div>

<!--Разметка модального окна-->

<div class="container-modal">
    <div>
        <span class="container-modal-close">&times;</span>
    </div>
    <div class="container-modal-img-block">
        <img src="" alt="image" class="container-modal-img">
    </div>
</div>

</body>
</html>


