<?php
include "../checkRole.php";
include "../../connect.php";

$sql = "SELECT * FROM restaurant WHERE id = 1";
$result = $pdo->query($sql);
?>
<head>
    <link rel="stylesheet" type="text/css" href="../css/topbar.css">
    <link rel="stylesheet" type="text/css" href="../css/res.css">
</head>
<body>
    <?php
    if ($result) {
        $restaurant = $result->fetch(PDO::FETCH_ASSOC);

        if ($restaurant) {
    ?> 
        <div class="topbar">
            <a href="../index.php"><img src="../../menu/icon/back.png" width="30rem"></a>
            <h1 class="center-title">สรุปข้อมูล</h1>
        </div>

        <div class="navbar">
            <ul>
                <li><a href="index.php" class="active">จัดการร้านอาหาร</a></li>
                <li><a href="review.php">รีวิวลูกค้า</a></li>
            </ul>
        </div>

        <table class="restaurant">
            <tr>
                <th>ชื่อร้าน (ภาษาอังกฤษ)</th>
                <td><?= $restaurant['restaurant_name_eng'] ?></td>
                <td><button onclick="editNameEng()">แก้ไข</button></td>
            </tr>
            <tr>
                <th>ชื่อร้าน (ภาษาไทย)</th>
                <td><?= $restaurant['restaurant_name_thai'] ?></td>
                <td><button onclick="editNameThai()">แก้ไข</button></td>
            </tr>
            <tr>
                <th>จำนวนโต๊ะ</th>
                <td><?= $restaurant['number_of_tables'] ?></td>
                <td><button onclick="editTableNumber()">แก้ไข</button></td>
            </tr>
        </table>


    <?php
        } else {
            header("Location: ../index.php");
        }
    } else {
        header("Location: ../index.php");
    }
    ?>
</body>

<script>
        function editNameEng() {
            var restaurant_name_eng = prompt("กรุณากรอกชื่อร้าน (ภาษาอังกฤษ):");
            var id = 1; // เปลี่ยนเลข id เป็นค่าที่คุณมี

            var pattern = /^[A-Za-z\s]+$/; // รับเฉพาะอักษรภาษาอังกฤษและช่องว่าง

            if (restaurant_name_eng !== null && restaurant_name_eng !== "" && pattern.test(restaurant_name_eng)) {
                var url = './editnameeng.php?id=' + id + '&restaurant_name_eng=' + restaurant_name_eng;
                window.location.href = url;
            } else {
                alert("กรุณากรอกข้อมูลให้เป็นภาษาอังกฤษเท่านั้นและไม่เป็นค่าว่าง");
            }
        }

        function editNameThai() {
            var restaurant_name_thai = prompt("กรุณากรอกชื่อร้าน (ภาษาไทย):");
            var id = 1; 

            var pattern = /^[\u0E00-\u0E7F\s]+$/; // รับเฉพาะอักษรภาษาไทยและช่องว่าง

            if (restaurant_name_thai !== null && restaurant_name_thai !== "" && pattern.test(restaurant_name_thai)) {
                var url = './editnamethai.php?id=' + id + '&restaurant_name_thai=' + restaurant_name_thai;
                window.location.href = url;
                alert("อัพเดตข้อมูลสำเร็จ!");
            } else {
                alert("กรุณากรอกข้อมูลให้เป็นภาษาไทยเท่านั้นและไม่เป็นค่าว่าง");
            }
        }

        function editTableNumber() {
            var number_of_tables = prompt("กรุณากรอกจำนวนโต๊ะ:");

            if (!isNaN(number_of_tables) && number_of_tables.indexOf(' ') === -1) {
                var id = 1;
                var url = './edittablenumber.php?id=' + id + '&number_of_tables=' + number_of_tables;
                window.location.href = url;
                alert("อัพเดตข้อมูลสำเร็จ!");
            } else {
                alert("กรุณากรอกข้อมูลเป็นตัวเลขและไม่มีช่องว่าง");
            }
        }

</script>
