<?php 
include "./checkRole.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    
    <link rel="stylesheet" href="findmenu.css">

</head>
<body>

    <header>
        <div class="back">
            <a href="index.php"><img src="../menu/icon/back.png" width="30rem"></a>
        </div>
		<h1>ADMIN</h1>
        <a href="../logout.php"><img src="../logout.png" width="50rem"></a>
	</header>

        <nav id="nav">
            <ul>
                <li><a href="admin.php">รายการอาหารทั้งหมด</a></li>
                <li><a href="#main" class="active">ค้นหาเมนู</a></li>
            </ul>
        </nav>

        <div id="main">
            <h2>ค้นหาเมนู</h2>
            
            <div class="c6">
                <div class="warpborder tt1">
                    <img src="icon\find.png">
                    <input class="withicon" type="text" id="menu_name" onkeyup="send()">
                </div>


                <div class="tt1 add">
                    <a href="addmenu.php"><button class="confirmButton">เพิ่มอาหาร</button></a>
                </div>
            </div>

        </div>

        <div id="result"></div>

    <div id="popup" class="overlay">
        <div class="popup center">
            <h2>รูปภาพ</h2>
            <a class="close" href="#" onclick="hidePopup()">&times;</a>
            <div class="content">
                <img id="popup-image" src="">
            </div>
        </div>
    </div>

</body>
</html>

<script>
        function showPopup(imageUrl) {
            // Set the image source of the popup window
            document.getElementById("popup-image").src = imageUrl;

            // Show the popup window
            document.getElementById("popup").style.display = "block";
        }


        function hidePopup() {
            // Hide the popup window
            document.getElementById("popup").style.display = "none";
        }

        function send() {
            request = new XMLHttpRequest();
            request.onreadystatechange = showResult;
            var menu_name = document.getElementById("menu_name").value; // ใช้ตัวแปร menu_name
            var url = "search.php?menu_name=" + menu_name; // ใช้ตัวแปร menu_name
            request.open("GET", url, true);
            request.send(null);
        }

        function showResult() {
            if (request.readyState == 4) {
            if (request.status == 200)
                document.getElementById("result").innerHTML = request.responseText;
            }
        }

        function confirmDelete(menu_name) {
            var ans = confirm("ต้องการลบรายการอาหาร " + menu_name);
            if (ans) {
                return true;
            } else {
                return false;
            }
        }

</script>