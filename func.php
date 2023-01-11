<?php

function getUsersList()
{
    $usersList = json_decode(file_get_contents(__DIR__ . '/data'), true);
    return $usersList;
}

function existsUser($login): bool
{
    $usersList = getUsersList();
    foreach ($usersList as $user) {
        if ($user['login'] === $login) {
            return true;
        }
    }
    return false;
}

function checkPassword($login, $password): bool
{
    $usersList = getUsersList();
    if (existsUser($login) === true) {
        foreach ($usersList as $user) {
            if ($user['login'] === $login && password_verify($password, $user['password'])) {
                return true;
            }
        }
    }
    return false;
}

function getCurrentUser()
{
    $loginFromSession = $_SESSION['login'];
    $passwordFromSession = $_SESSION['password'];
    if (checkPassword($loginFromSession, $passwordFromSession)) {
        return $loginFromSession;
    }
    return null;
}


function addUserToList()
{
    $usersList = getUsersList();
    $newUser = ['login' => $_POST['login'], 'password' => password_hash($_POST['password'], PASSWORD_DEFAULT), 'date-birthday' => $_POST['date-birthday']];
    $usersList[] = $newUser;
    $usersListJSON = json_encode($usersList);
    return file_put_contents(__DIR__ . '/data', $usersListJSON, LOCK_EX);
}

// display services
function displayTabContents($promo)
{
    $services = getServices();
    foreach ($services as $service) {
        $title = getServiceTitle($service);
        $description = $service['description'];
        $content = <<<CNT
                    <li class="services-list__item hidden">
                    <div class="service__info">
                    <div class="service__title"><h1>$title</h1></div>
                    <div class='service__description'><p>$description</p></div>
                    <div class="service__prices">
                    CNT;
        echo $content;
        displayServicePriceList($service, $promo);
        echo '</div></div></li>';
    }
}

function getServices()
{
    return json_decode(file_get_contents(__DIR__ . '/services'), true);
}

function getServiceTitle(array $service)
{
    return $service['title'];
}

function getRandomService()
{
    return getServices()[rand(0, count(getServices()) - 1)];
}

function displayTabLinks($promo)
{
    $services = getServices();
    $id = 0;
    foreach ($services as $service) {
        $title = getServiceTitle($service);
        if ($promo !== null && $title === $promo) {
            echo "<li><a class='menu__tablink promo' id='$id'>";
            echo getServiceTitle($service);
            echo '</a></li>';
            $id += 1;
        } else {
            echo "<li><a class='menu__tablink' id='$id'>";
            echo getServiceTitle($service);
            echo '</a></li>';
            $id += 1;  
        }
    }
}

function displayServicePriceList($service, $promo)
{
    $priceList = $service['price-list'];
    if ($promo !== null && getServiceTitle($service) === $promo) {
        foreach($priceList as $p) {
            $duration = (float) $p['duration'];
            $price = (float) $p['price'];
            $promoPrice = (float) $p['price'] - (float) $p['price'] * 0.2;
            $priceFormat = number_format($price, 0, '.', ',');
            $promoPriceFormat = number_format($promoPrice, 0, '.', ',');
            if ($duration < 1) {
                $duration = $duration * 60;
                echo "<div class='service__price_promo'><p><span>$duration мин</span><br> <span>$promoPriceFormat &#8381;</span><br><del>$priceFormat &#8381;</del></p></div>";
            } elseif ($duration == 1) {
                echo "<div class='service__price_promo'><p><span>$duration час</span><br> <span>$promoPriceFormat &#8381;</span><br><del>$priceFormat &#8381;</del></p></div>";
            } elseif ($duration > 1 && $duration < 5) {
                echo "<div class='service__price_promo'><p><span>$duration часа</span><br> <span>$promoPriceFormat &#8381;</span><br><del>$priceFormat &#8381;</del></p></div>";
            } else {
                echo "<div class='service__price_promo'><p><span>$duration часов</span><br> <span>$promoPriceFormat &#8381;</span><br><del>$priceFormat &#8381;</del></p></div>";
            }
        }
    } else {
        foreach($priceList as $p) {
            $duration = (float) $p['duration'];
            $price = (float) $p['price'];
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
}

// promo
function timeLeft(string $entryTime): int
{
    $currentTime = timeToSeconds(date('H:i:s'));
    $startTime = timeToSeconds($entryTime);
    $dayTime = 24 * 3600;
    $timeLeft = $startTime + $dayTime - $currentTime;
    return $timeLeft;
}

function timeToSeconds(string $time): int
{
    $parts = explode(':', $time);
    $seconds = (int) $parts[0] * 3600 + (int) $parts[1] * 60 + (int) $parts[2];
    return $seconds;
}

function secondsToTime(int $seconds): string
{
    $h = intdiv($seconds, 3600);
    $m = intdiv($seconds % 3600, 60);
    $s = $seconds % 3600 % 60;
    if ($h < 10) {
        $strH = '0' . (string) $h;
    } else {
        $strH = (string) $h;
    }
    if ($m < 10) {
        $strM = '0' . (string) $m;
    } else {
        $strM = (string) $m;
    }
    if ($s < 10) {
        $strS = '0' . (string) $s;
    } else {
        $strS = (string) $s;
    }
    return "$strH:$strM:$strS";
}
