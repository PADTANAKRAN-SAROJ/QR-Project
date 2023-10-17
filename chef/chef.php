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
    // Check if a form was submitted
    if (isset($_POST['order_id']) && isset($_POST['action'])) {
        $order_id = $_POST['order_id'];
        $action = $_POST['action'];

        // Check user authorization and perform actions in the database
        if ($action == 'cancel') {
            // Check user authorization here, e.g., based on user roles or session
            $authorized = true;

            if ($authorized) {
                // Perform the cancel action in the database
                // You need to write SQL query for this
                echo "Order $order_id has been canceled.";
            } else {
                echo "ไม่อนุญาตให้ยกเลิกคำสั่งซื้อนี้";
            }
        } elseif ($action == 'complete') {
            // Check user authorization here, e.g., based on user roles or session
            $authorized = true;

            if ($authorized) {
                // Perform the complete action in the database
                // You need to write SQL query for this
                echo "Order $order_id has been completed.";
            } else {
                echo "ไม่อนุญาตให้เสร็จสิ้นคำสั่งซื้อนี้";
            }
        }
    }

    // Query to retrieve order details with order_timestamp
    $sql = "SELECT orders.order_id, menu.menu_name, orders.quantity, orders.detail, orders.order_timestamp FROM orders
            INNER JOIN menu ON orders.menu_id = menu.menu_id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "<form method='post' action=''>"; // Form to submit order actions

        echo "<table>";
        echo "<tr><th>รหัสรายการ</th><th>ชื่อเมนู</th><th>จำนวน</th><th>รายละเอียด</th><th>เวลา</th><th>การดำเนินการ</th></tr>";

        while ($row = $stmt->fetch()) {
            $orderId = $row["order_id"];
            echo "<tr id='row_$orderId'><td>".htmlspecialchars($orderId)."</td><td>".htmlspecialchars($row["menu_name"])."</td><td>".htmlspecialchars($row["quantity"])."</td><td>".htmlspecialchars($row["detail"])."</td><td>".htmlspecialchars($row["order_timestamp"])."</td>";

            // Add Cancel and Complete buttons for each order
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
