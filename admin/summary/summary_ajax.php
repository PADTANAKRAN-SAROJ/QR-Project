<?php
// เชื่อมต่อกับฐานข้อมูล MySQL
$mysqli = new mysqli("localhost", "ชื่อผู้ใช้", "รหัสผ่าน", "ชื่อฐานข้อมูล");

// ตรวจสอบการเชื่อมต่อ
if ($mysqli->connect_error) {
    die("การเชื่อมต่อกับฐานข้อมูลล้มเหลว: " . $mysqli->connect_error);
}

// ดึงข้อมูลจากตาราง restaurant
$sql = "SELECT * FROM restaurant";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>รายชื่อร้านอาหาร</h2>";
    echo "<table border='1'>
            <tr>
                <th>รหัสร้าน</th>
                <th>ชื่อร้าน (ภาษาอังกฤษ)</th>
                <th>ชื่อร้าน (ภาษาไทย)</th>
                <th>จำนวนโต๊ะ</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["restaurant_name_eng"] . "</td>
                <td>" . $row["restaurant_name_thai"] . "</td>
                <td>" . $row["number_of_tables"] . "</td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "ไม่พบข้อมูลร้านอาหารในฐานข้อมูล.";
}

// ดึงข้อมูลจากตาราง menu
$sql = "SELECT * FROM menu";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>รายการเมนูอาหาร</h2>";
    echo "<table border='1'>
            <tr>
                <th>รหัสเมนู</th>
                <th>ชื่อเมนู</th>
                <th>ประเภท</th>
                <th>ราคา</th>
                <th>ผู้ใช้ที่สร้าง</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["menu_id"] . "</td>
                <td>" . $row["menu_name"] . "</td>
                <td>" . $row["category"] . "</td>
                <td>" . $row["price"] . "</td>
                <td>" . $row["username"] . "</td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "ไม่พบข้อมูลเมนูอาหารในฐานข้อมูล.";
}

// ปิดการเชื่อมต่อกับฐานข้อมูล
$mysqli->close();
?>
