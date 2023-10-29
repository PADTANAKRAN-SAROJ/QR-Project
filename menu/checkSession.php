<?php
// เริ่ม session (หรือใช้การตรวจสอบการล็อกอินอื่น ๆ)
include "../connect.php";
session_start();
if (isset($_COOKIE['cus_id'])) {
    $decodedCusId = base64_decode($_COOKIE['cus_id']);

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
                header("Location: ../thankYou.php");
            }
        } else {
            header("Location: ../contactStaff.php");
        }
    } else {
        header("Location: ../contactStaff.php");
    }

}else{
    header("Location: ../contactStaff.php");
}