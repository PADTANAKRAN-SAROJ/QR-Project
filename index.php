<?php
session_start();

if (isset($_SESSION['role'])) {
    if (isset($_COOKIE['role'])) {
        // ถอดรหัส
        $decodedRole = base64_decode($_COOKIE['role']);

        if ($decodedRole == "admin") {
            header("Location: ./admin/admin.php");
            exit();
        } else if ($decodedRole == "chef") {
            header("Location: ./chef/chef.php");
            exit();
        } else if ($decodedRole == "employee") {
            // หากไม่ใช่ admin หรือ chef ให้เปลี่ยนไปยังหน้าอื่น ๆ
            header("Location: ./employee/index.php");
            exit();
        }
    } else {
        // ถ้าไม่มีคีย์ 'role' ใน $_COOKIE
        echo "ข้อผิดพลาด: ไม่มีคีย์ 'role' ในคุกกี้";
        header("Location: login.php");
        exit();
    }
} else {
    // ถ้าไม่มี session หรือไม่มีบทบาท
    echo "ข้ออภัยคุณไม่มีสิทธิ์ในการเข้าถึงข้อมูล";
    header("Location: login.php");
    exit();
}

?>