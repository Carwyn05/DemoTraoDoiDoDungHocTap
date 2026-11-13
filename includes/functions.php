<?php
// Các hàm dùng chung cho toàn bộ hệ thống

function laVaiTro($vaiTro) {
    return isset($_SESSION['vaiTro']) && $_SESSION['vaiTro'] === $vaiTro;
}

function yeuCauDangNhap() {
    if (!isset($_SESSION['maND'])) {
        header("Location: dang-nhap.php");
        exit();
    }
}

function yeuCauAdmin() {
    if (!isset($_SESSION['maND']) || $_SESSION['vaiTro'] !== 'admin') {
        header("Location: ../dang-nhap.php");
        exit();
    }
}

function hinhThucLabel($ht) {
    $map = ['ban' => 'Bán', 'tang' => 'Tặng', 'trao_doi' => 'Trao đổi'];
    return $map[$ht] ?? $ht;
}

function trangThaiLabel($tt) {
    $map = [
        'cho_duyet' => 'Chờ duyệt', 'da_duyet' => 'Đã duyệt',
        'da_trao_doi' => 'Đã trao đổi xong', 'tu_choi' => 'Bị từ chối'
    ];
    return $map[$tt] ?? $tt;
}
