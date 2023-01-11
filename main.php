<?php
require_once __DIR__ . '/func.php';

session_start();

$auth = $_SESSION['auth'] ?? null;
if ($auth === null) {
    header('Location: /index.php');
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>SPA-salon</title>
</head>

<body>
    <!-- header -->
    <header class="header">
        <div class="header__bar"></div>
        <div class="logo">SPA</div>
        <div class="header__user-bar">
            <span class="user-login">Привет, <?=getCurrentUser();?>.</span>
            <form action="/log_off.php" method="post">
                <button class="header__button header__button_">Выйти</button>
            </form>
        </div>
    </header>
    <div class="alert">
        <?php
        // echo $_SESSION['entrytime'] . PHP_EOL;
        // echo date('H:i:s') . PHP_EOL;
        echo timeLeft($_SESSION['entrytime']) . PHP_EOL;
        
        ?>
    </div>
    <div class="page">
        <!-- menu -->
        <div class="menu">
            <h2 class="menu__title">SPA-меню</h2>
            <ul class="menu__tablinks">
                <?= displayTabLinks(); ?>
            </ul>
        </div>
        <div class="main">
            <ul class="services-list">
                <?= displayTabContents(); ?>
            </ul>
            <!-- slideshow -->
            <section class="slideshow">
                <div class="container">
                    <div class="slideshow__switch slideshow__switch_prev">
                        <a>&#10094;</a>
                    </div>
                    <div class="slideshow__slide fade">
                        <img src="img/1.webp">
                    </div>

                    <div class="slideshow__slide fade">
                        <img src="img/2.webp">
                    </div>

                    <div class="slideshow__slide fade">
                        <img src="img/3.webp">
                    </div>

                    <div class="slideshow__switch slideshow__switch_next">
                        <a>&#10095;</a>
                    </div>
                </div>
                <div class="slideshow__dots">
                    <span class="dot" id="0"></span>
                    <span class="dot" id="1"></span>
                    <span class="dot" id="2"></span>
                </div>
            </section>

        </div>
        <!-- feedback -->
        <div class="feedback">
            <h2 class="feedback__title">Отзывы</h2>
        </div>
    </div>
    <footer class="footer">
        <div class="copyright">&#169; SPA 2023</div>
        <div class="icons">
            <div class="icon"><img src="img/vk.svg"></div>
            <div class="icon"><img src="img/tg.svg"></div>
        </div>
        <div class="address">
            <span class="addr">ул. Ленина, д. 1</span>
            <span class="tel">+7(000)000-00-00</span>
        </div>
    </footer>


    <script src="main.js"></script>
</body>

</html>