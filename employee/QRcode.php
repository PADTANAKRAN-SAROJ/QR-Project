<?php 
include "../connect.php" ;
include "./checkRole.php" ;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>employee</title>
    <link rel="stylesheet" type="text/css" href="./css/topbar.css">
    <link rel="stylesheet" type="text/css" href="./css/qr.css">
    
    <script type="text/javascript">
            function showOrder() {
                var url = "./index.php";
                window.location.href = url;
            }
            // ประกาศฟังก์ชันเพื่อเปลี่ยน URL สำหรับแสดงรายละเอียด
            function showDetail(cus_id) {
                var url = "./detailQr.php?cus_id=" + cus_id;
                window.location.href = url;
            }

            // ประกาศฟังก์ชันสำหรับเปลี่ยน URL สำหรับสร้างรหัส QR
            function createQR(tableNumber) {
                var url = "./createQr.php?table_number=" + tableNumber;
                window.location.href = url;
            }

            //order page
            function served(button) {
                console.log("served!!");
                var orderRow = button.parentElement.parentElement; // รับแถวข้อมูลออร์เดอร์ที่ถูกคลิก
                var id = orderRow.querySelector("#order_id").value;

                var xhttp = new XMLHttpRequest();
                var url = "served.php?order_id=" + id; // ใช้ query parameter
                xhttp.open("GET", url);
                xhttp.onload = function () {
                    if (this.status === 200) {
                        orderPage(); // อัพเดตหน้า Order โดยเรียกฟังก์ชัน orderPage()
                    }
                };
                xhttp.send();
            }

            function qrPage() {
                var xhttp2 = new XMLHttpRequest();
                xhttp2.onload = function () {
                    if (this.status === 200) {
                        document.getElementById("qrPage").innerHTML = this.responseText;
                    }
                };
                xhttp2.open("GET", "./qr.php");
                xhttp2.send();
            }

            // เรียกใช้ฟังก์ชันเมื่อหน้าเว็บโหลดเสร็จสิ้น
            window.onload = qrPage;

            setInterval(qrPage, 500);
        </script>
</head>
<body>
    <div class="employeePage">
        <div class="topBar">
            <!-- ไปหน้า order -->
            <button class="menuButton" onclick="showOrder()">Order</button>
            <button class="menuButton" disabled>QR Code</button>
            <a href="../logout.php"><img src="../logout.png"  width="50rem"></a>
        </div>
        <!-- หน้า QR Code -->
        <div id="qrCodePage">
            <div id="qrPage"></div>
        </div>
    </div>
</body>
</html>