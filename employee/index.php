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
    <link rel="stylesheet" type="text/css" href="./css/order.css">
    
    <script type="text/javascript">
            //ไปหน้า qrcode
            function showQRCode() {
                var url = "./QRcode.php";
                window.location.href = url;
            }
            //order page
            function served(button) {
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

            function cancel(button) {
                var orderRow = button.parentElement.parentElement; // รับแถวข้อมูลออร์เดอร์ที่ถูกคลิก
                var id = orderRow.querySelector("#order_id").value;

                var xhttp = new XMLHttpRequest();
                var url = "cancel.php?order_id=" + id; // ใช้ query parameter
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
            // เรียกใช้ฟังก์ชันเมื่อหน้าเว็บโหลดเสร็จสิ้น
            window.onload = orderPage;

            setInterval(orderPage, 1000); 
        </script>

</head>
<body>
    <div class="employeePage">
            <div class="topBar">
                <button class="menuButton" disabled>Order</button>
                <button class="menuButton" onclick="showQRCode()">QR Code</button>
            </div>
        
        <!-- แสดง หน้า Order แบบ เรียลไทม์-->
        <div id="orderPage"></div>

    </div>
</body>
</html>