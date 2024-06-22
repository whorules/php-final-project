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
<title>Fitness Club | Trainings</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" media="screen" href="../css/reset.css">
<link rel="stylesheet" type="text/css" media="screen" href="../css/style.css">
<link rel="stylesheet" type="text/css" media="screen" href="../css/grid_12.css">
</head>
<body>
<div class="main">
  <div class="bg-img"></div>
  <header>
    <h1><a href="../index.php">Фитнес<strong>клуб.</strong></a></h1>
    <br/><br/>
    <div class="auth-buttons">
        <?php if ($loggedIn): ?>
        <a href="../registration/logout.php">Выйти</a>
        <?php else: ?>
        <a href="../registration/login.php">Войти</a>
        <?php endif; ?>
     </div>
    <nav>
      <ul class="menu">
        <li><a href="../index.php">О нас</a></li>
        <li class="current"><a href="trainings.php">Услуги</a></li>
        <li><a href="../main/orders.php">Записаться</a></li>
        <li><a href="prices.php">Цены</a></li>
        <li><a href="contacts.php">Контакты</a></li>
      </ul>
    </nav>
  </header>
  <section id="content">
    <div class="container_12">
      <div class="grid_12">
        <div class="box-shadow">
          <div class="wrap block-2">
            <div class="col-3">
              <h2 class="p3"><span class="color-1">Основные</span> программы</h2>
              </br>
              <p class="p4">Откройте мир фитнеса с нашим разнообразным выбором – от йоги и пилатеса до интенсивных кардио и силовых тренировок.
              </p>
              <ul class="list-2 p5">
                <li><a href="#">Кардиотренировки</a></li>
                <li><a href="#">Йога</a></li>
                <li><a href="#">Силовые тренировки</a></li>
                <li><a href="#">Пилатес</a></li>
              </ul>
              <p>Наши тренировки подходят для всех уровней подготовки.</p>
              <a href="#" class="button top-3">Узнать больше</a> </div>
            <div class="col-4">
              <h2 class="p3"><span class="color-1">Наши</span> тренировки</h2>
              <p class="p2"><strong>Персонализированный подход к вашему фитнесу</strong></p>
              <p>Откройте для себя наши индивидуальные и групповые тренировки, специально разработанные для достижения ваших целей. Независимо от вашего уровня подготовки наши профессиональные тренеры помогут вам раскрыть ваш потенциал и достичь результатов, которые вы заслуживаете. .</p>
              <div class="wrap box-1 top-4"> <img src="images/page2-img1.jpg" alt="" class="img-border img-indent">
                <div class="extra-wrap">
                  <p class="p2"><strong>Йога в нашем спортивном комплексе</strong></p>
                  <p>Откройте волнующие глубины йоги в нашем специализированном зале. Наши классы предлагают уникальную возможность гармонизировать тело, разум и дух под руководством опытных инструкторов.</p>
                </div>
              </div>
              <div class="wrap box-1 top-2"> <img src="images/page2-img2.jpg" alt="" class="img-border img-indent">
                <div class="extra-wrap">
                  <p class="p2"><strong>Силовые тренировки в нашем спортивном комплексе</strong></p>
                  <p>Укрепите свое тело и достигните новых высот с нашими силовыми тренировками. Независимо от ваших целей – от увеличения мышечной массы до повышения выносливости – наши тренеры помогут вам разработать индивидуальную программу.</p>
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
