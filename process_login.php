<?php
require_once 'connect.php';

// รับข้อมูลจากฟอร์มเข้าสู่ระบบ
$username = $_POST['username'];
$password = $_POST['password'];

// ...

try {
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
        $_SESSION['username'] = $username;

        // ตรวจสอบบทบาท (role)
        $role = $user['role'];
        $_SESSION['role'] = $role;

        // สร้าง Cookie
        setcookie("user", $username, time() + 3600, "/"); // Cookie มีอายุ 1 ชั่วโมง

        if($role=="admin"){
            header("Location: ./admin/admin.php");
        }else if($role=="chef"){
            header("Location: ./chef/chef.php");
        }else if($role=="employee"){
            // หากไม่ใช่ admin หรือ chef ให้เปลี่ยนไปยังหน้าอื่น ๆ
            header("Location: ./employee/index.php");
        }
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
