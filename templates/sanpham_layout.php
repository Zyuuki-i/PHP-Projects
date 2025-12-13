<?php
    if (!defined('APP_RUNNING')) {
    header('Location: /home');
    exit;
    }
    use \App\Model\LoaiSanPham;
    use \App\Model\NhaSanXuat;
    $pdo = require __DIR__ . '/../config/config.php';
    $DsLoai = LoaiSanPham::getAll($pdo);
    $DsNSX = NhaSanXuat::getAll($pdo);
    $baseUrl = $GLOBALS['baseUrl'] ?? '';
?>
<div class="container-fluid mt-2 mb-5">
    <div class="row">
        <div class="col-sm-3 d-flex flex-column flex-shrink-0 p-3 bg-info rounded-2">
            <a class="nav-link" href="<?=$baseUrl?>/SanPham">
                <p class="text-dark text-center text-uppercase fs-4">Danh mục sản phẩm</p>
            </a>
            <p class="text-secondary fw-semibold fs-4 mt-3 ms-3">Loại Sản Phẩm</p>
            <?php if (isset($DsLoai) && $DsLoai != null): ?>
                <ul class="nav nav-pills flex-column mb-4">
                    <?php foreach ($DsLoai as $loai): ?>
                        <li class="nav-item li-hover">
                            <a class="nav-link text-white" href="<?=$baseUrl?>/SanPham/LocLoai?maloai=<?= htmlspecialchars($loai->ma_loai) ?>">
                                <i class="mdi mdi-cube-outline fs-5"></i><?= htmlspecialchars($loai->tenloai) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <p class="text-secondary fw-semibold fs-4 mt-3 ms-3">Nhà Sản Xuất</p>
            <?php if (isset($DsNSX) && $DsNSX != null): ?>
                <ul class="nav nav-pills flex-column mb-4">
                    <?php foreach ($DsNSX as $nsx): ?>
                        <li class="nav-item li-hover">
                            <a class="nav-link text-white" href="<?=$baseUrl?>/SanPham/LocNSX?mansx=<?= htmlspecialchars($nsx->ma_nsx) ?>">
                                <i class="mdi mdi-cube-outline fs-5"></i><?= htmlspecialchars($nsx->tennsx) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        <div class="container col-sm-9">
            <main role="main" class="pb-3 ps-3">
                <?php if (isset($content)) echo $content; ?>
            </main>
        </div>
    </div>
</div>