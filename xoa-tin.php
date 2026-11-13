<?php
session_start();
require 'includes/functions.php';
yeuCauDangNhap();
require 'config/database.php';

$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("DELETE FROM TinDang WHERE maTin = ? AND maND = ?");
$stmt->bind_param("ii", $id, $_SESSION['maND']);
$stmt->execute();

header("Location: tin-cua-toi.php");
