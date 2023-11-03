<!DOCTYPE html>
<html lang="en">
<body>
    <?php
    include "../connect.php";
    include "./checkSession.php";

    // เช็คว่า session 'cart' มีค่าหรือไม่
    if (!empty($_SESSION['cart'])) {
        $current_timestamp = date("Y-m-d H:i:s");

        // วนลูปเพื่อแสดงรายการสินค้าในตะกร้า
        foreach ($_SESSION['cart'] as $menu_id => $item) {
            $cus_id = $_SESSION["cus_id"];
            $menu_id = $item['menu_id'];
            $qty = $item['qty'];
            $detail = $item['detail'];
            $process = "Cooking";

            $stmt = $pdo->prepare("INSERT INTO orders (cus_id, menu_id, process, quantity, detail, order_timestamp) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bindParam(1, $cus_id);
            $stmt->bindParam(2, $menu_id);
            $stmt->bindParam(3, $process);
            $stmt->bindParam(4, $qty);
            $stmt->bindParam(5, $detail);
            $stmt->bindParam(6, $current_timestamp);
             
            $stmt->execute();

            // ลบตะกร้าสินค้าที่อยู่ใน $_SESSION
            unset($_SESSION['cart']);
            header("Location: ./history.php");
        }
    } else {
        echo "ไม่มีสินค้าในตะกร้า";
        echo "<a href='./category.php'>กลับไปเลือกสินค้า</a>";
    }

    ?>
</body>
</html>
