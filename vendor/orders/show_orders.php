<?php
$query = "
    SELECT i.id, i.supplier, i.buyer, i.created_at, i.address, i.phone, SUM(it.total) AS total_amount
    FROM invoices i
    LEFT JOIN items it ON i.id = it.invoices_id
    WHERE i.user_id = \$1
    GROUP BY i.id
";
$result = pg_query_params($connect, $query, array($_SESSION['user_id']));

if ($result && pg_num_rows($result) > 0) {
    while ($row = pg_fetch_assoc($result)) {
        $formatted_total = number_format($row['total_amount'], 2, '.', ' '); 

        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['supplier']}</td> 
            <td>{$row['buyer']}</td>
            <td>{$row['created_at']}</td>
            <td>{$row['address']}</td>
            <td>{$row['phone']}</td>
            <td>{$formatted_total} ₽</td> 
            <td>
                <a href='vendor/orders/download.php?id={$row['id']}' title='Скачать накладную'>
                    <img src='images/download_icon.svg' class='download-icon' alt='Загрузить' style='width: 24px; height: 24px;'>
                </a>
                </td>
               <td>
    <img src='images/delete-icon.svg' class='delete-icon' alt='Удалить' data-id='{$row['id']}'>
</td>

        </tr>";
    }
} else {
    echo "<tr class='no_data'><td colspan='9' class='no_data'>Нет записей для отображения</td></tr>";
}
?>



