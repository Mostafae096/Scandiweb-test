<?php
require 'connection.php';

class DataRetriever extends DatabaseConnection {
    public function insertData() {
    }

    // getting the data from database
    public function getProducts(){
        $sql = "SELECT * FROM $this->table";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = array();
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        return $products;
    }
}

$db_retriever = new DataRetriever();
$products = $db_retriever->getProducts();
header('Content-Type: application/json');
echo json_encode($products);
?>
