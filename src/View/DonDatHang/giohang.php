<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$baseUrl = $GLOBALS['baseUrl'] ?? '';
?>

<div class="container mt-4">
    <h3 class="fw-bold mb-4 text-uppercase"><i class="bi bi-cart3"></i> Giỏ hàng của bạn</h3>

    <?php if (empty($items)): ?>
        <div class="text-center py-5 bg-light rounded-3">
            <i class="bi bi-cart3 text-muted fs-1"></i>
            <p class="text-muted mt-3">Giỏ hàng đang trống.</p>
            <a href="<?= $baseUrl ?>/SanPham" class="btn btn-outline-dark">Xem sản phẩm</a>
        </div>
        <div style="height: 100px;"></div>
    <?php else: ?>
        <div class="row">
            <div class="col-lg-8">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Sản phẩm</th>
                                <th>Đơn giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i = 1;
                                $pdo = require __DIR__ . '/../../../config/config.php';
                                foreach ($items as $it):
                                    if ($it instanceof \App\Model\ChiTietDonDatHang) {
                                        $prod = \App\Model\Product::getById($pdo, $it->ma_sp);
                                        $name = $prod ? $prod->tensp : ($it->ma_sp ?? '');
                                        $unit = $it->gia;
                                        $qty = (int)$it->soluong;
                                        $line = $it->thanhtien ?? ($unit * $qty);
                                    } elseif (is_array($it)) {
                                        $name = $it['tensp'] ?? ($it['ma_sp'] ?? '');
                                        $unit = $it['giasp'] ?? 0;
                                        $qty = (int)($it['soluong'] ?? 0);
                                        $line = ($it['thanhtien'] ?? ($unit * $qty));
                                    } else {
                                        $name = '';
                                        $unit = 0;
                                        $qty = 0;
                                        $line = 0;
                                    }
                            ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td>
                                        <?= htmlspecialchars($name) ?>
                                    </td>
                                    <td><?= number_format($unit, 0, ',', '.') ?> đ</td>
                                    <td><?= $qty ?></td>
                                    <td><?= number_format($line, 0, ',', '.') ?> đ</td>
                                    <td class="text-end">
                                        <form action="<?= $baseUrl ?>/DonDatHang/XoaItem" method="post" style="display:inline">
                                            <input type="hidden" name="ma_sp" value="<?= htmlspecialchars($it instanceof \App\Model\ChiTietDonDatHang ? $it->ma_sp : ($it['ma_sp'] ?? '')) ?>">
                                            <button class="btn btn-sm btn-outline-danger" type="submit" title="Xóa"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card p-3">
                    <h5 class="fw-bold">Thông tin đơn hàng</h5>
                    <div class="d-flex justify-content-between mt-3">
                        <div>Tổng sản phẩm</div>
                        <div class="fw-bold"><?= (int)$totalQty ?></div>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <div>Tổng tiền</div>
                        <div class="fw-bold text-danger"><?= number_format($totalPrice, 0, ',', '.') ?> đ</div>
                    </div>

                    <hr>
                    <div>
                        <p class="form-control text-secondary fs-6 mb-4" readonly>Nhấn "<strong>Thanh toán</strong>" đồng nghĩa với việc bạn đồng ý tuân theo <a class="text-decoration-none text-danger">Điều khoản & Chính sách</a> của đơn vị</p>
                    </div>
                    <form action="<?= $baseUrl ?>/DonDatHang/ThanhToanCart" method="post">
                        <div class="w-100">
                            <select name="payment_method" class="form-select form-select-sm">
                                <option value="cod">COD - Thanh toán khi nhận hàng</option>
                                <option value="vnpay">VNPay - Thanh toán trực tuyến</option>
                            </select>
                        </div>
                        <div class="d-flex gap-2">
                            <div style="flex:1">
                                <button class="btn btn-outline-danger w-100 mt-3" type="submit" formaction="<?= $baseUrl ?>/DonDatHang/ClearCart">Hủy</button>
                            </div>
                            <div style="flex:2">
                                <button class="btn btn-success w-100 mt-3" type="submit">Thanh toán</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
