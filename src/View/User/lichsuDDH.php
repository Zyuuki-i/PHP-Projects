<?php
    $baseUrl = $GLOBALS['baseUrl'] ?? '';
    if (empty($_SESSION['user'])) {
        header('Location: ' . $baseUrl . '/');
        exit;
    }
?>

<div class="row">
    <div class="col-12 mb-4">
        <h3>Lịch sử đặt hàng</h3>
        <p class="text-muted small">Xem chi tiết và trạng thái các đơn hàng của bạn.</p>
    </div>

    <div class="col-12">
        <?php if (empty($donhangs)): ?>
            <div class="alert alert-info">Bạn chưa có đơn hàng nào.</div>
            <div style="height: 500px;"></div>
        <?php else: ?>
            <?php foreach ($donhangs as $dh):
                $status = $dh->trangthai ?: $dh->tt_thanhtoan;
                $s = mb_strtolower($status, 'UTF-8');
                $badgeClass = 'bg-secondary text-white';
                if (strpos($s, 'giao') !== false || strpos($s, 'hoàn') !== false) $badgeClass = 'bg-success text-white';
                elseif (strpos($s, 'đang') !== false || strpos($s, 'xử lý') !== false) $badgeClass = 'bg-warning text-dark';
                elseif (strpos($s, 'hủy') !== false || strpos($s, 'chưa') !== false) $badgeClass = 'bg-danger text-white';
            ?>
                <div class="card mb-3 order-card shadow-sm">
                    <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-1">Đơn #<?= htmlspecialchars($dh->ma_ddh) ?></h6>
                            <div class="text-muted small">Ngày đặt: <?= htmlspecialchars($dh->ngaydat) ?></div>
                            <div class="mt-2">Tổng tiền: <strong><?= number_format($dh->tongtien ?? 0, 0, ',', '.') ?> đ</strong></div>
                        </div>

                        <div class="text-end mt-3 mt-md-0">
                            <span class="badge order-badge <?= $badgeClass ?>"><?= htmlspecialchars($status) ?></span>
                            <div class="mt-2">
                                <a href="<?= $baseUrl ?>/DonDatHang/ChiTiet?id=<?= $dh->ma_ddh ?>" class="btn btn-outline-primary btn-sm">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>