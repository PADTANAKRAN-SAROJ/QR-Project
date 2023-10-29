<?php
try {
    // $db_host = "localhost";
    // $db_name = "id21472414_scansvor";
    // $db_charset = "utf8";
    // $db_user = "id21472414_db_scansvor";
    // $db_pass = "q50.TmOa9C,vh&vV1T3";

    // $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=$db_charset", $db_user, $db_pass);
    $pdo = new PDO("mysql:host=localhost;dbname=test;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("การเชื่อมต่อกับฐานข้อมูลล้มเหลว: " . $e->getMessage());
}
?>
