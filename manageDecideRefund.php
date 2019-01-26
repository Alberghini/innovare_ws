<?php
require_once('reusable/cors.php');
require_once('models/refund.php');

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $RefundModel = new RefundModel();
    print_r(json_encode($RefundModel->getExistingRefunds()));
} else if($_SERVER['REQUEST_METHOD'] == 'PUT'){
    $RefundModel = new RefundModel();
    print_r(json_encode($RefundModel->updateStatusRefund(file_get_contents("php://input"))));
}
?>