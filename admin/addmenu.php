<?php
    include "./checkRole.php";
    include "../connect.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>addmenu</title>

    <link rel="stylesheet" href="addmenu.css">

</head>
<body>

    <header>
        <div class="icon">
            <a href="admin.php"><img src="../menu/icon/back.png" width="30rem"></a>
        </div>
        <h1>เพิ่มรายการอาหาร</h1>
    </header>

    <div class="center">
        <h2>- กรุณากรอกรายละเอียด -</h2>
        <form action="add.php" method="post" enctype="multipart/form-data" style="text-align: center; margin: 0 auto; width: max-content;">
            <p>ชื่อเมนู: <input type="text" name="name"><span>* โปรดกรอกชื่อเมนูเป็น ภาษาไทย เท่านั้น *</span></p>
            <p>ประเภทอาหาร:
                <select class="select-add" name="type" id="type">
                    <option value="จานเดียว">จานเดียว</option>
                    <option value="กับข้าว">กับข้าว</option>
                    <option value="ของกินเล่น">ของกินเล่น</option>
                    <option value="ต้ม">ต้ม</option>
                    <option value="เส้น">เส้น</option>
                    <option value="ของหวาน">ของหวาน</option>
                    <option value="เครื่องดื่ม">เครื่องดื่ม</option>
                    <option value="อื่นๆ">อื่นๆ</option>
                </select>
            </p>
            <p>ราคา: <input type="text" name="price"><span>* โปรดกรอกราคาเป็น ตัวเลข เท่านั้น *</span></p>
            <p>อัพโหลดรูปภาพ: <input type="file" name="picture"></p>
            <br>
            <input class="confirmButton" type="submit" value="เพิ่มข้อมูล" id="confirmButton">
        </form>
    </div>

</body>
</html>

<script>
        document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.querySelector('input[name="name"]');
        const priceInput = document.querySelector('input[name="price"]');
        const namePattern = /^[\u0E01-\u0E5B\s]+$/; // Regular expression ชื่อเมนูภาษาไทย
        const pricePattern = /^\d+(\.\d+)?$/; // Regular expression เป็นตัวเลข & ทศนิยม

        nameInput.addEventListener('blur', function() {
            if (!namePattern.test(nameInput.value)) {
                alert("โปรดกรอกชื่อเมนูเป็นภาษาไทย (ก-ฮ และสระ) เท่านั้น");
                nameInput.value = ''; // ล้างข้อมูลที่กรอก
            }
        });

        priceInput.addEventListener('blur', function() {
            if (!pricePattern.test(priceInput.value)) {
                alert("โปรดกรอกราคาเป็นตัวเลขเท่านั้น");
                priceInput.value = ''; // ล้างข้อมูลที่กรอก
            }
        });
    });

</script>