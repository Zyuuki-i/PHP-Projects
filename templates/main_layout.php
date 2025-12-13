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
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Shop Nhạc Cụ - Mua Bán Nhạc Cụ Chính Hãng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body class="d-flex flex-column" style="min-height: 100vh;">
<header>
    <nav class="navbar navbar-expand-sm navbar-toggleable-sm navbar-light bg-white border-bottom box-shadow mb-3">
            <div class="container-fluid">
               <a class="navbar-brand me-0" href="<?=$baseUrl?>/">
                    <img src="./assets/images/logo.png" alt="Logo" style="height:50px;" class="ms-5 me-5" />
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse collapse d-sm-inline-flex justify-content-between" id="navbarSupportedContent">
                    <ul class="navbar-nav flex-grow-1 d-flex justify-content-evenly me-5">
                        <li class="nav-item">
                            <a href="<?=$baseUrl?>/" class="nav-link text-dark fs-5" >Trang chủ</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=$baseUrl?>/GioiThieu" class="nav-link text-dark fs-5" >Giới thiệu</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=$baseUrl?>/SanPham" class="nav-link text-dark fs-5">Sản phẩm</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=$baseUrl?>/DanhGia" class="nav-link text-dark fs-5">Đánh giá</a>
                        </li>
                    </ul>
                </div>
                <div class="d-flex align-content-center me-5">
                    <div class="me-1">
                        <i class="bi bi-telephone fs-3 me-1"></i>
                    </div>
                    <div>
                        Hotline<br /><b>0869 347 040</b>
                    </div>
                </div>
                <div class="border border-secondary rounded-2">
                    <form action="<?=$baseUrl?>/SanPham/TimKiem" class="d-flex" method="get">
                        <input class="form-control border-0 " type="search" name="keyword" placeholder="Tìm kiếm sản phẩm..">
                        <button type="submit" class="btn rounded-2"><i class="bi bi-search"></i></button>
                    </form>
                </div>
                <div class="position-relative">
                    <form action="<?=$baseUrl?>/DonDatHang/GioHang" method="post">
                        <button class="btn ms-3 me-3" type="submit">
                            <i class="bi bi-cart fs-4"></i>
                            <i class="bi bi-circle-fill text-danger position-absolute start-50"></i>
                            <span class="position-absolute start-50 ms-1">
                                0
                            </span>
                        </button>
                    </form>
                </div>
                <form action="<?=$baseUrl?>/User/DangNhap" method="post">
                    <button class="btn btn-outline-info d-flex align-items-center" type="submit">
                        <i class="bi bi-person fs-4"></i><span class="ms-2">Đăng Nhập</span>
                    </button>
                </form>
            </div>
        </nav>
</header>

<div class="container flex-grow-1">
    <main role="main" class="pb-3">
        <?php if (isset($content)) echo $content; ?>
    </main>
</div>
<footer class="border-top bg-dark footer text-muted">
    <div class="container text-center text-light py-3">    
        <div class="row mt-2">
            <div class="col-md-4">
                <h5>Về Chúng Tôi</h5>
                <p>Chúng tôi cam kết mang đến những sản phẩm nhạc cụ chất lượng cao với dịch vụ khách hàng tận tâm.</p>
            </div>
            <div class="col-md-4">
                <h5>Liên Hệ</h5>
                <p>Địa chỉ: 180 Cao lỗ, Phường 4, Quận 8, TP.HCM<br/>
                   Điện thoại: 0869 347 040<br/>
                   Email: dh52200473@student.stu.edu.vn
                </p>
            </div>
            <div class="col-md-4">
                <style>
                    table, th, td {
                        border: 0;
                        border-collapse: collapse;
                        padding: 5px;
                        background-color: rgb(33 37 41) !important;
                        color: white !important;
                    }
                </style>
                <h5>Thực Hiện</h5>
                <table class="table">
                    <tr>
                        <td>Lê Văn Đạt/DH52200473/D22_TH06</td>
                    </tr>
                    <tr>
                        <td>Lê Công Toại/DH52201583/D22_TH06</td>
                    </tr>
                </table>
            </div>
        </div>
        <hr/>
        &copy; 2025 - Zyuuki Music Store
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
