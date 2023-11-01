<?php
include "../../connect.php";

// ตรวจสอบว่ามีการส่ง ID และ restaurant_name_thai มาจาก URL
if (isset($_GET['id']) && isset($_GET['restaurant_name_thai'])) {
    // รับค่า ID และ restaurant_name_thai จาก URL
    $id = $_GET['id'];
    $restaurant_name_thai = $_GET['restaurant_name_thai'];

    // อัปเดตค่าในฐานข้อมูล
    $sql = "UPDATE restaurant SET restaurant_name_thai = :restaurant_name_thai WHERE id = :id";

    // ใช้ PDO เพื่อป้องกัน SQL Injection
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':restaurant_name_thai', $restaurant_name_thai, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // ทำการอัปเดต
    if ($stmt->execute()) {
        // อัปเดตสำเร็จ
        header("Location: ./index.php");
    } else {
        // อัปเดตไม่สำเร็จ
        header("Location: ./index.php");
    }
} else {
    // ถ้าไม่มี ID หรือ restaurant_name_thai ใน URL
    header("Location: ../index.php");
}
?>
