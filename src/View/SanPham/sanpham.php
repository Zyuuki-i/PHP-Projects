<?php $baseUrl = $GLOBALS['baseUrl'] ?? ''; ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-light p-3 rounded-3">

        <li class="breadcrumb-item">
            <a href="<?=$baseUrl?>/SanPham" class="text-secondary"><i class="bi bi-house"></i></a>
        </li>
    </ol>
</nav>
<div class="row g-4">
    <?php if (isset($thongbaoloi) && $thongbaoloi != null)
    {?>
        <div class="alert alert-danger text-center fw-bold">
            <?php echo $thongbaoloi; ?>
        </div>
    <?php } ?>
    <?php if (empty($products)) { ?>
        <h3 class="text-center text-danger fw-bold mt-5">Không có sản phẩm phù hợp!</h3>
    <?php } else { ?>
        <?php foreach ($products as $item)
        {
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
        ?>
            <div class="col-md-4 mb-4 ho-item">
                <div class="card h-100">
                    <div class="col h-100">
                        <div class="card">
                            <a href="<?=$baseUrl?>/SanPham/ChiTiet?id=<?php echo htmlspecialchars($item->ma_sp); ?>">
                                <div class="d-flex p-1 align-content-center" style="height: 250px">
                                    <img src="<?php echo htmlspecialchars($url); ?>" class="card-img-top" alt="Hình Sản Phẩm" style="object-fit:contain;">
                                </div>
                            </a>
                            <div class="card-body">
                                <h3 class="card-title fw-bold" style="height: 80px"><?php echo htmlspecialchars($item->tensp); ?> </h3>
                                <h5 class="card-text text-danger text-center mb-3" style="height: 20px"><?php echo number_format($item->giasp, 0, ',', '.') . " đ"; ?></h5>
                                <div class="d-flex w-100 justify-content-end">
                                    <form action="<?=$baseUrl?>/DonDatHang/MuaNgay?id=<?php echo htmlspecialchars($item->ma_sp); ?>" method="post" class="flex-fill">
                                        <input type="hidden" name="soluong" value="1" />
                                        <button type="submit" class="btn btn-warning w-100 mt-2 fs-4">Mua ngay</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>