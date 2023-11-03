<?php
include "../connect.php";
?>

<!DOCTYPE html>
<html>

<head>
    <title>รายการอาหารที่สั่ง</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        h1 {
            background-color: #333;
            color: #fff;
            padding: 15px;
            text-align: center;
        }
        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        th {
            background-color: #333;
            color: white;
        }
    button.cancel {
        padding: 5px 10px;
        background-color: #FF0000;
        color: #fff;
        border: none;
        cursor: pointer;
    }
    button.cancel:hover {
        background-color: #555;
    }

    button.complete {
        padding: 5px 10px;
        background-color: #008000;
        color: #fff;
        border: none;
        cursor: pointer;
    }
    button.complete:hover {
        background-color: #555;
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
            table.innerHTML = "<tr><th>รหัสรายการ</th><th>ชื่อเมนู</th><th>หมวดหมู่</th><th>จำนวน</th><th>รายละเอียด</th><th>เวลา</th><th>การดำเนินการ</th></tr>";

            orders.forEach(function (order) {
                var orderId = order.order_id;
                var menuName = order.menu_name;
                var category = order.category; // รายละเอียดของหมวดหมู่
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
                var cell3 = row.insertCell(2); // เพิ่ม cell สำหรับหมวดหมู่
                var cell4 = row.insertCell(3);
                var cell5 = row.insertCell(4);
                var cell6 = row.insertCell(5);
                var cell7 = row.insertCell(6);

                cell1.innerHTML = orderId;
                cell2.innerHTML = menuName;
                cell3.innerHTML = category; // แสดงหมวดหมู่
                cell4.innerHTML = quantity;
                cell5.innerHTML = detail;
                cell6.innerHTML = orderTime;

                cell7.innerHTML = `
                    <input type='hidden' name='order_id' value='${orderId}'>
                    <button class='cancel' type='button' onclick='cancelOrder(${orderId})'>ยกเลิกรายการ</button>
                    <button class='complete' type='button' onclick='completeOrder(${orderId})'>เสร็จสิ้น</button>
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
