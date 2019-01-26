<?php
require_once('reusable/cors.php');
require_once('models/refund.php');

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $RefundModel = new RefundModel();
    print_r(json_encode($RefundModel->getHistoricRefunds()));
}
?>