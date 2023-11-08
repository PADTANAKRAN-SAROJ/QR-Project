<?php
include "../../connect.php";
include "../checkRole.php";
// ตรวจสอบว่ามีการส่ง ID และ restaurant_name_eng มาจาก URL
if (isset($_GET['id']) && isset($_GET['restaurant_name_eng'])) {
    // รับค่า ID และ restaurant_name_eng จาก URL
    $id = $_GET['id'];
    $restaurant_name_eng = $_GET['restaurant_name_eng'];

    // อัปเดตค่าในฐานข้อมูล
    $sql = "UPDATE restaurant SET restaurant_name_eng = :restaurant_name_eng WHERE id = :id";

    // ใช้ PDO เพื่อป้องกัน SQL Injection
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':restaurant_name_eng', $restaurant_name_eng, PDO::PARAM_STR);
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
    // ถ้าไม่มี ID หรือ restaurant_name_eng ใน URL
    header("Location: ../index.php");
}
?>
