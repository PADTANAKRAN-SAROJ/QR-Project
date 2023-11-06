<?php
include "../connect.php";

$$sql = "SELECT orders.order_id, menu.menu_name, menu.category, orders.quantity, orders.detail, orders.order_timestamp
FROM orders
JOIN menu ON orders.menu_id = menu.menu_id
WHERE orders.process = 'Cooking'";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($orders);
?>
