<?php 
include "../connect.php" ;
include "./checkRole.php" ;

if (isset($_GET['table_number'])) {
    $tableNumber = $_GET['table_number'];

    $sql = "INSERT INTO customer (table_number, state, entry_timestamp) VALUES (:table_number, 'On_table', CURRENT_TIMESTAMP)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':table_number', $tableNumber, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "เพิ่มข้อมูลลูกค้าสำเร็จ!";
        echo "<script>setTimeout(function() {
            var number_table = " . $tableNumber . "; // รับค่า number_table
            window.location.href = 'genQR.php?number_table=' + number_table;
        }, 1000);</script>";
        
    }
}
?>
