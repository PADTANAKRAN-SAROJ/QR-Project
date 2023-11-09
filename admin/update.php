<?php
    include "./checkRole.php";
    include "../connect.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPDATE</title>
</head>
<body>
    <?php
        $menu_id = $_POST["menu_id"];
        $menu_name = $_POST["menu_name"];
        $price = $_POST["price"];
        $category = $_POST["category"];
 
        // ตรวจสอบว่ามีการอัปโหลดรูปภาพใหม่หรือไม่
        if (isset($_FILES["profile"]) && is_uploaded_file($_FILES["profile"]["tmp_name"])) {
            // ลบไฟล์เดิม
            $oldProfilePicture = "../menu/food/" . $menu_id . ".jpg";
            if (file_exists($oldProfilePicture)) {
                unlink($oldProfilePicture);
            }

            // อัปโหลดรูปภาพใหม่
            $profilePicture = $_FILES["profile"];

            $uploadDirectory = "../menu/food/";
            $profilePictureName = $menu_id . ".jpg";

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

        header("location: admin.php");
    ?>
</body>
</html>
