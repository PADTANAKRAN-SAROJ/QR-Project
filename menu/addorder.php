<!DOCTYPE html>
<html lang="en">
<body>
<?php
    include "./checkSession.php";

    //ติดไว้ก่อน
    // รับข้อมูลจากฟอร์ม
    $username = $_POST["username"];
    $password = $_POST["password"];
    $name = $_POST["name"];
    $address = $_POST["address"];
    $mobile = $_POST["mobile"];
    $email = $_POST["email"];

    // ข้อมูลของไฟล์รูปภาพ
    $profilePicture = $_FILES["profile"];

    // ตรวจสอบว่ามีการอัพโหลดรูปภาพหรือไม่
    if (!empty($profilePicture["name"])) {
        // ระบุโฟลเดอร์ที่คุณต้องการบันทึกไฟล์
        $uploadDirectory = "member_photo/";

        // สร้างชื่อไฟล์ใหม่โดยใช้ username และนามสกุลของไฟล์
        $profilePictureName = $username . ".jpg";

        // อัพโหลดไฟล์ไปยังโฟลเดอร์
        if (move_uploaded_file($profilePicture["tmp_name"], $uploadDirectory . $profilePictureName)) {
            // เชื่อมต่อฐานข้อมูลและเพิ่มข้อมูลโดยไม่รวมรูปภาพ
            include "../connect.php";

            $stmt = $pdo->prepare("INSERT INTO member (username, password, name, address, mobile, email) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bindParam(1, $username);
            $stmt->bindParam(2, $password);
            $stmt->bindParam(3, $name);
            $stmt->bindParam(4, $address);
            $stmt->bindParam(5, $mobile);
            $stmt->bindParam(6, $email);

            $stmt->execute(); // เริ่มเพิ่มข้อมูล

            // ส่งผู้ใช้ไปยังหน้ารายละเอียดด้วยชื่อผู้ใช้
            header("location: detail.php?username=" . $username);
        } else {
            echo "การอัพโหลดรูปภาพล้มเหลว";
        }
    } else {
        echo "โปรดเลือกรูปภาพ";
    }

?>


</body>
</html>