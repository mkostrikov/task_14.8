<?php

function existsUser(string $login): bool
{
    require __DIR__ . '/usersDB.php';
    foreach ($users as $user) {
        if ($user['login'] === $login) {
            return true;
        }
    }
    return false;
}

function checkPassword(string $login, string $password): bool
{
    require __DIR__ . '/usersDB.php';
    foreach ($users as $user) {
        if ($user['login'] === $login && password_verify($password, $user['password'])) {
            return true;
        }
    }
    return false;
}

// function getCurrentUser(): ?string {
//     $loginFromCookie = $_COOKIE['login'] ?? '';
//     $passwordFromCookie = $_COOKIE['password'] ?? '';
// }

// display tabContents
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

function getServiceTitle(array $service)
{
    $title = $service['title'];
    echo "$title";
}

function displayTabContents(array $services)
{
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
function displayTabLinks(array $services)
{
    $id = 0;
    foreach ($services as $service) {
        echo "<li><a class='menu__tablink' id='$id'>";
        getServiceTitle($service);
        echo '</a></li>';
        $id += 1;
    }
}
