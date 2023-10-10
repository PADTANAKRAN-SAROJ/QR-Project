<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>เข้าสู่ระบบ</h2>
    <form action="process_login.php" method="post">
        <label for="username">ชื่อผู้ใช้:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">รหัสผ่าน:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="เข้าสู่ระบบ">
    </form>
</body>
</html>
