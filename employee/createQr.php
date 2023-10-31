<?php 
include "../connect.php" ;
include "./checkRole.php" ;

if (isset($_GET['table_number'])) {
    $tableNumber = $_GET['table_number'];

    $sql = "INSERT INTO customer (table_number, state, entry_timestamp) VALUES (:table_number, 'On_table', CURRENT_TIMESTAMP)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':table_number', $tableNumber, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $redirectURL = 'genQR.php?number_table=' . $tableNumber;
        header('Location: ' . $redirectURL);
        exit;
    }
}
?>
