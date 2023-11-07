<?php
include "../connect.php";
include "./checkRole.php";

if (isset($_GET['cus_id'])) {
    $cusId = $_GET['cus_id'];

    // ตรวจสอบว่า cus_id นี้มีอยู่ในฐานข้อมูล
    $sql = "SELECT * FROM customer WHERE cus_id = :cus_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':cus_id', $cusId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // ตรวจสอบว่ามีข้อมูลลูกค้าในฐานข้อมูล
        if ($stmt->rowCount() > 0) {
            // ตรวจสอบว่ามีคำสั่งที่มีสถานะ "Served" หรือ "Cooking" อยู่ในโต๊ะนี้หรือไม่
            $orderSql = "SELECT COUNT(*) FROM orders WHERE cus_id = :cus_id AND (process = 'Served' OR process = 'Cooking')";
            $orderStmt = $pdo->prepare($orderSql);
            $orderStmt->bindParam(':cus_id', $cusId, PDO::PARAM_INT);
            if ($orderStmt->execute()) {
                $orderCount = $orderStmt->fetchColumn();
                if ($orderCount == 0) {

                    $updateSql = "UPDATE customer SET state = 'Done' WHERE cus_id = :cus_id";
                    $updateStmt = $pdo->prepare($updateSql);
                    $updateStmt->bindParam(':cus_id', $cusId, PDO::PARAM_INT);
                    if ($updateStmt->execute()) {
                        header("Location: ./QRcode.php");
                    }
                } else {
                    echo '<script>
                            window.location.href = "./index.php";
                            alert("รายการอาหารบางรายการยังไม่ถูกเสริฟ");
                        </script>';
                }
            }
        }
    }
}
?>
