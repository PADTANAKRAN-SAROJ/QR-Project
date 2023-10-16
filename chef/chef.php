<?php include "../connect.php" ?>

<!DOCTYPE html>
<html>
<head>
    <title>รายการอาหารที่สั่ง</title>
</head>
<body>
    <h1>รายการอาหารที่สั่ง</h1>

    <?php
    // Check if a form was submitted
    if (isset($_POST['order_id']) && isset($_POST['action'])) {
        $order_id = $_POST['order_id'];
        $action = $_POST['action'];

        // You can add code here to handle the "Cancel" and "Complete" actions in the database.
        // For now, let's just display a confirmation message and remove the row from the display.
        if ($action == 'cancel') {
            echo "Order $order_id has been canceled.";
        } elseif ($action == 'complete') {
            echo "Order $order_id has been completed.";
        }
    }

    // Query to retrieve order details
    $sql = "SELECT orders.order_id, menu.menu_name, orders.quantity, orders.detail FROM orders
            INNER JOIN menu ON orders.menu_id = menu.menu_id";

    $stmt = $pdo->query($sql);

    if ($stmt->rowCount() > 0) {
        echo "<form method='post' action=''>"; // Form to submit order actions

        echo "<table>";
        echo "<tr><th>รหัสรายการ</th><th>ชื่อเมนู</th><th>จำนวน</th><th>รายละเอียด</th><th>การดำเนินการ</th></tr>";

        while ($row = $stmt->fetch()) {
            echo "<tr><td>".$row["order_id"]."</td><td>".$row["menu_name"]."</td><td>".$row["quantity"]."</td><td>".$row["detail"]."</td>";
            
            // Add Cancel and Complete buttons for each order
            echo "<td>
                <input type='hidden' name='order_id' value='".$row["order_id"]."'>
                <button type='submit' name='action' value='cancel'>Cancel</button>
                <button type='submit' name='action' value='complete'>Complete</button>
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
