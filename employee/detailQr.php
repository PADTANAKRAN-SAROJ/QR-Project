<?php
include "../connect.php";

// ตรวจสอบว่ามีค่า cus_id ที่ถูกส่งมาหรือไม่
if (isset($_GET['cus_id'])) {
    $cusId = $_GET['cus_id'];

    // คำสั่ง SQL เพื่อดึงข้อมูลลูกค้าจาก cus_id
    $sql = "SELECT * FROM customer WHERE cus_id = :cus_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':cus_id', $cusId, PDO::PARAM_INT);
    $stmt->execute();

    // ตรวจสอบว่าพบข้อมูลหรือไม่
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $numberTable = $row['table_number'];
        $entryTime = $row['entry_timestamp'];

        // แปลงเวลาเข้าร้านให้อยู่ในรูปแบบที่คุณต้องการ
        $entryTimeFormatted = date('Y-m-d H:i:s', strtotime($entryTime));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายละเอียด</title>
</head>
<body>
    <h1>หมายเลขโต๊ะ <?php echo $numberTable; ?></h1> 
    <p>เวลาเข้าร้าน: <?php echo $entryTimeFormatted; ?></p>
    <a href="genQR.php?number_table=<?php echo $numberTable; ?>" target="_blank">ดู QR Code</a> </br>
    <a href="bill.php?cus_id=<?php echo $cusId; ?>">เช็คบิล</a> </br>
    <a href="./employee.php">ย้อนกลับ</a> </br>
</body>
</html>
<?php
    } else {
        echo "ไม่พบข้อมูลลูกค้าสำหรับ cus_id ที่ระบุ";
    }
} else {
    echo "ไม่ได้ระบุ cus_id";
}
?>
