<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="menu.css">
</head>

<body>
    <?php
        $pdo = new PDO("mysql:host=localhost;dbname=test;charset=utf8", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT * FROM menu WHERE category = ?");
        $stmt->bindParam(1, $_GET["category"]); // ผูกค่าจากพารามิเตอร์ URL
        $stmt->execute(); // ดำเนินการคิวรี
    ?>

    <header>
        <a class="back" href="category.php">< กลับไปหน้าหลัก</a>
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
            <img src='food/<?= $row["menu_name"] ?>.jpg'>
            <br>
            <?php
            echo $row["menu_name"];
            ?>

        </div>
    <?php endwhile; ?>

    </div>
</body>
</html>
