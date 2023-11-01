function loadOrders() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "get_orders.php", true);

    xhr.onload = function () {
        if (xhr.status == 200) {
           
            document.body.innerHTML = "<h1>รายการอาหารที่สั่ง</h1>";

            
            document.body.innerHTML += xhr.responseText;
        }
    };

    xhr.send();
}

window.addEventListener("load", function () {
    loadOrders();
});

setInterval(loadOrders, 10000);
