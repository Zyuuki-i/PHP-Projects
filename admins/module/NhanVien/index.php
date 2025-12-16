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
    use App\Model\NhanVien;
    $pdo = require_once __DIR__ . '/../../../config/config.php';
    $nv = NhanVien::getAll($pdo);
?>
<div class="row">
    <div class="col-md-12">
        <h2 class="text-center my-3 fw-bold text-uppercase">QUẢN LÝ NHÂN VIÊN</h2>
        <a href="index.php?mod=NhanVien&act=create" class="btn btn-success mb-3">Thêm nhân viên</a>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Mã</th>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Địa chỉ</th>
                    <th>Chức vụ</th>
                    <th>Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($nv as $item): if ($item->ma_vt !== 'Admin'): ?>
                    <tr>
                        <td><?= htmlspecialchars($item->ma_nv) ?></td>
                        <td><?= htmlspecialchars($item->tennv) ?></td>
                        <td><?= htmlspecialchars($item->email) ?></td>
                        <td><?= htmlspecialchars($item->sdt) ?></td>
                        <td><?= htmlspecialchars($item->diachi) ?></td>
                        <td><?= htmlspecialchars($item->ma_vt) ?></td>
                        <td>
                            <a href="index.php?mod=NhanVien&act=edit&ma_nv=<?= urlencode($item->ma_nv) ?>" class="btn btn-sm btn-primary">Sửa</a>
                            <?php if($item->trangthai == 1): ?>
                            <a href="index.php?mod=NhanVien&act=deactivate&ma_nv=<?= urlencode($item->ma_nv) ?>" class="btn btn-sm btn-warning" onclick="return confirm('Bạn có chắc chắn muốn vô hiệu hóa nhân viên này không?');">Vô hiệu</a>
                            <?php else: ?>
                            <a href="index.php?mod=NhanVien&act=activate&ma_nv=<?= urlencode($item->ma_nv) ?>" class="btn btn-sm btn-success" onclick="return confirm('Bạn có chắc chắn muốn kích hoạt nhân viên này không?');">Kích hoạt</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; endforeach; ?>
            </tbody>
        </table>
    </div>
</div>