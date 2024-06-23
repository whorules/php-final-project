<?php
header('Content-Type: text/html; charset=utf-8');
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['records'])) {
    $records = $_POST['records'];

    if (empty($records)) {
        http_response_code(400);
        echo "Нет записей для удаления";
        exit;
    }

    $database = new Database();
    $db = $database->getConnection();

    $placeholders = implode(',', array_fill(0, count($records), '?'));
    $query = "DELETE FROM registrations WHERE registration_id IN ($placeholders)";
    $stmt = $db->prepare($query);

    foreach ($records as $index => $record) {
        $stmt->bindValue(($index + 1), $record, PDO::PARAM_INT);
    }

    if ($stmt->execute()) {
        echo "Записи успешно удалены";
    } else {
        echo "Ошибка при удалении записей";
    }
} else {
    http_response_code(400);
    echo "Неверный запрос";
}
?>
