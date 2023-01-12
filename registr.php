<?php
require_once __DIR__ . '/func.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = test_input($_POST['login']);
    $password = test_input($_POST['password']);
    $dateBirthday = test_input($_POST['date-birthday']);
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$newUser = ['login' => $_POST['login'], 'password' => password_hash($_POST['password'], PASSWORD_DEFAULT), 'date-birthday' => $_POST['date-birthday']];

if (addUserToList($newUser) == true) {
            header('Location: /message.php');
        } else {
            header('Location: /error.php');
        }
