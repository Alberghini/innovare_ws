<?php
require_once('db/connection.php');

class LoginModel{

    private $conn;

    public function __construct() {
        $Connection = new Connection();
        $this->conn = $Connection->getConn();
    }
    
    function validate($isAdmin, $email, $password){

        $password = hash('md5', $password);

        $sql = "SELECT id,
                       name,
                       email 
                FROM ";
        $sql .= ($isAdmin === 'true') ? "admins" : "workers";
        $sql .= " WHERE email = :email AND password = :password";

        $stmt = $this->conn->prepare($sql);
        if($stmt->execute(array(":email"=>$email, ":password"=>$password))){
            if($stmt->rowCount() > 0){
                $result = $stmt->fetchObject();
				return $result;
            }
        }

        return false;
    }
    
    function getAll(){

        $sql = "SELECT * FROM refunds";

        $stmt = $this->conn->prepare($sql);
        if($stmt->execute()){
            if($stmt->rowCount() > 0){
                return $stmt->fetchAll();
            }
        }

        return false;
    }

    function delete($id){
        $refund = json_decode($refund);

        $sql = "DELETE FROM refunds WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        if($stmt->execute(array(":id"=>$id))) return true;

        return false;
    }


}

?>