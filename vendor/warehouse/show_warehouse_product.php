<?php
$query = "SELECT * FROM warehouse where user_id = \$1";
$result = pg_query_params($connect, $query, array($_SESSION['user_id']));

if ($result && pg_num_rows($result) > 0) {
    while ($row = pg_fetch_assoc($result)) {
        $row['total'] = $row['sale_price'] * $row['count'];
        $formatted_sale_price = number_format($row['sale_price'], 2, '.', ' '); 
        $formatted_total = number_format($row['total'], 2, '.', ' '); 

        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['art']}</td> 
            <td>{$row['count']} шт.</td>
            <td>{$formatted_sale_price} &#8381</td>
            <td>{$formatted_total} &#8381</td>
            <td>
                <img src='images/edit_data_icon.svg' class='edit-icon' 
                     alt='Редактировать' style='cursor:pointer;'
                     data-id='{$row['id']}' 
                     data-name='{$row['name']}' 
                     data-art='{$row['art']}' 
                     data-count='{$row['count']}' 
                     data-sale-price='{$row['sale_price']}'>
            </td>
            <td>
                <img src='images/delete-icon.svg' class='delete-icon' alt='Удалить' data-id='{$row['id']}'>
            </td>
            </tr>";
    }
} else {
    echo "<tr class='no_data'><td colspan='8'>Нет записей для отображения</td></tr>";
}

?>
