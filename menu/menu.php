<!DOCTYPE html>
<html lang="en">

<body>
    <?php
        $pdo = new PDO("mysql:host=localhost;dbname=test;charset=utf8", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $stmt = $pdo->prepare("SELECT * FROM menu WHERE category = ?");
        $stmt->bindParam(1, $_GET["category"]); // 2. น าค่า pid ที่สงมากับ ่ URL ก าหนดเป็นเงื่อนไข
        $stmt->execute(); // 3. เริ่มค ้นหา
        $row = $stmt->fetch(); // 4. ดึงผลลัพธ์ (เนื่องจากมีข ้อมูล 1 แถวจึงเรียกเมธอด fetch เพียงครั้งเดียว)
    ?>
    <div style="display:flex">
        <div>
            <img src='type/<?=$row["category"]?>.png' width='150' height='150'>
        </div>
        <div style="padding: 15px">
            <h2><?=$row["category"]?></h2>
            <?php
            echo "ชื่อประเภท: " . $row ["category"] . "<br>";

            ?>
        </div>
    </div>
    
    
</body>
</html>