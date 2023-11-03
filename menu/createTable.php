<?php
session_start(); // เริ่มเซสชัน

// ลบ session เก่า (ถ้ามี)
session_unset();
session_destroy();

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
                header("Location: ../thackYou.php");
            } 
            else {
                //ตรวจสอบว่าข้อมูลที่ได้มานั้นถูกต้องไหม
                if ($databaseTableNumber == $tableNumber && $databaseEntryTime == $entryTimestamp) {
                    // ลบคุกกี้เก่าที่อาจถูกใช้ไว้
                    if (isset($_COOKIE['cart'])) {
                        setcookie("cart", "", time() - 10800, "/");
                    }
                    if (isset($_COOKIE['cus_id'])) {
                        setcookie("cus_id", "", time() - 10800, "/");
                    }

                    // เริ่ม session ใหม่
                    session_start();

                    // สร้าง session ใหม่เมื่อข้อมูลถูกตรวจสอบและถูกต้อง
                    $_SESSION['cart'] = array();
                    $_SESSION['cus_id'] = $cusId;

                    // สร้าง cookie ใหม่ 3 ชม
                    setcookie("cart", "", time() - 10800, "/");
                    setcookie("cus_id", "", time() - 10800, "/");

                    
                    //ไปหน้าcategory เมื่อสร้าง sessionเสร็จสิ้น
                    header("Location: ./category.php");
                }else {
                    header("Location: ../contactStaff.php");
                }
            }
        } else {
            header("Location: ../contactStaff.php");
        }
    }else {
        header("Location: ../contactStaff.php");
    }
}else {
    header("Location: ../contactStaff.php");
}
?>
