<?php 
class DatabaseConnection {
  public $conn;

  public function __construct() {
    try {
      $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE, DB_PORT);
      
      if ($this->conn->connect_error) {
        throw new Exception("Database connection failed: " . $this->conn->connect_error);
      }
    } catch (Exception $e) {
      $customErrorMessage = "<h1>" . $e->getMessage() . "</h1>";
      die($customErrorMessage);
    }
    
  }
}

?>