<?php
$query = "SELECT * FROM procurement where user_id = \$1";
$result = pg_query_params($connect, $query, array($_SESSION['user_id']));

if ($result && pg_num_rows($result) > 0) {
    while ($row = pg_fetch_assoc($result)) {
        $formatted_purchase_price = number_format($row['purchase_price'], 2, '.', ' '); 
        $formatted_sale_price = number_format($row['sale_price'], 2, '.', ' '); 
        $formatted_total = number_format($row['total'], 2, '.', ' '); 

        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['art']}</td> 
            <td>{$row['count']} шт.</td>
            <td>{$row['supplier']}</td>
            <td>{$formatted_purchase_price} &#8381</td>
            <td>{$formatted_sale_price} &#8381</td>
            <td>{$formatted_total} &#8381</td>
            </tr>";
    }
} else {
    echo "<tr class = 'no_data'><td colspan='8'>Нет записей для отображения</td></tr>";
}
?>
