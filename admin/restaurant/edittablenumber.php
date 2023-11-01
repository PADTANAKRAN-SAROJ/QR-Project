<?php
include "../../connect.php";

// ตรวจสอบว่ามีการส่ง ID และ number_of_tables มาจาก URL
if (isset($_GET['id']) && isset($_GET['number_of_tables'])) {
    // รับค่า ID และ number_of_tables จาก URL
    $id = $_GET['id'];
    $number_of_tables = $_GET['number_of_tables'];

    // ตรวจสอบว่า number_of_tables เป็นตัวเลข
    if (is_numeric($number_of_tables)) {
        // อัปเดตค่าในฐานข้อมูล
        $sql = "UPDATE restaurant SET number_of_tables = :number_of_tables WHERE id = :id";

        // ใช้ PDO เพื่อป้องกัน SQL Injection
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':number_of_tables', $number_of_tables, PDO::PARAM_INT);
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
        // ถ้า number_of_tables ไม่ใช่ตัวเลข
        header("Location: ./index.php");
    }
} else {
    // ถ้าไม่มี ID หรือ number_of_tables ใน URL
    header("Location: ../index.php");
}
?>
