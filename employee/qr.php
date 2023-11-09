<?php 
include "../connect.php" ;
include "./checkRole.php" ;

// ดึงข้อมูลร้านอาหารที่มี ID เท่ากับ 1
$sqlnum = "SELECT number_of_tables FROM restaurant WHERE id = 1";
$stmt = $pdo->query($sqlnum);

// เก็บผลลัพธ์ลงในตัวแปร $restaurantData
$restaurantData = $stmt->fetch(PDO::FETCH_ASSOC);

// ตรวจสอบว่าพบร้านอาหารหรือไม่
if ($restaurantData) {
    // ดึงข้อมูลร้านอาหารสำเร็จ
    $number_of_tables = $restaurantData['number_of_tables'];

    // สร้างอาร์เรย์ $tableStatus และกำหนดค่าเริ่มต้นเป็น 'empty'
    $tableStatus = array_fill(1, $number_of_tables, 'empty');

    // ดึงข้อมูลสถานะโต๊ะจากตาราง customer
    $sql = "SELECT * FROM customer WHERE state = 'On_table'";
    $stmt = $pdo->query($sql);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $table_number = $row['table_number'];
        $tableStatus[$table_number] = 'full';
    }

} else {
    // ไม่พบร้านอาหารที่มี ID เท่ากับ 1
    echo "ไม่พบร้านอาหารที่คุณค้นหา";
}
?>

<html>
<head>

</head>
<body>
    
<ul class="tableList">
    <?php for ($tableNumber = 1; $tableNumber <= $number_of_tables; $tableNumber++): ?>
        <?php
            $tableClass = ($tableStatus[$tableNumber] === 'full') ? 'full' : 'empty';
            $cusId = getCusId($tableNumber);
        ?>
        <li class="<?= $tableClass ?>">
            <?php if ($tableStatus[$tableNumber] === 'full'): ?>
                <button class="buttonFull" onclick="showDetail(<?= $cusId ?>)"><?= $tableNumber ?></button>
            <?php else: ?>
                <button class="buttonEmpty" onclick="createQR(<?= $tableNumber ?>)"><?= $tableNumber ?></button>
            <?php endif; ?>
        </li>
    <?php endfor; ?>
</ul>
</body>
</html>

<?php
function getCusId($tableNumber) {
    global $pdo;
    $sql = "SELECT cus_id FROM customer WHERE state = 'On_table' AND table_number = $tableNumber";
    $stmt = $pdo->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ? $row['cus_id'] : null;
}
?>
