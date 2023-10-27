<!DOCTYPE html>
<html>
<head>
    <title>LOGIN</title>
</head>
<body>
    <h2>LOGIN</h2>
    <form action="process_login.php" method="post">
        <label for="username">ชื่อผู้ใช้:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">รหัสผ่าน:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="เข้าสู่ระบบ">
    </form>
</body>
</html>