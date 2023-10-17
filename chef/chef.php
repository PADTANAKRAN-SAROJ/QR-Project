<?php include "../connect.php" ?>
<!DOCTYPE html>
<html>
<head>
    <title>รายการอาหารที่สั่ง</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
    </style>

    <script>
        function hideAndRemoveRow(orderId) {
            var row = document.getElementById("row_" + orderId);
            row.style.display = "none";
            row.parentNode.removeChild(row);
        }
    </script>
</head>
<body>
    <h1>รายการอาหารที่สั่ง</h1>

    <?php
         //ตรวจการส่งแบบฟอร์ม
    if (isset($_POST['order_id']) && isset($_POST['action'])) {
        $order_id = $_POST['order_id'];
        $action = $_POST['action'];

        // ตรวจการอนุมัตuser&data
        if ($action == 'cancel') {
            $authorized = true;
            if ($authorized) {
                //เขียนSQL query
                echo "Order $order_id has been canceled.";
            } else {
                echo "ไม่อนุญาตให้ยกเลิกคำสั่งซื้อนี้";
            }
        } elseif ($action == 'complete') {
            //ตรวจการให้สิทธิ์
            $authorized = true;

            if ($authorized) {
                //ดำเนินการทั้งหมดในฐานข้อมูล
                echo "Order $order_id has been completed.";
            } else {
                echo "ไม่อนุญาตให้เสร็จสิ้นคำสั่งซื้อนี้";
            }
        }
    }

    // ดึงรายละเอียดคำสั่งซื้อด้วย order_timestamp
    $sql = "SELECT orders.order_id, menu.menu_name, orders.quantity, orders.detail, orders.order_timestamp FROM orders
            INNER JOIN menu ON orders.menu_id = menu.menu_id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "<form method='post' action=''>"; //การสั่งซื้อ

        echo "<table>";
        echo "<tr><th>รหัสรายการ</th><th>ชื่อเมนู</th><th>จำนวน</th><th>รายละเอียด</th><th>เวลา</th><th>การดำเนินการ</th></tr>";

        while ($row = $stmt->fetch()) {
            $orderId = $row["order_id"];
            echo "<tr id='row_$orderId'><td>".htmlspecialchars($orderId)."</td><td>".htmlspecialchars($row["menu_name"])."</td><td>".htmlspecialchars($row["quantity"])."</td><td>".htmlspecialchars($row["detail"])."</td><td>".htmlspecialchars($row["order_timestamp"])."</td>";

            //  Cancel&Completeของทุกๆorder
            echo "<td>
                <input type='hidden' name='order_id' value='".$orderId."'>
                <button type='submit' name='action' value='cancel' onclick='hideAndRemoveRow($orderId)'>Cancel</button>
                <button type='submit' name='action' value='complete' onclick='hideAndRemoveRow($orderId)'>Complete</button>
            </td></tr>";
        }

        echo "</table>";
        echo "</form>";
    } else {
        echo "ไม่มีข้อมูลในฐานข้อมูล";
    }
    ?>
</body>
</html>
