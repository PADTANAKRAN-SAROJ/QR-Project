<?php
// เริ่ม session (หรือใช้การตรวจสอบการล็อกอินอื่น ๆ)
include "../connect.php";
session_start();
if (isset($_COOKIE['cus_id'])) {
// เมื่อต้องการใช้ค่า cus_id ในรูปแบบที่ถูกถอดรหัส
$decodedCusId = base64_decode($_COOKIE['cus_id']);
echo "ค่า cus_id ที่ถูกถอดรหัส: " . $decodedCusId;

//ตรวจสอบสถาณะของโต๊ะนั้นๆ
$sql = "SELECT * FROM customer WHERE cus_id = :decodedCusId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':decodedCusId', $decodedCusId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $databaseTableNumber = $row['table_number'];
            $databaseEntryTime = $row['entry_timestamp'];

            if ($row['state'] == 'Done') {
                echo "ไปที่หน้า  ขอบคุณที่อุดหนุน!";
                header("Location: ../thankYou.php");
            }else{
                echo "ยินดีต้อนรับ! อยู่หน้าเดิม";
            }
        } else {
            echo "ไม่พบข้อมูลในฐานข้อมูล ไปหน้าปิดปรับปรุง";
            header("Location: ../contactStaff.php");
        }
    } else {
        echo "เกิดข้อผิดพลาดในการคิวรีข้อมูล ไปหน้าปิดปรับปรุง";
        header("Location: ../contactStaff.php");
    }

}else{
    echo "ไม่มีคุกกี 'cus_id' หรืออาจไม่ได้ถูกตั้งค่า";
    header("Location: ../contactStaff.php");
}