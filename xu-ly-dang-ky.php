<?php
require 'config/database.php';

$hoTen = trim($_POST['hoTen']);
$email = trim($_POST['email']);
$sdt = trim($_POST['sdt']);
$matKhau = password_hash($_POST['matKhau'], PASSWORD_DEFAULT);

// Kiểm tra email đã tồn tại chưa
$check = $conn->prepare("SELECT maND FROM NguoiDung WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
if ($check->get_result()->num_rows > 0) {
    header("Location: dang-ky.php?loi=" . urlencode("Email này đã được đăng ký."));
    exit();
}

$stmt = $conn->prepare("INSERT INTO NguoiDung (hoTen, email, matKhau, sdt) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $hoTen, $email, $matKhau, $sdt);

if ($stmt->execute()) {
    header("Location: dang-nhap.php?dangky=1");
} else {
    header("Location: dang-ky.php?loi=" . urlencode("Có lỗi xảy ra, vui lòng thử lại."));
}
