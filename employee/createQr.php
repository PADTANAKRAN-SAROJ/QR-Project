<?php
include "../connect.php";

// ตรวจสอบว่ามีค่า table_number ที่ถูกส่งมาหรือไม่
if (isset($_GET['table_number'])) {
    $tableNumber = $_GET['table_number'];

    // คำสั่ง SQL เพื่อเพิ่มข้อมูลลูกค้าในตาราง customer
    $sql = "INSERT INTO customer (table_number, state, entry_timestamp) VALUES (:table_number, 'On_table', CURRENT_TIMESTAMP)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':table_number', $tableNumber, PDO::PARAM_INT);

    // ทำการเพิ่มข้อมูลลูกค้า
    if ($stmt->execute()) {
        echo "เพิ่มข้อมูลลูกค้าสำเร็จ!";
        echo "<script>setTimeout(function() {
            var number_table = " . $tableNumber . "; // รับค่า number_table
            window.location.href = 'genQR.php?number_table=' + number_table;
        }, 1000);</script>";
        
    } else {
        echo "เกิดข้อผิดพลาดในการเพิ่มข้อมูลลูกค้า";
    }
} else {
    echo "ไม่ได้ระบุ table_number";
}
?>
