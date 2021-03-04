<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php
        /* Задание 1 */
        $a = 5;
        $b = 7;

        if ($a >= 0 && $b >= 0)
            $result = $a - $b;
        elseif ($a < 0 && $b < 0)
            $result = $a * $b;
        elseif (($a >= 0 && $b < 0) || ($a < 0 && $b>= 0 ))
            $result = $a + $b
    ?>

    <p>Результат задания 1: <?=$result?></p>

    <p>Результат задания 2:</p>
    <?php
        /* Задание 2 */
        $a = 8;
        switch ($a):
            case 1: ?>1<br><?php
            case 2: ?>2<br><?php
            case 3: ?>3<br><?php
            case 4: ?>4<br><?php
            case 5: ?>5<br><?php
            case 6: ?>6<br><?php
            case 7: ?>7<br><?php
            case 8: ?>8<br><?php
            case 9: ?>9<br><?php
            case 10: ?>10<br><?php
            case 11: ?>11<br><?php
            case 12: ?>12<br><?php
            case 13: ?>13<br><?php
            case 14: ?>14<br><?php
            case 15: ?>15<br><?php
        endswitch;
    ?>

    <?php 
        /* Задание 3 */
        function sum($a, $b){
            return $a + $b;
        }
        function sub($a, $b){
            return $a - $b;
        }
        function mult($a, $b){
            return $a * $b;
        }
        function div($a, $b){
            return $a / $b;
        }
    ?>

    <?php 
        /* Задание 4 */
        function mathOperation($arg1, $arg2, $operation){
            switch ($operation){
                case 'sum': return sum($arg1, $arg2);
                case 'sub': return sub($arg1, $arg2);
                case 'mult': return mult($arg1, $arg2);
                case 'div': return div($arg1, $arg2);
            }
        }
    ?>
    <p>Результат задания 4:</p>
    Сложение: <?= mathOperation(3, 5, 'sum')?><br>
    Вычитание: <?= mathOperation(3, 5, 'sub')?><br>
    Умножение: <?= mathOperation(3, 5, 'mult')?><br>
    Деление: <?= mathOperation(3, 5, 'div')?><br>

    <!-- Задание 5 - исключено из содержания работ -->

    <?php
        /* Задание 6 */
        function recursion(&$result, $val, $pow){
            if ($pow < 1) {
                //var_dump($result);
                return $result;
            }
            $result *= $val;
            recursion($result, $val, $pow - 1);
        }

        function power($val, $pow){

            if ($pow == 1) return $val;
            if ($pow == 0) return 0;

            $result = 1;
            recursion($result, $val, $pow);
            return $result;
        }
   ?>
   
   <p>Результат задания 6:</p>
   3 в степени 5: <?= power(3, 5) ?> <br>
   -3 в степени 5: <?= power(-3, 5) ?> <br>

    <?php
        /* Задание 7 */

        $dt = new \DateTime('now', new \DateTimeZone('+0300'));

        $hours = (int)$dt->format('H');
        switch ($hours % 10){
            case 1: $hoursDeclension = 'час'; break;
            case 2: 
            case 3: 
            case 4: $hoursDeclension = 'часа'; break;
            default: $hoursDeclension = 'часов'; 
        }

        $minutes = (int)$dt->format('i');
        switch ($minutes % 10){
            case 1: $minutesDeclension = 'минута'; break;
            case 2: 
            case 3: 
            case 4: $minutesDeclension = 'минуты'; break;
            default: $minutesDeclension = 'минут';
        }
    ?>
    <p>Результат задания 7: <?= $hours.' '.$hoursDeclension.' '.$minutes.' '.$minutesDeclension?></p>

</body>
</html>



