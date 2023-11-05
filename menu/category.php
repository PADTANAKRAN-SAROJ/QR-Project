<!DOCTYPE html>
<html lang="en">
<?php
include "./checkSession.php";
?>

<head>
    <link rel="stylesheet" href="css/category.css">
</head>

<body>
    <header>
        <h1>ประเภทอาหาร</h1>
        <div class="icon">
            <a href="order.php?action="><img src="icon\shopping-cart.png" width="30rem"></a>
        </div>
    </header>
    
    <div class="flex-container">
        <?php
        include "../connect.php";

        $stmt = $pdo->prepare("SELECT * FROM menu GROUP BY category");
        $stmt->execute();
        while ($row = $stmt->fetch()) : ?>
            <div class="menu-item">
                <a href="./menu.php?category=<?= $row["category"] ?>">
                    <img src='./type/<?= $row["category"] ?>.png' alt="<?= $row["category"] ?>">
                </a>
                <br>
                <?php
                echo $row["category"] . "<br>";
                ?>
                
                
            </div>
        <?php endwhile; ?>
    </div>
</body>

</html>
