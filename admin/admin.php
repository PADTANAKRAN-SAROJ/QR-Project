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
                <input class="withicon" name="menu_name" placeholder="ค้นหาชื่อเมนู" />
            </div>
            <div class="aa">
                <input class="nextButton" type="submit" value="ค้นหา">
            </div>
        </form>
    </div>

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
                echo "<td>" . $row["price"] . " บาท" . "</td>";
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