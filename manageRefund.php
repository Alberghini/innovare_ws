<?php
require_once('reusable/cors.php');
require_once('models/refund.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $RefundModel = new RefundModel();
    print_r(json_encode($RefundModel->save(file_get_contents("php://input"))));
} else if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_GET['id'])){
        $RefundModel = new RefundModel();
        print_r(json_encode($RefundModel->get($_GET['id'])));
    } else {
        $RefundModel = new RefundModel();
        print_r(json_encode($RefundModel->getAll()));
    }
} else if($_SERVER['REQUEST_METHOD'] == 'PUT'){
    $RefundModel = new RefundModel();
    print_r(json_encode($RefundModel->put(file_get_contents("php://input"))));
} else if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
    $RefundModel = new RefundModel();
    print_r(json_encode($RefundModel->delete($_GET['id'])));
}
?>