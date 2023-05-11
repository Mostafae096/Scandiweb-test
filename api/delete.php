<?php
require 'connection.php';

class DataDelete extends DatabaseConnection {
    public function insertData() {
    }
    public function deleteData($ids) {
        $ids = array_map('intval', $ids); // sanitize the values
        $ids = implode(',', $ids); // join the values with commas
        // deleting the value from database
        $sql = "DELETE FROM $this->table WHERE id IN ($ids)";
        $stmt = $this->conn->prepare($sql);
        // $stmt
        $stmt->execute();
    }
}


$json_str = file_get_contents('php://input');
$data = json_decode($json_str, true);

// delete the data using the DataDelete class
$db = new DataDelete();
$db->deleteData($data);
?>


