<?php
session_start();
require '../connect.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $user_id = $_SESSION['user_id']; 

    // Запрос на удаление
    $query = "DELETE FROM invoices WHERE id = \$1 AND user_id = \$2";
    $result = pg_query_params($connect, $query, array($id, $user_id));

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Ошибка при удалении записи.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Неверный запрос.']);
}
?>
