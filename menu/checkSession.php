<?php
include "../connect.php";
session_start();

if (isset($_SESSION['cus_id'])) {
    $cusId = $_SESSION['cus_id'];

    // ตรวจสอบสถานะของโต๊ะนั้น ๆ
    $sql = "SELECT * FROM customer WHERE cus_id = :cusId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':cusId', $cusId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $databaseTableNumber = $row['table_number'];
            $databaseEntryTime = $row['entry_timestamp'];

            $tableNumber = $row["table_number"];
            $_SESSION["table_number"] = $tableNumber;

            if ($row['state'] == 'Done') {
                header("Location: ../thankYou.php");
            }
        } else {
            header("Location: ../contactStaff.php");
        }
    } else {
        header("Location: ../contactStaff.php");
    }
} else {
    header("Location: ../contactStaff.php");
}

?>