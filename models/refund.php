<?php
require_once('db/connection.php');

class RefundModel{

    private $conn;

    public function __construct() {
        $Connection = new Connection();
        $this->conn = $Connection->getConn();
    }
    
    function save($refund){
        $refund = json_decode($refund);

        $sql = "INSERT INTO refunds (description) VALUES (:description)";

        $stmt = $this->conn->prepare($sql);
        if($stmt->execute(array(":description"=>$refund->description))) return true;

        return false;
    }
    function put($refund){
        $refund = json_decode($refund);

        $sql = "UPDATE refunds SET description = :description WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        if($stmt->execute(array(":description"=>$refund->description, ":id"=>$refund->id))) return true;

        return false;
    }

    function get($id){

        $sql = "SELECT * FROM refunds WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        if($stmt->execute(array(":id"=>$id))){
            if($stmt->rowCount() > 0){
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
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

        $sqlVerify = "SELECT id FROM refundask WHERE type = :type";

        $stmt = $this->conn->prepare($sqlVerify);
        if($stmt->execute(array(":type"=>$id))){
            if($stmt->rowCount() > 0){
                return array("err"=>1, "message"=>"Este tipo de reembolso já está em uso e por isto não pode ser removido");
            } else {
                $sql = "DELETE FROM refunds WHERE id = :id";
                
                $stmt = $this->conn->prepare($sql);
                if($stmt->execute(array(":id"=>$id))){
                    if($stmt->rowCount() > 0) return array("err"=>0, "message"=>"Tipo de reembolso removido com sucesso!");
                }    
            }
        }
        return array("err"=>1, "message"=>"Oops... Ocorreu um erro no sistema. Por favor, contate o suporte");
    }

    function askRefund($refundArray){
        $error = false;
        $refundArray = json_decode($refundArray);

        $this->conn->beginTransaction();

        foreach($refundArray as $refund){
            $sql = "INSERT INTO refundAsk (id_worker, type, value, status) VALUES (:id_worker, :type, :value, :status)";
            
            $stmt = $this->conn->prepare($sql);
            if(!$stmt->execute(array(":id_worker"=>$refund->id_worker, ":type"=>$refund->type, ":value"=>$refund->value, ":status"=>1))){
                $error = true;
            }
        }
        if(!$error){
            $this->conn->commit();
            return true;
        }

        $this->conn->rollback();
        return false;
    }

    function getExistingRefunds(){

        $sql = "SELECT r.id,
                       w.email,
                       rt.description,
                       r.value,
                       s.description as status,
                       r.status as status_id
                FROM refundask as r
                INNER JOIN workers AS w ON w.id = r.id_worker
                INNER JOIN refunds AS rt ON rt.id = r.type
                INNER JOIN status AS s ON s.id = r.status
                WHERE r.status = 1
                ORDER BY id DESC";

        $stmt = $this->conn->prepare($sql);
        if($stmt->execute()){
            if($stmt->rowCount() > 0){
                return $stmt->fetchAll();
            }
        }

        return [];
    }

    function getHistoricRefunds(){

        $sql = "SELECT r.id,
                       w.email,
                       rt.description,
                       r.value,
                       s.description as status,
                       r.status as status_id
                FROM refundask as r
                INNER JOIN workers AS w ON w.id = r.id_worker
                INNER JOIN refunds AS rt ON rt.id = r.type
                INNER JOIN status AS s ON s.id = r.status
                WHERE r.status != 1
                ORDER BY id DESC";

        $stmt = $this->conn->prepare($sql);
        if($stmt->execute()){
            if($stmt->rowCount() > 0){
                return $stmt->fetchAll();
            }
        }

        return [];
    }

    function updateStatusRefund($data){
        $data = json_decode($data);

        $sql = "UPDATE refundask SET status = :status WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        if($stmt->execute(array(":status"=>$data->status, ":id"=>$data->id))) return true;

        return false;
    }


}

?>