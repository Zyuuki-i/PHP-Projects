<?php
if (!defined('APP_RUNNING')) {
    header('Location: /home');
    exit;
}
$baseUrl = $GLOBALS['baseUrl'] ?? '';
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zyuuki Music - Nhạc Cụ Chính Hãng</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <?php $cssPath = __DIR__ . '/../assets/css/style.css';
        $cssVersion = file_exists($cssPath) ? filemtime($cssPath) : time(); ?>
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/css/style.css?v=<?= $cssVersion ?>">
    <style>

    </style>
</head>

<body class="d-flex flex-column" style="min-height: 100vh;">

<header>
    <nav class="navbar navbar-expand-lg sticky-top py-3">
        <div class="container">
            <a class="navbar-brand me-2" href="<?=$baseUrl?>/">
                <img src="<?=$baseUrl?>/assets/images/logo.png" alt="Zyuuki Music" style="height: 50px; object-fit: contain;">
                </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item mx-2"><a href="<?=$baseUrl?>/" class="nav-link">Trang chủ</a></li>
                    <li class="nav-item mx-2"><a href="<?=$baseUrl?>/GioiThieu" class="nav-link">Giới thiệu</a></li>
                    <li class="nav-item mx-2"><a href="<?=$baseUrl?>/SanPham" class="nav-link">Sản phẩm</a></li>
                    <li class="nav-item mx-2"><a href="<?=$baseUrl?>/DanhGia" class="nav-link">Đánh giá</a></li>
                </ul>

                <div class="d-flex align-items-center gap-3 flex-column flex-lg-row">
                    <form action="<?=$baseUrl?>/SanPham/TimKiem" method="get" class="d-flex input-group" style="width: 250px;">
                        <input class="form-control border-end-0" type="search" name="keyword" placeholder="Tìm nhạc cụ..." aria-label="Search">
                        <button class="btn btn-outline-secondary border-start-0 btn-search" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>

                    <div class="d-none d-xl-block text-end lh-1">
                        <small class="text-muted" style="font-size: 0.75rem;">Hotline hỗ trợ</small><br>
                        <span class="fw-bold text-dark">0869 347 040</span>
                    </div>

                    <form action="<?=$baseUrl?>/DonDatHang/GioHang" method="get" class="d-inline">
                        <button class="cart-btn text-dark p-2" type="submit">
                            <i class="bi bi-cart3 fs-4"></i>
                            <span class="badge rounded-pill bg-danger cart-badge"><?php echo $_SESSION['SoLuongGioHang'] ?? 0; ?></span>
                        </button>
                    </form>

                    <?php if (!isset($_SESSION['user'])): ?>
                        <button class="btn btn-outline-dark rounded-pill px-4" type="button" data-bs-toggle="modal" data-bs-target="#authModal">
                            <i class="bi bi-person-fill me-1"></i> Đăng nhập
                        </button>
                    <?php else: ?>
                        <div class="dropdown">
                            <button class="btn btn-outline-dark dropdown-toggle rounded-pill px-3" type="button" id="userMenuBtn" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-1"></i> <?= htmlspecialchars($_SESSION['user']['tennd'] ?? $_SESSION['user']['email']) ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenuBtn">
                                <li><a class="dropdown-item" href="<?= $baseUrl ?>/User/ThongTin?id=<?= $_SESSION['user']['ma_nd'] ?>">Hồ sơ</a></li>
                                <li><a class="dropdown-item" href="<?= $baseUrl ?>/User/Edit?id=<?= $_SESSION['user']['ma_nd'] ?>">Chỉnh sửa</a></li>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Đổi mật khẩu</a></li>
                                    <li><a class="dropdown-item" href="<?= $baseUrl ?>/User/LichSuDatHang?id=<?= $_SESSION['user']['ma_nd'] ?>">Lịch sử đặt hàng</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="<?= $baseUrl ?>/User/Logout">Đăng xuất</a></li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
</header>

<div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="authModalLabel">Tài khoản</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="authTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab">Đăng nhập</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab">Đăng ký</button>
                    </li>
                </ul>
                <div class="tab-content pt-3">
                    <div class="tab-pane fade show active" id="login" role="tabpanel">
                        <?php if (isset($_SESSION['login_error'])): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['login_error']) ?></div>
                        <?php endif; ?>
                        <form action="<?= $baseUrl ?>/User/Login" method="post">
                            <div class="mb-3">
                                <label for="loginEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="loginEmail" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="loginPassword" class="form-label">Mật khẩu</label>
                                <input type="password" class="form-control" id="loginPassword" name="password" required>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Đăng nhập</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="register" role="tabpanel">
                        <?php if (isset($_SESSION['register_error'])): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['register_error']) ?></div>
                        <?php endif; ?>
                        <form action="<?= $baseUrl ?>/User/Register" method="post">
                            <div class="mb-3">
                                <label for="regName" class="form-label">Họ tên</label>
                                <input type="text" class="form-control" id="regName" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="regEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="regEmail" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="regPassword" class="form-label">Mật khẩu</label>
                                <input type="password" class="form-control" id="regPassword" name="password" required>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-success">Đăng ký</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordLabel">Đổi mật khẩu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= $baseUrl ?>/User/ChangePassword" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Mật khẩu cũ</label>
                        <input type="password" name="old_password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mật khẩu mới</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Xác nhận mật khẩu</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="flex-grow-1 bg-light">
    <main role="main" class="container py-4">
        <?php if (isset($_SESSION['MessageSuccess_GioHang'])): ?>
            <div class="alert alert-success text-center fw-bold shadow-sm fade show mb-4">
                <i class="bi bi-check-circle-fill me-2"></i> <?= htmlspecialchars($_SESSION['MessageSuccess_GioHang']) ?>
            </div>
            <?php unset($_SESSION['MessageSuccess_GioHang']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['MessageError_GioHang'])): ?>
            <div class="alert alert-danger text-center fw-bold shadow-sm fade show mb-4">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= htmlspecialchars($_SESSION['MessageError_GioHang']) ?>
            </div>
            <?php unset($_SESSION['MessageError_GioHang']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['MessageSuccess_User'])): ?>
            <div class="alert alert-success text-center fw-bold shadow-sm fade show mb-4">
                <i class="bi bi-check-circle-fill me-2"></i> <?= htmlspecialchars($_SESSION['MessageSuccess_User']) ?>
            </div>
            <?php unset($_SESSION['MessageSuccess_User']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['MessageError_User'])): ?>
            <div class="alert alert-danger text-center fw-bold shadow-sm fade show mb-4">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= htmlspecialchars($_SESSION['MessageError_User']) ?>
            </div>
            <?php unset($_SESSION['MessageError_User']); ?>
        <?php endif; ?>

        <?php if (isset($content)) echo $content; ?>

        <?php if (!isset($content)): ?>
            <div class="alert alert-info text-center">
                <h3>KHÔNG TÌM THẤY NỘI DUNG PHÙ HỢP!</h3>
            </div>
        <?php endif; ?>
    </main>
</div>

<footer class="pt-5 pb-3">
    <div class="container">    
        <div class="row gy-4">
            <div class="col-md-4">
                <h5>Về Chúng Tôi</h5>
                <p class="small">Chúng tôi chuyên cung cấp các loại nhạc cụ Piano, Guitar, Violin chính hãng với giá tốt nhất thị trường cùng chế độ bảo hành uy tín.</p>
                <div class="mt-3">
                    <a href="#" class="me-3 fs-5"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="me-3 fs-5"><i class="bi bi-youtube"></i></a>
                    <a href="#" class="me-3 fs-5"><i class="bi bi-tiktok"></i></a>
                </div>
            </div>

            <div class="col-md-4">
                <h5>Thông Tin Liên Hệ</h5>
                <ul class="list-unstyled small">
                    <li class="mb-2"><i class="bi bi-geo-alt-fill me-2 text-warning"></i> 180 Cao Lỗ, Phường 4, Quận 8, TP.HCM</li>
                    <li class="mb-2"><i class="bi bi-telephone-fill me-2 text-warning"></i> 0869 347 040</li>
                    <li class="mb-2"><i class="bi bi-envelope-fill me-2 text-warning"></i> dh52200473@student.stu.edu.vn</li>
                </ul>
            </div>

            <div class="col-md-4">
                <h5>Đội Ngũ Thực Hiện</h5>
                <ul class="list-unstyled student-info ps-2 border-start border-secondary">
                    <li>
                        <strong>Lê Văn Đạt</strong><br>
                        <span class="text-secondary">MSSV: DH52200473 - Lớp: D22_TH06</span>
                    </li>
                    <li class="mt-3">
                        <strong>Lê Công Toại</strong><br>
                        <span class="text-secondary">MSSV: DH52201583 - Lớp: D22_TH06</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <hr class="border-secondary mt-5 mb-3"/>
        <div class="text-center small text-secondary">
            &copy; 2025 - <strong>Zyuuki Music Store</strong>. All rights reserved.
        </div>
    </div>
</footer>

<?php $jsPath = __DIR__ . '/../assets/js/script.js';
    $jsVersion = file_exists($jsPath) ? filemtime($jsPath) : time(); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php
    // If there were auth errors, trigger modal and select proper tab
    $openAuthModal = false;
    $authTab = 'login';
    if (isset($_SESSION['login_error'])) { $openAuthModal = true; $authTab = 'login'; }
    if (isset($_SESSION['register_error'])) { $openAuthModal = true; $authTab = 'register'; }
?>
<?php if ($openAuthModal): ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var myModal = new bootstrap.Modal(document.getElementById('authModal'));
        var tabEl = document.querySelector('#authTab button#<?= $authTab ?>-tab');
        if (tabEl) new bootstrap.Tab(tabEl).show();
        myModal.show();
    });
</script>
<?php endif; ?>
<script src="<?= $baseUrl ?>/assets/js/script.js?v=<?= $jsVersion ?>"></script>
<?php
    // Clear flash messages so modal won't reopen repeatedly
    unset($_SESSION['login_error']);
    unset($_SESSION['register_error']);
?>
</body>
</html>