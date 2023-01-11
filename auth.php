<?php
require_once __DIR__ . '/func.php';


$login = $_POST['login'];
$password = $_POST['password'];
if (checkPassword($login, $password) === true) {
    session_start();
    $_SESSION['auth'] = true;  
    $_SESSION['login'] = $login;
    $_SESSION['password'] = $password;
    $_SESSION['entrytime'] = date('H:i:s');
    $_SESSION['promo'] = getServiceTitle(getRandomService());
} 

$auth = $_SESSION['auth'] ?? null;

if ($auth === true) {
    header('Location: /index.php');
} else {
    header('Location: /error.php');
}
