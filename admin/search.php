<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php
    $menu_name = $_GET["menu_name"];
    echo $menu_name . "<br>";
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=test;charset=utf8", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    $sql = "SELECT * FROM menu WHERE menu_name LIKE :menu_name";
    $nameParam = '%' . $menu_name . '%';  // Add '%' to the bound parameter
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':menu_name', $nameParam, PDO::PARAM_STR);  // Use $nameParam
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
     
    <table border="1">
        <tr>
            <th>ชื่อรายการ</th>
            <!---<th>รูปภาพ</th>-->
            <th>ประเภท</th>
            <th>ราคา</th>
        </tr>
        
        <?php foreach ($result as $row): ?>
            
            <tr>
                <td>
                    <?php echo $row["menu_name"] ?>
                </td>
                <!--<td>
                    echo $row["name"]
                </td>-->
                <td>
                    <?php echo $row["category"] ?>
                </td>
                <td>
                    <?php echo $row["price"] ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

        
</body>
</html>