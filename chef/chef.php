<?php include "../connect.php" ?>

<!DOCTYPE html>
<html>
<head>
    <title>รายการอาหารที่สั่ง</title>
</head>
<body>
    <h1>รายการอาหารที่สั่ง</h1>

    <?php
    // สร้างคำสั่ง SQL เพื่อดึงข้อมูลเฉพาะรหัสรายการ (order_id), ชื่อเมนู (menu_name), จำนวน (quantity), และรายละเอียด (detail)
    $sql = "SELECT orders.order_id, menu.menu_name, orders.quantity, orders.detail FROM orders
            INNER JOIN menu ON orders.menu_id = menu.menu_id";

    // ทำการ query ข้อมูลโดยใช้ PDO
    $stmt = $pdo->query($sql);

    // ตรวจสอบว่ามีข้อมูลหรือไม่
    if ($stmt->rowCount() > 0) {
        echo "<table>";
        echo "<tr><th>รหัสรายการ</th><th>ชื่อเมนู</th><th>จำนวน</th><th>รายละเอียด</th></tr>";

        while ($row = $stmt->fetch()) {
            echo "<tr><td>".$row["order_id"]."</td><td>".$row["menu_name"]."</td><td>".$row["quantity"]."</td><td>".$row["detail"]."</td></tr>";
        }

        echo "</table>";
    } else {
        echo "ไม่มีข้อมูลในฐานข้อมูล";
    }
    ?>
</body>
</html>
