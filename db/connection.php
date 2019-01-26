<?php
    include_once("connection_config.php");

    class Connection {
        private $conn;

        function __construct() {
            $this->conn = new PDO(
                'mysql:host='.DATABASE_HOST.'; dbname='.DATABASE_NAME.'; charset=utf8mb4', 
                DATABASE_USER, 
                DATABASE_PASS, 
                array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_PERSISTENT => false
                )
            );
        }
        function getConn() {
            return $this->conn;
        }
    }
?>