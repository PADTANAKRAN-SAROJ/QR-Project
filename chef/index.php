<!DOCTYPE html>
<html>

<head>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #B0C4DE;
        margin: 0;
        padding: 0;
    }

    h1 {
        text-align: center;
    }

    .descriptions {
        gap: 0px;
    }

    .divmenu {
        display: flex;
        flex-direction: row;
        padding: 0;
        margin: 0;
    }

    .detail {
        color: gray;
        font-size: 15px;
    }

    .chef {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-template-rows: repeat(2, 1fr); /* Adjust rows if necessary */
        gap: 10px;
    }

    .container {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    .category-container {
        display: flex;
        flex-direction: column;
        background-color: #008000;
        gap: 10px;
        width: 100%;
        max-height: 330px; /* Use max-height instead of height to allow content to overflow */
        overflow: auto; /* Add overflow to make content scrollable if it exceeds the container */
        border: 1px solid #000000;
        align-items: center;
    }

    .cards {
        background-color: #FFFFFF;
        border-radius: 10px;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        padding: 20px;
        width: 300px;
        height: 100px;
        
    }

    .cancel {
        background-color: #DC143C;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        margin: 0 auto;
    }

    .complete {
        background-color: #228B22;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        margin: 0 auto;
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
                    <div>
                    <button class='complete' type='button' onclick='completeOrder(${orderId})'>DONE</button>
                    <button class='cancel' type='button' onclick='cancelOrder(${orderId})'>X</button></div>
              `;
              descriptions.classList.add('descriptions')
              divmenu.classList.add('divmenu')
              p4.classList.add('detail')
                
                p1.innerHTML = orderId
                p2.innerHTML = menuName
                p3.innerHTML = `(${quantity})`
                p4.innerHTML =  `หมายเหตุ:${detail} `
                p5.innerHTML = orderTime
                p6.innerHTML =cell6Content

                divmenu.append(p2)
                divmenu.append(p3)
                descriptions.append(divmenu)
                descriptions.append(p4)
                

                cards.append(p5)
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
