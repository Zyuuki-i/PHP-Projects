<?php
if (!isset($_SESSION['admin'])) {
    header('Location: ../../index.php');
    exit();
}

$pdo = require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Model\DonDatHang;

$type = isset($_GET['type']) ? preg_replace('/[^a-z0-9_\-]/i', '', $_GET['type']) : 'all';
$month = isset($_GET['month']) ? (int) $_GET['month'] : 0;
$year = isset($_GET['year']) ? (int) $_GET['year'] : (int) date('Y');

$namHienTai = (int) date('Y');
$years = range(2023, $namHienTai);
$months = [0=>'Tất cả',1=>'Tháng 1',2=>'Tháng 2',3=>'Tháng 3',4=>'Tháng 4',5=>'Tháng 5',6=>'Tháng 6',7=>'Tháng 7',8=>'Tháng 8',9=>'Tháng 9',10=>'Tháng 10',11=>'Tháng 11',12=>'Tháng 12'];

$all = DonDatHang::getAll($pdo);
$list = [];
foreach ($all as $it) {
	$flag = false;
	switch ($type) {
		case 'dangxuly':
			$flag = (stripos($it->trangthai, 'Đang xử lý') !== false) || ($it->trangthai === 'Đang xử lý');
			break;
		case 'daxuly':
			$flag = (stripos($it->trangthai, 'Đã xử lý') !== false) || ($it->trangthai === 'Đã xử lý');
			break;
		case 'hoanthanh':
			$flag = (trim($it->trangthai) === 'Hoàn thành');
			break;
		case 'huy':
			$flag = (stripos($it->trangthai, 'hủy') !== false) || (trim($it->trangthai) === 'Đã hủy');
			break;
		case 'all':
		default:
			$flag = true;
			break;
	}
	if (!$flag) continue;

	if (!isset($it->ngaydat)) continue;
	$ts = strtotime($it->ngaydat);
	if ($ts === false) continue;
	$y = (int) date('Y', $ts);
	$m = (int) date('n', $ts);
	if ($year && $y !== $year) continue;
	if ($month && $m !== $month) continue;

	$list[] = $it;
}

usort($list, function($a, $b){
	return strtotime($b->ngaydat) <=> strtotime($a->ngaydat);
});
?>

<div class="row">
	<div class="col-12">
		<h2 class="text-center my-3 fw-bold text-uppercase">Quản lý Đơn đặt hàng</h2>

		<form action="index.php" method="get" class="row g-2 align-items-end mb-3">
			<input type="hidden" name="mod" value="dondathang">
			<div class="col-auto">
				<label for="type" class="form-label">Loại</label>
				<select name="type" id="type" class="form-select">
					<option value="all" <?= $type === 'all' ? 'selected' : '' ?>>Tất cả</option>
					<option value="dangxuly" <?= $type === 'dangxuly' ? 'selected' : '' ?>>Đơn mới / Đang xử lý</option>
					<option value="daxuly" <?= $type === 'daxuly' ? 'selected' : '' ?>>Đã xử lý</option>
					<option value="hoanthanh" <?= $type === 'hoanthanh' ? 'selected' : '' ?>>Hoàn thành</option>
					<option value="huy" <?= $type === 'huy' ? 'selected' : '' ?>>Đã hủy</option>
				</select>
			</div>
			<div class="col-auto">
				<label for="month" class="form-label">Tháng</label>
				<select name="month" id="month" class="form-select">
					<?php foreach ($months as $key => $label): ?>
						<option value="<?= $key ?>" <?= $key === $month ? 'selected' : '' ?>><?= $label ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="col-auto">
				<label for="year" class="form-label">Năm</label>
				<select name="year" id="year" class="form-select">
					<?php foreach ($years as $y): ?>
						<option value="<?= $y ?>" <?= $y === $year ? 'selected' : '' ?>><?= $y ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="col-auto">
				<button type="submit" class="btn btn-primary">Lọc</button>
			</div>
		</form>

		<table class="table table-striped table-bdhed">
			<thead>
				<tr>
					<th>ID</th>
					<th>Ngày đặt</th>
					<th>Người đặt</th>
					<th>Trạng thái</th>
					<th>Thanh toán</th>
					<th>Tổng tiền</th>
					<th>Hành động</th>
				</tr>
			</thead>
			<tbody>
				<?php if (empty($list)): ?>
					<tr><td colspan="7" class="text-center">Không tìm thấy đơn nào.</td></tr>
				<?php else: ?>
					<?php foreach ($list as $dh): ?>
						<tr>
							<td><?= htmlspecialchars('#' . $dh->ma_ddh) ?></td>
							<td style="width: 110px"><?= htmlspecialchars($dh->ngaydat) ?></td>
							<td><?= htmlspecialchars($pdo->query("SELECT tennd FROM nguoi_dung WHERE ma_nd = " . $dh->ma_nd)->fetch(PDO::FETCH_ASSOC)['tennd']) ?></td>
							<td><?= htmlspecialchars($dh->trangthai) ?></td>
							<td><?= htmlspecialchars($dh->tt_thanhtoan) ?></td>
							<td><?= number_format($dh->tongtien, 0, ',', '.') ?></td>
							<td class="text-center align-content-center">
                                <?php if($dh->trangthai === 'Đang xử lý'): ?>
                                    <a href="index.php?mod=dondathang&action=xuly&ma_ddh=<?= $dh->ma_ddh ?>" class="btn btn-sm btn-warning w-100">Xác nhận</a>
                                <?php elseif($dh->trangthai === 'Đã xử lý'): ?>
                                    <a href="index.php?mod=dondathang&action=hoanthanh&ma_ddh=<?= $dh->ma_ddh ?>" class="btn btn-sm btn-success w-100">Hoàn thành</a>
                                <?php endif; ?>
                            </td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>