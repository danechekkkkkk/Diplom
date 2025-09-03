<?php
require_once '../connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id'], $_POST['editName'], $_POST['editArt'], $_POST['editCount'], $_POST['editPrice'])) {
        $id = intval($_POST['id']); 
        $name = $_POST['editName'];
        $art = $_POST['editArt'];
        $count = intval($_POST['editCount']); 
        $salePrice = floatval($_POST['editPrice']); 

       
        $query = "UPDATE warehouse SET name = \$1, art = \$2, count = \$3, sale_price = \$4 WHERE id = \$5";
        
        
        $result = pg_query_params($connect, $query, array($name, $art, $count, $salePrice, $id));

        if ($result) {
            header("Location: ../../warehouse.php");
            exit(); 
        } else {
            echo "Ошибка при обновлении записи: " . pg_last_error($connect);
        }
    } else {
        echo "Отсутствуют необходимые данные для обновления.";
    }
}
?>
