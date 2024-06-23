<?php
header('Content-Type: text/html; charset=utf-8');
include('db.php');
include('Coach.php');

if (isset($_POST['specialization_id'])) {
    $specializationId = $_POST['specialization_id'];

    $database = new Database();
    $db = $database->getConnection();

    $coach = new Coach($db);
    $coach->specialization_id = $specializationId;
    $stmt = $coach->readAllBySpecialization();

    $coaches = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $coaches[] = [
            'coach_id' => $row['coach_id'],
            'name' => htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'),
            'description' => htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8'),
            'start_time' => date('H:i', strtotime($row['start_time'])),
            'activity_id' => $row['activity_id']
        ];
    }

    echo json_encode(['coaches' => $coaches]);
}
?>
