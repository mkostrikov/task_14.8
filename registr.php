<?php
require_once __DIR__ . '/func.php';


addUserToList();
echo 'Успешно.';
header('Refresh: 1; url=/index.php');