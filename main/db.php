<?php
header('Content-Type: text/html; charset=utf-8');
class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    public $conn;

    public function __construct() {
        $this->host = getenv('DB_HOST') ?: '127.0.0.1';
        $this->db_name = getenv('DB_DATABASE') ?: 'php_final_project';
        $this->username = getenv('DB_USERNAME') ?: 'root';
        $this->password = getenv('DB_PASSWORD') ?: 'password';
    }

    public function getConnection() {
        $this->conn = null;
        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }

}
?>
