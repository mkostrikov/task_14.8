<?php

session_start();

$auth = $_SESSION['auth'] ?? null;

if ($auth === true) {
    $_SESSION = [];
    $_COOKIE = [];
    header('Location: /index.php');
}
