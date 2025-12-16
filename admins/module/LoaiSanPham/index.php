<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (
        !isset($_SESSION['admin']) ||
        ($_SESSION['admin']['ma_vt'] ?? '') !== 'Admin'
    ) {
        header('Location: ../../index.php');
        exit();
        }
        require_once __DIR__ . '/../../../vendor/autoload.php';  
    use App\Model\LoaiSanPham;
    $pdo = require_once __DIR__ . '/../../../config/config.php';
    $loaisp = LoaiSanPham::getAll($pdo);
?>
<div class="row">
    <div class="col-md-12">
        <h2 class="text-center my-3 fw-bold text-uppercase">QUẢN LÝ LOẠI SẢN PHẨM</h2>
        <a href="index.php?mod=LoaiSanPham&act=create" class="btn btn-success mb-3">Thêm loại sản phẩm</a>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Mã</th>
                    <th>Tên loại sản phẩm</th>
                    <th class="text-center">Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($loaisp as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item->ma_loai) ?></td>
                        <td><?= htmlspecialchars($item->tenloai) ?></td>
                        <td class="text-center">
                            <a href="index.php?mod=LoaiSanPham&act=edit&ma_loai=<?= urlencode($item->ma_loai) ?>" class="btn btn-sm btn-primary w-25">Sửa</a>
                            <a href="index.php?mod=LoaiSanPham&act=delete&ma_loai=<?= urlencode($item->ma_loai) ?>" class="btn btn-sm btn-danger w-25" onclick="return confirm('Bạn có chắc chắn muốn xóa loại sản phẩm này không?');">Xóa</a>
                        </td>    
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>