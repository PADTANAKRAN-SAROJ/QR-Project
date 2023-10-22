<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $pdo = new PDO("mysql:host=localhost;dbname=test;charset=utf8", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $menu_id = $_POST["menu_id"];
        $menu_name = $_POST["menu_name"];
        $price = $_POST["price"];
        $category = $_POST["category"];


        // ตรวจสอบค่าที่รับมาจากแบบฟอร์ม
        $category = $_POST["category"];
        echo "category: " . $category;
        

        // ตรวจสอบว่ามีการอัปโหลดไฟล์รูปภาพใหม่หรือไม่
        if (isset($_FILES["profile"]) && is_uploaded_file($_FILES["profile"]["tmp_name"])) {
            // อัปโหลดรูปภาพใหม่เฉพาะหากมีการเลือกไฟล์ใหม่
            $profilePicture = $_FILES["profile"];

            $uploadDirectory = "../menu/food/";
            $profilePictureName = $menu_name . ".jpg";

            if (move_uploaded_file($profilePicture["tmp_name"], $uploadDirectory . $profilePictureName)) {
                // ได้ทำการอัปโหลดรูปภาพเรียบร้อยแล้ว
            } else {
                echo "เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ";
            }
        }

        // ตรวจสอบโค้ด SQL เพื่ออัปเดตข้อมูลรายการอาหาร
        $stmt = $pdo->prepare("UPDATE menu SET menu_name = ?, price = ?, category = ? WHERE menu_id = ?");
        
        $stmt->bindParam(1, $menu_name);
        $stmt->bindParam(2, $price);
        $stmt->bindParam(3, $category);
        $stmt->bindParam(4, $menu_id);

        $stmt->execute();
 
        echo "อัปเดตข้อมูลรายการอาหารเรียบร้อยแล้ว";

        header("location: admin.php");
    ?>

</body>
</html>