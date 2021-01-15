<?php 
  class Database {
    // DB Params
    // private $host = 'mysql-01-litil-test.ckgh6sla2gwb.us-east-2.rds.amazonaws.com';
    // private $db_name = 'litil';
    // private $username = 'admin';
    // private $password = 'litilwell';

    private $host = 'localhost';
    private $db_name = 'little_app';
    private $username = 'root';
    private $password = 'sa@123';

    private $conn;
    // DB Connect
    public function connect() {
      $this->conn = null;
      try { 
        $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        echo 'Connection Error: ' . $e->getMessage();
      }
      return $this->conn;
    }
  }