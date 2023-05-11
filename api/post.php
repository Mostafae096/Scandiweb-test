<?php
require 'connection.php';
require 'functions.php';

// this class handle all post requests

class DataSubmission extends DatabaseConnection {

    // handle if the data is not set or if it the wrong type
    private function checkData($data){
        if (!isset($data['sku']) 
        || !isset($data['price']) 
        || !isset($data['productType']) 
        || !isset($data['name'])) {
            die("SKU, Name, Price or Product Type isn't provided");
        } else{
            if (!regexCheck($data['price'], 'number') ){
                die("Price is wrong data type");
            } else if (!regexCheck($data['name'], 'text') ){
                die("Name is wrong data type");
            } else if (!regexCheck($data['productType'], 'text')){
                die("productType is wrong data type");
            } else if (!regexCheck($data['sku'], 'text')){
                die("sku is wrong data type");
            }
        }

        if ($data['productType'] === 'DVD'){
            if (!isset($data['size']) || !regexCheck($data['size'], 'number')) {
                die("Size isn't ptovided or it's wrong data type");
            }
        } else if ($data['productType'] === 'Book') {
            if (!isset($data['weight']) || !regexCheck($data['weight'], 'number')) {
                die("Weight isn't ptovided or it's wrong data type");
            }
        } else if ($data['productType'] === 'Furniture') {
            if (!isset($data['height']) 
            || !isset($data['width']) 
            || !isset($data['length']) 
            || !regexCheck($data['height'], 'number')
            || !regexCheck($data['width'], 'number')
            || !regexCheck($data['length'], 'number')) {
                die("height, width or length isn't ptovided or it's wrong data type");
            }
        }
    }

    // inserting data in database
    public function insertData() {
        $json_str = key($_POST);
        $data = json_decode($json_str, true);
        $this->checkData($data);
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

$db = new DataSubmission();
$db->insertData();
?>
