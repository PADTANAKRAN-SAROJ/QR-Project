<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #F8F8FF;
            text-align: center;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #E6E6FA;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-family: 'Your Desired Font', sans-serif;
            font-size: 36px;
            color: #A52A2A; 
            text-align: center; 
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 10);

        }

        .menu-link {
            display: block;
            margin: 10px 0;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .menu-link:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>SCANSAVOR</h1>
        <a class="menu-link" href="./admin/admin.php">Admin</a>
        <a class="menu-link" href="./chef/chef.php">Chef</a>
        <a class="menu-link" href="./employee/employee.php">Employee</a>
        <a class="menu-link" href="./menu/menu.php">Menu</a>
    </div>
</body>
</html>
