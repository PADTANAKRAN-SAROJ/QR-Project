<?php
    include "./checkRole.php";
    include "../connect.php";
?>
<?php
if (isset($_GET["menu_id"])) { 
    $menu_id = $_GET["menu_id"];  

    // ดึง menu_id ของรายการอาหารที่จะถูกลบ
    $stmt = $pdo->prepare("SELECT menu_id FROM menu WHERE menu_id = ?");  
    $stmt->bindParam(1, $menu_id);
    
    if ($stmt->execute()) {
        $row = $stmt->fetch();

        // ลบรูปภาพของรายการอาหาร
        $imagePath = "../menu/food/" . $menu_id . ".jpg";
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // ลบรายการอาหาร
        $stmt = $pdo->prepare("DELETE FROM menu WHERE menu_id = ?"); 
        $stmt->bindParam(1, $menu_id);

        if ($stmt->execute()) {
            header("Location: admin.php");
            exit();
        } else {
            echo "เกิดข้อผิดพลาดในการลบ";
        }
    } else {
        echo "เกิดข้อผิดพลาดในการลบ";
    }
} else {
    echo "ไม่ได้รับเมนูที่ต้องการลบ";
    header("Location: admin.php");
}
?>
