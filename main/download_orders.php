<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../registration/login.php');
    exit;
}

include('db.php');
include('Registration.php');

$database = new Database();
$db = $database->getConnection();

$registration = new Registration($db);
$registration->user_id = $_SESSION['user_id'];
$stmt = $registration->readAllByUser();
$registrations = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $registrations[] = $row;
}
$stmt->closeCursor();

$filename = "orders_" . $_SESSION['user_id'] . ".txt";
header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="' . $filename . '"');

foreach ($registrations as $row) {
    echo "Дата: " . date('Y-m-d', strtotime($row['registration_date'])) . "\n";
    echo "Время: " . date('H:i', strtotime($row['start_time'])) . " - " . date('H:i', strtotime($row['end_time'])) . "\n";
    echo "Название активности: " . htmlspecialchars($row['activity_name'], ENT_QUOTES, 'UTF-8') . "\n";
    echo "Статус: " . htmlspecialchars($row['status'], ENT_QUOTES, 'UTF-8') . "\n";
    echo "Тренер: " . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . "\n";
    echo "------------------------\n";
}
exit;
?>
