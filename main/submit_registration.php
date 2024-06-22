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
    $registration->activity_id = $_POST['activity_id'];
    $registration->registration_date = $_POST['date'];

    if ($registration->create()) {
        header('Location: orders.php');
    } else {
        echo "Ошибка при создании записи";
    }
}
?>
