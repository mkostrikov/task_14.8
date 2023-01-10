<?php

function getUsersList () {
    $usersList = json_decode(file_get_contents(__DIR__ . '/data'), true);
    return $usersList;
}

function existsUser ($login):bool {
    $usersList = getUsersList ();
    foreach($usersList as $user) {
        if ($user['login'] === $login) {
            return true;
        }
    }
    return false;
}

function checkPassword ($login, $password):bool {
    $usersList = getUsersList ();
    if (existsUser($login) === true) {
        foreach($usersList as $user) {
            if ($user['login'] === $login &&  $user['password'] === $password) {
                return true;
            }
        }
    }
    return false;
}

function getCurrentUser () {
    $loginFromCookie = $_COOKIE['login'];
    $passwordFromCookie = $_COOKIE['password'];
    if (checkPassword($loginFromCookie, $passwordFromCookie)) {
        return $loginFromCookie;
    }
    return null;
}


function addUserToList () {
    $usersList = getUsersList();
    $newUser = ['login' => $_POST['login'], 'password' => $_POST['password'], 'date-birthday' => $_POST['date-birthday']];
    $usersList[] = $newUser;
    $usersListJSON = json_encode($usersList);
    file_put_contents(__DIR__ . '/data', $usersListJSON, LOCK_EX);
}

// display services
function displayTabContents()
{
    $servicesDB = file_get_contents(__DIR__ . '/services');
    $services = json_decode($servicesDB, true);
    foreach ($services as $service) {
        $description = $service['description'];
        echo '<li class="services-list__item hidden">';
        echo '<div class="service__info">';
        echo '<div class="service__title"><h1>';
        getServiceTitle($service);
        echo '</h1></div>';
        echo "<div class='service__description'><p>$description</p></div>";
        echo '<div class="service__prices">';
        getServicePrice($service['price-list']);
        echo '</div>';
        echo '</div>';
        echo '</li>';
    }
}

// display tabLinks
function displayTabLinks()
{
    $servicesDB = file_get_contents(__DIR__ . '/services');
    $services = json_decode($servicesDB, true);
    $id = 0;
    foreach ($services as $service) {
        echo "<li><a class='menu__tablink' id='$id'>";
        getServiceTitle($service);
        echo '</a></li>';
        $id += 1;
    }
}

function getServiceTitle(array $service)
{
    $title = $service['title'];
    echo "$title";
}

function getServicePrice(array $prices)
{
    foreach ($prices as $price) {
        $duration = (float) $price['duration'];
        $price = (float) $price['price'];
        $priceFormat = number_format($price, 0, '.', ',');
        if ($duration < 1) {
            $duration = $duration * 60;
            echo "<div class='service__price'><p>$duration мин<br> $priceFormat &#8381;</p></div>";
        } elseif ($duration == 1) {
            echo "<div class='service__price'><p>$duration час<br> $priceFormat &#8381;</p></div>";
        } elseif ($duration > 1 && $duration < 5) {
            echo "<div class='service__price'><p>$duration часа<br> $priceFormat &#8381;</p></div>";
        } else {
            echo "<div class='service__price'><p>$duration часов<br> $priceFormat &#8381;</p></div>";
        }
    }
}
