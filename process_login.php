<?php
require_once 'connect.php';

// รับข้อมูลจากฟอร์มเข้าสู่ระบบ
$username = $_POST['username'];
$password = $_POST['password'];


// ใช้การสร้างคำสั่ง SQL ด้วย PDO
$stmt = $pdo->prepare("SELECT * FROM user WHERE username = :username AND password = :password");
$stmt->bindParam(":username", $username);
$stmt->bindParam(":password", $password);
$stmt->execute();

// ตรวจสอบผลลัพธ์
if ($stmt->rowCount() == 1) {
    // การเข้าสู่ระบบถูกต้อง
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    session_start();

    // ตรวจสอบบทบาท (role)
    $role = $user['role'];
    $_SESSION['role'] = $role;

    // สร้าง Cookieแบบใส่รหัส
    $encodedRole = base64_encode($role);
    setcookie("role", $encodedRole, time() + 3600, "/"); // Cookie มีอายุ 1 ชั่วโมง


    header("Location: ./index.php");
    exit();
} else {
    // การเข้าสู่ระบบไม่ถูกต้อง
    echo "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
    header("Location: login.php");
}


?>