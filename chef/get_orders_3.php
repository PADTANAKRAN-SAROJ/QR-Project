<?php
include "../connect.php";

$category = "ของกินเล่น"; // ของกินเล่น

$sql = "SELECT orders.order_id, menu.menu_name, menu.category, orders.quantity, orders.detail, orders.order_timestamp
    FROM orders
    JOIN menu ON orders.menu_id = menu.menu_id
    WHERE orders.process = 'Cooking' AND menu.category = :category";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':category', $category, PDO::PARAM_STR);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($orders);
?>
