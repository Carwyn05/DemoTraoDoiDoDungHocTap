<?php
session_start();
require 'includes/functions.php';
yeuCauDangNhap();
require 'config/database.php';

$maTin = $_POST['maTin'];
$soTien = $_POST['soTien'];
$phuongThuc = $_POST['phuongThuc'];

if (!$soTien || $soTien < 0) {
    header("Location: xac-nhan-thanh-toan.php?id=$maTin&loi=1");
    exit();
}

$tinStmt = $conn->prepare("SELECT maND FROM TinDang WHERE maTin = ?");
$tinStmt->bind_param("i", $maTin);
$tinStmt->execute();
$tin = $tinStmt->get_result()->fetch_assoc();

$maNguoiMua = $_SESSION['maND'];
$maNguoiBan = $tin['maND'];

$conn->begin_transaction();
try {
    $gd = $conn->prepare("INSERT INTO GiaoDich (maTin, maNguoiMua, maNguoiBan, soTien, phuongThucTT, trangThai)
                           VALUES (?, ?, ?, ?, ?, 'da_thanh_toan')");
    $gd->bind_param("iiids", $maTin, $maNguoiMua, $maNguoiBan, $soTien, $phuongThuc);
    $gd->execute();

    $upd = $conn->prepare("UPDATE TinDang SET trangThai = 'da_trao_doi' WHERE maTin = ?");
    $upd->bind_param("i", $maTin);
    $upd->execute();

    $conn->commit();
    header("Location: bien-nhan.php?id=" . $conn->insert_id);
} catch (Exception $e) {
    $conn->rollback();
    header("Location: xac-nhan-thanh-toan.php?id=$maTin&loi=1");
}
