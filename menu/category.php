<?php
include "./checkSession.php";
include "../connect.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/category.css">
</head>

<body>
    <header>
        <h1>ประเภทอาหาร</h1>
        <div class="icon">
            <a href="order.php?action="><img src="icon\cart.png" width="40rem"></a>
        </div>
    </header>
    
    <div class="flex-container">
        <?php
        $stmt = $pdo->prepare("SELECT * FROM menu GROUP BY category");
        $stmt->execute();
        while ($row = $stmt->fetch()) : ?>
            <div class="menu-item">
                <a href="./menu.php?category=<?= $row["category"] ?>">
                    <img src='./type/<?= $row["category"] ?>.png' alt="<?= $row["category"] ?>">
                </a>
                <br>
                <?php
                echo "<h2>" . $row["category"] . "</h2>";
                ?>
            </div>
        <?php endwhile; ?>
    </div>
</body>

</html>
