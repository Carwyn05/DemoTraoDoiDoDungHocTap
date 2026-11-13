<?php
require 'includes/functions.php';
if (session_status() === PHP_SESSION_NONE) session_start();
yeuCauDangNhap();
require 'config/database.php';
include 'includes/header.php';

$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT * FROM TinDang WHERE maTin = ? AND maND = ?");
$stmt->bind_param("ii", $id, $_SESSION['maND']);
$stmt->execute();
$tin = $stmt->get_result()->fetch_assoc();

if (!$tin) { header("Location: tin-cua-toi.php"); exit(); }

$monHoc = $conn->query("SELECT * FROM MonHoc");
$danhMuc = $conn->query("SELECT * FROM DanhMucVatPham");
?>
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card p-4">
      <h4 class="mb-3">Sửa tin đăng</h4>
      <form action="xu-ly-sua-tin.php" method="POST">
        <input type="hidden" name="maTin" value="<?= $tin['maTin'] ?>">
        <div class="mb-3">
          <label class="form-label">Tiêu đề</label>
          <input type="text" name="tieuDe" class="form-control" value="<?= htmlspecialchars($tin['tieuDe']) ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Mô tả</label>
          <textarea name="moTa" class="form-control" rows="3"><?= htmlspecialchars($tin['moTa']) ?></textarea>
        </div>
        <div class="mb-3">
          <label class="form-label">Tình trạng</label>
          <input type="text" name="tinhTrang" class="form-control" value="<?= htmlspecialchars($tin['tinhTrang']) ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Môn học</label>
          <select name="maMon" class="form-select">
            <?php while ($m = $monHoc->fetch_assoc()): ?>
              <option value="<?= $m['maMon'] ?>" <?= $tin['maMon'] == $m['maMon'] ? 'selected' : '' ?>><?= htmlspecialchars($m['tenMon']) ?></option>
            <?php endwhile; ?>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Loại vật phẩm</label>
          <select name="maDanhMuc" class="form-select">
            <?php while ($d = $danhMuc->fetch_assoc()): ?>
              <option value="<?= $d['maDanhMuc'] ?>" <?= $tin['maDanhMuc'] == $d['maDanhMuc'] ? 'selected' : '' ?>><?= htmlspecialchars($d['tenDanhMuc']) ?></option>
            <?php endwhile; ?>
          </select>
        </div>
        <button type="submit" class="btn btn-primary w-100">Lưu thay đổi</button>
      </form>
    </div>
  </div>
</div>
<?php include 'includes/footer.php'; ?>
