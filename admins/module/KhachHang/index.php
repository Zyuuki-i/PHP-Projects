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
    use App\Model\NguoiDung;
    $pdo = require_once __DIR__ . '/../../../config/config.php';
    $kh = NguoiDung::getAll($pdo);
?>
<div class="row">
    <div class="col-md-12">
        <h2 class="text-center my-3 fw-bold text-uppercase">QUẢN LÝ KHÁCH HÀNG</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Mã</th>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Địa chỉ</th>
                    <th>Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($kh as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item->ma_nd) ?></td>
                        <td><?= htmlspecialchars($item->tennd) ?></td>
                        <td><?= htmlspecialchars($item->email) ?></td>
                        <td><?= htmlspecialchars($item->sdt) ?></td>
                        <td><?= htmlspecialchars($item->diachi) ?></td>
                        <td>
                            <a href="index.php?mod=khachhang&act=edit&ma_nd=<?= urlencode($item->ma_nd) ?>" class="btn btn-sm btn-primary">Sửa</a>
                            <?php if($item->trangthai == 1): ?>
                            <a href="index.php?mod=khachhang&act=deactivate&ma_nd=<?= urlencode($item->ma_nd) ?>" class="btn btn-sm btn-warning" onclick="return confirm('Bạn có chắc chắn muốn vô hiệu hóa khách hàng này không?');">Vô hiệu</a>
                            <?php else: ?>
                            <a href="index.php?mod=khachhang&act=activate&ma_nd=<?= urlencode($item->ma_nd) ?>" class="btn btn-sm btn-success" onclick="return confirm('Bạn có chắc chắn muốn kích hoạt khách hàng này không?');">Kích hoạt</a>
                            <?php endif; ?>
                        </td>    
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>