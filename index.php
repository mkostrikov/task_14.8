<?php
$servicesDB = file_get_contents(__DIR__ . '/services.json');
$services = json_decode($servicesDB, true);
require_once __DIR__ . '/func.php';
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
    <?php
    require __DIR__ . '/header/header.php';
    ?>
    <div class="prompt">
        <p>Зарегистрируйтесь, чтобы учавствовать в акции по случаю дня рождения и получать индивидуальные скидки и предложения.</p>
    </div>
    <div class="page">
        <!-- menu -->
        <?php
        require __DIR__ . '/menu/menu.php';
        ?>
        <div class="main">
            <ul class="services-list">
                <?= displayTabContents($services) ?>
            </ul>
            <!-- slideshow -->
            <?php
            require __DIR__ . '/slideshow/slideshow.php';
            ?>

        </div>
        <!-- feedback -->
        <?php
        require __DIR__ . '/feedback/feedback.php';
        ?>
    </div>
    <?php
    require __DIR__ . '/footer/footer.php';
    ?>

    <script src="script.js"></script>
</body>

</html>