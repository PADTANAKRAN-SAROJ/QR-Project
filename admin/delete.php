<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>
<body>
    <?php
    if (isset($_GET["menu_name"])) {
        $pdo = new PDO("mysql:host=localhost;dbname=test;charset=utf8", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $stmt = $pdo->prepare("DELETE FROM menu WHERE menu_name = ?");
        $stmt->bindParam(1, $_GET["menu_name"]);
    
        if ($stmt->execute()) {
            header("Location: admin.php");
            exit();
        } else {
            echo "เกิดข้อผิดพลาดในการลบ";
        }
    } else {
        echo "ไม่ได้รับเมนูที่ต้องการลบ";
        header("Location: admin.php");
    }
    ?>

</body>
</html>