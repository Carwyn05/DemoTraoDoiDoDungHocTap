<?php
require '../includes/functions.php';
if (session_status() === PHP_SESSION_NONE) session_start();
yeuCauAdmin();
require '../config/database.php';
include '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten = trim($_POST['tenNganh']);
    if ($ten) {
        $stmt = $conn->prepare("INSERT INTO Nganh (tenNganh) VALUES (?)");
        $stmt->bind_param("s", $ten);
        $stmt->execute();
    }
    header("Location: nganh.php");
    exit();
}
if (isset($_GET['xoa'])) {
    $stmt = $conn->prepare("DELETE FROM Nganh WHERE maNganh = ?");
    $stmt->bind_param("i", $_GET['xoa']);
    $stmt->execute();
    header("Location: nganh.php");
    exit();
}

$nganhList = $conn->query("SELECT * FROM Nganh ORDER BY tenNganh");
?>
<h4 class="mb-3">Quản lý ngành</h4>
<form method="POST" class="row g-2 mb-4">
  <div class="col-md-9"><input name="tenNganh" class="form-control" placeholder="VD: Sư phạm Địa lý" required></div>
  <div class="col-md-3"><button class="btn btn-primary w-100">Thêm ngành</button></div>
</form>
<table class="table bg-white">
  <thead><tr><th>Tên ngành</th><th></th></tr></thead>
  <tbody>
  <?php while ($ng = $nganhList->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($ng['tenNganh']) ?></td>
      <td><a href="nganh.php?xoa=<?= $ng['maNganh'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa ngành này? (chỉ xóa được nếu không còn môn học nào thuộc ngành)')">Xóa</a></td>
    </tr>
  <?php endwhile; ?>
  </tbody>
</table>
<p class="mt-2"><a href="mon-hoc.php" class="btn btn-outline-secondary btn-sm">Quản lý môn học</a></p>
<?php include '../includes/footer.php'; ?>
