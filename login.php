<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="./icon.png">
    <link rel="stylesheet" type="text/css" href="./login.css">
    <title>LOGIN</title>

</head>
<?php 
include "./connect.php";

$query = "SELECT restaurant_name_eng,restaurant_name_thai FROM restaurant WHERE id = 1";
$result = $pdo->query($query);

if ($result) {
    $row = $result->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $restaurantNameEng = strtoupper($row['restaurant_name_eng']);
        $restaurantNameThai = strtoupper($row['restaurant_name_thai']);
    }
}
?>

<body>
    <div class="loginPage">
        <img src="./icon.png" alt="Restaurant Logo">
        <div class="restaurant_name">
            <h1><?= $restaurantNameEng ?></h1>
            <h2>(<?= $restaurantNameThai ?>) </h2>
        </div>
        <h2>LOGIN</h2>
        <form class="formLogin" action="process_login.php" method="post">
            <div class="form-group">
                <label for="username">ชื่อผู้ใช้:</label><br>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">รหัสผ่าน:</label><br>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <input type="submit" value="เข้าสู่ระบบ">
            </div>
        </form>
    </div>
</body>
</html>
