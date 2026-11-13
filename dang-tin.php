<?php
require 'includes/functions.php';
if (session_status() === PHP_SESSION_NONE) session_start();
yeuCauDangNhap();
require 'config/database.php';
include 'includes/header.php';

$nganhList = $conn->query("SELECT * FROM Nganh ORDER BY tenNganh");
$monHocAll = $conn->query("SELECT * FROM MonHoc ORDER BY tenMon");
$danhMuc = $conn->query("SELECT * FROM DanhMucVatPham");

$monHocJson = [];
while ($m = $monHocAll->fetch_assoc()) {
    $monHocJson[] = ['maMon' => $m['maMon'], 'tenMon' => $m['tenMon'], 'maNganh' => $m['maNganh']];
}
?>
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="mb-4">
      <div class="small text-primary fw-bold">ĐĂNG TIN</div>
      <h2 class="fw-bold">Chia sẻ đồ dùng học tập của bạn</h2>
      <p class="text-muted">Hãy thêm ảnh thật để người xem biết chính xác tình trạng sản phẩm.</p>
    </div>

    <div class="card border-0 shadow-sm rounded-4 p-4">
      <?php if (isset($_GET['loi'])): ?>
        <div class="alert alert-danger">Vui lòng điền đầy đủ thông tin bắt buộc.</div>
      <?php endif; ?>
      <?php if (isset($_GET['anhloi'])): ?>
        <div class="alert alert-warning"><?= htmlspecialchars($_GET['anhloi']) ?></div>
      <?php endif; ?>

      <form action="xu-ly-dang-tin.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label class="form-label fw-semibold">Tiêu đề <span class="text-danger">*</span></label>
          <input type="text" name="tieuDe" class="form-control form-control-lg" required placeholder="VD: Giáo trình Cơ sở dữ liệu">
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">Loại vật phẩm <span class="text-danger">*</span></label>
            <select name="maDanhMuc" class="form-select" required>
              <?php while ($d = $danhMuc->fetch_assoc()): ?>
                <option value="<?= $d['maDanhMuc'] ?>"><?= htmlspecialchars($d['tenDanhMuc']) ?></option>
              <?php endwhile; ?>
            </select>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">Hình thức</label>
            <select name="hinhThuc" id="hinhThuc" class="form-select" onchange="document.getElementById('giaBox').style.display = this.value==='ban' ? 'block' : 'none';">
              <option value="trao_doi">Trao đổi</option>
              <option value="tang">Tặng</option>
              <option value="ban">Bán</option>
            </select>
          </div>
        </div>

        <div class="mb-3" id="giaBox" style="display:none;">
          <label class="form-label fw-semibold">Giá (đ)</label>
          <input type="number" name="gia" class="form-control" value="0" min="0">
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">Ngành <span class="text-danger">*</span></label>
            <select id="nganhSelect" class="form-select" required>
              <option value="">-- Chọn ngành --</option>
              <?php while ($ng = $nganhList->fetch_assoc()): ?>
                <option value="<?= $ng['maNganh'] ?>"><?= htmlspecialchars($ng['tenNganh']) ?></option>
              <?php endwhile; ?>
            </select>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">Môn học <span class="text-danger">*</span></label>
            <select name="maMon" id="monHocSelect" class="form-select" required>
              <option value="">-- Chọn ngành trước --</option>
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">Tình trạng</label>
            <input type="text" name="tinhTrang" class="form-control" placeholder="VD: còn 80%, không rách">
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">Năm / phiên bản</label>
            <input type="text" name="namPhienBan" class="form-control" placeholder="VD: 2024">
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Địa điểm giao dịch</label>
          <input type="text" name="diaDiemGiaoDich" class="form-control" placeholder="VD: Thư viện trường, cổng KTX B...">
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold">Mô tả</label>
          <textarea name="moTa" class="form-control" rows="4" placeholder="Mô tả chi tiết tình trạng, lý do trao đổi..."></textarea>
        </div>

       <div class="mb-4">
  <label class="form-label fw-semibold">
    Ảnh giáo trình / đồ dùng
  </label>

  <div class="small text-muted mb-2">
    Có thể thêm tối đa 5 ảnh · mỗi ảnh tối đa 5MB
  </div>

  <div id="imageContainer" class="image-upload-container">

    <!-- Nút thêm ảnh đầu tiên -->
    <div class="add-image-box" id="addImageBox" onclick="chooseImage()">
      <div class="fs-1">📷</div>
      <div class="fw-semibold">Thêm ảnh</div>
      <div class="small text-muted">
        Chụp hoặc chọn ảnh
      </div>
    </div>

  </div>

  <!-- Input file sẽ được tạo bằng JavaScript -->
  <div id="fileInputs"></div>

  <div class="small text-muted mt-2">
    💡 Bạn có thể thêm ảnh lần lượt, tối đa 5 ảnh.
  </div>
</div>

        <button type="submit" class="btn btn-primary btn-lg w-100">🚀 Đăng tin</button>
      </form>
    </div>
  </div>
</div>

<style>

.image-upload-container {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-top: 10px;
}


/* Ô + Thêm ảnh */
.add-image-box {
    width: 150px;
    height: 150px;

    border: 2px dashed #cfd4da;
    border-radius: 15px;

    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;

    cursor: pointer;

    background: #fafafa;

    transition: all 0.2s ease;
}

.add-image-box:hover {
    border-color: #0d6efd;
    background: #f0f6ff;
}


/* Khung ảnh preview */
.image-preview-item {
    width: 150px;
    height: 150px;

    position: relative;

    border-radius: 15px;

    overflow: hidden;

    background: #f5f5f5;

    border: 1px solid #ddd;
}


/* Ảnh */
.image-preview-item img {
    width: 100%;
    height: 100%;

    object-fit: cover;
}


/* Số thứ tự ảnh */
.image-number {
    position: absolute;

    left: 7px;
    bottom: 7px;

    background: rgba(0,0,0,0.65);

    color: white;

    padding: 3px 8px;

    border-radius: 20px;

    font-size: 12px;
}


/* Nút Xóa */
.remove-image {
    position: absolute;

    top: 6px;
    right: 6px;

    width: 30px;
    height: 30px;

    border: none;

    border-radius: 50%;

    background: rgba(220,53,69,0.9);

    color: white;

    font-size: 20px;

    line-height: 25px;

    cursor: pointer;

    display: flex;
    justify-content: center;
    align-items: center;
}


.remove-image:hover {
    background: #dc3545;
}


/* Mobile */
@media (max-width: 576px) {

    .image-preview-item,
    .add-image-box {
        width: calc(50% - 8px);
        height: 150px;
    }

}

</style>

<script>
const monHocData = <?= json_encode($monHocJson, JSON_UNESCAPED_UNICODE) ?>;
const nganhSelect = document.getElementById('nganhSelect');
const monHocSelect = document.getElementById('monHocSelect');
nganhSelect.addEventListener('change', function() {
  const maNganh = this.value;
  monHocSelect.innerHTML = '';
  if (!maNganh) {
    monHocSelect.innerHTML = '<option value="">-- Chọn ngành trước --</option>';
    return;
  }
  const filtered = monHocData.filter(m => String(m.maNganh) === maNganh);
  if (!filtered.length) {
    monHocSelect.innerHTML = '<option value="">Chưa có môn học trong ngành này</option>';
    return;
  }
  filtered.forEach(m => {
    const opt = document.createElement('option');
    opt.value = m.maMon;
    opt.textContent = m.tenMon;
    monHocSelect.appendChild(opt);
  });
});

/* =========================
   XỬ LÝ THÊM ẢNH
========================= */

const imageContainer = document.getElementById('imageContainer');
const fileInputs = document.getElementById('fileInputs');

let imageCount = 0;
const MAX_IMAGES = 5;
const MAX_SIZE = 5 * 1024 * 1024;


/* Mở cửa sổ chọn ảnh */
function chooseImage() {

  if (imageCount >= MAX_IMAGES) {
    alert('Bạn chỉ có thể thêm tối đa 5 ảnh.');
    return;
  }

  const input = document.createElement('input');

  input.type = 'file';
  input.name = 'images[]';
  input.accept = 'image/*';
  input.className = 'd-none';

  /*
     Không dùng multiple.
     Mỗi lần chỉ chọn 1 ảnh.
  */

  input.addEventListener('change', function () {

    if (!this.files || !this.files.length) {
      return;
    }

    const file = this.files[0];

    /* Kiểm tra loại file */
    if (!file.type.startsWith('image/')) {
      alert('Vui lòng chọn file hình ảnh.');
      this.remove();
      return;
    }

    /* Kiểm tra dung lượng */
    if (file.size > MAX_SIZE) {
      alert('Ảnh không được vượt quá 5MB.');
      this.remove();
      return;
    }

    imageCount++;

    /*
       Lưu input vào form.
       Khi submit PHP sẽ nhận được:
       images[]
       images[]
       images[]
       ...
    */
    fileInputs.appendChild(this);

    showImagePreview(file, this, imageCount);

    updateAddButton();
  });

  fileInputs.appendChild(input);

  input.click();
}


/* Hiển thị ảnh xem trước */
function showImagePreview(file, input, number) {

  const reader = new FileReader();

  reader.onload = function (e) {

    const box = document.createElement('div');

    box.className = 'image-preview-item';

    box.dataset.input = number;

    box.innerHTML = `
      <img src="${e.target.result}" alt="Ảnh ${number}">

      <div class="image-number">
        Ảnh ${number}
      </div>

      <button
        type="button"
        class="remove-image"
        onclick="removeImage(this, ${number})">
        ×
      </button>
    `;

    /*
       Thêm ảnh trước nút + Thêm ảnh
    */
    imageContainer.insertBefore(box, document.getElementById('addImageBox'));
  };

  reader.readAsDataURL(file);
}


/* Xóa ảnh */
function removeImage(button, number) {

  const box = button.closest('.image-preview-item');

  if (box) {
    box.remove();
  }

  /*
     Tìm input tương ứng
     và xóa khỏi form
  */
  const inputs = fileInputs.querySelectorAll('input[type="file"]');

  if (inputs[number - 1]) {
    inputs[number - 1].remove();
  }

  imageCount--;

  updateAddButton();
}


/* Cập nhật nút thêm ảnh */
function updateAddButton() {

  const addBox = document.getElementById('addImageBox');

  if (imageCount >= MAX_IMAGES) {

    addBox.style.display = 'none';

  } else {

    addBox.style.display = 'flex';

  }
}
</script>
<?php include 'includes/footer.php'; ?>
