<?php
include "../connect.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['order_id']) && isset($_POST['action'])) {
        $order_id = $_POST['order_id'];
        $action = $_POST['action'];

        // ตรวจสอบว่าผู้ใช้ล็อกอินและมีเซสชัน
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            if ($action == 'cancel') {
                $sql = "UPDATE orders SET process = 'Cancel' WHERE order_id = :order_id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
                $stmt->execute();
                echo "Order $order_id has been canceled.";
            } elseif ($action == 'complete') {
                $sql = "UPDATE orders SET process = 'Served' WHERE order_id = :order_id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
                $stmt->execute();
                echo "Order $order_id has been marked as served.";
            }
        } else {
            echo "ไม่อนุญาตให้ $action คำสั่งซื้อนี้";
        }
    }
}
?>
