<?php
/* Контроллер авторизации */

/* Загрузка общих функций и данных */
require_once $_SERVER['DOCUMENT_ROOT'] . '/../engine/functions.php';

$actions = ['check', 'login', 'logoff'];

if (isset($_GET['action'])) {
    if (in_array($_GET['action'], $actions)){
        $action = $_GET['action'];
    }
}

if (!isset($action)) {
    header('Location: '.$named_routes['index']);
    exit;

}

if ($action == 'logoff'){
    unset($_SESSION['user_role']);
    header('Location: '.$named_routes['index']);
    exit;
}

if ($action == 'check'){
    /* Проверка введенных реквизитов */

    /* Если имя пользователя не указано, то перенаправляем на страницу аутентификации */
    if (!isset($_POST['name'])){
        header('Location: '.$named_routes['auth.login']);
        exit;
    }

    $user_array = dbhelper_get_user($_POST['name']);

    if (!$user_array){
        /* Если пользователь не найден, то перенаправляем на страницу аутентификации */
        header('Location: '.$named_routes['auth.login']);
        exit;
    }

    if (!password_verify($_POST['password'], $user_array['password'])){
        /* Если пароль не совпадает, то перенаправляем на страницу аутентификации */
        header('Location: '.$named_routes['auth.login']);
        exit;
    }


    /* Если пользователь прошел аутентификацию, то сохраняем роль в сессии */
    $_SESSION['user_role'] = $user_array['role'];
    header('Location: '.$named_routes['index']);
}

/* Отображаем форму авторизации */
?>
<!--Загрузка шапки-->
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../templates/header.php'; ?>

    <form action="<?= $named_routes['auth.check'] ?>" method="post">
        <label for="name">Имя учетной записи</label>
        <input type="text" name="name" id="name">
        <label for="password">Пароль</label>
        <input type="password" name="password" id="password">
        <button type="submit">Отправить</button>
    </form>

    <!--Загрузка подвала-->
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../templates/footer.php'; ?>