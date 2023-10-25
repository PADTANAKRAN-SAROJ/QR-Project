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

        function confirmDelete(menu_name) {
            var ans = confirm("ต้องการลบรายการอาหาร " + menu_name);
            if (ans) {
                return true;
            } else {
                return false;
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
		<h1>ADMIN</h1>
	</header>

    <div class="topnav">
		<a class="now" href="#list">รายการอาหารทั้งหมด</a>
		<a href="findmenu.php">ค้นหาเมนู</a>
	</div>
    
    <div id="list">
        <h2>รายการอาหารทั้งหมด</h2>

        <div class="c6">
            <div class="tt1 add">
                <a href="addmenu.php"><button class="confirmButton">เพิ่มอาหาร</button></a>
                <!--<a href="edit.php"><button class="editButton">แก้ไข</button></a> -->
            </div>
        </div>

        <table class="t8">
            <thead>
                <tr>
                    <th>ชื่อรายการ</th>
                    <th>รูปภาพ</th>
                    <th>ประเภท</th>
                    <th>ราคา</th>
                    <th></th>
                </tr>
            </thead>
            
            <tbody>
            <?php
            while ($row = $stmt->fetch()) {
                echo "<tr>";
                    echo "<td>" . $row["menu_name"] . "</td>";
                    echo '<td><button onclick="showPopup(\'http://localhost/qr/menu/food/' . $row['menu_id'] . '.jpg\')">ดูรูป</button></td>';
                    echo "<td>" . $row["category"] . "</td>";
                    echo "<td>" . $row["price"] . "</td>";
                    echo "<td><a href='edit.php?menu_id=" . $row["menu_id"] . "'><button class='editButton'>แก้ไข</button></a>";
                    echo "<a href='delete.php?menu_name=" . $row["menu_name"] . "' onclick='return confirmDelete(\"" . $row["menu_name"] . "\")'><button class='deleteButton'>ลบ</button></a></td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>

    </div>

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