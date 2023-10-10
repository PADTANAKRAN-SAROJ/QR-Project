<?php
include "../connect.php";

    $stmt = $pdo->prepare("UPDATE orders SET process='Done' WHERE order_id=?");
    $stmt->bindParam(1, $_POST["order_id"]);

    $stmt->execute();

    header("location: employee.php")

?>