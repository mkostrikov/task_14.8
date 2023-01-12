<?php
require_once __DIR__ . '/func.php';

if (addUserToList() == true) {
            header('Location: /message.php');
        } else {
            header('Location: /error.php');
        }

// $filter = [
//     'login' => array(
//         'filter' => FILTER_VALIDATE_REGEXP,
//         'options' => array('regexp' => '/[W]/i')
//     ),
//     'password' => array(
//         'filter' => FILTER_VALIDATE_REGEXP,
//         'options' => array('regexp' => '/[a-z0-9@*]/i')
//     )
// ];

// $postFilter = filter_input_array(INPUT_POST, $filter);
// $postFilterValues = array_values($postFilter);
// $result = in_array(false, $postFilterValues, true);

// if (!$result) {
//     if (addUserToList() == true) {
//         header('Location: /message.php');
//     } else {
//         header('Location: /error.php');
//     }
// }

