<?php
include "../connect.php";

$category = "จานเดียว"; // เปลี่ยนเป็นประเภทอาหารที่ต้องการดึง
$sql = "SELECT orders.order_id, menu.menu_name, menu.category, orders.quantity, orders.detail, orders.order_timestamp
    FROM orders
    JOIN menu ON orders.menu_id = menu.menu_id
    WHERE orders.process = 'Cooking' AND menu.category = :category";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':category', $category, PDO::PARAM_STR); // ใช้ PDO::PARAM_STR สำหรับ string
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($orders);
?>
