<?php
require 'includes/functions.php';
include 'includes/header.php';
require 'config/database.php';

$nganh = $_GET['nganh'] ?? '';
$loai = $_GET['loai'] ?? '';

$sql = "SELECT t.*, m.tenMon, d.tenDanhMuc, n.hoTen AS nguoiBan, ng.tenNganh
        FROM TinDang t
        JOIN MonHoc m ON t.maMon = m.maMon
        JOIN Nganh ng ON m.maNganh = ng.maNganh
        JOIN DanhMucVatPham d ON t.maDanhMuc = d.maDanhMuc
        JOIN NguoiDung n ON t.maND = n.maND
        WHERE t.trangThai = 'da_duyet'";
$params = []; $types = "";
if ($nganh !== '') { $sql .= " AND m.maNganh = ?"; $params[] = $nganh; $types .= "i"; }
if ($loai !== '') { $sql .= " AND t.maDanhMuc = ?"; $params[] = $loai; $types .= "i"; }
$sql .= " ORDER BY t.ngayDang DESC";

$stmt = $conn->prepare($sql);
if ($params) $stmt->bind_param($types, ...$params);
$stmt->execute();
$tinDang = $stmt->get_result();

$nganhList = $conn->query("SELECT * FROM Nganh ORDER BY tenNganh");
$danhMuc = $conn->query("SELECT * FROM DanhMucVatPham");

$imageMap = [];
$imgTableExists = false;
$check = $conn->query("SHOW TABLES LIKE 'HinhAnhTin'");
if ($check && $check->num_rows) {
    $imgTableExists = true;
    $imgRes = $conn->query("SELECT maTin, duongDan FROM HinhAnhTin ORDER BY thuTu, maAnh");
    while ($img = $imgRes->fetch_assoc()) {
        if (!isset($imageMap[$img['maTin']])) $imageMap[$img['maTin']] = $img['duongDan'];
    }
}
?>
<div class="hero mb-4">
  <div class="row align-items-center">
    <div class="col-lg-8">
      <div class="small mb-2 opacity-75">DÀNH CHO SINH VIÊN ĐẠI HỌC SƯ PHẠM ĐÀ NẴNG</div>
      <h1 class="display-6 mb-2">Tìm, trao đổi và chia sẻ đồ dùng học tập</h1>
      <p class="mb-4 opacity-75">Giáo trình, tài liệu, máy tính và nhiều vật dụng học tập từ sinh viên.</p>
      <form method="GET" class="hero-search">
        <input class="form-control" name="q" placeholder="Tìm giáo trình, môn học..." value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
        <button class="btn btn-primary px-4">🔍 Tìm</button>
      </form>
    </div>
    <div class="col-lg-4 d-none d-lg-block text-center fs-1">📚🎓📝</div>
  </div>
</div>

<div class="row g-3 mb-5">
  <?php
  $cats = [
    ['📚','Giáo trình','Tìm sách theo môn học'],
    ['📝','Tài liệu','Tài liệu học tập'],
    ['💻','Thiết bị','Máy tính, máy tính cầm tay'],
    ['🎒','Đồ dùng','Đồ dùng học tập khác']
  ];
  foreach ($cats as $c):
  ?>
  <div class="col-6 col-md-3">
    <div class="category-card">
      <div class="category-icon mb-3"><?= $c[0] ?></div>
      <div class="fw-bold"><?= $c[1] ?></div>
      <div class="small text-muted"><?= $c[2] ?></div>
    </div>
  </div>
  <?php endforeach; ?>
</div>

<div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-3">
  <div>
    <div class="small text-primary fw-bold">MỚI NHẤT</div>
    <h4 class="section-title mb-0">Đồ dùng đang được trao đổi</h4>
  </div>
  <a href="dang-tin.php" class="btn btn-primary">＋ Đăng tin</a>
</div>

<form method="GET" class="card border-0 shadow-sm p-3 mb-4">
  <div class="row g-2">
    <div class="col-md-6">
      <label class="form-label small text-muted">Ngành</label>
      <select name="nganh" class="form-select" onchange="this.form.submit()">
        <option value="">Tất cả ngành</option>
        <?php while ($ng = $nganhList->fetch_assoc()): ?>
          <option value="<?= $ng['maNganh'] ?>" <?= $nganh == $ng['maNganh'] ? 'selected' : '' ?>><?= htmlspecialchars($ng['tenNganh']) ?></option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="col-md-6">
      <label class="form-label small text-muted">Loại vật phẩm</label>
      <select name="loai" class="form-select" onchange="this.form.submit()">
        <option value="">Tất cả loại</option>
        <?php while ($d = $danhMuc->fetch_assoc()): ?>
          <option value="<?= $d['maDanhMuc'] ?>" <?= $loai == $d['maDanhMuc'] ? 'selected' : '' ?>><?= htmlspecialchars($d['tenDanhMuc']) ?></option>
        <?php endwhile; ?>
      </select>
    </div>
  </div>
</form>

<div class="row g-4">
<?php if ($tinDang->num_rows === 0): ?>
  <div class="col-12"><div class="alert alert-light border">Không có tin đăng phù hợp.</div></div>
<?php endif; ?>

<?php while ($tin = $tinDang->fetch_assoc()): ?>
  <div class="col-xl-3 col-lg-4 col-md-6">
    <a href="tin-chi-tiet.php?id=<?= $tin['maTin'] ?>" class="text-decoration-none text-dark">
      <div class="card card-item h-100">
        <?php if ($imgTableExists && !empty($imageMap[$tin['maTin']])): ?>
          <img src="<?= htmlspecialchars($imageMap[$tin['maTin']]) ?>" class="product-img" alt="<?= htmlspecialchars($tin['tieuDe']) ?>">
        <?php else: ?>
          <div class="placeholder-img">📚</div>
        <?php endif; ?>
        <div class="card-body">
          <span class="badge badge-<?= $tin['hinhThuc'] ?> text-white mb-2"><?= hinhThucLabel($tin['hinhThuc']) ?></span>
          <h6 class="card-title fw-bold"><?= htmlspecialchars($tin['tieuDe']) ?></h6>
          <p class="small text-muted mb-1"><?= htmlspecialchars($tin['tinhTrang']) ?> · <?= htmlspecialchars($tin['tenMon']) ?></p>
          <p class="small text-muted mb-2">👤 <?= htmlspecialchars($tin['nguoiBan']) ?></p>
          <?php if ($tin['hinhThuc'] === 'ban'): ?>
            <p class="fw-bold fs-5 mb-0 text-primary"><?= number_format($tin['gia']) ?>đ</p>
          <?php else: ?>
            <p class="fw-bold mb-0 text-success"><?= hinhThucLabel($tin['hinhThuc']) ?></p>
          <?php endif; ?>
        </div>
      </div>
    </a>
  </div>
<?php endwhile; ?>
</div>
<?php include 'includes/footer.php'; ?>
