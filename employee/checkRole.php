<?php
session_start();

if (isset($_SESSION['role']) && ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'employee')) {

} else {
    header("Location: ../login.php");
    exit();
}
?>