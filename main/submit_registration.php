<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../registration/login.php');
    exit;
}

include('db.php');
include('Registration.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $registration = new Registration($db);

    $registration->user_id = $_SESSION['user_id'];
    $registration->activity_id = $_POST['specialization'];
    $registration->registration_date = $_POST['date'];

    $logMessage = "User ID: " . $_SESSION['user_id'] . ", Activity ID: " . $_POST['specialization'] . ", Date: " . $_POST['date'] . "\n";
    file_put_contents('debug.log', $logMessage, FILE_APPEND);

    if ($registration->create()) {
        header('Location: orders.php');
    } else {
        echo "Ошибка при создании записи";
    }
}
?>
