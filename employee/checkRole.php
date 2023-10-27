<?php
// เริ่ม session (หรือใช้การตรวจสอบการล็อกอินอื่น ๆ)
session_start();

// ตรวจสอบว่ามี session และมีตัวแปร role อยู่หรือไม่
if (isset($_SESSION['role'])) {
    //ถอดรหัส
    $decodedRole = base64_decode($_COOKIE['user']);

    // ตรวจสอบว่าบทบาทไม่ใช่ "admin" หรือ "employee"
    if ($decodedRole !== "admin" && $decodedRole !== "employee") {
        echo "ข้ออภัยคุณไม่มีสิทธิ์ในการเข้าถึงข้อมูล โปรดติดต่อหัวหน้า";
        exit;
    }
} else {
    // ถ้าไม่มี session หรือไม่มีบทบาท
    echo "ข้ออภัยคุณไม่มีสิทธิ์ในการเข้าถึงข้อมูล";
    exit;
}
?>
