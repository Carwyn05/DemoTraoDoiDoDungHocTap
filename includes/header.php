<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trao đổi đồ dùng học tập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root{
            --primary:#25316D;
            --primary2:#4F63C7;
            --soft:#F5F7FF;
            --text:#172033;
        }
        body{background:#f6f8fc;color:var(--text);}
        .navbar{background:linear-gradient(90deg,#202a66,#3347a1)!important;box-shadow:0 2px 14px rgba(0,0,0,.08);}
        .navbar-brand,.nav-link{color:#fff!important}
        .hero{
            border-radius:24px;
            padding:42px 32px;
            color:#fff;
            background:
                linear-gradient(100deg,rgba(25,37,99,.96),rgba(63,91,190,.82)),
                url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1600&q=80') center/cover;
            box-shadow:0 14px 35px rgba(37,49,109,.18);
        }
        .hero h1{font-weight:800;letter-spacing:-.5px}
        .hero-search{background:#fff;border-radius:16px;padding:7px;display:flex;max-width:720px}
        .hero-search input{border:0;box-shadow:none!important}
        .category-card{
            border:0;border-radius:18px;background:#fff;padding:18px;
            box-shadow:0 5px 20px rgba(24,35,72,.06);height:100%;
            transition:.2s;
        }
        .category-card:hover{transform:translateY(-3px);box-shadow:0 10px 28px rgba(24,35,72,.11)}
        .category-icon{width:48px;height:48px;border-radius:14px;display:grid;place-items:center;font-size:23px;background:#eef1ff}
        .card-item{border:0;border-radius:18px;overflow:hidden;transition:.2s;box-shadow:0 5px 18px rgba(24,35,72,.06)}
        .card-item:hover{transform:translateY(-4px);box-shadow:0 12px 30px rgba(24,35,72,.12)}
        .product-img{width:100%;height:210px;object-fit:cover;background:#eef1f7}
        .placeholder-img{height:210px;background:linear-gradient(135deg,#eef1ff,#e6f6ef);display:grid;place-items:center;font-size:58px}
        .badge-trao_doi{background:#1B7A43}.badge-ban{background:#A15A00}.badge-tang{background:#1E2761}.badge-cho_duyet{background:#A15A00}
        .section-title{font-weight:800}
        .upload-zone{border:2px dashed #c8d0ea;border-radius:18px;padding:22px;text-align:center;background:#fafbff;cursor:pointer}
        .upload-zone:hover{background:#f2f5ff;border-color:#6578d6}
        .preview-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(110px,1fr));gap:10px;margin-top:14px}
        .preview-item{position:relative}
        .preview-item img{width:100%;height:110px;object-fit:cover;border-radius:12px}
        .preview-item span{position:absolute;left:6px;bottom:6px;background:rgba(0,0,0,.65);color:#fff;border-radius:8px;padding:2px 6px;font-size:11px}
        .detail-main-img{width:100%;height:420px;object-fit:cover;border-radius:20px;background:#eef1f7}
        .small-thumb{width:82px;height:70px;object-fit:cover;border-radius:10px;cursor:pointer;border:2px solid transparent}
        .small-thumb:hover{border-color:#4f63c7}
        footer{color:#68708a}
        @media(max-width:768px){.hero{padding:30px 20px}.product-img,.placeholder-img{height:180px}.detail-main-img{height:300px}}
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg mb-4">
  <div class="container py-1">
    <?php
    $isAdminPage = basename(dirname($_SERVER['SCRIPT_NAME'])) === 'admin';
    $prefix = $isAdminPage ? '../' : '';
    ?>
    <a class="navbar-brand fw-bold" href="<?= $prefix ?>index.php"> Trao đổi đồ dùng học tập</a>
    <div class="d-flex flex-wrap gap-2">
      <?php if (isset($_SESSION['maND'])): ?>
        <a href="<?= $prefix ?>dang-tin.php" class="btn btn-sm btn-outline-light">＋ Đăng tin</a>
        <a href="<?= $prefix ?>tin-cua-toi.php" class="btn btn-sm btn-outline-light">Tin của tôi</a>
        <?php if (($_SESSION['vaiTro'] ?? '') === 'admin'): ?>
          <a href="<?= $isAdminPage ? 'index.php' : 'admin/index.php' ?>" class="btn btn-sm btn-warning">Quản trị</a>
        <?php endif; ?>
        <a href="<?= $prefix ?>dang-xuat.php" class="btn btn-sm btn-light">Đăng xuất</a>
      <?php else: ?>
        <a href="<?= $prefix ?>dang-nhap.php" class="btn btn-sm btn-outline-light">Đăng nhập</a>
        <a href="<?= $prefix ?>dang-ky.php" class="btn btn-sm btn-light">Đăng ký</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
<div class="container pb-5">
