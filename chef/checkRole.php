<?php
session_start();

// ตรวจสอบว่ามี session และค่า role ถูกตั้งไว้หรือไม่
if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];

    // ตรวจสอบว่าบทบาทไม่ใช่ "chef"
    if ($role === "chef") {
        // "คุณมีสิทธิ์ในการเข้าถึงข้อมูล";
    } else {
        header("Location: ../login.php");
        exit;
    }
} else {
    // ถ้าไม่มี session หรือไม่มีค่า role
    header("Location: ../login.php");
    exit;
}

?>