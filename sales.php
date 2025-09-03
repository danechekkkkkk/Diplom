<?php
session_start();
require_once 'vendor/connect.php'; 

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth.php');
    exit();
}

$expensesQuery = "SELECT SUM(purchase_price * count) AS total_expenses FROM procurement";
$expensesResult = pg_query($connect, $expensesQuery);
$expensesRow = pg_fetch_assoc($expensesResult);
$total_expenses = $expensesRow['total_expenses'] ?? 0;

// Запрос для получения оборота
$turnoverQuery = "SELECT SUM(price * count) AS total_turnover FROM items";
$turnoverResult = pg_query($connect, $turnoverQuery);
$turnoverRow = pg_fetch_assoc($turnoverResult);
$total_turnover = $turnoverRow['total_turnover'] ?? 0;

$profit = $total_turnover - $total_expenses; 
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/sales.css">
    <title>Статистика</title>
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
    <h2 class = "title-page">Статистика</h2>
    <div class="main-cont-bl">
        <div class="main-container">
            <div class="line-cont">
            </div>
            <p class="output_numbers">Общие расходы: <?= number_format($total_expenses, 2, ',', ' ') ?> ₽</p>
            <p class="output_numbers">Общие продажи: <?= number_format($total_turnover, 2, ',', ' ') ?> ₽</p>
            <p class="output_numbers">Прибыль: <?= number_format($profit, 2, ',', ' ') ?> ₽</p>
        </div>
    </div>
</body>
</html>
