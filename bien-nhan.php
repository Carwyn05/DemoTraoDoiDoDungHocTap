<?php
require 'includes/functions.php';
if (session_status() === PHP_SESSION_NONE) session_start();
yeuCauDangNhap();
require 'config/database.php';
include 'includes/header.php';

$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT g.*, t.tieuDe FROM GiaoDich g JOIN TinDang t ON g.maTin = t.maTin WHERE g.maGD = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$gd = $stmt->get_result()->fetch_assoc();
?>
<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card p-4">
      <h4 class="text-success mb-3">✔ Đã ghi nhận giao dịch</h4>
      <?php if ($gd): ?>
        <table class="table table-sm">
          <tr><td class="text-muted">Mã giao dịch</td><td class="text-end">GD<?= str_pad($gd['maGD'], 5, '0', STR_PAD_LEFT) ?></td></tr>
          <tr><td class="text-muted">Sản phẩm</td><td class="text-end"><?= htmlspecialchars($gd['tieuDe']) ?></td></tr>
          <tr><td class="text-muted">Số tiền</td><td class="text-end fw-bold"><?= number_format($gd['soTien']) ?>đ</td></tr>
          <tr><td class="text-muted">Hình thức</td><td class="text-end"><?= $gd['phuongThucTT'] === 'tien_mat' ? 'Tiền mặt' : 'Chuyển khoản' ?></td></tr>
          <tr><td class="text-muted">Thời gian</td><td class="text-end"><?= date('d/m/Y H:i', strtotime($gd['ngayThanhToan'])) ?></td></tr>
        </table>
      <?php endif; ?>
      <a href="index.php" class="btn btn-primary w-100">Về trang chủ</a>
    </div>
  </div>
</div>
<?php include 'includes/footer.php'; ?>
