<?php
require 'includes/functions.php';
if (session_status() === PHP_SESSION_NONE) session_start();
yeuCauDangNhap();
require 'config/database.php';
include 'includes/header.php';

$stmt = $conn->prepare("SELECT t.*, m.tenMon FROM TinDang t JOIN MonHoc m ON t.maMon = m.maMon
                         WHERE t.maND = ? ORDER BY t.ngayDang DESC");
$stmt->bind_param("i", $_SESSION['maND']);
$stmt->execute();
$tinDang = $stmt->get_result();
?>
<h4 class="mb-3">Tin đăng của tôi</h4>
<div class="table-responsive">
<table class="table bg-white">
  <thead><tr><th>Tiêu đề</th><th>Môn học</th><th>Hình thức</th><th>Trạng thái</th><th></th></tr></thead>
  <tbody>
  <?php if ($tinDang->num_rows === 0): ?>
    <tr><td colspan="5" class="text-muted">Bạn chưa đăng tin nào.</td></tr>
  <?php endif; ?>
  <?php while ($tin = $tinDang->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($tin['tieuDe']) ?></td>
      <td><?= htmlspecialchars($tin['tenMon']) ?></td>
      <td><?= hinhThucLabel($tin['hinhThuc']) ?></td>
      <td><span class="badge bg-secondary"><?= trangThaiLabel($tin['trangThai']) ?></span></td>
      <td>
        <?php if ($tin['trangThai'] !== 'da_trao_doi'): ?>
          <a href="sua-tin.php?id=<?= $tin['maTin'] ?>" class="btn btn-sm btn-outline-secondary">Sửa</a>
          <a href="xoa-tin.php?id=<?= $tin['maTin'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa tin này?')">Xóa</a>
        <?php endif; ?>
      </td>
    </tr>
  <?php endwhile; ?>
  </tbody>
</table>
</div>
<?php include 'includes/footer.php'; ?>
