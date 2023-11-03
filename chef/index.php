<!DOCTYPE html>
<html>

<head>
    <title>รายการอาหารที่สั่ง</title>
    <script>
        function hideAndRemoveRow(orderId) {
            var row = document.getElementById("row_" + orderId);
            row.style.display = "none";
        }

    function loadOrdersByCategory(category) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "get_orders_" + category + ".php", true);

    xhr.onload = function () {
        if (xhr.status == 200) {
            var orders = JSON.parse(xhr.responseText);

            var categoryContainer = document.getElementById("category_" + category);
            categoryContainer.innerHTML = ""; // Clear previous content

            var table = document.createElement('table');
            categoryContainer.appendChild(table);

            var headerRow = table.insertRow(0);
            headerRow.innerHTML = "<th>รหัสรายการ</th><th>ชื่อเมนู</th><th>จำนวน</th><th>รายละเอียด</th><th>เวลา</th><th>การดำเนินการ</th>";

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

                var cell6Content = `
                    <input type='hidden' name='order_id' value='${orderId}'>
                    <button class='cancel' type='button' onclick='cancelOrder(${orderId})'>Cancel</button>
                    <button class='complete' type='button' onclick='completeOrder(${orderId})'>Complete</button>
                `;
                cell6.innerHTML = cell6Content;
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
            loadOrdersByCategory(1);
            loadOrdersByCategory(2);
            loadOrdersByCategory(3);
            loadOrdersByCategory(4);
            loadOrdersByCategory(5);
            loadOrdersByCategory(6);
            loadOrdersByCategory(7);
            loadOrdersByCategory(8);
        });

        // Replace the previous setInterval calls with this code
        setInterval(function () {
            loadOrdersByCategory(1);
            loadOrdersByCategory(2);
            loadOrdersByCategory(3);
            loadOrdersByCategory(4);
            loadOrdersByCategory(5);
            loadOrdersByCategory(6);
            loadOrdersByCategory(7);
            loadOrdersByCategory(8);
        }, 1000);

    </script>
</head>

<body>
    <h1>รายการอาหารที่สั่ง</h1>
    
    <div id="category_1"></div>
    <div id="category_2"></div>
    <div id="category_3"></div>
    <div id="category_4"></div>
    <div id="category_5"></div>
    <div id="category_6"></div>
    <div id="category_7"></div>
    <div id="category_8"></div>

</body>

</html>
