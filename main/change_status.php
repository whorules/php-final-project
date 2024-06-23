<?php
include('db.php');

error_log('Received POST data: ' . print_r($_POST, true));

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['records']) && isset($_POST['status'])) {
    $records = $_POST['records'];
    $status = $_POST['status'];

    // Проверка статуса
    if (!in_array($status, ['confirmed', 'cancelled'])) {
        http_response_code(400);
        echo "Неверный статус";
        exit;
    }

    $database = new Database();
    $db = $database->getConnection();

    // Подготовка запроса с именованными параметрами
    $placeholders = [];
    foreach ($records as $index => $record) {
        $placeholders[] = ":record_id_$index";
    }
    $placeholders_str = implode(',', $placeholders);
    $query = "UPDATE registrations SET status = :status WHERE registration_id IN ($placeholders_str)";
    $stmt = $db->prepare($query);

    // Привязка параметров
    $stmt->bindParam(':status', $status);
    foreach ($records as $index => $record) {
        $stmt->bindValue(":record_id_$index", $record, PDO::PARAM_INT);
    }

    // Выполнение запроса
    if ($stmt->execute()) {
        echo "Статус успешно обновлен";
    } else {
        echo "Ошибка при обновлении статуса";
    }
} else {
    http_response_code(400);
    echo "Неверный запрос";
}
?>
