<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=test;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("การเชื่อมต่อกับฐานข้อมูลล้มเหลว: " . $e->getMessage());
}
?>
