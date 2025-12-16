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
    use App\Model\Product;
    $pdo = require_once __DIR__ . '/../../../config/config.php';
    $sp = Product::getAll($pdo);

    $trang = isset($_GET['trang']) ? (int)$_GET['trang'] : 1;
    $sosp = 6; 
    if ($trang < 1) $trang = 1;

    $vitribd = ($trang - 1) * $sosp;

    $tongsp = Product::countAll($pdo); 
    $tongtrang = ceil($tongsp / $sosp);

    $products = Product::getPage($pdo, $sosp, $vitribd, $sp);
?>

<div class="row">
    <div class="col-md-12">
        <h2 class="text-center my-3 fw-bold text-uppercase">QUẢN LÝ SẢN PHẨM</h2>
        
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="index.php?mod=sanpham&act=create" class="btn btn-success">
                <i class="fas fa-plus"></i> Thêm sản phẩm
            </a>
            <span class="text-muted">Tổng: <strong><?= $tongsp ?></strong> sản phẩm</span>
        </div>

        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Mã</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th class="text-center">Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($products) > 0): ?>
                    <?php foreach ($products as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item->ma_sp) ?></td>
                            <td><?= htmlspecialchars($item->tensp) ?></td>
                            <td><?= number_format($item->giasp, 0, ',', '.') ?> VNĐ</td>
                            <td><?= htmlspecialchars($item->soluongton) ?></td>
                            <td class="text-center">
                                <a href="index.php?mod=sanpham&act=edit&ma_sp=<?= urlencode($item->ma_sp) ?>" class="btn btn-sm btn-primary">Sửa</a>
                                <a href="index.php?mod=sanpham&act=delete&ma_sp=<?= urlencode($item->ma_sp) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?');">Xóa</a>
                            </td>    
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">Không có sản phẩm nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <?php if ($tongtrang > 1): ?>
        <nav aria-label="Page navigation" class="my-4">
            <ul class="pagination justify-content-center pagination-sm"> <li class="page-item <?= ($trang <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="index.php?mod=sanpham&trang=<?= $trang - 1 ?>" aria-label="Previous">
                        <span aria-hidden="true"><i class="fas fa-chevron-left"></i> &laquo;</span>
                    </a>
                </li>

                <?php for ($i = 1; $i <= $tongtrang; $i++): ?>
                    <?php if ($i == 1 || $i == $tongtrang || ($i >= $trang - 2 && $i <= $trang + 2)): ?>
                        <li class="page-item <?= ($i == $trang) ? 'active' : '' ?>">
                            <a class="page-link" href="index.php?mod=sanpham&trang=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php elseif ($i == $trang - 3 || $i == $trang + 3): ?>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    <?php endif; ?>
                <?php endfor; ?>

                <li class="page-item <?= ($trang >= $tongtrang) ? 'disabled' : '' ?>">
                    <a class="page-link" href="index.php?mod=sanpham&trang=<?= $trang + 1 ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo; <i class="fas fa-chevron-right"></i></span>
                    </a>
                </li>
            </ul>
        </nav>
        <?php endif; ?>
    </div>
</div>