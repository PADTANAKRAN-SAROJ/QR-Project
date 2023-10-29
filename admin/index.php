<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin page</title>
</head>
<?php
    //ตรวจสอบสิทธิ์
    include "./checkRole.php";
?>
<body>
    <div class="adminpage">
        <ol>
            <li><a href="./admin.php">admin</a></li>
            <li><a href="../employee/index.php">emplyee</a></li>
        </ol>
    </div>
</body>
</html>