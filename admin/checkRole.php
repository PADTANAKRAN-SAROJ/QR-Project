<?php
// เริ่ม session (หรือใช้การตรวจสอบการล็อกอินอื่น ๆ)
session_start();

// ตรวจสอบว่ามี session และมีคุ๊กกี้ role อยู่หรือไม่
if (isset($_COOKIE['role'])) {
    $decodedRole = base64_decode($_COOKIE['role']);

    // ตรวจสอบว่าบทบาทไม่ใช่ "admin"
    if ($decodedRole === "admin") {
        // "คุณมีสิทธิ์ในการเข้าถึงข้อมูล";
    } else {
        header("Location: ../login.php");
    }
} else {
    // ถ้าไม่มี session หรือไม่มีคุ๊กกี้ role
    header("Location: ../login.php");
}

?>
