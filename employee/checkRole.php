<?php
session_start();

if (isset($_SESSION['role'])) {
    // ตรวจสอบบทบาท
    $role = $_SESSION['role'];

    // ตรวจสอบว่าบทบาทไม่ใช่ "admin" หรือ "employee"
    if ($role !== "admin" && $role !== "employee") {
        header("Location: ../login.php");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}

?>
