<?php

class Database{

    private $host = "localhost";
    private $db = "api_db";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        
        $this->conn = null;

        $this->conn = new mysqli($this->host,$this->username,$this->password,$this->db);

        if ($this->conn->connect_errno) {
            $this->conn = "Connection Error - ".$this->conn->connect_error;
        }

        return $this->conn;

    }
  
}

?>