<?php
$pdo = new PDO("mysql:host=localhost;dbname=test;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(isset($_GET['menu_name'])){
    $menu_name = '%' . $_GET['menu_name'] . '%';
    $stmt = $pdo->prepare("SELECT * FROM menu WHERE menu_name LIKE :menu_name");
    $stmt->bindParam(':menu_name', $menu_name, PDO::PARAM_STR);
    $stmt->execute();

    echo '<table>';
    echo '<thead>';
    echo '<tr>';
    echo '<th>ชื่อรายการ</th>';
    echo '<th>ประเภท</th>';
    echo '<th>ราคา</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    
    while ($row = $stmt->fetch()) {
        echo '<tr>';
        echo '<td>' . $row['menu_name'] . '</td>';
        echo '<td>' . $row['category'] . '</td>';
        echo '<td>' . $row['price'] . ' บาท</td>';
        echo '</tr>';
    }
    
    echo '</tbody>';
    echo '</table>';
}
?>
