<?php 
    include "../connect.php";
?>
<table>
    
    <?php
    $stmt = $pdo->prepare("SELECT *
        FROM orders o
        INNER JOIN menu m ON o.menu_id = m.menu_id
        INNER JOIN customer c ON o.cus_id = c.cus_id
        WHERE o.process LIKE '%Serve%';
    ");

    
    $stmt->execute();
    $rows = $stmt->fetchAll();

    if (count($rows) > 0) {
        echo "    
        <tr>
            <th>เมนู</th>
            <th>จำนวน</th>
            <th>โต๊ะ</th>
            <th>ส่งงาน</th>
        </tr>";
        foreach ($rows as $row) {
    ?>
    
    <tr>
        <input type="hidden" id="order_id" value="<?=$row['order_id']?>">
        <td><?=$row ["menu_name"]?> (<?=$row ["category"]?>)</td>
        <td><?=$row ["quantity"]?></td>
        <td><?=$row ["table_number"]?></td>
        <td><input type="submit" onclick="served(this)"></td>
    </tr>
    <?php }
    } else {
        // ถ้าไม่มีข้อมูล
        echo "<h1>ไม่พบรายการเสริฟ</h1>";
    }
    ?>

</table>

