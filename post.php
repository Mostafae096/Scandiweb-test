<?php
require 'connection.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");



class DataSubmission extends DatabaseConnection {
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
        $name = $this->sanitizeData($data['name']);
        $size = isset($data['size']) ? $this->sanitizeData($data['size']) : null;
        $weight = isset($data['weight']) ? $this->sanitizeData($data['weight']) : null;
        $height = isset($data['height']) ? $this->sanitizeData($data['height']) : null;
        $width = isset($data['width']) ? $this->sanitizeData($data['width']) : null;
        $length = isset($data['length']) ? $this->sanitizeData($data['length']) : null;
        $sql = "INSERT INTO $this->table (sku, price, name, productType, size, weight, height, width, length) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssddddd", $sku, $price, $name, $productType, $size, $weight, $height, $width, $length);
        $stmt->execute();
              
    }
}



$db = new DataSubmission('localhost', 'User', 'Us123456//', "mysql", 'products');
$db->insertData();
?>
