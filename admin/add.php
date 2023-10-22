<!DOCTYPE html>
<html lang="en">
<body>
<?php
    // รับข้อมูลจากฟอร์ม
    $name = $_POST["name"];
    $type = $_POST["type"];
    $price = $_POST["price"];

    // ข้อมูลของไฟล์รูปภาพ
    $Picture = $_FILES["picture"];

    // ตรวจสอบว่ามีการอัพโหลดรูปภาพหรือไม่
    if (!empty($Picture["name"])) {
        // ระบุโฟลเดอร์ที่คุณต้องการบันทึกไฟล์
        $uploadDirectory = "../menu/food/";

        // สร้างชื่อไฟล์ใหม่โดยใช้ name และนามสกุลของไฟล์
        $PictureName = $name . ".jpg";

        // อัพโหลดไฟล์ไปยังโฟลเดอร์
        if (move_uploaded_file($Picture["tmp_name"], $uploadDirectory . $PictureName)) {
            // เชื่อมต่อฐานข้อมูลและเพิ่มข้อมูลโดยไม่รวมรูปภาพ
            $pdo = new PDO("mysql:host=localhost;dbname=test;charset=utf8", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("INSERT INTO menu (menu_name, category, price) VALUES (?, ?, ?)");
            $stmt->bindParam(1, $name);
            $stmt->bindParam(2, $type);
            $stmt->bindParam(3, $price);

            $stmt->execute(); // เริ่มเพิ่มข้อมูล

            // ส่งผู้ใช้ไปยังหน้ารายละเอียดด้วยชื่อผู้ใช้
            header("location: admin.php");

        } else {
            echo "การอัพโหลดรูปภาพล้มเหลว";
        }
    } else {
        echo "โปรดเลือกรูปภาพ";
    }

?>


</body>
</html>