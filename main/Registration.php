<?php
header('Content-Type: text/html; charset=utf-8');
class Registration {
    private $conn;
    private $table_name = "registrations";

    public $user_id;
    public $activity_id;
    public $registration_date;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "CALL CreateRegistration(:user_id, :activity_id, :registration_date)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':activity_id', $this->activity_id);
        $stmt->bindParam(':registration_date', $this->registration_date);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function readAllByUser() {
        $query = "CALL getRegistrationsByUser(?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->user_id);
        $stmt->execute();

        return $stmt;
    }

    public function readAll() {
        $query = "SELECT
                    r.registration_id,
                    r.registration_date,
                    r.status,
                    a.activity_name,
                    a.start_time,
                    a.end_time,
                    u.username
                  FROM " . $this->table_name . " r
                  JOIN activities a ON r.activity_id = a.activity_id
                  JOIN users u ON r.user_id = u.user_id
                  ORDER BY r.registration_date";
        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }
}
?>
