<?php
require_once 'connect.php';

// รับข้อมูลจากฟอร์มเข้าสู่ระบบ
$username = $_POST['username'];
$password = $_POST['password'];

try {
    // ใช้การสร้างคำสั่ง SQL ด้วย PDO
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = :username AND password = :password");
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":password", $password);
    $stmt->execute();

    // ตรวจสอบผลลัพธ์
    if ($stmt->rowCount() == 1) {
        // การเข้าสู่ระบบถูกต้อง
        session_start();
        $_SESSION['username'] = $username;

        // สร้าง Cookie
        setcookie("user", $username, time() + 3600, "/"); // Cookie มีอายุ 1 ชั่วโมง

        header("Location: index.php"); // ส่งผู้ใช้ไปยังหน้า admin.php
        exit();
    } else {
        // การเข้าสู่ระบบไม่ถูกต้อง
        echo "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
        header("Location: login.php");
    }
} catch (PDOException $e) {
    die("เกิดข้อผิดพลาดในการดำเนินการ: " . $e->getMessage());
    header("Location: login.php");
}
?>
