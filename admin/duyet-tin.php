<?php
session_start();
require '../includes/functions.php';
yeuCauAdmin();
require '../config/database.php';

$id = $_GET['id'] ?? 0;
$hanhDong = $_GET['hanhDong'] ?? '';
$trangThai = $hanhDong === 'duyet' ? 'da_duyet' : 'tu_choi';

$stmt = $conn->prepare("UPDATE TinDang SET trangThai = ? WHERE maTin = ?");
$stmt->bind_param("si", $trangThai, $id);
$stmt->execute();

header("Location: index.php");
