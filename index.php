<?php
session_start();

if (isset($_SESSION['role'])) {
    if (isset($_COOKIE['role'])) {
        $decodedRole = base64_decode($_COOKIE['role']);

        if ($decodedRole == "admin") {
            header("Location: ./admin/index.php");
            exit();
        } else if ($decodedRole == "chef") {
            header("Location: ./chef/chef.php");
            exit();
        } else if ($decodedRole == "employee") {
            header("Location: ./employee/index.php");
            exit();
        }
    } else {
        header("Location: ./login.php");
        exit();
    }
} else {
    header("Location: ./login.php");
    exit();
}

?>