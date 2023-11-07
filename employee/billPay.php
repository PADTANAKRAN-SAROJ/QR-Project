<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ใบเสร็จ</title>
    <script>
        function printContent() {
            var contentToPrint = document.querySelector(".bill");
            var popupWin = window.open('', '_blank', 'width=600,height=600');
            popupWin.document.open();
            popupWin.document.write('<html><head><title>Print</title><link rel="stylesheet" type="text/css" href="./css/bill.css"></head><body onload="window.print();">' + contentToPrint.innerHTML + '</body></html>');
            popupWin.document.close();
        }
    </script>
    <link rel="stylesheet" href="./css/bill.css">
</head>

<?php
include "../connect.php";
include "./checkRole.php";

if (isset($_GET['cus_id'])) {
    $cusId = $_GET['cus_id'];

    // ดึงข้อมูล orders ตาม cus_id
    $sql = "SELECT o.*, m.menu_name, m.price
            FROM orders o
            JOIN menu m ON o.menu_id = m.menu_id
            WHERE o.cus_id = :cus_id AND process = 'Done'";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':cus_id', $cusId, PDO::PARAM_INT);
    if ($stmt->execute()) {
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // ดึงข้อมูลเลขโต๊ะและเวลาเข้าของลูกค้า
    $customerInfoSql = "SELECT table_number, entry_timestamp ,state FROM customer WHERE cus_id = :cus_id ";
    $customerInfoStmt = $pdo->prepare($customerInfoSql);
    $customerInfoStmt->bindParam(':cus_id', $cusId, PDO::PARAM_INT);
    if ($customerInfoStmt->execute()) {
        $customerInfo = $customerInfoStmt->fetch(PDO::FETCH_ASSOC);

        // แปลงเวลาเข้าเป็นภาษาไทย
        $entry_timestamp = date("d F Y", strtotime($customerInfo['entry_timestamp']));
        $entry_timestampTime = date("H:i", strtotime($customerInfo['entry_timestamp']));
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
    }else{
        header("Location: ./QRcode.php");
        exit();
    }
}
?>

<body>
    <div class="bill">
        <h1>ใบเสร็จ</h1>
        <p>โต๊ะ: <?php echo $customerInfo['table_number']; ?></p>
        <p>วันที่: <?php echo $entry_timestamp; ?></p>
        <p>เวลา: <?php echo $entry_timestampTime; ?></p>
        <hr>
        
            <?php
            if (isset($orders) && !empty($orders)) {
                echo "
                <table>
                <tr>
                    <th>จำนวน</th>
                    <th>รายการ</th>
                    <th>หมายเหตุ</th>
                    <th>ราคา</th>
                </tr>";
                $total = 0;
                $item = 0;
                foreach ($orders as $order) {
                    $name = $order['menu_name'];
                    $detail = $order['detail'];
                    $quantity = $order['quantity'];
                    $price = $order['price'];
                    $prices = $quantity * $price;
                    $total += $prices;
                    $item++;
                    echo '<tr>';
                    echo '<td>' . $quantity . '</td>';
                    echo '<td>' . $name . ' (' . $price . ')' . '</td>';
                    echo '<td>' . $detail . '</td>';
                    echo '<td>' . $prices . '</td>';
                    echo '</tr>';
                }
            ?>
        </table>
        <hr>
        <div class="summarize">
            <table>
            <?php

                echo "<tr> <th> รายการอาหาร ทั้งหมด : " . $item . " รายการ </th> </tr>";

                echo '<tr> <th>ราคารวม : </th> <th>฿ ' . $total . ' </th> </tr>';

                $Tax_rate = 0.07;
                $Service_charge_rate = 0.15;
                $total_tax = $total * $Tax_rate;
                $total_charge = $total * $Service_charge_rate;

                echo '<tr> <th>Service charge ' . $Service_charge_rate * 100 . "% : </th> <th>฿ " . $total_charge . '</th> </tr> ';
                echo '<tr> <th>Exclude VAT ' . $Tax_rate * 100 . "% : </th> <th>฿ " . $total_tax . '</th> </tr>';
                $final_price = $total + $total_tax + $total_charge;
                echo '<tr> <th> <h3> รวมทั้งสิ้น : </th> <th>฿ ' . $final_price . '</h3> </th> </tr>';
            
            ?>
            </table>
        </div>

        
        <?php 
            }else {
                echo '<p>ไม่พบประวัติการซื้อสำหรับลูกค้านี้<p>';
            }
        ?>
    </div>
    <div class="menu">
            <a href="./QRcode.php"><button>Back</button></a>
            <button onclick="printContent()">Print</button>
            <?php
            if ($customerInfo['state'] == 'On_table' ) {
                echo '<a href="./bill.php?cus_id=' . $cusId . '"><button>Check Bill</button></a>';
            }
            ?>
    </div>
</body>
</html>
