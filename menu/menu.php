<?php
include "./checkSession.php";
include "../connect.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/menu.css">
</head>
<body>
    <?php
        $stmt = $pdo->prepare("SELECT * FROM menu WHERE category = ?");
        $stmt->bindParam(1, $_GET["category"]); // ผูกค่าจากพารามิเตอร์ URL
        $stmt->execute(); // ดำเนินการคิวรี
    ?>

    <header>
        <div class="icon">
            <a href="category.php"><img src="icon\back.png" width="30rem"></a>
        </div>
        <h1>
            <?php
                if ($stmt->rowCount() > 0) {
                    $category = $_GET["category"];
                    echo $category;
                } else {
                    echo "ไม่พบประเภท"; // จัดการกรณีที่ไม่พบประเภท
                }
            ?>
        </h1>
    </header>

    <div class="flex-container">
    <?php
        while ($row = $stmt->fetch()) :
    ?>
        <div class="menu-item">
            <img src='food/<?= $row["menu_id"] ?>.jpg'>
            <br>

            <div>
                <?php
                echo $row["menu_name"];
                ?>   
            </div>

            <div>
                <?php
                echo "ราคา: " . $row["price"] . " บาท";
                ?>   
            </div>

            <br>
            
            <form method="post" action="order.php?action=add&menu_id=<?=$row["menu_id"]?>&menu_name=<?=$row["menu_name"]?>&price=<?=$row["price"]?>">
                <select name="qty">
                    <?php
                    for ($i = 1; $i <= 9; $i++) {
                        echo "<option value='$i'>$i</option>";
                    }
                    ?>
                </select>
				<input class="orderConfirmButton" type="submit" value="ใส่ตะกร้า">	   
			</form>
        </div>
    <?php endwhile; ?>

    </div>
</body>
</html>
