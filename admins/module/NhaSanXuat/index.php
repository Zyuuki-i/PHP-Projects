<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['admin'])) {
        header('Location: ../../index.php');
        exit();
    }
    require_once __DIR__ . '/../../../vendor/autoload.php';  
    use App\Model\NhaSanXuat;
    $pdo = require_once __DIR__ . '/../../../config/config.php';
    $nsx = NhaSanXuat::getAll($pdo);
?>
<div class="row">
    <div class="col-md-12">
        <h2 class="text-center my-3 fw-bold text-uppercase">QUẢN LÝ NHÀ SẢN XUẤT</h2>
        <a href="index.php?mod=NhaSanXuat&act=create" class="btn btn-success mb-3">Thêm nhà sản xuất</a>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Mã</th>
                    <th>Tên nhà sản xuất</th>
                    <th class="text-center">Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($nsx as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item->ma_nsx) ?></td>
                        <td><?= htmlspecialchars($item->tennsx) ?></td>
                        <td class="text-center">
                            <a href="index.php?mod=NhaSanXuat&act=edit&ma_nsx=<?= urlencode($item->ma_nsx) ?>" class="btn btn-sm btn-primary w-25">Sửa</a>
                            <a href="index.php?mod=NhaSanXuat&act=delete&ma_nsx=<?= urlencode($item->ma_nsx) ?>" class="btn btn-sm btn-danger w-25" onclick="return confirm('Bạn có chắc chắn muốn xóa nhà sản xuất này không?');">Xóa</a>
                        </td>    
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>