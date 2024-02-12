<?php

function redirect($url) {
    header("Location: $url");
    die();
}

function view($name, $model = '') {
    global $view_bag;
    require(APP_PATH . "views/layout.view.php");
}

function is_get() {
    return $_SERVER['REQUEST_METHOD'] === 'GET';
}

function is_post() {
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

function sanitize($value) {
    $temp = filter_var(trim($value), FILTER_UNSAFE_RAW);

    if ($temp === false) {
        return '';
    }

    return $temp;
}

function authenticate_user($email, $password) {
    $admin = CONFIG['admin'];

    if (!isset($admin[$email])) {
        return false;
    }

    $user_password = $admin[$email];
    
    return $password == $user_password;
}

function registrate_user($name, $email, $password, $phone, $apartment, $floor) {
    $users = CONFIG['users'];

    // Проверяем, существует ли пользователь с таким email
    if (!isset($users[$email])) {
        return false;
    }

    // Получаем данные пользователя по email
    $user = $users[$email];

    // Сравниваем пароль, телефон, квартиру и этаж с данными пользователя
    return 
    $name == $user['name'] && 
    $password == $user['password'] &&
    $phone == $user['phone'] &&
    $apartment == $user['apartment'] &&
    $floor == $user['floor'];
}

function is_user_authenticated() {
    return isset($_SESSION['email']);
}

function ensure_user_is_authenticated() {
    if (!is_user_authenticated()) {
      redirect('../login.php');
    }
}
