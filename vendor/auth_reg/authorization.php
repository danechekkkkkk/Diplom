<?php
    require_once '../connect.php';
    session_start();

    $taxpayer_number = $_POST["taxpayer_number"];
    $password = md5($_POST["password"]);
   
    $query = "SELECT * FROM users where taxpayer_number = \$1 AND password = \$2";
    $result = pg_query_params($connect, $query, array($taxpayer_number, $password));
    $user = pg_fetch_assoc($result);

    if($user && pg_num_rows($result) > 0){
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['organization'] = $user['name_organization'];
        $_SESSION['inn'] = $user['taxpayer_number'];
        header("Location: ../../lk.php");
    }else{
        $_SESSION['message'] = "Неверные данные!";
        header("Location: ../../auth.php");
    }
    
?>