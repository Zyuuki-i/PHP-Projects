<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['act']) && $_GET['act'] === 'logout') {
    $_SESSION = [];
    unset($admin);
    session_destroy();
    header('Location: login.php');
    exit();
}

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

$admin = $_SESSION['admin'];

if (!defined('IN_ADMIN')) define('IN_ADMIN', true);

$mod = isset($_GET['mod']) ? preg_replace('/[^a-z0-9_\\-]/i', '', $_GET['mod']) : 'dashboard';
$module_index = __DIR__ . '/module/' . $mod . '/index.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./resources/css/style.css">
</head>
<body>
    <div class="container" style="height: 100vh;">
        <div class="row justify-content-center h-100">
            <div class="col-3 bg-admin text-white p-4 my-1 shadow rounded-3">
                <div class="row">
                    <div class="col-12 text-center mb-4">
                        <img src="./resources/images/logo.png" alt="Logo" style="max-width:250px;">
                        <h3 class="mt-4">Chào, <?php echo htmlspecialchars($admin['tennv']); ?></h3>
                    </div>
                    <div class="col-12">
                        <ul class="nav flex-column">
                           <?php 
                            if ($admin['ma_vt'] === 'Admin') {?>
                                <li class="nav-item mb-2">
                                    <a class="nav-link text-white" href="index.php?mod=thongke"><i class="bi bi-speedometer2 me-2"></i>Thống kê doanh thu</a>
                                </li>
                            <?php } ?>
                            <li class="nav-item mb-2">
                                  <a class="nav-link text-white" href="index.php?mod=sanpham"><i class="bi bi-box-seam me-2"></i>Quản lý sản phẩm</a>
                            </li>
                            <li class="nav-item mb-2">
                                  <a class="nav-link text-white" href="index.php?mod=loaisanpham"><i class="bi bi-file-earmark-text me-2"></i>Quản lý loại sản phẩm</a>
                            </li>
                            <li class="nav-item mb-2">
                                  <a class="nav-link text-white" href="index.php?mod=nhasanxuat"><i class="bi bi-file-earmark-text me-2"></i>Quản lý nhà sản xuất</a>
                            </li>
                            <li class="nav-item mb-2">
                                <a class="nav-link nav-top-item text-white" href="index.php?mod=dondathang"><i class="bi bi-file-earmark-text me-2"></i>Quản lý đơn đặt hàng</a>
                                <ul class="ul-items">
                                    <li class="nav-link"><a href="index.php?mod=dondathang&type=dangxuly"><i class="bi bi-arrow-bar-right"></i> Đơn hàng đang xử lý</a></li>
                                    <li class="nav-link"><a href="index.php?mod=dondathang&type=daxuly"><i class="bi bi-arrow-bar-right"></i> Đơn hàng đã xử lý</a></li>
                                    <li class="nav-link"><a href="index.php?mod=dondathang&type=hoanthanh"><i class="bi bi-arrow-bar-right"></i> Đơn hàng hoàn thành</a></li>
                                    <li class="nav-link"><a href="index.php?mod=dondathang&type=huy"><i class="bi bi-arrow-bar-right"></i> Đơn hàng đã hủy</a></li>
                                </ul>
                            </li>
                            <li class="nav-item mb-2">
                                <a class="nav-link nav-top-item text-white" href="#"><i class="bi bi-people me-2"></i>Quản lý người dùng</a>
                                <ul class="ul-items">
                                    <?php  if ($admin['ma_vt'] === 'Admin') {?>
                                        <li class="nav-link"><a href="index.php?mod=nhanvien"><i class="bi bi-arrow-bar-right"></i> Nhân viên</a></li>
                                    <?php } ?>
                                    <li class="nav-link"><a href="index.php?mod=khachhang"><i class="bi bi-arrow-bar-right"></i> Khách hàng</a></li>
                                </ul>
                            </li>
                            <li class="nav-item mt-4">
                                <a class="nav-link text-white" href="index.php?act=logout"><i class="bi bi-box-arrow-right me-2"></i>Đăng xuất</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div style="width: 10px;"></div>
            <div class="col-8 bg-admin text-white p-4 my-1 shadow rounded-3">
                <div class="admin-content text-white">
                    <?php
                    if (file_exists($module_index) && is_file($module_index)) {
                        include $module_index;
                    } else { ?>
                        <div class="row align-content-center justify-content-center text-center" style="height:100vh;">
                            <h2 class="fw-bold">Admin Dashboard</h2>
                            <p>Quản lý hệ thống website bán nhạc cụ.</p>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="./resources/scripts/script.js"></script>
</html>