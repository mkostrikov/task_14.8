<?php
require_once __DIR__ . '/func.php';

if (!empty($_POST)) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    if (checkPassword($login, $password) === true) {
        setcookie('login', $login, 0, '/');
        setcookie('password', $password, 0, '/');
        header('Location: /main.php');
    } else {
        $error = 'Ошибка авторизации';
        echo $error;
        header('Refresh: 2; url=/index.php');
    }
}