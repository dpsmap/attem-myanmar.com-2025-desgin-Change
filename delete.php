<?php

require_once('./config/db.php');
require_once('./config/helper.php');

session_start();

$userId = $_SESSION['id'] ?? null;
$userName = $_SESSION['name'] ?? '';
$userRole = $_SESSION['role'] ?? '';

if (empty($userId)) {
    header("location: ./login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['id'];

    $sql = "DELETE FROM `posts` WHERE id=$id";
    $stmt = $conn->query($sql);
    $stmt->execute();

    header('location:./dashboard.php');
    exit();
}
