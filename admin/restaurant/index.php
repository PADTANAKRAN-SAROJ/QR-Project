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

<?php
include "../../connect.php";
$sql = "SELECT * FROM restaurant WHERE id = 1";
$result = $pdo->query($sql);
?>
<body>
    <?php
    if ($result) {
        $restaurant = $result->fetch(PDO::FETCH_ASSOC);

        if ($restaurant) {
    ?> 
        <div class="topbar">
            <a href="../index.php" class="back-link">ย้อนกลับ</a>
            <h1 class="center-title">ข้อมูลร้าน</h1>
        </div>
        <div class="restaurant">
            <h1><?= $restaurant['restaurant_name_eng'] ?> <button onclick="editNameEng()">แก้ไข</button></h1>
            <h2>( <?= $restaurant['restaurant_name_thai'] ?> ) <button onclick="editNameThai()">แก้ไข</button></h2>
            <h3>จำนวนโต๊ะ: <?= $restaurant['number_of_tables'] ?> <button onclick="editTableNumber()">แก้ไข</button></h3>
        </div>

    <?php
        } else {
            header("Location: ../index.php");
        }
    } else {
        header("Location: ../index.php");
    }
    ?>
</body>


