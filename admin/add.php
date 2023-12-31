<?php 
include "./checkRole.php";
include "../connect.php";
?>
<!DOCTYPE html>
<html lang="en">
<body>
<?php 
    $name = $_POST["name"];
    $type = $_POST["type"];
    $price = $_POST["price"];
    $username = "admin"; // กำหนด username เป็น "admin"
    
    // ข้อมูลของไฟล์รูปภาพ
    $Picture = $_FILES["picture"];
    
    // ตรวจสอบว่ามีการอัพโหลดรูปภาพหรือไม่
    if (!empty($Picture["name"])) {
        // ระบุโฟลเดอร์ที่คุณต้องการบันทึกไฟล์
        $uploadDirectory = "../menu/food/";

        $stmt = $pdo->prepare("INSERT INTO menu (menu_name, category, price, username) VALUES (?, ?, ?, ?)");
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $type);
        $stmt->bindParam(3, $price);
        $stmt->bindParam(4, $username);
    
        $stmt->execute(); // เริ่มเพิ่มข้อมูล
    
        // รับค่า menu_id ที่ถูกสร้างอัตโนมัติหลังการเพิ่มข้อมูล
        $menuId = $pdo->lastInsertId();
    
        // สร้างชื่อไฟล์ใหม่โดยใช้ menu_id
        $newPictureName = $menuId . ".jpg";
    
        // อัพโหลดไฟล์ไปยังโฟลเดอร์
        if (move_uploaded_file($Picture["tmp_name"], $uploadDirectory . $newPictureName)) {
            // รูปภาพถูกอัพโหลดและเปลี่ยนชื่อสำเร็จ
 
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
