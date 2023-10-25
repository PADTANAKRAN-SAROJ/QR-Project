<?php 
include "../connect.php" ;
include "./checkRole.php" ;

if (isset($_GET["order_id"])) { // ใช้ $_GET ในการรับค่า
    $order_id = $_GET["order_id"];
    
    $stmt = $pdo->prepare("UPDATE orders SET process='Done' WHERE order_id = ?");
    $stmt->bindParam(1, $order_id);

    if ($stmt->execute()) {
        exit;
    } 
}
?>
