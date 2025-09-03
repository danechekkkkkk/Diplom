<?php
$query = "SELECT id, buyer, address, phone, contact_person FROM invoices where user_id = \$1";
$result = pg_query_params($connect, $query, array($_SESSION['user_id']));

if ($result && pg_num_rows($result) > 0) {
    while ($row = pg_fetch_assoc($result)) {
        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['buyer']}</td>
            <td>{$row['address']}</td> 
            <td>{$row['phone']}</td>
            <td>{$row['contact_person']}</td>
            </tr>";
    }
} else {
    echo "<tr class = 'no_data'><td colspan='5'>Нет записей для отображения</td></tr>";
}
?>
