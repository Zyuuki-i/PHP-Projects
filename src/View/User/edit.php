<?php
    $baseUrl = $GLOBALS['baseUrl'] ?? '';
    if (empty($_SESSION['user'])) {
        header('Location: ' . $baseUrl . '/');
        exit;
    }
?>

<div class="row mb-5">
    <div class="col-12">
        <h3 class="mb-4">Chỉnh sửa thông tin</h3>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <?php if (!empty($_SESSION['user_update_error'])): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['user_update_error']) ?></div>
                    <?php unset($_SESSION['user_update_error']); ?>
                <?php endif; ?>

                <form action="<?= $baseUrl ?>/User/Update" method="post" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" value="<?= htmlspecialchars($nguoidung->ma_nd) ?>" disabled>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" value="<?= htmlspecialchars($nguoidung->email) ?>" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Họ & tên</label>
                        <input type="text" name="tennd" class="form-control" value="<?= htmlspecialchars($nguoidung->tennd) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" name="sdt" class="form-control" value="<?= htmlspecialchars($nguoidung->sdt) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" name="diachi" class="form-control" value="<?= htmlspecialchars($nguoidung->diachi) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ảnh đại diện (tùy chọn)</label>
                        <input type="file" name="avatar" accept="image/*" class="form-control">
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?= $baseUrl ?>/User/ThongTin?id=<?= $nguoidung->ma_nd ?>" class="btn btn-outline-secondary">Hủy</a>
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6 mt-3 mt-md-0">
        <div class="card shadow-sm text-center p-3">
            <?php $avatar = $nguoidung->hinh ? ($baseUrl . '/assets/images/anhnd/' . $nguoidung->hinh) : ($baseUrl . '/assets/images/anhnd/default.png'); ?>
            <img src="<?= htmlspecialchars($avatar) ?>" alt="Avatar" class="rounded-circle mb-3 m-auto" style="width:140px;height:140px;object-fit:cover;">
            <h5 class="mb-1"><?= htmlspecialchars($nguoidung->tennd) ?></h5>
            <p class="text-muted small mb-0"><?= htmlspecialchars($nguoidung->email) ?></p>
        </div>
    </div>
</div>
