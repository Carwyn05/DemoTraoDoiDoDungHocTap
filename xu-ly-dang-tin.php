<?php
session_start();
require 'includes/functions.php';
yeuCauDangNhap();
require 'config/database.php';

$tieuDe = trim($_POST['tieuDe'] ?? '');
$moTa = trim($_POST['moTa'] ?? '');
$tinhTrang = trim($_POST['tinhTrang'] ?? '');
$namPhienBan = trim($_POST['namPhienBan'] ?? '');
$diaDiemGiaoDich = trim($_POST['diaDiemGiaoDich'] ?? '');
$hinhThuc = $_POST['hinhThuc'] ?? 'trao_doi';
$gia = $hinhThuc === 'ban' ? (int)($_POST['gia'] ?? 0) : 0;
$maMon = (int)($_POST['maMon'] ?? 0);
$maDanhMuc = (int)($_POST['maDanhMuc'] ?? 0);
$maND = (int)$_SESSION['maND'];

if (!$tieuDe || !$maMon || !$maDanhMuc) {
    header("Location: dang-tin.php?loi=1");
    exit();
}

/* Bắt buộc bảng ảnh phải tồn tại trước khi bật chức năng upload. */
$check = $conn->query("SHOW TABLES LIKE 'HinhAnhTin'");
if (!$check || !$check->num_rows) {
    header("Location: dang-tin.php?anhloi=" . urlencode("Chưa tạo bảng HinhAnhTin. Hãy chạy file database_anh.sql đi kèm project."));
    exit();
}

$stmt = $conn->prepare("INSERT INTO TinDang (tieuDe, moTa, tinhTrang, namPhienBan, diaDiemGiaoDich, hinhThuc, gia, maMon, maDanhMuc, maND, trangThai)
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'cho_duyet')");
$stmt->bind_param("ssssssiiii", $tieuDe, $moTa, $tinhTrang, $namPhienBan, $diaDiemGiaoDich, $hinhThuc, $gia, $maMon, $maDanhMuc, $maND);

if (!$stmt->execute()) {
    die("Không thể đăng tin: " . htmlspecialchars($stmt->error));
}

$maTin = $conn->insert_id;

/* =========================
   XỬ LÝ UPLOAD ẢNH
   ========================= */

$uploadDir = __DIR__ . '/uploads/tin/';

/* Tự động tạo thư mục uploads/tin nếu chưa tồn tại */
if (!is_dir($uploadDir)) {
    if (!mkdir($uploadDir, 0777, true)) {
        die("Không thể tạo thư mục uploads/tin");
    }
}

/* Các định dạng ảnh cho phép */
$allowed = [
    'image/jpeg' => 'jpg',
    'image/png'  => 'png',
    'image/webp' => 'webp'
];

$files = $_FILES['images'] ?? null;

/* Kiểm tra có ảnh được gửi lên hay không */
if ($files && isset($files['tmp_name']) && is_array($files['tmp_name'])) {

    $finfo = new finfo(FILEINFO_MIME_TYPE);

    /* Tối đa 5 ảnh */
    $count = min(count($files['tmp_name']), 5);

    for ($i = 0; $i < $count; $i++) {

        /* Kiểm tra lỗi upload */
        if ($files['error'][$i] !== UPLOAD_ERR_OK) {
            continue;
        }

        /* Tối đa 5MB / ảnh */
        if ($files['size'][$i] > 5 * 1024 * 1024) {
            continue;
        }

        /* Kiểm tra MIME thực tế */
        $mime = $finfo->file($files['tmp_name'][$i]);

        if (!isset($allowed[$mime])) {
            continue;
        }

        /* Kiểm tra file có thực sự là ảnh */
        if (@getimagesize($files['tmp_name'][$i]) === false) {
            continue;
        }

        /* Lấy phần mở rộng */
        $ext = $allowed[$mime];

        /* Tạo tên file duy nhất */
        $fileName = 'tin_' . $maTin . '_' . bin2hex(random_bytes(8)) . '.' . $ext;

        /* Đường dẫn lưu file */
        $destination = $uploadDir . $fileName;

        /* Di chuyển ảnh vào uploads/tin */
        if (move_uploaded_file($files['tmp_name'][$i], $destination)) {

            /* Đường dẫn lưu vào database */
            $relativePath = 'uploads/tin/' . $fileName;

            /* Lưu thông tin ảnh vào bảng HinhAnhTin */
            $insertImg = $conn->prepare(
                "INSERT INTO HinhAnhTin (maTin, duongDan, thuTu)
                 VALUES (?, ?, ?)"
            );

            if (!$insertImg) {
                die("Lỗi chuẩn bị lưu ảnh: " . $conn->error);
            }

            $thuTu = $i + 1;

            $insertImg->bind_param(
                "isi",
                $maTin,
                $relativePath,
                $thuTu
            );

            if (!$insertImg->execute()) {
                die("Lỗi lưu ảnh vào database: " . $insertImg->error);
            }

            $insertImg->close();
        }
    }
}

/* Quay về danh sách tin */
header("Location: tin-cua-toi.php");
exit();

