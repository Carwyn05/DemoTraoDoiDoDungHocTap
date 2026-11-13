<?php
require '../includes/functions.php';
if (session_status() === PHP_SESSION_NONE) session_start();
yeuCauAdmin();
require '../config/database.php';
include '../includes/header.php';

$pending = $conn->query("SELECT t.*, m.tenMon, n.hoTen AS nguoiDang
                          FROM TinDang t
                          JOIN MonHoc m ON t.maMon = m.maMon
                          JOIN NguoiDung n ON t.maND = n.maND
                          WHERE t.trangThai = 'cho_duyet' ORDER BY t.ngayDang DESC");
?>
<h4 class="mb-3">Tin chờ duyệt</h4>
<div class="row g-3 mb-4">
  <?php if ($pending->num_rows === 0): ?>
    <p class="text-muted">Không có tin nào chờ duyệt.</p>
  <?php endif; ?>
  <?php while ($tin = $pending->fetch_assoc()): ?>
    <div class="col-md-4">
      <div class="card p-3">
        <h6><?= htmlspecialchars($tin['tieuDe']) ?></h6>
        <p class="small text-muted mb-2"><?= htmlspecialchars($tin['tenMon']) ?> · Đăng bởi: <?= htmlspecialchars($tin['nguoiDang']) ?></p>
        <div class="d-flex gap-2">
          <a href="duyet-tin.php?id=<?= $tin['maTin'] ?>&hanhDong=duyet" class="btn btn-sm btn-success flex-fill">Duyệt</a>
          <a href="duyet-tin.php?id=<?= $tin['maTin'] ?>&hanhDong=tuchoi" class="btn btn-sm btn-outline-danger flex-fill">Từ chối</a>
        </div>
      </div>
    </div>
  <?php endwhile; ?>
</div>
<div class="d-flex gap-2 mb-3">
  <a href="mon-hoc.php" class="btn btn-outline-secondary btn-sm">Quản lý môn học</a>
  <a href="giao-dich.php" class="btn btn-outline-secondary btn-sm">Lịch sử giao dịch</a>
</div>
<?php include '../includes/footer.php'; ?>
