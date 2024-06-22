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
    <title>Fitness Club | Contacts</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/reset.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/style.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/grid_12.css">
</head>
<body>
<div class="main">
    <div class="bg-img"></div>
    <header>
        <h1><a href="../index.php">Фитнес <strong>клуб.</strong></a></h1>
        <br/><br/>
        <div class="auth-buttons">
            <?php if ($loggedIn): ?>
            <a href="../registration/logout.php">Выйти</a>
            <?php else: ?>
            <a href="../registration/login.php">Войти</a>
            <?php endif; ?>
        </div>
        <nav>
            <div class="social-icons"><a href="#" class="icon-2"></a> <a href="#" class="icon-1"></a></div>
            <ul class="menu">
                <li><a href="../index.php">О нас</a></li>
                <li><a href="trainings.php">Услуги</a></li>
                <li><a href="../main/orders.php">Записаться</a></li>
                <li><a href="prices.php">Цены</a></li>
                <li class="current"><a href="contacts.php">Контакты</a></li>
            </ul>
        </nav>
    </header>
    <section id="content">
        <div class="container_12">
            <div class="grid_12">
                <div class="box-shadow">
                    <div class="wrap block-2">
                        <div class="col-3">
                            <h2><span class="color-1">Найдите</span> нас</h2>
                            <div class="map img-border">
                                <iframe src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Saint+Petersburg,+Russia&amp;aq=0&amp;sll=37.0625,-95.677068&amp;sspn=61.282355,146.513672&amp;ie=UTF8&amp;hq=&amp;hnear=Saint+Petersburg,+Russia&amp;ll=59.9342802,30.3350986&amp;spn=0.01628,0.025663&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe>
                            </div>
                            <dl>
                                <dt class="color-1"><strong>ул. Политехническая, 29,<br>
                                    Санкт-Петербург, 195251</strong></dt>
                                <dd><span>Freephone: </span>+7 800 600 6000</dd>
                                <dd><span>Telephone: </span>+7 800 600 6001</dd>
                                <dd><span>Fax: </span>+7 800 889 9898</dd>
                                <dd><span>E-mail: </span><a href="mailto:korovko@spbstu.ru" class="link">korovko@spbstu.ru</a></dd>
                            </dl>
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
