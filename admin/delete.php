<?php
if (isset($_GET["menu_name"])) {
    //ตรวจสอบสิทธิ์
    include "./checkRole.php";
    include "../connect.php";

    $menu_name = $_GET["menu_name"];

    // ดึง menu_id ของรายการอาหารที่จะถูกลบ
    $stmt = $pdo->prepare("SELECT menu_id FROM menu WHERE menu_name = ?");
    $stmt->bindParam(1, $menu_name);
    $stmt->execute();
    $row = $stmt->fetch();
    $menu_id = $row["menu_id"];

    $stmt = $pdo->prepare("DELETE FROM menu WHERE menu_name = ?");
    $stmt->bindParam(1, $menu_name);

    if ($stmt->execute()) {
        // ลบเสร็จแล้ว ลบรูปภาพด้วย
        $imagePath = "../menu/food/" . $menu_id . ".jpg";
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        header("Location: admin.php");
        exit();
    } else {
        echo "เกิดข้อผิดพลาดในการลบ";
    }
} else {
    echo "ไม่ได้รับเมนูที่ต้องการลบ";
    header("Location: admin.php");
}
?>
