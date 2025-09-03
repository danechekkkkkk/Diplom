<?php
require_once '../connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$organization = htmlspecialchars(trim($_POST['organization']));
$address = htmlspecialchars(trim($_POST['address']));
$director = htmlspecialchars(trim($_POST['director']));
$accountant = htmlspecialchars(trim($_POST['accountant']));
$ogrn = htmlspecialchars(trim($_POST['ogrn']));
$taxpayer_number = htmlspecialchars(trim($_POST['inn']));
$account = htmlspecialchars(trim($_POST['account']));

$query_check = "SELECT * FROM personal_data WHERE user_id = \$1";
$result_check = pg_query_params($connect, $query_check, array($user_id));

if (pg_num_rows($result_check) > 0) {
    $query_update = "UPDATE personal_data SET 
        name_organization = \$1, 
        address = \$2, 
        director = \$3, 
        accountant = \$4, 
        taxpayer_number = \$5, 
        ogrn = \$6, 
        account = \$7 
        WHERE user_id = \$8";

    $result_update = pg_query_params($connect, $query_update, array($organization, $address, $director, $accountant, $taxpayer_number, $ogrn, $account, $user_id));

    if ($result_update) {
        $_SESSION['message'] = "Данные успешно обновлены.";
    } else {
        $_SESSION['message'] = "Ошибка при обновлении данных: " . pg_last_error($connect);
    }
} else {
    $query_insert = "INSERT INTO personal_data (name_organization, address, director, accountant, taxpayer_number, ogrn, account, user_id) 
    VALUES (\$1, \$2, \$3, \$4, \$5, \$6, \$7, \$8)";

    $result_insert = pg_query_params($connect, $query_insert, array($organization, $address, $director, $accountant, $taxpayer_number, $ogrn, $account, $user_id));

    if ($result_insert) {
        $_SESSION['message'] = "Данные успешно сохранены.";
    } else {
        $_SESSION['message'] = "Ошибка при сохранении данных: " . pg_last_error($connect);
    }
}

$_SESSION['save_success'] = true;
header("Location: ../../lk.php");
exit();
?>
