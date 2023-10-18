<!DOCTYPE html>
<html lang="en">
<?php
// Include the database connection
include "../connect.php";
// ตรวจสอบว่ามีค่า cus_id ใน GET หรือไม่
if (isset($_GET['cus_id'])) {
    $cusId = $_GET['cus_id'];
    $tableNumber = $_GET['table_number'];
    $entryTime = $_GET['entry_time'];

    // ตรวจสอบว่า cus_id นี้มีอยู่ในฐานข้อมูลหรือไม่
    $sql = "SELECT * FROM customer WHERE cus_id = :cus_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':cus_id', $cusId, PDO::PARAM_INT);

    // ทำการคิวรีฐานข้อมูล
    if ($stmt->execute()) {
        // ตรวจสอบว่ามีข้อมูลลูกค้าในฐานข้อมูล
        if ($stmt->rowCount() > 0) {
            // ดึงข้อมูลจากฐานข้อมูล
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $databaseTableNumber = $row['table_number'];
            $databaseEntryTime = $row['entry_timestamp'];

            // ตรวจสอบ state
            if ($row['state'] == 'Done') {
                echo "ขอบคุณที่อุดหนุน!";
            } else {
                // เปรียบเทียบเฉพาะวันและเวลา (ไม่เจาะจงไปถึงวินาที)
                if ($tableNumber == $databaseTableNumber && date('Y-m-d H:i', strtotime($entryTime)) == date('Y-m-d H:i', strtotime($databaseEntryTime))) {
                    echo "GET Data: Cus ID - $cusId, Table Number - $tableNumber, Entry Time - $entryTime";
                    echo "<br>Database Data: Number Table - $databaseTableNumber, Entry Time - $databaseEntryTime";
                    echo "<br>ข้อมูลตรงกัน";
                } else {
                    echo "ข้อมูลไม่ตรงกัน";
                }
            }
        } else {
            echo "ไม่พบข้อมูลในฐานข้อมูล";
        }
    } else {
        echo "เกิดข้อผิดพลาดในการคิวรีข้อมูล";
    }
} else {
    echo "ไม่มี Cus ID ใน GET ไม่สามารถดึงข้อมูล";
}

?>



<head>
    <link rel="stylesheet" href="css/menu.css">
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
        <div class="back">
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
            <img src='food/<?= $row["menu_name"] ?>.jpg'>
            <br>

            <div>
                <?php
                echo $row["menu_name"];
                ?>   
            </div>

            <div>
                <?php
                echo "ราคา:" . $row["price"];
                ?>   
            </div>

            <br>
            
            <form method="post" action="order.php?action=add&menu_id=<?=$row["menu_id"]?>&menu_name=<?=$row["menu_name"]?>&price=<?=$row["price"]?>">
				<input type="number" name="qty" value="1" min="1" max="9">
				<input type="submit" value="ใส่ตะกร้า">	   
			</form>
        </div>
    <?php endwhile; ?>

    </div>
</body>
</html>
