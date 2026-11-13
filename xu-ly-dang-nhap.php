<?php
session_start();
require 'config/database.php';

$email = trim($_POST['email']);
$matKhau = $_POST['matKhau'];

$stmt = $conn->prepare("SELECT * FROM NguoiDung WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if ($user && password_verify($matKhau, $user['matKhau'])) {
    $_SESSION['maND'] = $user['maND'];
    $_SESSION['hoTen'] = $user['hoTen'];
    $_SESSION['vaiTro'] = $user['vaiTro'];
    header("Location: index.php");
} else {
    header("Location: dang-nhap.php?loi=" . urlencode("Sai email hoặc mật khẩu."));
}
