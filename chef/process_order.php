<?php
include "../connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['order_id']) && isset($_POST['action'])) {
        $order_id = $_POST['order_id'];
        $action = $_POST['action'];

    
        $authorized = true;

        if ($authorized) {
            if ($action == 'cancel') {
                $sql = "UPDATE orders SET status = 'Canceled' WHERE order_id = :order_id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
                $stmt->execute();
            } elseif ($action == 'complete') {
                $sql = "UPDATE orders SET status = 'Completed' WHERE order_id = :order_id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
                $stmt->execute();
            }
            echo "Order $order_id has been $action.";
        } else {
            echo "ไม่อนุญาตให้ $action คำสั่งซื้อนี้";
        }
    }
}
?>
