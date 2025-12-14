<?php

if (!defined('APP_RUNNING')) {
    header('Location: /home');
    exit;
}
$baseUrl = $GLOBALS['baseUrl'] ?? '';
?>
<style>

</style>

<div id="sliderHome" class="carousel slide mb-5" data-bs-ride="carousel">

    <div class="carousel-indicators">
        <button type="button" data-bs-target="#sliderHome" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#sliderHome" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#sliderHome" data-bs-slide-to="2"></button>
    </div>

    <div class="carousel-fade-wrapper">
        <div class="carousel-inner">

            <div class="carousel-item active">
                <img src="./assets/images/slider/slider_1.jpg" class="d-block w-100">
            </div>

            <div class="carousel-item">
                <img src="./assets/images/slider/slider_2.jpg" class="d-block w-100">
            </div>

            <div class="carousel-item">
                <img src="./assets/images/slider/slider_3.jpg" class="d-block w-100">
            </div>

        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#sliderHome" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#sliderHome" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>

</div>
<div class="text-center mb-5" style="width: 500px; margin: auto; padding-top: 50px;">
    <h1 class="text-danger">Nhạc cụ cổ điển</h1>
    <p class="fst-italic">
        Những sản phẩm nhạc cụ cổ điển chất lượng cao được tuyển chọn
        kỹ lưỡng từ các thương hiệu nổi tiếng thế giới
    </p>
</div>
    <div class="row row-cols-1 row-cols-md-2 g-4">
        <?php foreach ($products as $item): ?>
        <?php
            $tenfile = "";

            foreach ($hinhList as $h) {
                if ($h->ma_sp == $item->ma_sp) {
                    $tenfile = $h->tenhinh;
                    break;
                }
            }
            
            $dir = "./assets/images/anhsp/";
            $url = "";

            if ($tenfile === "") {
                $url = $dir . "default.png";
            } else {
                $url = $dir . trim($item->ma_sp) . "/" . $tenfile;
            }

            $giaMoi = $item->giasp;
            $giaCu = $item->giasp + ($item->giasp * 18 / 100);

            $giamGia = 0;
            if ($giaCu > $giaMoi && $giaCu > 0) {
                $giamGia = round((($giaCu - $giaMoi) / $giaCu) * 100);
            }
        ?>
        <div class="col-md-4 col-lg-3 mb-4"> <div class="card h-100 product-card shadow-sm border-0 rounded-3">
            <a href="<?=$baseUrl?>/SanPham/ChiTiet?id=<?php echo $item->ma_sp; ?>" class="text-decoration-none">
                <div class="product-img-wrap border-bottom">
                    <?php if ($giamGia > 0): ?>
                        <span class="badge-sale">-<?php echo $giamGia; ?>%</span>
                    <?php endif; ?>
                    
                    <img src="<?php echo $url; ?>" alt="<?php echo htmlspecialchars($item->tensp); ?>">
                </div>
            </a>

            <div class="card-body d-flex flex-column p-3">
                <div class="text-muted small mb-1 text-uppercase ls-1">
                    <?php
                        $tenLoai = "Unknown";
                        foreach ($nsxList as $loai) {
                            if ($loai->ma_nsx == $item->ma_nsx) {
                                $tenLoai = $loai->tennsx;
                                break;
                            }
                        }
                        echo htmlspecialchars($tenLoai);
                    ?>
                </div>

                <h5 class="card-title mb-2">
                    <a href="<?=$baseUrl?>/SanPham/ChiTiet?id=<?php echo $item->ma_sp; ?>" class="text-dark text-decoration-none text-line-clamp-2" title="<?php echo $item->tensp; ?>">
                        <?php echo $item->tensp; ?>
                    </a>
                </h5>

                <div class="mb-3">
                    <span class="text-danger fw-bold fs-5 me-2">
                        <?php echo number_format($giaMoi, 0, ',', '.'); ?>đ
                    </span>
                    <?php if ($giaCu > $giaMoi): ?>
                        <small class="text-decoration-line-through text-muted">
                            <?php echo number_format($giaCu, 0, ',', '.'); ?>đ
                        </small>
                    <?php endif; ?>
                </div>

                <p class="card-text text-muted small text-line-clamp-2 mb-3">
                    <?php echo strip_tags($item->mota); ?>
                </p>

                <div class="mt-auto">
                    <form action="<?=$baseUrl?>/DonDatHang/MuaNgay" method="post">
                        <input type="hidden" name="soluong" value="1" />
                        <input type="hidden" name="id" value="<?php echo $item->ma_sp; ?>" />
                        <button type="submit" class="btn btn-buy w-100 rounded-pill py-2">
                            <i class="bi bi-cart-plus me-1"></i> Mua Ngay
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    </div>
     <div class="text-center mt-3 mb-3">
        <a href="<?=$baseUrl?>/SanPham" class="btn btn-outline-gold rounded-pill">
            Xem tất cả sản phẩm <i class="bi bi-arrow-right ms-2"></i>
        </a>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const alertBox = document.querySelector(".alert");
        if (alertBox) {
            setTimeout(() => alertBox.style.display = "none", 3000);
        }
    });
</script>
