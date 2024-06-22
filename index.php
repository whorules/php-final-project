<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    $loggedIn = false;
} else {
    $loggedIn = true;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Fitness Club</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" media="screen" href="css/reset.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/grid_12.css">
</head>
<body>
<div class="main">
    <div class="bg-img"></div>
    <header>
        <h1><a href="index.php">Фитнес<strong>клуб.</strong></a></h1>
        <br/><br/>
        <div class="auth-buttons">
            <?php if ($loggedIn): ?>
            <a href="registration/logout.php">Выйти</a>
            <?php else: ?>
            <a href="registration/login.php">Войти</a>
            <?php endif; ?>
        </div>
        <nav>
            <ul class="menu">
                <li class="current"><a href="index.php">О нас</a></li>
                <li><a href="html/trainings.php">Услуги</a></li>
                <li><a href="main/orders.php">Записаться</a></li>
                    <li><a href="html/prices.php">Цены</a></li>
                    <li><a href="html/contacts.php">Контакты</a></li>
            </ul>
        </nav>
    </header>
    <section id="content">
        <div class="container_12">
            <div class="grid_12 top-1">
                <div class="block-1 box-shadow">
                    <p class="font-3">Добро пожаловать в наш спортивный комплекс! Мы предлагаем современные тренажерные
                        залы, разнообразные групповые занятия и индивидуальные тренировки для всех уровней подготовки.
                        Наша миссия — помочь вам достичь ваших фитнес-целей в дружелюбной и поддерживающей атмосфере.
                        Присоединяйтесь к нам и начните свой путь к здоровому образу жизни уже сегодня!</p>
                </div>
            </div>
            <div class="grid_12 top-1">
                <div class="box-shadow">
                    <div class="wrap block-2">
                        <div class="col-1">
                            <h2 class="p3"><span class="color-1">Последние</span> события</h2>
                            <div class="wrap box-1"><img src="images/page1-img1.jpg" alt=""
                                                         class="img-border img-indent">
                                <div class="extra-wrap">
                                    <p class="p2"><strong>Йога на свежем воздухе</strong></p>
                                    <p>На прошлой неделе в нашем спортивном комплексе прошло захватывающее занятие по
                                        йоге на свежем воздухе. Участники насладились расслабляющими асанами под
                                        руководством опытного инструктора, погружаясь в гармонию с природой и обретая
                                        внутреннее спокойствие. Присоединяйтесь к нам на следующем занятии, чтобы
                                        испытать баланс тела и души!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </section>
    <footer>
        <p>© 2024 Фитнес клуб</p>
    </footer>
</div>
</body>
</html>
