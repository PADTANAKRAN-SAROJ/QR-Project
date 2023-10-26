<?php
session_start(); // เริ่มเซสชันตอนแรก
include "../connect.php";

//ตรวจสอบข้อมูลที่ได้มาจากลิ้ง
if (isset($_GET['cus_id'])) {
    $cusId = $_GET['cus_id'];
    $tableNumber = $_GET['table_number'];
    $entryTimestamp = $_GET['entry_time'];
    //ดึงข้อมูลจากดาต้า เพื่อนำมาตรวจสอบสถาระของ โต๊ะนั้นๆ
    $sql = "SELECT * FROM customer WHERE cus_id = :cus_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':cus_id', $cusId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $databaseTableNumber = $row['table_number'];
            $databaseEntryTime = $row['entry_timestamp'];
            //ลูกค้าที่ โต๊ะว่างไปแล้วจะขอบคุณไม่สามารถเข้าถึงหนา้นั้นได้
            if ($row['state'] == 'Done') {
                echo "ขอบคุณที่อุดหนุน!";
                header("Location: ../thackYou.php");
            } else {
                //ตรวจสอบว่าข้อมูลที่ได้มานั้นถูกต้องไหม
                if ($databaseTableNumber == $tableNumber && $databaseEntryTime == $entryTimestamp) {
                    
                    // สร้าง session cart and cus_id สร้างใหม่ตลอดเพื่อปก้องกัน ข้อมูลเดิม หลงเหลือ กรณี กินอาหารวันเดียวกัน และ cookie ยังอยู่
                    $_SESSION['cart'] = array();
                    $_SESSION['cus_id'] = $cusId;
                    
                    setcookie("cart", serialize($_SESSION['cart']), time() + 43200, "/"); // ตั้งค่าคุกกี้ "cart" มีอายุ 12 ชั่วโมง
                
                    $encodedCusId = base64_encode($cusId);
                    setcookie("cus_id", $encodedCusId, time() + 43200, "/"); // ตั้งค่าคุกกี "cus_id" มีอายุ 12 ชั่วโมง
                    
                    //ไปหน้าcategory เมื่อสร้าง sessionเสร็จสิ้น
                    header("Location: ./category.php");
                } else {
                    echo "ไม่พบข้อมูล โปรดติดต่อพนักงาน";
                }
            }
        } else {
            echo "ไม่พบข้อมูลในฐานข้อมูล";
        }
    } else {
        echo "เกิดข้อผิดพลาดในการคิวรีข้อมูล";
    }
} else {
    echo "ไม่มี Cus ID ใน GET ไม่สามารถดึงข้อมูล";
}
?>
