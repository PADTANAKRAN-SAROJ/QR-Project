<?php
session_start();
// ตรวจสอบว่ามี session role และมีค่าเป็น 'admin' หรือ 'user' หรือบทบาทที่คุณกำหนด
if (isset($_SESSION['role']) && ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'employee')) {
    // ผู้ใช้มีบทบาทที่ถูกต้อง ไม่ต้องทำอะไรเพิ่มเติม
} else {
    // ถ้าไม่มีบทบาทที่ถูกต้อง นำทางไปยังหน้า login.php
    header("Location: ../login.php");
    exit();
}
?>