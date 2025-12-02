<?php

if (!defined('APP_RUNNING')) {
    header('Location: /home');
    exit;
}
?>
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
            
            $baseUrl = "./assets/images/anhsp/";
            $url = "";

            if ($tenfile === "") {
                $url = $baseUrl . "default.png";
            } else {
                $url = $baseUrl . trim($item->ma_sp) . "/" . $tenfile;
            }

            $giaMoi = $item->giasp;
            $giaCu = $item->giasp + ($item->giasp * 18 / 100);
        ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="col h-100">
                    <div class="card">
                        <a href="chiTietSP.php?id=<?php echo $item->ma_sp; ?>">
                            <div class="d-flex align-content-center p-1" style="height: 400px">
                                <img src="<?php echo $url; ?>" class="card-img-top" alt="Hình Sản Phẩm" style="object-fit:contain;">
                            </div>
                        </a>
                        <div class="card-body">
                            <h3 class="card-title fw-bold"><?php echo $item->tensp; ?></h3>
                            
                            <p class="card-text">Thương hiệu 
                                <small class="text-body-secondary">
                                   Unknown
                                </small>
                            </p>
                            
                            <p class="card-text text-muted" style="height: 40px">
                                <?php echo $item->mota; ?>
                            </p>
                            
                            <h4 class="card-text text-danger text-center mb-4">
                                <?php echo number_format($giaMoi, 0, ',', '.'); ?> đ 
                                <span class="text-secondary ms-2 fs-5 text-decoration-line-through">
                                    <?php echo number_format($giaCu, 0, ',', '.'); ?> đ
                                </span>
                            </h4>
                            
                            <div class="d-flex w-100 justify-content-end">                
                                <form action="xu-ly-mua-hang.php?id=<?php echo $item->ma_sp; ?>" method="post" class="flex-fill">
                                    <input type="hidden" name="soluong" value="1" /> 
                                    <button type="submit" class="btn btn-warning w-100 mt-2 fs-4">Mua ngay</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
    <div class="d-flex justify-content-center align-items-center">
        <a href="" asp-action="Index" class="fs-4 text-decoration-none text-primary">Xem thêm</a>
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
