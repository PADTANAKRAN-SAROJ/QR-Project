<?php
session_start(); // เริ่มเซสชันหรือใช้เซสชันที่มีอยู่

if (!isset($_SESSION['username'])) {
    // ถ้าไม่มีเซสชันชื่อผู้ใช้งาน หมายความว่ายังไม่เข้าสู่ระบบ
    header("Location: login.php"); // เด้งไปยังหน้า login.php
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <a href="./admin/admin.php">admin</a>
    <a href="./chef/chef.php">chef</a>
    <a href="./employee/employee.php">employee</a>
    <a href="./menu/menu.php">menu</a>
</body>
</html>