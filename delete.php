<?php
require 'connection.php';


class DataDelete extends DatabaseConnection {
    private $table;

    public function __construct($servername, $username, $password, $dbname, $table) {
        parent::__construct($servername, $username, $password, $dbname);
        $this->table = $table;
    }
    public function insertData() {
    }
    public function deleteData($ids) {
        $ids = array_map('intval', $ids); // sanitize the values
        $ids = implode(',', $ids); // join the values with commas

        $sql = "DELETE FROM $this->table WHERE id IN ($ids)";
        $stmt = $this->conn->prepare($sql);
        // $stmt
        $stmt->execute();
    }
}


$json_str = file_get_contents('php://input');
$data = json_decode($json_str, true);

// delete the data using the DataDelete class
$db = new DataDelete('localhost', 'User', 'Us123456//', 'mysql', 'products');
$db->deleteData($data);
?>


