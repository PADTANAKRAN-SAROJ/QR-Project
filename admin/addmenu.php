<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>addmenu</title>

    <link rel="stylesheet" href="addmenu.css">
</head>
<body>
    <?php
        //ตรวจสอบสิทธิ์
        include "./checkRole.php";
        include "../connect.php";
    ?>

    <header>
        <div class="back">
            <a href="admin.php"><img src="../menu/icon/back.png" width="30rem"></a>
        </div>
        <h1>เพิ่มรายการอาหาร</h1>
    </header>

    <div class="center">
        <h2>- กรุณากรอกรายละเอียด -</h2>
        <form action="add.php" method="post" enctype="multipart/form-data" style="text-align: center; margin: 0 auto; width: max-content;">
            <p>ชื่อเมนู: <input type="text" name="name"></p>
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
            <p>ราคา: <input type="text" name="price"></p>
            <p>อัพโหลดรูปภาพ: <input type="file" name="picture"></p>
            <br>
            <input class="confirmButton" type="submit" value="เพิ่มข้อมูล">
        </form>
    </div>

</body>
</html>