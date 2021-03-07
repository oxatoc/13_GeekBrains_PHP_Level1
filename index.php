<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

<?php
/* Задание 1 */
echo 'Задание 1 <br>';
$index = 0;
do {
    if ($index % 3 == 0) {
        echo $index . ', ';
    }
    $index++;
} while ($index <= 100);
echo '<br><br>';

/* Задание 2 */
echo 'Задание 2 <br>';
$index = 0;
do {
    if ($index == 0) {
        echo $index . ' - ноль.<br>';
    } elseif ($index % 2 == 0) {
        echo $index . ' - четное число.<br>';
    } else {
        echo $index . ' - нечетное число.<br>';
    }
    $index++;
} while ($index <= 10);
echo '<br><br>';

/* Задание 3 */
echo 'Задание 3 <br>';
$regions = [
    'Московская область' => ['Москва', 'Зеленоград', 'Клин']
    , 'Ленинградская область' => ['Санкт-Петербург', 'Всеволжск', 'Павловск', 'Кронштадт']
    , 'Рязанская область' => ['Михайлов', 'Скопин', 'Касимов', 'Шацк']
];

foreach ($regions as $region => $cities) {
    echo $region . ':<br>';
    echo implode(', ', $cities) . '<br>';
}
?>
<br><br>

<?php
/* Задание 4 */
function translit($str)
{
    $translitAray = ['а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e'
        , 'ё' => 'yo', 'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'yi', 'к' => 'k'
        , 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r'
        , 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'ts'
        , 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'stch', 'ы' => 'y', 'э' => 'e'
        , 'ю' => 'yu', 'я' => 'ya'];
    return strtr($str, $translitAray);
}

$str = 'в этом случае, ключи и значения могут иметь любую длину';
?>
Задание 4 <br>
<?= $str ?><br>
<?= translit($str) ?><br>
<br><br>

<?php
/* Задание 5 */
function spacesToUnderlines($str)
{
    return str_replace(' ', '_', $str);
}

$str = 'в этом случае, ключи и значения могут иметь любую длину';
?>
Задание 5<br>
<?= $str ?><br>
<?= spacesToUnderlines($str) ?><br>
<br><br>
<?php
/* Задание 6 */
/* 'Имеющееся меню' - где это меню имеется - из задания непонятно, создаем свое меню */
$menuArray = [
    'MenuItem1' => ['SubMenuItem1-1', 'SubMenuItem1-2', 'SubMenuItem1-3']
    , 'MenuItem2' => ['SubMenuItem2-1', 'SubMenuItem2-2', 'SubMenuItem2-3']
    , 'MenuItem3' => ['SubMenuItem3-1', 'SubMenuItem3-2', 'SubMenuItem3-3']
    , 'MenuItem4' => ['SubMenuItem4-1', 'SubMenuItem4-2', 'SubMenuItem4-3']
];
?>
Задание 6<br>
<ul>
    <?php foreach ($menuArray as $menuItem => $submenus): ?>
        <li>
            <?= $menuItem ?>
            <ul>
                <?php foreach ($submenus as $submenu): ?>
                    <li><?= $submenu ?></li>
                <?php endforeach; ?>
            </ul>
        </li>
    <?php endforeach; ?>
</ul>

<?php
/* Задание 7 */
echo 'Задание 7<br>';
for ($i = 0; $i < 10; print_r($i++)) {
}
?>
<br><br>

<?php
/* Задание 8 */
echo 'Задание 8<br>';

foreach ($regions as $region => $cities) {
    echo $region . ':<br>';
    $filtered = array_filter($cities, function ($item) {
        return mb_substr($item, 0, 1) == 'К';
    });
    echo implode(', ', $filtered) . '<br>';
}
?>
<br><br>
<?php
/* Задание 9 */
function createSlug($str){
    $translitAray = ['а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e'
        , 'ё' => 'yo', 'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'yi', 'к' => 'k'
        , 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r'
        , 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'ts'
        , 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'stch', 'ы' => 'y', 'э' => 'e'
        , 'ю' => 'yu', 'я' => 'ya'];
    $translited = strtr($str, $translitAray);
    return str_replace(' ', '_', $translited);
}
$slug = 'паттерны проектирования';
?>
Задание 9<br>
ключевая фраза: <?=$slug?><br>
slug: <?=createSlug($slug)?><br>


</body>
</html>


