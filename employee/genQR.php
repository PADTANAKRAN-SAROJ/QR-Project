<?php
include "../connect.php";
include "./checkRole.php";

$url = ""; // กำหนดค่าเริ่มต้นของ $url
$restaurantName = "";

// ตรวจสอบว่ามีค่า number_table ที่ถูกส่งมาหรือไม่
if (isset($_GET['number_table'])) {
    $numberTable = $_GET['number_table'];

    // คำสั่ง SQL เพื่อดึงข้อมูลลูกค้าที่ตรงกับ number_table และสถานะ "On_table"
    $sql = "SELECT * FROM customer WHERE table_number = :number_table AND state = 'On_table'";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':number_table', $numberTable, PDO::PARAM_INT);

    // ทำการคิวรีฐานข้อมูล
    if ($stmt->execute()) {
        // ตรวจสอบว่ามีข้อมูลลูกค้า
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cusId = $row['cus_id'];
            $tableNumber = $row['table_number'];
            $entryTime = $row['entry_timestamp'];

            // สร้าง URL ด้วยเลขโต๊ะและเวลาเข้าร้าน
            //$url = "https://scansavor.000webhostapp.com/menu/createTable.php?cus_id=" . $cusId . "&table_number=" . $tableNumber . "&entry_time=" . $entryTime;

            $url = "../menu/createTable.php?cus_id=" . $cusId . "&table_number=" . $tableNumber . "&entry_time=" . $entryTime;
            $entryDate = date('d/m/Y', strtotime($entryTime));
            $entryTimeFormatted = date('H:i', strtotime($entryTime));

            // คำสั่ง SQL เพื่อดึงชื่อร้านจากตาราง "restaurant" โดยใช้ id 1
            $restaurantId = 1; // รหัสร้าน (ให้แทนค่านี้ด้วยค่าที่ถูกต้อง)
            $restaurantSql = "SELECT restaurant_name_thai FROM restaurant WHERE id = :restaurant_id";
            $restaurantStmt = $pdo->prepare($restaurantSql);
            $restaurantStmt->bindParam(':restaurant_id', $restaurantId, PDO::PARAM_INT);

            if ($restaurantStmt->execute()) {
                $restaurantRow = $restaurantStmt->fetch(PDO::FETCH_ASSOC);
                $restaurantName = $restaurantRow['restaurant_name_thai'];
            }
        }else{
            header("Location: ./QRcode.php");
            exit();
        }
    }else{
        header("Location: ./QRcode.php");
        exit();
    }
}else{
    header("Location: ./QRcode.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR CODE</title>
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <script>
        function printContent() {
            var contentToPrint = document.querySelector(".genQr");
            var popupWin = window.open('', '_blank', 'width=600,height=600');
            popupWin.document.open();
            popupWin.document.write('<html><head><title>Print</title><link rel="stylesheet" type="text/css" href="./css/genQR.css"></head><body onload="window.print();">' + contentToPrint.innerHTML + '</body></html>');
            popupWin.document.close();
        }
    </script>
    <link rel="stylesheet" href="./css/genQR.css">
</head>
<body>
    <div class="genQr">
        <h1><?php echo $restaurantName; ?></h1>
        <h2>หมายเลขโต๊ะ <?php echo $numberTable; ?></h2>
        <div class="qr">
            <a href="<?php echo $url; ?>">
                <div id="qrcode" class="centered-qrcode"></div>
            </a><br>
            
            <script>
                var qrcode = new QRCode(document.getElementById("qrcode"), {
                    text: "<?php echo $url; ?>",
                    width: 256,
                    height: 256
                });
            </script>
        </div>
        <p>( กรุณาแสกนเพื่อสั่งอาหาร )</p>
        <p>วันที่: <?php echo $entryDate; ?></p>
        <p>เวลา: <?php echo $entryTimeFormatted; ?></p>
    </div>
    <div class="menu">
        <a class="back-link" href="./QRcode.php"> <button>ย้อนกลับ</button> </a>
        <button onclick="printContent()">ปริ้น QR Code</button>
    </div>
</body>

</html>
