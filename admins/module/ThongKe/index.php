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

$pdo = require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Model\DonDatHang;

$namHienTai = (int) date('Y');
$years = range(2023, $namHienTai);
$selectedYear = isset($_GET['year']) ? (int) $_GET['year'] : $namHienTai;

$ddh = DonDatHang::getAll($pdo);
$hienThi = [];
try {
    foreach ($ddh as $item) {
        if (!isset($item->ngaydat) || $item->trangthai !== 'Hoàn thành') continue;
        $ts = strtotime($item->ngaydat);
        if ($ts === false) continue;
        $y = (int) date('Y', $ts);
        if ($y !== $selectedYear) continue;
        $m = (int) date('n', $ts);
        if (!isset($hienThi[$m])) $hienThi[$m] = ['count' => 0, 'total' => 0];
        $hienThi[$m]['count'] += 1;
        $hienThi[$m]['total'] += (float) $item->tongtien;
    }
    ksort($hienThi);
} catch (\Exception $e) {
}
?>
<div class="row">
    <div class="col-md-12">
        <h2 class="text-center my-3 fw-bold text-uppercase">Thống kê doanh thu</h2>

        <form action="index.php" method="get" class="mb-3 row g-2 align-items-center">
            <input type="hidden" name="mod" value="thongke">
            <div class="col-auto">
                <label for="year" class="form-label">Năm</label>
                <select name="year" id="year" class="form-select">
                    <?php foreach ($years as $y): ?>
                        <option value="<?= $y ?>" <?= $y === $selectedYear ? 'selected' : '' ?>><?= $y ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-auto align-self-end">
                <button type="submit" class="btn btn-primary">Lọc</button>
            </div>
        </form>

        <?php
            $thanglst = [1=>'Tháng 1','Tháng 2','Tháng 3','Tháng 4','Tháng 5','Tháng 6','Tháng 7','Tháng 8','Tháng 9','Tháng 10','Tháng 11','Tháng 12'];
            $tongDon = 0;
            $doanhthuthang = 0;
        ?>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tháng</th>
                    <th>Số đơn (Hoàn thành)</th>
                    <th>Doanh thu</th>
                    <th class="text-center">Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($hienThi)): ?>
                    <tr>
                        <td colspan="4" class="text-center py-5">Không có đơn hàng nào được đặt vào năm <?= $selectedYear ?></td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($hienThi as $m => $data):
                        $c = $data['count'];
                        $r = $data['total'];
                        $tongDon += $c;
                        $doanhthuthang += $r;
                    ?>
                    <tr>
                        <td><?= $thanglst[$m] ?></td>
                        <td><?= $c ?></td>
                        <td><?= number_format($r, 0, ',', '.') ?></td>
                        <td class="text-center"><a href="index.php?mod=dondathang&type=hoanthanh&month=<?= $m ?>&year=<?= $selectedYear ?>" class="btn btn-sm btn-info">Xem chi tiết</a></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Tổng (<?= $selectedYear ?>)</th>
                    <th><?= $tongDon ?></th>
                    <th><?= number_format($doanhthuthang, 0, ',', '.') ?></th>
                    <th class="text-center"><a href="index.php?mod=dondathang&type=hoanthanh&month=&year=<?= $selectedYear ?>" class="btn btn-sm btn-info">Xem chi tiết</a></th>
                </tr>
            </tfoot>
        </table>

    </div>
</div>