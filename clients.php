<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/clients.css">
    <title>Список клиентов</title>
</head>

<body>
    <div class="header">
        <div class="header-line">
            <div class="logo">
                <img src="images/logo.svg" alt="">
            </div>
            <div class="menu">
                <a class="menu-item" href="warehouse.php">Склад</a>
                <a class="menu-item" href="procurement.php">Закупки</a>
                <a class="menu-item" href="sales.php">Статистика</a>
            </div>
            <div class="lk">
                <a class="menu-item" href="lk.php">Личный кабинет</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="container-line">
            <a class="cont-line" href="clients.php">Клиенты</a>
            <a class="cont-line" href="orders.php">Заказы клиентов</a>
            <a class="cont-line" href="consignment.php">Накладная</a>
        </div>
    </div>
    <h2 class = "title-page">Список клиентов</h2>
    <div class="main-cont-bl">
        <div class="main-container">
            
            <table class="data-table" id="consignment-table">
                <thead>
                    <tr>
                        <th>№</th>
                        <th>Наименование</th>
                        <th>Юр. адрес</th>
                        <th>Телефон</th>
                        <th>Контактное лицо</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        require_once 'vendor/connect.php';
                        require_once 'vendor/clients/show_clients.php'
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>