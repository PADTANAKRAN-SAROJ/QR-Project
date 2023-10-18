<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin</title>

    <link rel="stylesheet" href="admin.css">

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
    </script>


</head>

<body>
 
    <?php
    $pdo = new PDO("mysql:host=localhost;dbname=test;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT * FROM menu");
    $stmt->execute();
    ?>

    <header>
		<h1>เมนูอาหารทั้งหมด</h1>
	</header>

    <div class="c6">
        <form method="get" action="findmenu.php">
            <div class="warpborder tt1">
                <img src="icon\search.png">
                <input class="withicon" type="text" id="menu_name" onkeyup="send()">
                <!--<input class="withicon" name="menu_name" placeholder="ค้นหาชื่อเมนู" />
                <input class="nextButton" type="submit" value="ค้นหา"> -->
            </div>
            
        </form>

        <div class="tt1 add">
            <a href="addmenu.php"><button class="confirmButton">เพิ่มอาหาร</button></a>
        </div>
    </div>

    <div id="result"></div>
    
    <table class="t8">
        <thead>
            <tr>
                <th>ชื่อรายการ</th>
                <th>รูปภาพ</th>
                <th>ประเภท</th>
                <th>ราคา</th>
            </tr>
        </thead>
        
        <tbody>
        <?php
        while ($row = $stmt->fetch()) {
            echo "<tr>";
                echo "<td>" . $row["menu_name"] . "</td>";
                echo '<td><button onclick="showPopup(\'http://localhost/qr/menu/food/' . $row['menu_name'] . '.jpg\')">ดูรูป</button></td>';
                echo "<td>" . $row["category"] . "</td>";
                echo "<td>" . $row["price"] . "</td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>


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