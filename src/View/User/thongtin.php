<?php
    $baseUrl = $GLOBALS['baseUrl'] ?? '';
    if (empty($_SESSION['user'])) {
        header('Location: ' . $baseUrl . '/');
        exit;
    }
?>

<div class="row">
    <div class="col-12">
        <h3 class="mb-4 text-uppercase"><i class="bi bi-info-circle"></i> Thông tin tài khoản</h3>
    </div>

    <div class="col-md-4 col-sm-12">
        <div class="card user-card shadow-sm">
            <div class="card-body text-center">
                <?php $avatar = $nguoidung->hinh ? ($baseUrl . '/assets/images/anhnd/' . $nguoidung->hinh) : ($baseUrl . '/assets/images/avatar-placeholder.png'); ?>
                <img src="<?= htmlspecialchars($avatar) ?>" alt="Avatar" class="rounded-circle mb-3" style="width:120px;height:120px;object-fit:cover;">
                <h5 class="card-title mb-1"><?= htmlspecialchars($nguoidung->tennd) ?></h5>
                <p class="text-muted small mb-0"><?= htmlspecialchars($nguoidung->email) ?></p>
            </div>
            <div class="card-footer text-center bg-white">
                <a href="<?= $baseUrl ?>/User/Edit?id=<?= $nguoidung->ma_nd ?>" class="btn btn-outline-primary btn-sm me-2">Chỉnh sửa</a>
            </div>
        </div>
    </div>

    <div class="col-md-8 col-sm-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Hồ sơ</h5>
                <div class="row">
                    <div class="col-sm-6 mb-2"><strong>Họ & tên:</strong><br><?= htmlspecialchars($nguoidung->tennd) ?></div>
                    <div class="col-sm-6 mb-2"><strong>Số điện thoại:</strong><br><?= htmlspecialchars($nguoidung->sdt ?: '-'); ?></div>
                    <div class="col-sm-6 mb-2"><strong>Email:</strong><br><?= htmlspecialchars($nguoidung->email) ?></div>
                    <div class="col-sm-6 mb-2"><strong>Địa chỉ:</strong><br><?= htmlspecialchars($nguoidung->diachi ?: '-'); ?></div>
                </div>
                <hr>
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">Tài khoản #: <?= htmlspecialchars($nguoidung->ma_nd) ?></small>
                    <a href="<?= $baseUrl ?>/User/LichSuDatHang?id=<?= $nguoidung->ma_nd ?>" class="btn btn-outline-gold btn-sm">Xem lịch sử đặt hàng</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 mt-3 mb-3">
        <?php if (!empty($canDanhGia)): ?>
            <h5 class="mb-3">Sản phẩm cần đánh giá</h5>
            <?php foreach ($canDanhGia as $item):
                $p = $item['product'];
                $img = $item['image'];
                $imgUrl = $img ? ($baseUrl . '../assets/images/anhsp/'. trim($p->ma_sp) . '/' . $img) : ($baseUrl . '../assets/images/anhsp/default.png');
            ?>
                <div class="card mb-3">
                    <div class="card-body d-flex gap-3 align-items-start">
                        <img src="<?= htmlspecialchars($imgUrl) ?>" alt="<?= htmlspecialchars($p->tensp) ?>" style="width:72px;height:72px;object-fit:cover;border-radius:6px;">
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong><?= htmlspecialchars($p->tensp) ?></strong>
                                    <div class="text-muted small">Giá: <?= number_format($p->giasp ?? 0, 0, ',', '.') ?> đ</div>
                                </div>
                            </div>

                            <form action="<?= $baseUrl ?>/User/DanhGia" method="post" class="row g-2 mt-2">
                                <input type="hidden" name="ma_sp" value="<?= htmlspecialchars($p->ma_sp) ?>">
                                <div class="col-12 col-md-8">
                                    <textarea name="noidung" rows="2" class="form-control" placeholder="Viết đánh giá... (tối đa 300 ký tự)" maxlength="300" required></textarea>
                                </div>
                                <div class="col-6 col-md-2">
                                    <select name="sosao" class="form-select">
                                        <option value="5">5 sao</option>
                                        <option value="4">4 sao</option>
                                        <option value="3">3 sao</option>
                                        <option value="2">2 sao</option>
                                        <option value="1">1 sao</option>
                                    </select>
                                </div>
                                <div class="col-6 col-md-2 text-end">
                                    <button class="btn btn-primary btn-sm w-100" type="submit">Gửi</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-muted">Không có sản phẩm cần đánh giá.</div>
        <?php endif; ?>
    </div>
    <div class="col-12 mb-5">
        <?php if (empty($daDanhGia)): ?>
            <div class="text-muted">Bạn chưa đánh giá sản phẩm nào.</div>
        <?php else: ?>
            <h5 class="mb-3">Sản phẩm đã đánh giá</h5>
            <?php foreach ($daDanhGia as $item):
                $p = $item['product'];
                $img = $item['image'];
                $imgUrl = $img ? ($baseUrl . '../assets/images/anhsp/'. trim($p->ma_sp) . '/' . $img) : ($baseUrl . '../assets/images/anhsp/default.png');
                ?>
                <div class="card mb-3">
                    <div class="card-body d-flex gap-3 align-items-center">
                        <img src="<?= htmlspecialchars($imgUrl) ?>" alt="<?= htmlspecialchars($p->tensp) ?>" style="width:72px;height:72px;object-fit:cover;border-radius:6px;">
                        <div>
                            <strong><?= htmlspecialchars($p->tensp) ?></strong>
                            <div class="text-muted small">Giá: <?= number_format($p->giasp ?? 0, 0, ',', '.') ?> đ</div>
                            <div class="mt-2">
                                <?php
                                    $sosao = (int)($item['danhgia']->sosao ?? 0);
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $sosao) {
                                            echo '<i class="bi bi-star-fill text-warning"></i> ';
                                        } else {
                                            echo '<i class="bi bi-star text-warning"></i> ';
                                        }
                                    }
                                ?>
                                <p class="mt-2"><?= $item['danhgia']->noidung ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>