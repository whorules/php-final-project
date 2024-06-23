<?php
header('Content-Type: text/html; charset=utf-8');
include('server.php');
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
    <link rel="stylesheet" type="text/css" media="screen" href="../css/reset.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/style.css">
    <link rel="stylesheet" type="text/css" media="screen" href="style.css">
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
            <a href="logout.php">Выйти</a>
            <?php else: ?>
            <a href="login.php">Войти</a>
            <?php endif; ?>
        </div>
        <nav>
            <div class="social-icons"><a href="#" class="icon-2"></a> <a href="#" class="icon-1"></a></div>
            <ul class="menu">
                <li><a href="../index.php">О нас</a></li>
                <li><a href="../html/trainings.php">Услуги</a></li>
                <li class="current"><a href="index.php">Записаться</a></li>
                <li><a href="../html/prices.php">Цены</a></li>
                <li><a href="../html/contacts.php">Контакты</a></li>
            </ul>
        </nav>
    </header>
    <section id="content">
        <div class="header">
            <h2>Регистрация</h2>
        </div>

        <form method="post" action="register.php">
            <?php include('errors.php'); ?>
            <div class="input-group">
                <label>Логин</label>
                <input type="text" name="username" value="<?php echo $username; ?>">
            </div>
            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" value="<?php echo $email; ?>">
            </div>
            <div class="input-group">
                <label>Пароль</label>
                <input type="password" name="password_1">
            </div>
            <div class="input-group">
                <label>Подтвердите пароль</label>
                <input type="password" name="password_2">
            </div>
            <div class="input-group">
                <button type="submit" class="btn" name="reg_user">Зарегистрироваться</button>
            </div>
            <p>
                Уже зарегистрированы? <a href="login.php">Войти</a>
            </p>
        </form>
    </section>
    <footer>
        <p>© 2024 Фитнес клуб</p>
    </footer>
</div>
</body>
</html>
