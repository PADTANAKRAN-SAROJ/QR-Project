<?php
    $pdo = new PDO("mysql:host=localhost;dbname=test;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // จำนวนรายการต่อหน้า
    $itemsPerPage = 10;

    // หน้าปัจจุบัน
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    // คำนวณ offset
    $offset = ($currentPage - 1) * $itemsPerPage;

    // เรียกดึงข้อมูล
    $stmt = $pdo->prepare("SELECT * FROM menu LIMIT :itemsPerPage OFFSET :offset");
    $stmt->bindParam(':itemsPerPage', $itemsPerPage, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ส่งข้อมูลในรูปแบบ JSON
    echo json_encode($results);

?>
