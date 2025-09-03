<?php
    require_once("vendor/connect.php");
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/reg_auth.css">
    <title>Регистрация</title>
</head>
<body>
    <div class="header">
        <div class="header-line">
            <div class="logo">
                <img src="images/logo.svg" alt="">
            </div>
        </div>
    </div>

    <div class="register_container">
        <div class="register_form">
            <form action="vendor/auth_reg/reg.php" method = "post">
                <h1>Регистрация</h1>
                <div class="underline"></div>
                <input type="text" name="name_org" placeholder = "Название организации" required>
                <input type="text" name="taxpayer_number" placeholder = "Введите ИНН" required>
                <input type="email" name="email" placeholder = "Введите эл. почту" required>
                <input type="password" name="password" placeholder = "Введите пароль" required>
                <input type="password" name="confirm_password" placeholder = "Подтвердите пароль" required>
                <button type = "submit">Зарегистрироваться</button>
                <p class="message">
                 <?php 
                    echo @$_SESSION['message'];
                    unset($_SESSION['message']);
                ?>
                </p>
            </form>
        </div>
    </div>
</body>
</html>