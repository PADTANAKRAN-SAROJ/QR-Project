<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin</title>

    <link rel="stylesheet" href="admin.css">

    <style>
        /* เพิ่ม CSS สำหรับ pagination */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }
        .pagination button {
            margin: 5px;
            padding: 5px 10px;
            border: 1px solid #ccc;
            cursor: pointer;
        }
        .pagination button.active {
            background-color: #333;
            color: white;
        }
    </style>

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
    
    // รับผลลัพธ์ทั้งหมด
    $result = $stmt->fetchAll();
    $itemsPerPage = 10; // จำนวนรายการต่อหน้า
    $totalItems = count($result); // จำนวนรายการทั้งหมด

    // คำนวณจำนวนหน้าทั้งหมด
    $totalPages = ceil($totalItems / $itemsPerPage);
    
    if (!isset($_GET['page']) || $_GET['page'] < 1 || $_GET['page'] > $totalPages) {
        $currentPage = 1;
    } else {
        $currentPage = $_GET['page'];
    }
    
    // คำนวณช่วงของรายการที่ต้องแสดงในหน้าปัจจุบัน
    $start = ($currentPage - 1) * $itemsPerPage;
    $end = $start + $itemsPerPage;
    
    // กำหนด CSS class ที่ใช้ในปุ่ม pagination
    $previousButtonClass = ($currentPage > 1) ? "" : "disabled";
    $nextButtonClass = ($currentPage < $totalPages) ? "" : "disabled";
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
            for ($i = $start; $i < $end; $i++) {
                if ($i >= $totalItems) {
                    break;
                }
                $row = $result[$i];
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

        <div class="pagination">
            <button class="prev <?php echo $previousButtonClass; ?>"><a href="?page=<?php echo $currentPage - 1; ?>">ก่อนหน้า</a></button>
            <?php
                for ($page = 1; $page <= $totalPages; $page++) {
                    $activeClass = ($page == $currentPage) ? "active" : "";
                    echo "<a href='?page=$page'><button class='$activeClass'>$page</button></a>";
                }
            ?>
            <button class="next <?php echo $nextButtonClass; ?>"><a href="?page=<?php echo $currentPage + 1; ?>">ถัดไป</a></button>
        </div>

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
