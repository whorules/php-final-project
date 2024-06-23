<?php
header('Content-Type: text/html; charset=utf-8');
class Coach {
    private $conn;
    private $table_name = "coaches";

    public $specialization_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAllBySpecialization() {
        $query = "SELECT coach_id, name, description, start_time, activity_id
                  FROM view_coaches_by_specialization
                  WHERE specialization_id = ?
                  ORDER BY start_time";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->specialization_id);
        $stmt->execute();

        return $stmt;
    }

}
?>
