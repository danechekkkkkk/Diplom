<?php
    require_once '../connect.php';
    session_start();

    $name_org = $_POST["name_org"];
    $taxpayer_number = $_POST["taxpayer_number"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];


    if($password === $confirm_password){
        $password = md5($password);
        $query = "INSERT INTO users (name_organization, taxpayer_number, email, password) VALUES (\$1, \$2, \$3, \$4)";
        $result = pg_query_params($connect, $query, array($name_org, $taxpayer_number, $email, $password));

        header("Location: ../../auth.php");
            
    } else{
        $_SESSION['message'] = "Пароли не совпадают!";
        header("Location: ../../register.php");
        
    }
?>