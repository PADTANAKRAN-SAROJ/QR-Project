<?php
session_start();

if (isset($_COOKIE['role'])) {
    //ถอดรหัส
    $decodedRole = base64_decode($_COOKIE['role']);

    // ตรวจสอบว่าบทบาทไม่ใช่ "admin" หรือ "employee"
    if ($decodedRole !== "admin" && $decodedRole !== "employee") {
        header("Location: ../login.php");
        exit;
    }
} else {
    // ถ้าไม่มี session หรือไม่มีบทบาท
    header("Location: ../login.php");
    exit;
}
?>
