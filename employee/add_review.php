<?php
include "../connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าจากฟอร์ม
    $cus_id = $_POST["cus_id"];
    $rate = $_POST["rate"];
    $comment = $_POST["comment"];

    echo "<p>รหัสลูกค้า: $cus_id</p>";
    echo "<p>คะแนน: $rate</p>";
    echo "<p>คำติชม: $comment</p>";

    $updateSql = "UPDATE customer SET rate = :rate, review = :comment WHERE cus_id = :cus_id";
    $updateStmt = $pdo->prepare($updateSql);
    $updateStmt->bindParam(':cus_id', $cus_id, PDO::PARAM_INT);
    $updateStmt->bindParam(':rate', $rate, PDO::PARAM_INT);
    $updateStmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    
    if ($updateStmt->execute()) {
        header("Location: ../thankYou.php");
    }
} else {
    header("Location: ../thankYou.php");
}
?>