<?php
include('db.php');
include('Coach.php');

if (isset($_POST['specialization_id'])) {
    $specializationId = $_POST['specialization_id'];

    $database = new Database();
    $db = $database->getConnection();

    $coach = new Coach($db);
    $coach->specialization_id = $specializationId;
    $stmt = $coach->readAllBySpecialization();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<option value="'.$row['coach_id'].'">'.htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8').' — '.htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8').' ('.date('H:i', strtotime($row['start_time'])).')</option>';
    }
}
?>