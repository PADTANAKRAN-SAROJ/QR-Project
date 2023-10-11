<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="category.css">
</head>

<body>
<?php
	if(!isset($_SESSION['cart'])){
		$_SESSION['cart']=array();
	}	
	?>

    <header>
        <h1>ประเภทอาหาร</h1>
        <a class="cart" href="cart.php?action=">สินค้าในตะกร้า (<?=sizeof($_SESSION['cart'])?>)</a>
    </header>
    
    <div class="flex-container">
        <?php
        $pdo = new PDO("mysql:host=localhost;dbname=test;charset=utf8", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT * FROM menu GROUP BY category");
        $stmt->execute();
        while ($row = $stmt->fetch()) : ?>
            <div class="menu-item">
                <a href="menu.php?category=<?= $row["category"] ?>">
                    <img src='type/<?= $row["category"] ?>.png' alt="<?= $row["category"] ?>">
                </a>
                <br>
                <?php
                echo "ชื่อประเภท: " . $row["category"] . "<br>";
                ?>
                
                
            </div>
        <?php endwhile; ?>
    </div>
</body>

</html>
