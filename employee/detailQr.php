<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/detailqr.css">
    <title>Details</title>
</head>
<?php 
include "../connect.php" ;
include "./checkRole.php" ;

// ตรวจสอบว่ามีค่า cus_id ที่ถูกส่งมาหรือไม่
if (isset($_GET['cus_id'])) {
    $cusId = $_GET['cus_id'];

    // คำสั่ง SQL เพื่อดึงข้อมูลลูกค้าจาก cus_id
    $sql = "SELECT * FROM customer WHERE cus_id = :cus_id AND state = 'On_table' ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':cus_id', $cusId, PDO::PARAM_INT);
    $stmt->execute();

    // ตรวจสอบว่าพบข้อมูลหรือไม่
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $numberTable = $row['table_number'];

        // แปลงเวลาเข้าเป็นภาษาไทย
        $entry_timestamp = date("d F Y", strtotime($row['entry_timestamp']));
        $entry_timestampTime = date("H:i", strtotime($row['entry_timestamp']));
        $entry_timestamp = str_replace('January', 'มกราคม', $entry_timestamp);
        $entry_timestamp = str_replace('February', 'กุมภาพันธ์', $entry_timestamp);
        $entry_timestamp = str_replace('March', 'มีนาคม', $entry_timestamp);
        $entry_timestamp = str_replace('April', 'เมษายน', $entry_timestamp);
        $entry_timestamp = str_replace('May', 'พฤษภาคม', $entry_timestamp);
        $entry_timestamp = str_replace('June', 'มิถุนายน', $entry_timestamp);
        $entry_timestamp = str_replace('July', 'กรกฎาคม', $entry_timestamp);
        $entry_timestamp = str_replace('August', 'สิงหาคม', $entry_timestamp);
        $entry_timestamp = str_replace('September', 'กันยายน', $entry_timestamp);
        $entry_timestamp = str_replace('October', 'ตุลาคม', $entry_timestamp);
        $entry_timestamp = str_replace('November', 'พฤศจิกายน', $entry_timestamp);
        $entry_timestamp = str_replace('December', 'ธันวาคม', $entry_timestamp);
        // แปลงปีพ.ศ.
        $entry_timestamp = str_replace(date('Y'), date('Y') + 543, $entry_timestamp);
?>
<body>
    <div class="detail">
        <?php 
            $query = "SELECT restaurant_name_eng,restaurant_name_thai FROM restaurant WHERE id = 1";
            $result = $pdo->query($query);

            if ($result) {
                $row = $result->fetch(PDO::FETCH_ASSOC);

                if ($row) {
                    $restaurantNameEng = strtoupper($row['restaurant_name_eng']);
                    $restaurantNameThai = strtoupper($row['restaurant_name_thai']);
                }
            }
        ?>
        <h1><?php echo $restaurantNameThai; ?></h1>
        <h2>หมายเลขโต๊ะ <?php echo $numberTable; ?></h2> 
        <p>วันที่: <?php echo $entry_timestamp; ?></p>
        <p>เวลา: <?php echo $entry_timestampTime; ?></p>
        <br><hr><br>
        <footer>
            <a href="./billPay.php?cus_id=<?php echo $cusId; ?>">เช็คบิล</a> </br>
            <a href="genQR.php?number_table=<?php echo $numberTable; ?>" target="_blank">ดู QR Code</a> </br>
            <a href="./QRcode.php">ย้อนกลับ</a> </br>
        </footer>
    </div>
</body>
</html>
<?php
    } else {
        header("Location: ./QRcode.php");
        exit();
    }
} else {
    header("Location: ./QRcode.php");
    exit();
}
?>
