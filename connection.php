<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

abstract class DatabaseConnection {
    protected $conn;

    public function __construct($servername, $username, $password, $dbname) {
        // Create connection
        $this->conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function __destruct() {
        // Close the database connection
        $this->conn->close();
    }

    abstract public function insertData();

    protected function sanitizeData($data) {
        // Sanitize the data to prevent SQL injection attacks
        return mysqli_real_escape_string($this->conn, $data);
    }
}

?>
