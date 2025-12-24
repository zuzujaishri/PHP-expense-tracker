<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

if (!isset($_POST['id'])) {
    header("Location: list.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$id = $_POST['id'];

/* 🛡️ Secure delete */
$sql = "DELETE FROM expenses WHERE id = $id AND user_id = $user_id";
mysqli_query($conn, $sql);

header("Location: list.php");
exit();