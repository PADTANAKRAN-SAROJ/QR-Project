<?php
include "../connect.php";

$category = "กับข้าว"; // กับข้าว

$sql = "SELECT orders.order_id, menu.menu_name, menu.category, orders.quantity, orders.detail, orders.order_timestamp
    FROM orders
    JOIN menu ON orders.menu_id = menu.menu_id
    WHERE orders.process = 'Cooking' AND menu.category = :category ORDER BY `orders`.`order_id` ASC";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':category', $category, PDO::PARAM_STR);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($orders);
?>
