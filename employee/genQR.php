<?php
include "../connect.php";

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
            $url = "../menu/category.php?cus_id=" . $cusId . "&table_number=" . $tableNumber . "&entry_time=" . $entryTime;

            // สร้าง QR code จาก URL
            echo '<div id="qrcode"></div>';
            echo '<script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>';
            echo '<script>';
            echo 'var qrcode = new QRCode(document.getElementById("qrcode"), {';
            echo 'text: "' . $url . '",';
            echo 'width: 128,';
            echo 'height: 128';
            echo '});';
            echo '</script>';

            // แสดงลิงก์ไปยังเมนู
            echo '<a href="' . $url . '">ไปยังเมนู</a> </br>';
            // เพิ่มปุ่ม "ปริ้น QR Code"
            echo '<button onclick="printQRCode()">ปริ้น QR Code</button> </br>';
            // แสดงลิ้งย้อนกลับ
            echo '<a href="./employee.php">ย้อนกลับ</a> </br>';
        } else {
            echo "ไม่พบข้อมูลลูกค้าสำหรับโต๊ะนี้";
        }
    } else {
        echo "เกิดข้อผิดพลาดในการคิวรีข้อมูลลูกค้า";
    }
} else {
    echo "ไม่ได้ระบุ number_table";
}
?>
<script>
function printQRCode() {
    // ดึงข้อมูลจาก <div> ที่มี id เป็น "qrcode"
    var qrcodeDiv = document.getElementById("qrcode");

    // สร้างใบปริ้นที่มีรหัส QR
    var printWindow = window.open('', '', 'width=600,height=600');
    printWindow.document.open();
    printWindow.document.write('<html><body>');
    printWindow.document.write('<img src="' + qrcodeDiv.getElementsByTagName("img")[0].src + '">');
    printWindow.document.write('</body></html>');
    printWindow.document.close();

    // ปริ้นใบปริ้นที่เปิด
    printWindow.print();
    printWindow.close();
}
</script>
