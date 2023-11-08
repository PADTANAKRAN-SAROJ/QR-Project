                <!DOCTYPE html>
                <html>

                <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <title>ทดสอบการใช้ google font for web devbanban.com</title>
                <link rel="preconnect" href="https://fonts.googleapis.com">
                <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                <link href="https://fonts.googleapis.com/css2?family=Itim&family=Thasadith:wght@400;700&display=swap" rel="stylesheet">

                <style>
                body {
                    background-image: url(https://png.pngtree.com/thumb_back/fw800/background/20190222/ourmid/pngtree-delicious-food-advertising-background-backgroundfoodhot-pot-ingredientsdatablue-image_54050.jpg);
                    background-repeat: no-repeat;
                    background-position: center top;
                    background-color: #F5F5F5; /* เปลี่ยนสีพื้นหลัง */
                    background-size: cover; /* ปรับขนาดให้เต็มพื้นที่ */
                    margin: 0;
                    padding: 0;
                    font-family: 'Itim', cursive;
                    font-family: 'Thasadith', sans-serif;
                    font-size: 1rem; /* เปลี่ยนขนาดตัวอักษรเป็น rem */
                }

                header {
                    display: flex;
                    text-align: center;
                    align-items: center;
                    justify-content: center;
                    background-color: rgba(248, 248, 255, 0.8);
                    padding: 0.1rem;
                    margin: 0;
                }

                header h1 {
                    margin-left: auto;
                    color: black;
                    font-size: 2rem;
                }

                h2{
                    text-align: center;
                    padding: 0;
                    margin: 0.4rem;
                }

                header a {
                    margin-left: auto;
                    margin-right: 20px;
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
                    height: 320px;
                    display: flex;
                    flex-direction: column;
                    background-color: rgba(248, 248, 255, 0.8 ); /* ค่า RGBA ที่ใช้ให้โปร่งใส */
                    border: 1px solid #DDD;
                    margin: 1px;
                    
                }
                @media (min-width: 768px) {
                    .category-container {
                    width: 24%;
                    }
                }

                /*  */
                @media (max-width: 768px) {
                    .category-container {
                        width: 100%; 
                    }

                    .cards {
                        flex-direction: column; 
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
                    background-color: rgba(248, 248, 255, 0.8 ); /* สีเทาโปร่งใส */
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
                    border-radius: 10px;
                }

                .complete {
                    background-color: #27AE60;
                    border-radius: 10px;

                }

                </style>

                    <title>รายการอาหารที่สั่ง</title>
                    <script>
                        function hideAndRemoveRow(orderId) {
                            var row = document.getElementById("row_" + orderId);
                            row.style.display = "none";
                            }


                    function loadOrdersByCategory(category) {
                        var isAppend = false;
                    var xhr = new XMLHttpRequest();
                    xhr.open("GET", "get_orders_" + category + ".php", true);

                    xhr.onload = function () {
                        if (xhr.status == 200) {
                            var orders = JSON.parse(xhr.responseText);

                            var categoryContainer = document.getElementById("category_" + category);
                        categoryContainer.innerHTML = ""; // Clear previous content
                        var categoryList = ['จานเดียว','กับข้าว','ของกินเล่น','ต้ม','เส้น','ของหวาน','เครื่องดื่ม','อื่นๆ']
                        
                                var h2 = document.createElement('h2');
                        h2.innerHTML = categoryList[category-1];
                        categoryContainer.appendChild(h2);

                
                

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
                    <header>
                        <h1>รายการอาหารที่สั่ง</h1>
                        <a href="../logout.php"><img src="../logout.png"  width="35rem"></a>
                    </header>
                
                
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
