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
    <link rel="stylesheet" href="styles/warehouse.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script defer src = "js/sort.js"></script>
    <script defer src="js/warehouse.js"></script>
    <title>Склад</title>
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
    <h2 class = "title-page">Склад</h2>
    <div class="main-cont-bl">
    <div class="main-container">
        <div class="btn-cont">
            <div class="left-buttons">
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
                    <th>Цена</th>
                    <th>Сумма</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    require_once 'vendor/connect.php';
                    require_once 'vendor/warehouse/show_warehouse_product.php';
                ?>
            </tbody>
        </table>
    </div>
</div>

 

    <div id="editModal" class="modal">
    <div class="edit-modal-content">
        <span class="close" id="closeEditModal">&times;</span>
        <h2>Редактировать запись</h2>
        <form id="editRecord" method="post" action = "vendor/warehouse/edit_warehouse.php">
            <input type="hidden" id="id" name="id">
            <label for="editName">Наименование:</label>
            <input type="text" id="editName" required name="editName" class="edit-modal-input">
            <label for="editArt">Артикул:</label>
            <input type="text" id="editArt" required name="editArt" class="edit-modal-input">
            <label for="editCount">Количество:</label>
            <input type="number" id="editCount" required name="editCount" class="edit-modal-input">
            <label for="editPrice">Цена:</label>
            <input type="number" id="editPrice" required name="editPrice" class="edit-modal-input">
            <button type="submit" class="modal-btn">Сохранить изменения</button>
        </form>
    </div>
</div>
</body>
</html>