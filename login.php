<!DOCTYPE html>
<html>
<head>
    <title>LOGIN</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            text-align: center;
        }

        h2 {
            font-family: 'Your Desired Font', sans-serif;
            font-size: 36px;
            color: #101010; 
            text-align: center; 
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 10);

        }

        form {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            display: inline-block;
        }

        label {
            display: block;
            margin: 10px 0;
            color: #333;
            text-align: left; 
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #0074cc;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 30px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0058a6;
        }
    </style>
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
