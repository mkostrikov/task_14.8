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

function getUserBithdayDate()
{
    $usersList = getUsersList();
    foreach ($usersList as $user) {
        if (getCurrentUser() === $user['login']) {
            return substr($user['date-birthday'], 5);
        }
    }
}

function checkBithday($bithday): bool
{
    if (substr(date('Y-m-d'), 5) === $bithday) {
        return true;
    }
    return false;
}

function daysBeforeBithday($bithday)
{
    $numBithday = numDayInYear($bithday);
    $numToday = numDayInYear(date('m-d'));
    if ($numBithday > $numToday) {
        $daysBeforeBithday = $numBithday - $numToday;
        return $daysBeforeBithday;
    }
    return false;
}

function numDayInYear($date)
{
    $currentYear = (int) date('Y');
    if ($currentYear % 4 === 0) {
        $daysInMonths = [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
    } else {
        $daysInMonths = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
    }
    $monthAndDay = (explode('-', $date));
    $sumDaysInMonth = 0;
    for ($i = 1; $i < (int) $monthAndDay[0]; $i += 1) {
        $sumDaysInMonth += $daysInMonths[$i - 1];
    }
    $numDay = $sumDaysInMonth + (int) $monthAndDay[1];
    return $numDay;
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
function displayTabContents($promo, $checkBithday)
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
        displayServicePriceList($service, $promo, $checkBithday);
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

function displayTabLinks($promo, $checkBithday)
{
    $services = getServices();
    $id = 0;
    foreach ($services as $service) {
        $title = getServiceTitle($service);
        if ($promo !== null && $title === $promo) {
            if ($checkBithday === true) {
                $aClass = 'promo_bithday';
            } else {
                $aClass = 'promo';
            }
            echo "<li><a class='menu__tablink $aClass' id='$id'>";
            echo getServiceTitle($service);
            echo '</a></li>';
            $id += 1;
        } else {
            if ($checkBithday === true) {
                $aClass = 'bithday';
            } else {
                $aClass = '';
            }
            echo "<li><a class='menu__tablink $aClass' id='$id'>";
            echo getServiceTitle($service);
            echo '</a></li>';
            $id += 1;
        }
    }
}

function displayServicePriceList($service, $promo, $checkBithday)
{
    $priceList = $service['price-list'];
    if ($promo !== null && getServiceTitle($service) === $promo) {
        if ($checkBithday === true) {
            $k = 0.2 + 0.05;
            $divClass = 'service__price_promo_bithday';
        } else {
            $k = 0.2;
            $divClass = 'service__price_promo';
        }
        foreach ($priceList as $p) {
            $duration = (float) $p['duration'];
            $price = (float) $p['price'];
            $promoPrice = (float) $p['price'] - (float) $p['price'] * $k;
            $priceFormat = number_format($price, 0, '.', ',');
            $promoPriceFormat = number_format($promoPrice, 0, '.', ',');
            if ($duration < 1) {
                $duration = $duration * 60;
                echo "<div class=$divClass><p><span>$duration мин</span><br> <span>$promoPriceFormat &#8381;</span><br></p></div>";
            } elseif ($duration == 1) {
                echo "<div class=$divClass><p><span>$duration час</span><br> <span>$promoPriceFormat &#8381;</span><br></p></div>";
            } elseif ($duration > 1 && $duration < 5) {
                echo "<div class=$divClass><p><span>$duration часа</span><br> <span>$promoPriceFormat &#8381;</span></p></div>";
            } else {
                echo "<div class=$divClass><p><span>$duration часов</span><br> <span>$promoPriceFormat &#8381;</span></p></div>";
            }
        }
    } else {
        if ($checkBithday === true) {
            $k = 0.05;
            $divClass = 'service__price_bithday';
        } else {
            $k = 0;
            $divClass = 'service__price';
        }
        foreach ($priceList as $p) {
            $duration = (float) $p['duration'];
            $price = (float) $p['price'] - (float) $p['price'] * $k;
            $priceFormat = number_format($price, 0, '.', ',');
            if ($duration < 1) {
                $duration = $duration * 60;
                echo "<div class=$divClass><p>$duration мин<br> $priceFormat &#8381;</p></div>";
            } elseif ($duration == 1) {
                echo "<div class=$divClass><p>$duration час<br> $priceFormat &#8381;</p></div>";
            } elseif ($duration > 1 && $duration < 5) {
                echo "<div class=$divClass><p>$duration часа<br> $priceFormat &#8381;</p></div>";
            } else {
                echo "<div class=$divClass><p>$duration часов<br> $priceFormat &#8381;</p></div>";
            }
        }
    }
}

// promo
function timeLeft(string $entryTime): int
{
    $currentTime = timeToSeconds(date('H:i:s'));
    $startTime = timeToSeconds($entryTime) + 86400;
    $timeLeft = $startTime - $currentTime;
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
