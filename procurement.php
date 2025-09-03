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
    <link rel="stylesheet" href="styles/procurement.css">
    <script defer src="js/main.js"></script>
    <script defer src = "js/sort.js"></script>
    <title>Закупки</title>
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
    <h2 class = "title-page">Закупки</h2>
    <div class="main-cont-bl">
    <div class="main-container">
        <div class="btn-cont">
            <div class="left-buttons">
                <button class="addBtn" id = "addBtn">Добавить</button>
                <a href="" class = "sort" id = "sortBtn"><img src="images/sort.svg" alt=""></a>
            </div>
        </div>
        <table class="data-table" id="consignment-table">
            <thead>
                <tr>
                    <th>№</th>
                    <th>Наименование</th>
                    <th>Артикул</th>
                    <th>Кол-во</th>
                    <th>Поставщик</th>
                    <th>Цена закупки</th>
                    <th>Цена продажи</th>
                    <th>Сумма закупки</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    require_once 'vendor/connect.php';
                    require_once 'vendor/procurement/show_procurement.php';
                ?>
            </tbody>
        </table>
    </div>
</div>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Добавить запись</h2>
            <form id="addRecordForm" method="post" action = "vendor/procurement/add_procurement.php">
                <label for="name">Наименование:</label>
                <input type="text" id="name" required name="name" class="modal-input">
                <label for="art">Артикул:</label>
                <input type="text" id="art" required name="art" class="modal-input">
                <label for="count">Количество:</label>
                <input type="number" id="count" required name="count" class="modal-input">
                <label for="supplier">Поставщик:</label>
                <input type="text" id="supplier" required name="supplier" class="modal-input">
                <label for="purchase_price">Цена закупки:</label>
                <input type="number" id="purchase_price" required name="purchase_price" class="modal-input">
                <label for="sale_price">Цена продажи:</label>
                <input type="number" id="sale_price" required name="sale_price" class="modal-input">
                <button type="submit" class="modal-btn">Добавить</button>
            </form>
        </div>
    </div>
</body>
</html>