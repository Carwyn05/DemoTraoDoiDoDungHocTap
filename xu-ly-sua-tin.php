<?php
session_start();
require 'includes/functions.php';
yeuCauDangNhap();
require 'config/database.php';

$maTin = $_POST['maTin'];
$stmt = $conn->prepare("UPDATE TinDang SET tieuDe=?, moTa=?, tinhTrang=?, maMon=?, maDanhMuc=?
                         WHERE maTin=? AND maND=?");
$stmt->bind_param("sssiiii",
    $_POST['tieuDe'], $_POST['moTa'], $_POST['tinhTrang'],
    $_POST['maMon'], $_POST['maDanhMuc'], $maTin, $_SESSION['maND']);
$stmt->execute();

header("Location: tin-cua-toi.php");
