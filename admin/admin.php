<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin</title>

    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <?php
    $pdo = new PDO("mysql:host=localhost;dbname=test;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT * FROM menu");
    $stmt->execute();
    ?>

    <header>
		<h1>เมนูอาหารทั้งหมด</h1>
	</header>

    <div class="c6">
        <form method="get" action="findmenu.php">
            <div class="warpborder tt1">
                <img src="icon\search.png">
                <input class="withicon" name="menu_name" placeholder="ค้นหาชื่อเมนู" />
            </div>
            <div class="aa">
                <input class="nextButton" type="submit" value="ค้นหา">
            </div>
        </form>
    </div>

        <table class="t8">
            <thead>
                <tr>
                    <th>ชื่อรายการ</th>
                    
                    <th>ประเภท</th>
                    <th>ราคา</th>
                </tr>
            </thead>
            
            <tbody>
            <?php
            while ($row = $stmt->fetch()) {
                echo "<tr>";
                    echo "<td>" . $row["menu_name"] . "</td>";
                    //echo "<td>" . $row["pname"] . "</td>";
                    echo "<td>" . $row["category"] . "</td>";
                    echo "<td>" . $row["price"] . " บาท" . "</td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>

</body>
</html>