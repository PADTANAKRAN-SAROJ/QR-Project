<?php include "../connect.php" ?>

<!DOCTYPE html>
<html>
<head>
    <title>รายการอาหารที่สั่ง</title>
</head>
<body>
    <h1>รายการอาหารที่สั่ง</h1>

    <?php
    // สร้างคำสั่ง SQL สำหรับดึงข้อมูลจากตาราง orders
    $sql = "SELECT * FROM orders";

    // ทำการ query ข้อมูลโดยใช้ PDO
    $stmt = $pdo->query($sql);

    // ตรวจสอบว่ามีข้อมูลหรือไม่
    if ($stmt->rowCount() > 0) {
        echo "<table>";
        echo "<tr><th>รหัสรายการ</th><th>รหัสลูกค้า</th><th>รหัสรายการอาหาร</th><th>จำนวน</th><th>สถานะ</th><th>รายละเอียด</th><th>เวลาที่สั่ง</th></tr>";

        while ($row = $stmt->fetch()) {
            echo "<tr><td>".$row["order_id"]."</td><td>".$row["cus_id"]."</td><td>".$row["menu_id"]."</td><td>".$row["quantity"]."</td><td>".$row["process"]."</td><td>".$row["detail"]."</td><td>".$row["order_timestamp"]."</td></tr>";
        }

        echo "</table>";
    } else {
        echo "ไม่มีข้อมูลในฐานข้อมูล";
    }
    ?>
</body>
</html>