<?php include 'includes/header.php'; ?>
<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card p-4">
      <h3 class="mb-3">Đăng ký tài khoản</h3>
      <?php if (isset($_GET['loi'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_GET['loi']) ?></div>
      <?php endif; ?>
      <form action="xu-ly-dang-ky.php" method="POST">
        <div class="mb-3">
          <label class="form-label">Họ tên</label>
          <input type="text" name="hoTen" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Số điện thoại</label>
          <input type="text" name="sdt" class="form-control">
        </div>
        <div class="mb-3">
          <label class="form-label">Mật khẩu</label>
          <input type="password" name="matKhau" class="form-control" required minlength="6">
        </div>
        <button type="submit" class="btn btn-primary w-100">Đăng ký</button>
      </form>
      <p class="mt-3 mb-0">Đã có tài khoản? <a href="dang-nhap.php">Đăng nhập</a></p>
    </div>
  </div>
</div>
<?php include 'includes/footer.php'; ?>
