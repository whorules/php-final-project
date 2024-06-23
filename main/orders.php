<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../registration/login.php');
    $loggedIn = false;
    exit;
} else {
    $loggedIn = true;
}

include('db.php');
include('Registration.php');
include('Specialization.php');
include('Coach.php');

$database = new Database();
$db = $database->getConnection();

$registration = new Registration($db);
$registration->user_id = $_SESSION['user_id'];
$stmt = $registration->readAllByUser();
$registrations = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $registrations[] = $row;
}
$hasRecords = count($registrations) > 0;
$stmt->closeCursor();

$specialization = new Specialization($db);
$specializationsStmt = $specialization->readAll();
$specializations = [];
while ($row = $specializationsStmt->fetch(PDO::FETCH_ASSOC)) {
    $specializations[] = $row;
}
$specializationsStmt->closeCursor();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Мои заказы</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/reset.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/style.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/grid_12.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            const updateCoachOptions = (data) => {
                const coaches = JSON.parse(data).coaches;
                const options = coaches.map(coach =>
                    `<option value="${coach.coach_id}" data-activity-id="${coach.activity_id}">
                        ${coach.name} — ${coach.description} (${coach.start_time})
                    </option>`).join('');
                $('#coach').html(options).prop('disabled', false);
                $('#activity_id').val(coaches[0]?.activity_id || '');
            };

            $('#specialization').change(function () {
                const specializationId = $(this).val();
                $.post('get_coaches.php', { specialization_id: specializationId }, updateCoachOptions);
            });

            $('#coach').change(function() {
                $('#activity_id').val($(this).find('option:selected').data('activity-id'));
            });

            $('#registration-form').submit(function(e) {
                if (!$('#activity_id').val()) {
                    e.preventDefault();
                    alert('Please select a coach.');
                }
            });
        });
    </script>
</head>
<body>
<div class="main">
    <div class="bg-img"></div>
    <header>
        <h1><a href="../index.php">Фитнес <strong>клуб.</strong></a></h1>
        <br/>
        <div class="auth-buttons">
            <?php if ($loggedIn): ?>
            <a href="../registration/logout.php">Выйти</a>
            <?php else: ?>
            <a href="../registration/login.php">Войти</a>
            <?php endif; ?>
        </div>
        <nav>
            </br>
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
        <div class="container_12">
            <div class="grid_12">
                <div class="box-shadow centered-content">
                    </br>
                    <h2>Мои записи</h2>
                    <?php if ($hasRecords): ?>
                        <table>
                            <thead>
                            <tr>
                                <th>Дата</th>
                                <th>Время</th>
                                <th>Название активности</th>
                                <th>Статус</th>
                                <th>Тренер</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($registrations as $row): ?>
                                <tr>
                                    <td><?php echo date('Y-m-d', strtotime($row['registration_date'])); ?></td>
                                    <td><?php echo date('H:i', strtotime($row['start_time'])) . ' - ' . date('H:i', strtotime($row['end_time'])); ?></td>
                                    <td><?php echo htmlspecialchars($row['activity_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($row['status'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <br><br>
                    <button onclick="window.location.href='download_orders.php'">Скачать записи</button>
                    <?php else: ?>
                        <p>Вы еще никуда не записаны</p>
                    <?php endif; ?>
                    <br/><br/>
                    <h2>Записаться на активность</h2>
                    <div class="form-container">
                        <form method="POST" action="submit_registration.php" id="registration-form">
                            <div class="form-group">
                                <label for="specialization">Активность:</label>
                                <select id="specialization" name="specialization">
                                    <option value="">Выберите активность</option>
                                    <?php foreach ($specializations as $row): ?>
                                        <option value="<?php echo $row['specialization_id']; ?>">
                                            <?php echo htmlspecialchars($row['specialization_name'], ENT_QUOTES, 'UTF-8'); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="coach">Тренер:</label>
                                <select id="coach" name="coach" disabled>
                                    <option value="">Выберите тренера</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="date">Дата:</label>
                                <input type="date" id="date" name="date" required>
                            </div>
                            <input type="hidden" id="activity_id" name="activity_id">
                            <button type="submit">Записаться</button>
                        </form>
                    </div>
                <br><br>
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
