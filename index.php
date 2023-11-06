<?php
session_start();

if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];

    if ($role == "admin") {
        header("Location: ./admin/index.php");
        exit();
    } else if ($role == "chef") {
        header("Location: ./chef/index.php");
        exit();
    } else if ($role == "employee") {
        header("Location: ./employee/index.php");
        exit();
    }
} else {
    header("Location: ./login.php");
    exit();
}
?>
