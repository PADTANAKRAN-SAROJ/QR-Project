<?php
require_once 'connect.php';

$username = $_POST['username'];
$password = $_POST['password'];

if(empty($username) && empty($password)){
    header("location: login.php");
}
else{
    $stmt = $pdo->prepare("SELECT * FROM user WHERE username = :username AND password = :password");
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":password", $password);
    $stmt->execute();
    $user = $stmt->fetch();

    if (!empty($user)) {
        // เริ่ม session หรือใช้ session ที่มีอยู่แล้ว
        session_start();

        // ลบ session เก่า (ถ้ามี)
        session_unset();
        session_destroy();

        // สร้าง session ใหม่
        session_start();

        $role = $user['role'];
        $_SESSION['role'] = $role;

        header("Location: ./index.php");
        exit();
    } else {
        header("Location: login.php");
    }
}
?>