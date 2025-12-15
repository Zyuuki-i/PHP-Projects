<?php
	$baseUrl = $GLOBALS['baseUrl'] ?? '';
	if (empty($_SESSION['user'])) {
		header('Location: ' . $baseUrl . '/');
		exit;
	}
?>

<div class="row">
	<div class="col-12">
		<h3 class="mb-4">Chi tiết đơn hàng</h3>
	</div>

	<div class="col-md-6">
		<div class="card mb-3">
			<div class="card-body">
				<h5 class="card-title">Thông tin đơn hàng</h5>
				<p class="mb-2"><strong>Mã đơn:</strong> <?= htmlspecialchars($donhang->ma_ddh) ?></p>
				<p class="mb-2"><strong>Ngày đặt:</strong> <?= htmlspecialchars($donhang->ngaydat) ?></p>
				<p class="mb-2"><strong>Trạng thái:</strong> <?= htmlspecialchars($donhang->trangthai ?: $donhang->tt_thanhtoan) ?></p>
				<p class="mb-1"><strong>Địa chỉ giao hàng:</strong> <?= htmlspecialchars($donhang->diachi ?: '-') ?></p>
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="card mb-3">
			<div class="card-body text-end">
				<h5 class="card-title">Tổng cộng</h5>
				<div class="display-6 fw-bold text-danger"><?= number_format($total ?? 0, 0, ',', '.') ?> đ</div>
				<div class="text-muted">(Đã bao gồm VAT nếu có)</div>
				<div>
					<form method="post" action="<?= $baseUrl ?>/DonDatHang/HuyDon">
						<input type="hidden" name="ma_ddh" value="<?= htmlspecialchars($donhang->ma_ddh) ?>">
						<?php if ($donhang->trangthai !== 'Hoàn thành' && $donhang->trangthai !== 'Đã hủy'): ?>
							<button type="submit" class="btn btn-danger mt-3" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?');">Hủy đơn</button>
						<?php endif; ?>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h5 class="card-title mb-3">Sản phẩm</h5>
				<?php if (empty($items)): ?>
					<div class="text-muted">Không có sản phẩm trong đơn này.</div>
				<?php else: ?>
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th>Ảnh</th>
									<th>Sản phẩm</th>
									<th class="text-center">Số lượng</th>
									<th class="text-end">Đơn giá</th>
									<th class="text-end">Thành tiền</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($items as $it):
									$p = $it['product'];
									$img = $it['image'];
									$imgUrl = $img ? ($baseUrl . '/assets/images/anhsp/' . trim($p->ma_sp) . '/' . $img) : ($baseUrl . '/assets/images/anhsp/default.png');
								?>
									<tr>
										<td style="width:80px;"><img src="<?= htmlspecialchars($imgUrl) ?>" alt="<?= htmlspecialchars($p->tensp) ?>" style="width:64px;height:64px;object-fit:cover;border-radius:6px;"></td>
										<td><?= htmlspecialchars($p->tensp) ?></td>
										<td class="text-center"><?= htmlspecialchars($it['soluong']) ?></td>
										<td class="text-end"><?= number_format($it['gia'], 0, ',', '.') ?> đ</td>
										<td class="text-end"><?= number_format($it['thanhtien'], 0, ',', '.') ?> đ</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<div class="col-12 text-end mt-3 mb-5">
		<a href="<?= $baseUrl ?>/User/LichSuDatHang?id=<?= $_SESSION['user']['ma_nd'] ?>" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Quay lại lịch sử</a>
	</div>
</div>

