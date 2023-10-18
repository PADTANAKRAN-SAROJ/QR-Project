<?php include "../connect.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>employee</title>
    <link rel="stylesheet" type="text/css" href="./css/employee.css">

    <script src="./js/Switch_menu.js"></script>
    <script type="text/javascript">
            //qr - page
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

            
            //ajax realtime
            function orderPage() {
            var xhttp1 = new XMLHttpRequest();
            xhttp1.onload = function () {
                if (this.status === 200) {
                    document.getElementById("orderPage").innerHTML = this.responseText;
                }
            };
            xhttp1.open("GET", "./order.php");
            xhttp1.send();
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
            window.onload = orderPage;
            window.onload = qrPage;

            setInterval(orderPage, 100); 
            setInterval(qrPage, 2000);
        </script>
</head>
<body>
    <div class="employeePage">
        <div class="topBar">
            <button onclick="showOrder()">Order</button>
            <button onclick="showQRCode()">QR Code</button>
        </div>
        
        <!-- หน้า Order -->
        <div id="orderPage"></div>

        <!-- หน้า QR Code -->
        <div id="qrCodePage" style="display: none;">
            <div id="qrPage"></div>
        </div>
    </div>
</body>
</html>