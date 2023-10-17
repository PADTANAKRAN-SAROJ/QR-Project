<?php
include "../connect.php" ;
if (isset($_GET['cus_id'])) {
    $cusId = $_GET['cus_id'];

    // ตรวจสอบว่า cus_id นี้มีอยู่ในฐานข้อมูลหรือไม่
    $sql = "SELECT * FROM customer WHERE cus_id = :cus_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':cus_id', $cusId, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        // ตรวจสอบว่ามีข้อมูลลูกค้าในฐานข้อมูล
        if ($stmt->rowCount() > 0) {
            // อัปเดตสถานะของลูกค้าเป็น "Done"
            $updateSql = "UPDATE customer SET state = 'Done' WHERE cus_id = :cus_id";
            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->bindParam(':cus_id', $cusId, PDO::PARAM_INT);
            if ($updateStmt->execute()) {
                echo "บิลของลูกค้ารหัส $cusId อัปเดตสถานะเป็น 'Done'";
                echo '<script>window.location.href = "employee.php";</script>';
            } else {
                echo "ไม่สามารถอัปเดตสถานะบิลได้";
            }
        } else {
            echo "ไม่พบข้อมูลลูกค้าสำหรับ cus_id ที่ระบุ";
        }
    } else {
        echo "เกิดข้อผิดพลาดในการคิวรีข้อมูล";
    }
} else {
    echo "ไม่ได้ระบุ cus_id";
}
?>