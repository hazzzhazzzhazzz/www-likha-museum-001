<?php

class AdminDatabase {
    private $host = "127.0.0.1";
    private $port = "3309";
    // naka-3306 in default pero naka-3309 sa HeidiSQL and xampp ko (because ang port 3306 is being used by another application for ICS2607 si Workbench)
    private $DBname = "employees-admins_db";
    private $username = "root";
    private $password = "";


    public function connect() {
        try {
            $conn = new PDO("mysql:host=$this->host;port=$this->port;dbname=$this->DBname", 
                $this->username, 
                $this->password
            );
            $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }

        catch (PDOException $ex) {
            http_response_code(500);
            echo $ex -> getMessage();
            exit;

        }
    }
}


?>