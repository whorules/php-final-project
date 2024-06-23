<?php
header('Content-Type: text/html; charset=utf-8');
class Specialization {
    private $conn;
    private $table_name = "specializations";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}
?>
