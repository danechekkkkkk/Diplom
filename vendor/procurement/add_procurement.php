<?php
require_once '../connect.php';
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $name = $_POST['name'];
    $art = $_POST['art'];
    $count = $_POST['count'];
    $supplier = $_POST['supplier'];
    $purchase_price = $_POST['purchase_price'];
    $sale_price = $_POST['sale_price'];
    $user_id = $_SESSION['user_id'];
    
    
    $total = $count * $purchase_price;

    $query_1 = "INSERT INTO procurement (name, art, count, supplier, purchase_price, sale_price, total, user_id) VALUES (\$1, \$2, \$3, \$4, \$5, \$6, \$7, \$8)";
    $result_1 = pg_query_params($connect, $query_1, array($name, $art, $count, $supplier, $purchase_price, $sale_price, $total, $user_id));

    $query_2 = "INSERT INTO warehouse (name, art, count, sale_price, total, user_id) VALUES (\$1,\$2, \$3, \$4, \$5, \$6)";
    $result_2 = pg_query_params($connect, $query_2, array($name, $art, $count,$sale_price, $total, $user_id));
    

    header("Location: ../../procurement.php");

  
}
?>


