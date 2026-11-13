<?php
require 'includes/functions.php';
if (session_status() === PHP_SESSION_NONE) session_start();
yeuCauDangNhap();
require 'config/database.php';
include 'includes/header.php';

$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT * FROM TinDang WHERE maTin = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$tin = $stmt->get_result()->fetch_assoc();

if (!$tin || $tin['maND'] == $_SESSION['maND']) {
    header("Location: index.php");
    exit();
}
?>
<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card p-4">
      <h4 class="mb-3">Xác nhận thanh toán</h4>
      <p class="text-muted"><?= htmlspecialchars($tin['tieuDe']) ?></p>
      <?php if (isset($_GET['loi'])): ?>
        <div class="alert alert-danger">Vui lòng nhập số tiền hợp lệ.</div>
      <?php endif; ?>
      <form action="xu-ly-thanh-toan.php" method="POST">
        <input type="hidden" name="maTin" value="<?= $tin['maTin'] ?>">
        <div class="mb-3">
          <label class="form-label">Số tiền (đ)</label>
          <input type="number" name="soTien" class="form-control" value="<?= $tin['gia'] ?>" min="0" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Hình thức</label>
          <select name="phuongThuc" class="form-select">
            <option value="tien_mat">Tiền mặt khi gặp mặt</option>
            <option value="chuyen_khoan">Chuyển khoản</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary w-100">Xác nhận</button>
      </form>
    </div>
  </div>
</div>
<?php include 'includes/footer.php'; ?>
