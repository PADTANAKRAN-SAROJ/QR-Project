<?php
require_once 'connect.php';

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $pdo->prepare("SELECT * FROM user WHERE username = :username AND password = :password");
$stmt->bindParam(":username", $username);
$stmt->bindParam(":password", $password);
$stmt->execute();

if ($stmt->rowCount() == 1) {

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    session_start();

    $role = $user['role'];
    $_SESSION['role'] = $role;

    $encodedRole = base64_encode($role);
    setcookie("role", $encodedRole, time() + 14400, "/"); // Cookie มีอายุ 4 ชั่วโมง

    header("Location: ./index.php");
    exit();
} else {
    header("Location: login.php");
}

?>