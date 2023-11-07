<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin page</title>
    <link rel="stylesheet" href="index.css">
</head>
<?php
    //ตรวจสอบสิทธิ์
    include "./checkRole.php";
?>
<body>
    <header>
        <h1>กรุณาเลือกหน้าเข้าใช้งาน</h1>
        <a href="../logout.php"><img src="../logout.png" width="50rem"></a>
    </header>

    <div class="adminpage">
        <img src="./icon/admin.png" width="200rem">
        <ul>
            <li><a href="./admin.php">admin</a></li>
            <li><a href="../employee/index.php">emplyee</a></li>
            <li><a href="./restaurant/index.php">restaurant</a></li>
            <li><a href="./summary/index.php">summary</a></li>
        </ul>
    </div>
</body>
</html>