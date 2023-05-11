<?php

abstract class DatabaseConnection {
    protected $conn;
    protected $servername = 'localhost';
    protected $username = 'User';
    protected $password = 'Us123456//';
    protected $dbname = "mysql";
    protected $table = 'products';

    
    public function __construct() {
        // Create connection
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        // create the table if it doesn't exist
        $sql = "CREATE TABLE IF NOT EXISTS $this->table (
            id INT AUTO_INCREMENT PRIMARY KEY,
            sku VARCHAR(50) NOT NULL UNIQUE,
            name VARCHAR(50) NOT NULL,
            price DECIMAL(10,2) NOT NULL,
            productType VARCHAR(50),
            size VARCHAR(50),
            weight DECIMAL(10,2),
            height DECIMAL(10,2),
            width DECIMAL(10,2),
            length DECIMAL(10,2)
        );";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
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
