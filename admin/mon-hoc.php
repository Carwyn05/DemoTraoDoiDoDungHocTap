<?php
require '../includes/functions.php';
if (session_status() === PHP_SESSION_NONE) session_start();
yeuCauAdmin();
require '../config/database.php';
include '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten = trim($_POST['tenMon']);
    $maNganh = $_POST['maNganh'];
    if ($ten && $maNganh) {
        $stmt = $conn->prepare("INSERT INTO MonHoc (tenMon, maNganh) VALUES (?, ?)");
        $stmt->bind_param("si", $ten, $maNganh);
        $stmt->execute();
    }
    header("Location: mon-hoc.php");
    exit();
}
if (isset($_GET['xoa'])) {
    $stmt = $conn->prepare("DELETE FROM MonHoc WHERE maMon = ?");
    $stmt->bind_param("i", $_GET['xoa']);
    $stmt->execute();
    header("Location: mon-hoc.php");
    exit();
}

$nganhList = $conn->query("SELECT * FROM Nganh ORDER BY tenNganh");
$monHoc = $conn->query("SELECT m.*, n.tenNganh FROM MonHoc m JOIN Nganh n ON m.maNganh = n.maNganh ORDER BY n.tenNganh, m.tenMon");
?>
<h4 class="mb-3">Quản lý môn học</h4>
<form method="POST" class="row g-2 mb-4">
  <div class="col-md-5"><input name="tenMon" class="form-control" placeholder="Tên môn học" required></div>
  <div class="col-md-4">
    <select name="maNganh" class="form-select" required>
      <option value="">-- Chọn ngành --</option>
      <?php while ($ng = $nganhList->fetch_assoc()): ?>
        <option value="<?= $ng['maNganh'] ?>"><?= htmlspecialchars($ng['tenNganh']) ?></option>
      <?php endwhile; ?>
    </select>
  </div>
  <div class="col-md-3"><button class="btn btn-primary w-100">Thêm môn học</button></div>
</form>
<table class="table bg-white">
  <thead><tr><th>Tên môn</th><th>Ngành</th><th></th></tr></thead>
  <tbody>
  <?php while ($m = $monHoc->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($m['tenMon']) ?></td>
      <td><?= htmlspecialchars($m['tenNganh']) ?></td>
      <td><a href="mon-hoc.php?xoa=<?= $m['maMon'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa môn học này?')">Xóa</a></td>
    </tr>
  <?php endwhile; ?>
  </tbody>
</table>
<p class="mt-2"><a href="nganh.php" class="btn btn-outline-secondary btn-sm">Quản lý ngành</a></p>
<?php include '../includes/footer.php'; ?>
