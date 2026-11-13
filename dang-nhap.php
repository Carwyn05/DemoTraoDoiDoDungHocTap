<?php include 'includes/header.php'; ?>
<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card p-4">
      <h3 class="mb-3">Đăng nhập</h3>
      <?php if (isset($_GET['dangky'])): ?>
        <div class="alert alert-success">Đăng ký thành công! Hãy đăng nhập.</div>
      <?php endif; ?>
      <?php if (isset($_GET['loi'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_GET['loi']) ?></div>
      <?php endif; ?>
      <form action="xu-ly-dang-nhap.php" method="POST">
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Mật khẩu</label>
          <input type="password" name="matKhau" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
      </form>
      <p class="mt-3 mb-0">Chưa có tài khoản? <a href="dang-ky.php">Đăng ký</a></p>
      <hr>
      <p class="text-muted small mb-0">Tài khoản demo — Admin: admin@example.com / admin123<br>Sinh viên: sinhvien@example.com / sv123456</p>
    </div>
  </div>
</div>
<?php include 'includes/footer.php'; ?>
