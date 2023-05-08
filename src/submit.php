<?php
header('Access-Control-Allow-Origin: http://localhost:3000');

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
class DataSubmition extends DatabaseConnection {
    private $table;

    public function __construct($servername, $username, $password, $dbname, $table) {
        parent::__construct($servername, $username, $password, $dbname);
        $this->table = $table;
    }

    public function insertData() {


        $json_str = key($_POST);
        $data = json_decode($json_str, true);

        if (!isset($data['sku']) || !isset($data['price']) || !isset($data['productType'])) {
            die("Incomplete data received.");
        }
        // Use object properties to sanitize data
        $sku = $this->sanitizeData($data['sku']);
        $price = $this->sanitizeData($data['price']);
        $productType = $this->sanitizeData($data['productType']);
        $size = $this->sanitizeData($data['size']);
        $weight = $this->sanitizeData($data['weight']);
        $height = $this->sanitizeData($data['height']);
        $width = $this->sanitizeData($data['width']);
        $length = $this->sanitizeData($data['length']);
        
        $sql = "INSERT INTO $this->table (sku, price, productType, size, weight, height, width, length) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssdddd", $sku, $price, $productType, $size, $weight, $height, $width, $length);
        $stmt->execute();
        }
    } // added closing brace for the DataSubmition class

    $db = new DataSubmition('localhost', 'User', 'Us123456//', "mysql", 'products');
    $db->insertData();

?>
