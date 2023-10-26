<!DOCTYPE html>
<html lang="en">

<?php
    session_start(); // เริ่มเซสชันตอนแรก

    include "../connect.php";
    
    if (isset($_GET['cus_id'])) {
        $cusId = $_GET['cus_id'];
        $tableNumber = $_GET['table_number'];
        $entry_timestamp = $_GET['entry_time'];
    
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
                    if (isset($_SESSION['cus_id'])) {
                        echo "GET Data: Cus ID - {$_SESSION['cus_id']}, Table Number - {$_SESSION['table_number']}, Entry Time - {$_SESSION['entry_timestamp']}";
                        echo "<br>Database Data: Number Table - {$_SESSION['database_table_number']}, Entry Time - {$_SESSION['database_entry_timestamp']}";
                    } else {
                        echo "ข้อมูลเซสชันไม่พร้อมใช้งาน";
                    }
                }
            } else {
                echo "ไม่พบข้อมูลในฐานข้อมูล";
            }
        } else {
            echo "เกิดข้อผิดพลาดในการคิวรีข้อมูล";
        }
    
        if ($tableNumber == $databaseTableNumber && date('Y-m-d H:i', strtotime($entry_timestamp)) == date('Y-m-d H:i', strtotime($databaseEntryTime))) {
            // เก็บข้อมูลในตัวแปรเซสชัน
            $_SESSION['cus_id'] = $cusId;
            $_SESSION['table_number'] = $tableNumber;
            $_SESSION['entry_timestamp'] = $entry_timestamp;
            $_SESSION['database_table_number'] = $databaseTableNumber;
            $_SESSION['database_entry_timestamp'] = $databaseEntryTime;
        }
    }else {
        echo "ไม่มี Cus ID ใน GET ไม่สามารถดึงข้อมูล";
    }
    
?>
<head>
    <link rel="stylesheet" href="css/category.css">
</head>

<body>
<?php
	if(!isset($_SESSION['cart'])){
		$_SESSION['cart']=array();
	}	
	?>

    <header>
        <h1>ประเภทอาหาร</h1>
        <div class="icon">
            <a href="order.php?action="><img src="icon\shopping-cart.png" width="30rem"></a>
        </div>
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
