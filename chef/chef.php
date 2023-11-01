<?php
include "../connect.php";
?>

<!DOCTYPE html>
<html>

<head>
    <title>รายการอาหารที่สั่ง</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
    </style>

    <script>
        function hideAndRemoveRow(orderId) {
            var row = document.getElementById("row_" + orderId);
            row.style.display = "none";
        }

        function loadOrders() {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "get_orders.php", true);

            xhr.onload = function () {
                if (xhr.status == 200) {
                    var orders = JSON.parse(xhr.responseText);

                    var table = document.querySelector("table");
                    table.innerHTML = "<tr><th>รหัสรายการ</th><th>ชื่อเมนู</th><th>จำนวน</th><th>รายละเอียด</th><th>เวลา</th><th>การดำเนินการ</th></tr>";

                    orders.forEach(function (order) {
                        var orderId = order.order_id;
                        var menuName = order.menu_name;
                        var quantity = order.quantity;
                        var detail = order.detail;
                        var orderTimestamp = new Date(order.order_timestamp);
                        var currentTime = new Date();
                        var timeDiff = currentTime - orderTimestamp;

                        var hours = Math.floor(timeDiff / 3600000);
                        timeDiff %= 3600000;
                        var minutes = Math.floor(timeDiff / 60000);
                        timeDiff %= 60000;
                        var seconds = Math.floor(timeDiff / 1000);

                        var orderTime = `${hours} : ${minutes} : ${seconds}`;

                        var row = table.insertRow(-1);
                        row.id = "row_" + orderId;

                        var cell1 = row.insertCell(0);
                        var cell2 = row.insertCell(1);
                        var cell3 = row.insertCell(2);
                        var cell4 = row.insertCell(3);
                        var cell5 = row.insertCell(4);
                        var cell6 = row.insertCell(5);

                        cell1.innerHTML = orderId;
                        cell2.innerHTML = menuName;
                        cell3.innerHTML = quantity;
                        cell4.innerHTML = detail;
                        cell5.innerHTML = orderTime;

                        cell6.innerHTML = `
                            <input type='hidden' name='order_id' value='${orderId}'>
                            <button type='button' onclick='cancelOrder(${orderId})'>Cancel</button>
                            <button type='button' onclick='completeOrder(${orderId})'>Complete</button>
                        `;
                    });
                }
            };

            xhr.send();
        }

        function cancelOrder(orderId) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "process_order.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function () {
                if (xhr.status == 200) {
                    hideAndRemoveRow(orderId);
                }
            };
            xhr.send("action=cancel&order_id=" + orderId);
        }

        function completeOrder(orderId) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "process_order.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function () {
                if (xhr.status == 200) {
                    hideAndRemoveRow(orderId);
                }
            };
            xhr.send("action=complete&order_id=" + orderId);
        }


        window.addEventListener("load", function () {
            loadOrders();
        });


        setInterval(loadOrders, 1000);
    </script>
</head>

<body>
    <h1>รายการอาหารที่สั่ง</h1>

    <table>
        <tr>
            <th>รหัสรายการ</th>
            <th>ชื่อเมนู</th>
            <th>จำนวน</th>
            <th>รายละเอียด</th>
            <th>เวลา</th>
            <th>การดำเนินการ</th>
        </tr>
    </table>
</body>

</html>
