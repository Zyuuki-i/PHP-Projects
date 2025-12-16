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
                            <li class="nav-item mb-2">
                                <a class="nav-link text-white" href="index.php"><i class="bi bi-speedometer2 me-2"></i>Bảng điều khiển</a>
                            </li>
                            <li class="nav-item mb-2">
                                <a class="nav-link text-white" href="#"><i class="bi bi-box-seam me-2"></i>Quản lý sản phẩm</a>
                            </li>
                            <li class="nav-item mb-2">
                                <a class="nav-link text-white" href="#"><i class="bi bi-file-earmark-text me-2"></i>Quản lý loại sản phẩm</a>
                            </li>
                            <li class="nav-item mb-2">
                                <a class="nav-link text-white" href="#"><i class="bi bi-file-earmark-text me-2"></i>Quản lý nhà sản xuất</a>
                            </li>
                            <li class="nav-item mb-2">
                                <a class="nav-link text-white" href="#"><i class="bi bi-file-earmark-text me-2"></i>Quản lý đơn đặt hàng</a>
                            </li>
                            <li class="nav-item mb-2">
                                <a class="nav-link text-white" href="#"><i class="bi bi-people me-2"></i>Quản lý người dùng</a>
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
                <p class="m-auto">Đây là trang quản trị.</p>
            </div>
        </div>
    </div>
</body>
</html>