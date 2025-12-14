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

            $dir = ($baseUrl ? $baseUrl : '..') . "/assets/images/anhsp/";
            $url = "";

            if ($tenfile === "") {
                $url = $dir . "default.png";
            } else {
                $url = $dir . trim($item->ma_sp) . "/" . $tenfile;
            }
        ?>
        <div class="col-6 col-md-4 col-lg-3 mb-4">
            <div class="card h-100 product-card border-0 shadow-sm rounded-3">
                
                <a href="<?=$baseUrl?>/SanPham/ChiTiet?id=<?php echo htmlspecialchars($item->ma_sp); ?>" class="text-decoration-none">
                    <div class="card-img-wrapper border-bottom">
                        <img src="<?php echo htmlspecialchars($url); ?>" alt="<?php echo htmlspecialchars($item->tensp); ?>">
                    </div>
                </a>

                <div class="card-body d-flex flex-column p-3">
                    <h6 class="card-title mb-2">
                        <a href="<?=$baseUrl?>/SanPham/ChiTiet?id=<?php echo htmlspecialchars($item->ma_sp); ?>" class="text-dark text-decoration-none text-clamp-2" title="<?php echo htmlspecialchars($item->tensp); ?>">
                            <?php echo htmlspecialchars($item->tensp); ?>
                        </a>
                    </h6>

                    <div class="mt-auto mb-3 text-center">
                        <span class="text-danger fw-bold fs-5">
                            <?php echo number_format($item->giasp, 0, ',', '.'); ?> đ
                        </span>
                    </div>

                    <form action="<?=$baseUrl?>/DonDatHang/MuaNgay" method="post">
                        <input type="hidden" name="soluong" value="1" />
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($item->ma_sp); ?>" />
                        <button type="submit" class="btn btn-buy-now w-100 rounded-pill py-2">
                            <i class="bi bi-cart-plus me-1"></i> Mua Ngay
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <?php } ?>
    <?php } ?>
</div>
<?php if (isset($tongtrang) && $tongtrang > 1): ?>
    <nav aria-label="Page navigation" class="mt-4">
        <ul class="pagination justify-content-center">
            <?php
                $cp = isset($tranghientai) ? (int)$tranghientai : 1;
                $tp = (int)$tongtrang;
                $prevClass = $cp <= 1 ? ' disabled' : '';
                $nextClass = $cp >= $tp ? ' disabled' : '';
                $loaiID = $_SESSION['loaiID'] ?? null;
                $nsxID = $_SESSION['nsxID'] ?? null;
                $keyword = $_SESSION['keyword'] ?? null;
            ?>
            <li class="page-item<?php echo $prevClass; ?>">
                <a class="page-link" href="<?php echo htmlspecialchars($baseUrl . '/SanPham?maloai=' . $loaiID . '&mansx=' . $nsxID . '&keyword=' . $keyword . '&page=' . max(1, $cp - 1)); ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <?php for ($i = 1; $i <= $tp; $i++): ?>
                <li class="page-item<?php echo ($i === $cp) ? ' active' : ''; ?>">
                    <a class="page-link" href="<?php echo htmlspecialchars($baseUrl . '/SanPham?maloai=' . $loaiID . '&mansx=' . $nsxID . '&keyword=' . $keyword . '&page=' . $i); ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item<?php echo $nextClass; ?>">
                <a class="page-link" href="<?php echo htmlspecialchars($baseUrl . '/SanPham?maloai=' . $loaiID . '&mansx=' . $nsxID . '&keyword=' . $keyword . '&page=' . min($tp, $cp + 1)); ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
<?php endif; ?>