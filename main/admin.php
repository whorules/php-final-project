<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../registration/login.php');
    exit();
} else {
    $loggedIn = true;
}

if (!isset($_COOKIE['role_id']) || $_COOKIE['role_id'] != 1) {
    header('Location: ../index.php');
    exit();
}

include('db.php');
include('Registration.php');
include('Specialization.php');
include('Coach.php');

$database = new Database();
$db = $database->getConnection();

$registration = new Registration($db);
$registrations = $registration->readAll()->fetchAll(PDO::FETCH_ASSOC);
$hasRecords = count($registrations) > 0;

$specialization = new Specialization($db);
$specializations = $specialization->readAll()->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Управление записями</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/grid_12.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            function changeStatus(newStatus) {
                const selected = $('input[name="selected_records[]"]:checked').map(function() {
                    return this.value;
                }).get();
                if (selected.length > 0) {
                    $.post('change_status.php', { records: selected, status: newStatus }, function(response) {
                        location.reload();
                    });
                }
            }

            $('#delete-records').click(function() {
                const selected = $('input[name="selected_records[]"]:checked').map(function() {
                    return this.value;
                }).get();
                if (selected.length > 0) {
                    $.post('delete_records.php', { records: selected }, function(response) {
                        location.reload();
                    });
                }
            });

            $('#confirm-status').click(function() {
                changeStatus('confirmed');
            });

            $('#cancel-status').click(function() {
                changeStatus('cancelled');
            });
        });
    </script>
</head>
<body>
<div class="main">
    <header>
        <h1><a href="../index.php">Фитнес <strong>клуб.</strong></a></h1>
        <div class="auth-buttons">
            <?php if ($loggedIn): ?>
                <a href="../registration/logout.php">Выйти</a>
            <?php else: ?>
                <a href="../registration/login.php">Войти</a>
            <?php endif; ?>
        </div>
    </header>
    <section id="content">
        <div class="container_12">
            <div class="grid_12">
                <div class="box-shadow centered-content">
                    <br>
                    <h2>Записи пользователей</h2>
                    <?php if ($hasRecords): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Выбрать</th>
                                    <th>Дата</th>
                                    <th>Время</th>
                                    <th>Название активности</th>
                                    <th>Статус</th>
                                    <th>Пользователь</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($registrations as $row): ?>
                                    <tr>
                                        <td><input type="checkbox" name="selected_records[]" value="<?= $row['registration_id']; ?>"></td>
                                        <td><?= date('Y-m-d', strtotime($row['registration_date'])); ?></td>
                                        <td><?= date('H:i', strtotime($row['start_time'])) . ' - ' . date('H:i', strtotime($row['end_time'])); ?></td>
                                        <td><?= htmlspecialchars($row['activity_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?= htmlspecialchars($row['status'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?= htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div class="admin-button-container">
                            <button id="delete-records">Удалить выбранные</button>
                            <button id="confirm-status">Подтвердить</button>
                            <button id="cancel-status">Отменить</button>
                        </div>
                    <br>
                    <?php else: ?>
                        <p>Записей не найдено</p>
                        <br>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <footer>
        <p>© 2024 Фитнес клуб</p>
    </footer>
</div>
</body>
</html>
