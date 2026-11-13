<?php
require '../includes/functions.php';
if (session_status() === PHP_SESSION_NONE) session_start();
yeuCauAdmin();
require '../config/database.php';
include '../includes/header.php';

$gd = $conn->query("SELECT g.*, t.tieuDe, nb.hoTen AS ten_ban, nm.hoTen AS ten_mua
                     FROM GiaoDich g
                     JOIN TinDang t ON g.maTin = t.maTin
                     JOIN NguoiDung nb ON g.maNguoiBan = nb.maND
                     JOIN NguoiDung nm ON g.maNguoiMua = nm.maND
                     ORDER BY g.ngayThanhToan DESC");
?>
<h4 class="mb-3">Lịch sử giao dịch</h4>
<table class="table bg-white">
  <thead><tr><th>Mã GD</th><th>Sản phẩm</th><th>Người bán</th><th>Người mua</th><th>Số tiền</th><th>Thời gian</th></tr></thead>
  <tbody>
  <?php if ($gd->num_rows === 0): ?>
    <tr><td colspan="6" class="text-muted">Chưa có giao dịch nào.</td></tr>
  <?php endif; ?>
  <?php while ($row = $gd->fetch_assoc()): ?>
    <tr>
      <td>GD<?= str_pad($row['maGD'], 5, '0', STR_PAD_LEFT) ?></td>
      <td><?= htmlspecialchars($row['tieuDe']) ?></td>
      <td><?= htmlspecialchars($row['ten_ban']) ?></td>
      <td><?= htmlspecialchars($row['ten_mua']) ?></td>
      <td><?= number_format($row['soTien']) ?>đ</td>
      <td><?= date('d/m/Y H:i', strtotime($row['ngayThanhToan'])) ?></td>
    </tr>
  <?php endwhile; ?>
  </tbody>
</table>
<?php include '../includes/footer.php'; ?>
