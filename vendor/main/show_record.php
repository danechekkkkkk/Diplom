<?php
$query = "SELECT * FROM main where user_id = \$1";
$result = pg_query_params($connect, $query, array($_SESSION['user_id']));

if ($result) {
    while ($row = pg_fetch_assoc($result)) {
        $formatted_price = number_format($row['price'], 2, '.', ' '); 
        $formatted_total = number_format($row['total_amount'], 2, '.', ' '); 

        echo "<tr>
            <td>{$row['name']}</td>
            <td>{$row['code']}</td> 
            <td>{$row['artikul']}</td>
            <td>{$row['client']}</td>
            <td>{$row['date']}</td>
            <td>{$row['count']} шт.</td>
            <td>{$formatted_price} ₽</td> 
            <td>{$formatted_total} ₽</td> 
            </tr>";
    }
} else {
    echo "<tr><td colspan='8'>Нет записей для отображения</td></tr>";
}
?>
