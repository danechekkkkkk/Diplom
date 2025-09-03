<?php
session_start();
require_once '../connect.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $supplier = $data['supplier'];
    $buyer = $data['buyer'];
    $address = $data['address'];
    $phone = $data['phone'];
    $contact_person = $data['contact_person'];
    $tableData = $data['tableData'];
    $user_id = $_SESSION['user_id'];

    $insertQuery = "INSERT INTO invoices (supplier, buyer, address, phone, contact_person, user_id) VALUES (\$1, \$2, \$3, \$4, \$5, \$6) RETURNING id";
    $result = pg_query_params($connect, $insertQuery, array($supplier, $buyer, $address, $phone, $contact_person, $user_id));

    if (!$result) {
        echo json_encode(['status' => 'error', 'message' => 'Ошибка при сохранении накладной']);
        exit;
    }

    $invoiceId = pg_fetch_result($result, 0, 0); 

    foreach ($tableData as $item) {
        $id = (int)$item['id']; 
        $name = $item['name'];
        $count = $item['count'];
        $price = $item['price'];
        $total = $item['total'];

        $itemQuery = "INSERT INTO items (invoices_id, name, count, price, total) VALUES (\$1, \$2, \$3, \$4, \$5)";
        $itemResult = pg_query_params($connect, $itemQuery, array($invoiceId, $name, $count, $price, $total));

        if (!$itemResult) {
            echo json_encode(['status' => 'error', 'message' => 'Ошибка при сохранении товара с ID ' . $id]);
            exit;
        }

        $updateQuery = "UPDATE warehouse SET count = count - \$1 WHERE id = \$2";
        $updateResult = pg_query_params($connect, $updateQuery, array($count, $id));

        if (!$updateResult) {
            echo json_encode(['status' => 'error', 'message' => 'Ошибка при обновлении количества товара с ID ' . $id]);
            exit;
        }
    }

    echo json_encode(['status' => 'success', 'message' => 'Накладная успешно сохранена', 'invoice_id' => $invoiceId]);

} else {
    echo json_encode(['status' => 'error', 'message' => 'Неверный метод запроса']);
}
?>
