<!DOCTYPE html>
<html>

<head>
<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #F5F5F5; /* เปลี่ยนสีพื้นหลัง */
    margin: 0;
    padding: 0;
}

h1 {
    text-align: center;
    background-color: #333; /* เปลี่ยนสีพื้นหลังของเนื้อหา h1 */
    color: #FFF; /* เปลี่ยนสีข้อความใน h1 เป็นขาว */
    padding: 20px; /* เพิ่มระยะห่างรอบข้อความใน h1 */
    margin: 0px;
}

.chef {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

.category-container {
    overflow: auto;
    scrollbar-width: none; /* ซ่อน scrollbar */
    width: 24%;
    height: 450px;
    display: flex;
    flex-direction: column;
    background-color: #FFF;
    border: 1px solid #DDD;
    margin: 1px;
}
@media (max-height: 720px) {
    .category-container {
        height: 300px;
    }
}

/* สีของ scrollbar ใน Chrome */
.category-container::-webkit-scrollbar {
    width: 0; /* ซ่อน scrollbar */
}

/* สีของ scrollbar thumb ใน Chrome */
.category-container::-webkit-scrollbar-thumb {
    background-color: transparent; /* ทำให้ thumb โปร่งใส */
}

.cards {
    /* background-color: #a12fff; */
    border-radius: 10px;
    display: flex;
    flex-direction: row;
    align-items: center;
    padding: 0px 10px;
    margin: 10px; /* เพิ่มระยะห่างรอบ cards */
    border: 1px solid #333;
}
.cards p  {
    /* background-color: #a12;  */
    margin: 2px;
}

.cards .buttonAction{
    text-align: right;
    /* background-color: #333; */
}

.cards .detail p{
    /* background-color: #27AE60; */
    padding: 0px;
    margin: 0px;
}

.cards .divmenu{
    min-width: 60px;
    /* background-color: blue; */
    margin: 0px;
    padding: 0px;
    text-align: center;

}
.cards .descriptions{
    padding: 0px;
    margin: 0px;
    width: 100%;
    /* background-color: #27AE60; */
}
.cards .buttonAction{
    min-width: 120px;
}
.cancel, .complete {
    background-color: #E74C3C;
    color: #FFF;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
    margin: 5px; /* เพิ่มระยะห่างรอบปุ่ม */
}

.complete {
    background-color: #27AE60;
}

</style>

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

            
            var h2 = document.createElement('h2');
            h2.innerHTML = category
            categoryContainer.append(h2)
            

            orders.forEach(function (order) {
                var cards = document.createElement('div') //card
                cards.classList.add('cards')


                var p1 = document.createElement('p');
                var p2 = document.createElement('p');

                var p3 = document.createElement('p');

                var p4 = document.createElement('p');

                var p5 = document.createElement('p');

                var p6 = document.createElement('p');


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

                var orderTime = `${minutes} : ${seconds}`;
                var descriptions = document.createElement('div');
                var divmenu = document.createElement('div');
                var cell6Content = `
                    <input type='hidden' name='order_id' value='${orderId}'>
                    <div class='buttonAction'>
                        <button class='complete' type='button' onclick='completeOrder(${orderId})'>DONE</button>
                        <button class='cancel' type='button' onclick='cancelOrder(${orderId})'>X</button>
                    </div>
              `;
              descriptions.classList.add('descriptions')
              divmenu.classList.add('divmenu')
              p4.classList.add('detail')
                
                p1.innerHTML = orderId
                p2.innerHTML = menuName + `(${quantity})`
                p4.innerHTML =  `หมายเหตุ:${detail} `
                p5.innerHTML = orderTime
                p6.innerHTML =cell6Content

                divmenu.append(p5)
                descriptions.append(p2)
                descriptions.append(p4)
                

                cards.append(divmenu)
                cards.append(descriptions)

                cards.append(p6)//ปุ่ม
                categoryContainer.append(cards)

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

        //Replace the previous setInterval calls with this code
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
<div class= 'chef'>
    <div class="category-container" id="category_1"></div>
    <div class="category-container" id="category_2"></div>
    <div class="category-container" id="category_3"></div>
    <div class="category-container" id="category_4"></div>
    <div class="category-container" id="category_5"></div>
    <div class="category-container" id="category_6"></div>
    <div class="category-container" id="category_7"></div>
    <div class="category-container" id="category_8"></div>
    </div>
</body>

</html>
