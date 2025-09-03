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
    <link rel="stylesheet" href="styles/consignment.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script defer src="js/script_2.js"></script>
    <title>Создание накладной</title>
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
    <h2 class = "title-page">Создание накладной</h2>
    <div class="main-cont-bl">
        <div class="main-container">
            <div class="input-group">
                <div class="input-item">
                    <label for="supplier">Поставщик:</label>
                    <input type="text" id="supplier" name="supplier" required class="cons-input" autocomplete="off">
                </div>

                <div class="input-item">
                    <label for="buyer">Заказчик:</label>
                    <input type="text" id="buyer" name="buyer" required class="cons-input">
                </div>

                <div class="input-item">
                    <label for="address">Адрес доставки:</label>
                    <input type="text" id="address" name="address" required class="cons-input" autocompelete = "off">
                </div>

                <div class="input-item">
                    <label for="phone">Телефон:</label>
                    <input type="text" id="phone" name="phone" required class="cons-input">
                </div>

                <div class="input-item">
                    <label for="contact_person">Контактное лицо:</label>
                    <input type="text" id="contact_person" name="contact_person" required class="cons-input" autocompelete = "off">
                </div>
            </div>
            <div class="btns">
                <button class="create-button" id="openModal">Добавить</button>
                <button class="save-button" id="saveData">Сохранить</button>
            </div>

            <table class="data-table" id="consignment-table">
                <thead>
                    <tr>
                        <th>№</th>
                        <th>Наименование</th>
                        <th>Кол-во</th>
                        <th>Цена</th>
                        <th>Сумма</th>
                        <th> </th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>
            </table>
            <div class="consignment-price">
                <p>Итого: <span id="totalSum">0</span> руб.</p>
            </div>
        </div>
    </div>
    <div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeAddModal">&times;</span>
        <h2>Добавить запись</h2>
        <form id="addRecordForm" method="post">
            <label for="name">Наименование:</label>
            <select id="name" required name="name" class="modal-input">
                <?php
                require_once 'vendor/connect.php';
                $query = "SELECT id, name, count, sale_price FROM warehouse"; 
                $result = pg_query($connect, $query);

                while ($row = pg_fetch_assoc($result)) {
                    echo "<option 
                    value='{$row['id']}' 
                    data-name='{$row['name']}' 
                    data-count='{$row['count']}' 
                    data-price='{$row['sale_price']}'>
                    {$row['name']}
                </option>";
                }
                ?>
            </select>

            <label for="count">Количество:</label>
            <input type="number" id="count" required name="count" class="modal-input">
            <label for="price">Стоимость:</label>
            <input type="number" id="price" required name="price" class="modal-input">
            <button type="submit" class="modal-btn">Добавить</button>
        </form>
    </div>
</div>


<div id="editModal" class="modal">
    <div class="edit-modal-content">
        <span class="close" id="closeEditModal">&times;</span>
        <h2>Редактировать запись</h2>
        <form id="editRecord" method="post">
            <label for="editName">Наименование:</label>
            <input type="text" id="editName" required name="editName" class="edit-modal-input">
            <label for="editcount">Количество:</label>
            <input type="number" id="editcount" required name="editcount" class="edit-modal-input">
            <label for="editPrice">Стоимость:</label>
            <input type="number" id="editPrice" required name="editPrice" class="edit-modal-input">
            <button type="submit" class="modal-btn">Сохранить изменения</button>
        </form>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('name');
    const priceInput = document.getElementById('price');

    select.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const price = selectedOption.getAttribute('data-price');

        if (price) {
            priceInput.value = price;
        } else {
            priceInput.value = '';
        }
    });

    // Автоматически подставить цену при загрузке, если выбран элемент
    const event = new Event('change');
    select.dispatchEvent(event);
});
</script>


</body>

</html>