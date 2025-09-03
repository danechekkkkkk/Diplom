<?php
require_once '../connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $name = $_POST['name'];
    $code = $_POST['code'];
    $artikul = $_POST['artikul'];
    $client = $_POST['client'];
    $date = $_POST['date'];
    $count = $_POST['count'];
    $price = $_POST['price'];   
    $user_id = $_SESSION['user_id'];
    
    
    $total_amount = $count * $price;

    $query = "INSERT INTO main (name, code, artikul, client, date, count, price, total_amount, user_id) VALUES (\$1, \$2, \$3, \$4, \$5, \$6, \$7, \$8, \$9)";
    $result = pg_query_params($connect, $query, array($name, $code, $artikul, $client, $date, $count, $price, $total_amount, $user_id));

    header("Location: ../main.php");

  
}
?>
