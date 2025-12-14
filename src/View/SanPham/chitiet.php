<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$baseUrl = $GLOBALS['baseUrl'] ?? '';
$pageTitle = "Chi tiết sản phẩm";
?>

<div class="container mt-4">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb breadcrumb-custom">
            <li class="breadcrumb-item">
                <a href="<?=$baseUrl?>/SanPham" class="text-secondary"><i class="bi bi-house"></i></a>
            </li>
            <?php if ($sp): ?>
                <li class="breadcrumb-item active" aria-current="page">
                    <a class="text-decoration-none text-secondary" href="<?=$baseUrl?>/SanPham/LocNSX?mansx=<?= $sp->ma_nsx ?>">
                        <span class="text-uppercase"><?= $sp->ma_nsx ?></span>
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a class="text-decoration-none text-secondary" href="<?=$baseUrl?>/SanPham/LocLoai?maloai=<?= $sp->ma_loai ?>">
                        <span class="text-uppercase"><?= $sp->ma_loai ?></span>
                    </a>
                </li>
            <?php endif; ?>
        </ol>
    </nav>

    <?php if (isset($_SESSION['MessageSuccess_GioHang'])): ?>
        <div class="alert alert-success text-center fw-bold shadow-sm fade show mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> <?= $_SESSION['MessageSuccess_GioHang'] ?>
        </div>
        <?php unset($_SESSION['MessageSuccess_GioHang']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['MessageError_GioHang'])): ?>
        <div class="alert alert-danger text-center fw-bold shadow-sm fade show mb-4">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= $_SESSION['MessageError_GioHang'] ?>
        </div>
        <?php unset($_SESSION['MessageError_GioHang']); ?>
    <?php endif; ?>

    <?php if (!$sp): ?>
        <div class="text-center py-5">
            <h3 class="text-danger fw-bold">Sản phẩm không tồn tại!</h3>
            <a href="<?= $baseUrl ?>/" class="btn btn-outline-dark mt-3">Quay lại trang chủ</a>
        </div>
    <?php else: ?>
        <div class="row g-5 align-items-start">
            
            <div class="col-lg-6">
                <?php
                    $firstImgName = 'default.png';
                    if (!empty($dsHinh) && is_array($dsHinh)) {
                        $firstItem = reset($dsHinh); 
                        $firstImgName = $firstItem->tenhinh ?? $firstItem->Tenhinh ?? 'default.png';
                    }

                    if ($firstImgName === 'default.png') {
                        $mainImgUrl = ($baseUrl !== '' ? $baseUrl : '') . '/assets/images/anhsp/default.png';
                    } else {
                        $mainImgUrl = ($baseUrl !== '' ? $baseUrl : '') . '/assets/images/anhsp/' . trim($sp->ma_sp ?? $sp->MaSp) . '/' . $firstImgName;
                    }
                ?>

                <div class="main-image-frame mb-3" style="height: 400px;">
                    <img id="anhChinh" 
                        src="<?= $mainImgUrl ?>" 
                        class="img-fluid" 
                        alt="<?= $sp->tensp ?? $sp->Tensp ?? 'Sản phẩm' ?>" 
                        style="max-height: 100%; object-fit: contain;"
                        onerror="this.src='<?= $baseUrl !== '' ? $baseUrl : ''?>/assets/images/anhsp/default.png'"> </div>

                <?php if (!empty($dsHinh)): ?>
                    <div class="thumb-list ps-2">
                        <?php foreach ($dsHinh as $index => $hinh): ?>
                            <?php 

                                $imgName = $hinh->tenhinh ?? $hinh->Tenhinh ?? '';
                                
                                if(empty($imgName)) continue; 

                                $thumbUrl = ($baseUrl !== '' ? $baseUrl : '') . '/assets/images/anhsp/' . trim($sp->ma_sp ?? $sp->MaSp) . '/' . $imgName;
                                $activeClass = ($index == 0) ? "active" : "";
                            ?>
                            <img src="<?= $thumbUrl ?>" 
                                class="thumb-img <?= $activeClass ?>" 
                                onclick="changeImage(this)" 
                                alt="Thumbnail"
                                onerror="this.style.display='none'"> <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-lg-6">
                <h2 class="fw-bold mb-2"><?= $sp->tensp ?></h2>
                
                <div class="mb-3 d-flex align-items-center">
                    <div class="text-warning me-2">
                        <?php
                            $countReview = count($dsdg);
                            if ($countReview > 0) {
                                $tongdiem = 0;
                                foreach($dsdg as $d) {
                                    $tongdiem += $d->sosao;
                                }
                                $diemTB = $tongdiem / $countReview;
                                $sao = round($diemTB);
                                
                                for ($i = 1; $i <= 5; $i++) {
                                    $icon = ($i <= $sao) ? "bi-star-fill" : "bi-star";
                                    echo "<i class='bi $icon'></i> ";
                                }
                            } else {
                                echo str_repeat('<i class="bi bi-star text-muted"></i> ', 5);
                            }
                        ?>
                    </div>
                    <span class="text-muted small">(<?= $countReview ?> đánh giá)</span>
                </div>

                <div class="mb-4">
                    <?php
                        $brandName = "";
                        foreach ($dsnx as $nsx) {
                            if ($nsx->MaNsx == $sp->MaNsx) {
                                $brandName = $nsx->tennsx ?? $nsx->TenNsx ?? "Unknown";
                                break;
                            }
                        }
                    ?>
                    <p class="mb-1">Thương hiệu: <span class="fw-semibold text-dark"><?= $brandName ?></span></p>
                    <p class="mb-1">
                        Tình trạng: 
                        <?php if ($sp->soluongton > 0): ?>
                            <span class="badge bg-success bg-opacity-10 text-success px-3">Còn hàng</span>
                        <?php else: ?>
                            <span class="badge bg-danger bg-opacity-10 text-danger px-3">Hết hàng</span>
                        <?php endif; ?>
                    </p>
                </div>

                <div class="mb-4 p-3 bg-light rounded-3">
                    <span class="text-danger fw-bold display-6 me-3"><?= number_format($sp->giasp, 0, ',', '.') ?> đ</span>
                    <span class="text-muted text-decoration-line-through fs-6"><?= number_format($sp->giasp * 1.18, 0, ',', '.') ?> đ</span>
                </div>

                <p class="text-secondary mb-4">
                    <?= nl2br($sp->mota) ?>
                </p>

                <div class="d-flex align-items-center mb-4">
                    <span class="me-3 fw-semibold">Số lượng:</span>
                    <div class="input-group quantity-group" style="width: 140px;">
                        <button class="btn btn-outline-secondary btn-giam" type="button"><i class="bi bi-dash"></i></button>
                        <input type="text" class="form-control text-center soluong" value="1" min="1">
                        <button class="btn btn-outline-secondary btn-tang" type="button"><i class="bi bi-plus"></i></button>
                    </div>
                </div>

                <div class="d-flex gap-3 flex-column flex-sm-row">
                    <form action="<?=$baseUrl?>/DonDatHang/MuaNgay" method="post" class="flex-fill">
                        <input type="hidden" name="id" value="<?= $sp->ma_sp ?>">
                        <input type="hidden" name="soluong" class="sl-hidden" value="1" />
                        <button type="submit" class="btn btn-buy-now-lg w-100 btn-action-lg d-flex flex-column justify-content-center align-items-center">
                            <span class="fw-bold fs-5 text-uppercase">Mua Ngay</span>
                            <span class="small fw-normal">Giao hàng tận nơi</span>
                        </button>
                    </form>

                    <form action="<?=$baseUrl?>/DonDatHang/ThemVaoGio" method="post" class="flex-fill">
                        <input type="hidden" name="id" value="<?= $sp->ma_sp ?>">
                        <input type="hidden" name="soluong" class="sl-hidden" value="1" />
                        <button type="submit" class="btn btn-add-cart-lg w-100 btn-action-lg d-flex flex-column justify-content-center align-items-center">
                            <span class="fw-bold fs-5 text-uppercase">Thêm vào giỏ</span>
                            <span class="small fw-normal">Tìm thêm sản phẩm khác</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <hr class="my-5 text-secondary opacity-25" />

        <div class="row">
            <div class="col-lg-8">
                <h4 class="fw-bold mb-4 border-start border-4 border-warning ps-3">Đánh giá từ khách hàng</h4>
                
                <?php if (empty($dsdg)): ?>
                    <div class="text-center py-4 bg-light rounded-3">
                        <i class="bi bi-chat-square-dots text-muted fs-1"></i>
                        <p class="text-muted mt-2">Chưa có đánh giá nào cho sản phẩm này.</p>
                    </div>
                <?php else: ?>
                    <div class="review-list" style="max-height: 500px; overflow-y: auto;">
                        <?php foreach ($dsdg as $dg): ?>
                            <?php

                                $tenKhach = "Người dùng ẩn danh";
                                foreach ($dskh as $k) {
                                    if ($k->ma_nd == $dg->ma_nd) {
                                        $tenKhach = $k->tennd ?? ($k->ten_nd ?? ($k->ten ?? $tenKhach));
                                        break;
                                    }
                                }
                                $initial = function_exists('mb_substr')
                                    ? mb_strtoupper(mb_substr($tenKhach, 0, 1, 'UTF-8'), 'UTF-8')
                                    : strtoupper(substr($tenKhach, 0, 1));
                            ?>
                            <div class="review-item d-flex gap-3 mt-3">
                                <div class="flex-shrink-0">
                                    <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 50px; height: 50px;">
                                        <?= $initial ?>
                                    </div>
                                </div>
                                
                                <div>
                                    <h6 class="fw-bold mb-1"><?= $tenKhach ?></h6>
                                    <div class="text-warning small mb-2">
                                        <?php
                                            $starCount = $dg->sosao ?? 0;
                                            for ($i = 1; $i <= $starCount; $i++) echo '<i class="bi bi-star-fill"></i> ';
                                            for ($i = $starCount + 1; $i <= 5; $i++) echo '<i class="bi bi-star"></i> ';
                                        ?>
                                    </div>
                                    <p class="mb-0 text-dark"><?= $dg->noidung ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="mt-5">
            <h4 class="fw-bold mb-4 border-start border-4 border-warning ps-3">Sản phẩm tương tự</h4>
            
            <div class="d-flex overflow-auto pb-4 gap-4" style="scroll-snap-type: x mandatory;">
                <?php foreach ($relatedProducts as $item): ?>
                    <?php
                        $file = '';
                        if (isset($relatedHinh)) {
                            foreach ($relatedHinh[$item->ma_sp] as $img) {
                                if (!empty($img->tenhinh ?? $img->Tenhinh)) {
                                    $file = $img->tenhinh ?? $img->Tenhinh;
                                    break;
                                }
                            }
                        }
                        if($file === '') {
                            $urlItem = ($baseUrl !== '' ? $baseUrl : '') . '/assets/images/anhsp/default.png';
                        } else {
                            $urlItem = ($baseUrl !== '' ? $baseUrl : '') . '/assets/images/anhsp/' . trim($item->ma_sp) . '/' . $file;
                        }
                    ?>
                    <div class="flex-shrink-0" style="width: 280px; scroll-snap-align: start;">
                        <div class="card h-100 product-card shadow-sm border-0 rounded-3">
                            <a href="<?= $baseUrl ?>/SanPham/ChiTiet?id=<?= $item->ma_sp ?>" class="text-decoration-none">
                                <div class="card-img-wrapper border-bottom position-relative pt-100" style="padding-top: 100%; position: relative; overflow: hidden;">
                                    <img src="<?= $urlItem ?>"
                                        alt="<?= $item->tensp ?? $item->Tensp ?>" >
                                </div>
                            </a>
                            <div class="card-body p-3">
                                <h6 class="card-title text-truncate mb-2">
                                    <a  href="<?=$baseUrl?>/SanPham/ChiTiet?id=<?= $item->ma_sp ?>" class="text-dark text-decoration-none"><?= $item->tensp ?></a>
                                </h6>
                                <div class="text-danger fw-bold"><?= number_format($item->giasp, 0, ',', '.') ?> đ</div>
                                <form action="<?=$baseUrl?>/DonDatHang/MuaNgay" method="post" class="d-block">
                                    <input type="hidden" name="id" value="<?= $item->ma_sp ?>">
                                    <input type="hidden" name="soluong" value="1">
                                    <button type="submit" class="btn btn-sm btn-outline-dark w-100 mt-2 rounded-pill">Mua ngay</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>