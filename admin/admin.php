<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin</title>

    <link rel="stylesheet" href="admin.css">

    <style>
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }
        .pagination button {
            margin: 5px;
            padding: 5px 10px;
            border: 1px solid #FFFEFA;
            cursor: pointer;
            border-radius: 5px;
            background-color: #6FADA2;
            color: #FFFEFA;
        }
        .pagination button.active {
            background-color: #DABC73;
            color: #000000;
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
        //ตรวจสอบสิทธิ์
        include "./checkRole.php";
        include "../connect.php";

        $stmt = $pdo->prepare("SELECT * FROM menu");
        $stmt->execute();

        $result = $stmt->fetchAll();
        $itemsPerPage = 10;
        $totalItems = count($result);
        $totalPages = ceil($totalItems / $itemsPerPage);

        if (!isset($_GET['page']) || $_GET['page'] < 1 || $_GET['page'] > $totalPages) {
            $currentPage = 1;
        } else {
            $currentPage = $_GET['page'];
        }

        $start = ($currentPage - 1) * $itemsPerPage;
        $end = $start + $itemsPerPage;
        $previousButtonClass = ($currentPage > 1) ? "" : "disabled";
        $nextButtonClass = ($currentPage < $totalPages) ? "" : "disabled";
        ?>
        <header>
            <h1>ADMIN</h1>
        </header>

        <div id="wrapper">
            <nav id="nav">
                <ul>
                    <li><a href="#main" class="active">รายการอาหารทั้งหมด</a></li>
                    <li><a href="findmenu.php">ค้นหาเมนู</a></li>
                </ul>
            </nav>

            <div id="main">
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
                        echo '<td><button onclick="showPopup(\'../menu/food/' . $row['menu_id'] . '.jpg\')">ดูรูป</button></td>';
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