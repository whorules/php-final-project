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
    <title>Fitness Club | Prices</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/reset.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/style.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/grid_12.css">
    <style>
        table {
            width: 50%;
            margin: 20px auto;
            border-collapse: collapse;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 1px solid rgba(0, 0, 0, 0.1);
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="main">
    <div class="bg-img"></div>
    <header>
        <h1><a href="../index.php">Фитнес <strong>клуб.</strong></a></h1>
        <nav>
            <br><br>
            <div class="auth-buttons">
                <?php if ($loggedIn): ?>
                <a href="../registration/logout.php">Выйти</a>
                <?php else: ?>
                <a href="../registration/login.php">Войти</a>
                <?php endif; ?>
            </div>
            <div class="social-icons"><a href="#" class="icon-2"></a> <a href="#" class="icon-1"></a></div>
            <ul class="menu">
                <li><a href="../index.php">О нас</a></li>
                <li><a href="trainings.php">Услуги</a></li>
                <li><a href="../main/orders.php">Записаться</a></li>
                <li class="current"><a href="prices.php">Цены</a></li>
                <li><a href="contacts.php">Контакты</a></li>
            </ul>
        </nav>
    </header>
    <section id="content">
        <div class="container_12">
            <div class="grid_12">
                <div class="box-shadow">
                    <div class="wrap block-2">
                        <h2>Цены на услуги в спортивном комплексе</h2>
                        <table>
                            <tr>
                                <th>Название услуги</th>
                                <th>Цена</th>
                            </tr>
                            <tr>
                                <td>Кардиотренировки</td>
                                <td>4000 руб./месяц</td>
                            </tr>
                            <tr>
                                <td>Йога</td>
                                <td>500 руб./занятие</td>
                            </tr>
                            <tr>
                                <td>Силовые тренировки</td>
                                <td>4500 руб./месяц</td>
                            </tr>
                            <tr>
                                <td>Пилатес</td>
                                <td>600 руб./занятие</td>
                            </tr>
                        </table>
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
