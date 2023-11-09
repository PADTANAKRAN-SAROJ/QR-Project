<?php 
include "../connect.php";
include "./checkRole.php";
?>
<html>
<body>
<div class="order">
    <?php
    $stmt = $pdo->prepare("SELECT *
        FROM orders o
        INNER JOIN menu m ON o.menu_id = m.menu_id
        INNER JOIN customer c ON o.cus_id = c.cus_id
        WHERE o.process IN ('Served', 'Cancel');
    ");

    $stmt->execute();
    $rows = $stmt->fetchAll();

    if (count($rows) > 0) {
        echo "    
        <table class='orders'>
            <tr>
                <th>เมนู</th>
                <th>จำนวน</th>
                <th>โต๊ะ</th>
                <th>สถานะ</th>
            </tr>";
        foreach ($rows as $row) {
            ?>
            <tr>
                <input type="hidden" id="order_id" value="<?=$row['order_id']?>">
                <td class="menu-td"><?= $row["menu_name"] ?>
                    <?php
                    if ($row["detail"] != "") {
                        echo " <div class='detail'> หมายเหตุ :" . $row["detail"] . "</div>";
                    }
                    ?>
                </td>
                <td><?=$row ["quantity"]?></td>
                <td><?=$row ["table_number"]?></td>
                <td>
                    <?php
                    if ($row["process"] == "Served") {
                        echo '<input class="served" type="submit" value="เสริฟ" onclick="served(this)">';
                    } elseif ($row["process"] == "Cancel") {
                        echo '<input class="cancel" type="submit" value="ยกแลิก" onclick="cancel(this)">';
                    }
                    ?>
                </td>
            </tr>
            <?php
        }
        echo "</table>";
    } else {
        ?>
        <div class="noOrder"><h1>ไม่พบรายการเสริฟ</h1></div>
        <?php
    }
    ?>
</div>

</body>
</html>
