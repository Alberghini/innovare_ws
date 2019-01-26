<?php
require_once('reusable/cors.php');
require_once('models/login.php');

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $LoginModel = new LoginModel();
    print_r(json_encode($LoginModel->validate($_GET['isAdmin'], $_GET['email'], $_GET['password'])));
}
?>