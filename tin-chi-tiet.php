<?php
require 'includes/functions.php';
if (session_status() === PHP_SESSION_NONE) session_start();
require 'config/database.php';
include 'includes/header.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $conn->prepare("SELECT t.*, m.tenMon, d.tenDanhMuc, n.hoTen AS nguoiBan, n.sdt, n.email, n.maND AS maNguoiBan
                         FROM TinDang t
                         JOIN MonHoc m ON t.maMon = m.maMon
                         JOIN DanhMucVatPham d ON t.maDanhMuc = d.maDanhMuc
                         JOIN NguoiDung n ON t.maND = n.maND
                         WHERE t.maTin = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$tin = $stmt->get_result()->fetch_assoc();

if (!$tin) { echo "<div class='alert alert-warning'>Không tìm thấy tin đăng.</div>"; include 'includes/footer.php'; exit(); }

$images = [];
$check = $conn->query("SHOW TABLES LIKE 'HinhAnhTin'");
if ($check && $check->num_rows) {
    $imgStmt = $conn->prepare("SELECT duongDan FROM HinhAnhTin WHERE maTin = ? ORDER BY thuTu, maAnh");
    $imgStmt->bind_param("i", $id);
    $imgStmt->execute();
    $res = $imgStmt->get_result();
    while ($row = $res->fetch_assoc()) $images[] = $row['duongDan'];
}
?>
<div class="row g-4">
  <div class="col-lg-7">
    <?php if ($images): ?>
      <img id="mainImage" src="<?= htmlspecialchars($images[0]) ?>" class="detail-main-img mb-3" alt="Ảnh sản phẩm">
      <div class="d-flex flex-wrap gap-2">
        <?php foreach ($images as $img): ?>
          <img src="<?= htmlspecialchars($img) ?>" class="small-thumb" onclick="document.getElementById('mainImage').src=this.src" alt="Ảnh sản phẩm">
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="detail-main-img d-grid place-items-center" style="display:grid;place-items:center;font-size:90px;">📚</div>
    <?php endif; ?>
  </div>

  <div class="col-lg-5">
    <div class="card border-0 shadow-sm rounded-4 p-4">
      <span class="badge badge-<?= $tin['hinhThuc'] ?> text-white mb-2" style="width:fit-content;"><?= hinhThucLabel($tin['hinhThuc']) ?></span>
      <h2 class="fw-bold"><?= htmlspecialchars($tin['tieuDe']) ?></h2>
      <p class="text-muted"><?= htmlspecialchars($tin['tinhTrang']) ?> · <?= htmlspecialchars($tin['tenMon']) ?> · <?= htmlspecialchars($tin['tenDanhMuc']) ?></p>

      <?php if ($tin['hinhThuc'] === 'ban'): ?>
        <p class="fs-2 fw-bold text-primary"><?= number_format($tin['gia']) ?>đ</p>
      <?php endif; ?>

      <div class="bg-light rounded-3 p-3 mb-3">
        <div class="small text-muted">Mô tả</div>
        <div><?= nl2br(htmlspecialchars($tin['moTa'])) ?></div>
      </div>

      <hr>
      <p class="mb-2">👤 Người đăng: <strong><?= htmlspecialchars($tin['nguoiBan']) ?></strong></p>

      <?php if (!isset($_SESSION['maND'])): ?>
        <div class="alert alert-info">Đăng nhập để xem thông tin liên hệ và thanh toán.</div>
        <a href="dang-nhap.php" class="btn btn-primary w-100">Đăng nhập</a>
      <?php elseif ($_SESSION['maND'] == $tin['maNguoiBan']): ?>
        <div class="alert alert-secondary">Đây là tin đăng của bạn.</div>
      <?php else: ?>
        <p class="mb-1">📞 SĐT: <?= htmlspecialchars($tin['sdt'] ?: 'Chưa cập nhật') ?></p>
        <p class="mb-1">✉️ Email: <?= htmlspecialchars($tin['email']) ?></p>
        <p class="mb-3">📍 Địa điểm: <?= htmlspecialchars($tin['diaDiemGiaoDich'] ?: 'Chưa cập nhật') ?></p>
        <?php if ($tin['trangThai'] === 'da_duyet'): ?>
          <a href="xac-nhan-thanh-toan.php?id=<?= $tin['maTin'] ?>" class="btn btn-primary w-100">Xác nhận thanh toán / trao đổi xong</a>
        <?php else: ?>
          <div class="alert alert-secondary">Tin này đã được trao đổi xong.</div>
        <?php endif; ?>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php include 'includes/footer.php'; ?>
