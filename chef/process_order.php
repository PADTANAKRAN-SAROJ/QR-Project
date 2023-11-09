<?php
include "../connect.php";
include './checkRole.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['order_id']) && isset($_POST['action'])) {
        $order_id = $_POST['order_id'];
        $action = $_POST['action'];

    
        $authorized = true;//เดี่ยวค่อยใส่ ตรวจสอบsession มา

        if ($authorized) {
            if ($action == 'cancel') {
                $sql = "UPDATE orders SET process = 'Cancel' WHERE order_id = :order_id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
                $stmt->execute();
            } elseif ($action == 'complete') {
                $sql = "UPDATE orders SET process = 'Served' WHERE order_id = :order_id";
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
