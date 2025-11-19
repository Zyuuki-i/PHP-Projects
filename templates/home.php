<div class="hero">
    <h2>Chào mừng đến Shop Nhạc Cụ</h2>
    <p>Mua bán các loại nhạc cụ chính hãng, giá tốt nhất thị trường</p>
    <a href="/products" class="btn btn-primary">Mua sắm ngay</a>
</div>

<section class="featured-products">
    <h2>Sản phẩm nổi bật</h2>
    <div class="products">
        <?php if (empty($products)): ?>
            <p>Chưa có sản phẩm nào.</p>
        <?php else: ?>
            <?php foreach (array_slice($products, 0, 6) as $p): ?>
                <article class="product">
                    <div class="product-id">Mã: <?= htmlspecialchars($p->ma_sp) ?></div>
                    <h3><?= htmlspecialchars($p->tensp) ?></h3>
                    <?php if (!empty($p->mota)): ?>
                        <p class="product-desc"><?= htmlspecialchars(substr($p->mota, 0, 80)) ?></p>
                    <?php endif; ?>
                    <p class="product-price">💰 <?= number_format($p->giasp, 0, ',', '.') ?> VND</p>
                    <a href="/product/<?= htmlspecialchars($p->ma_sp) ?>" class="btn btn-small">Chi tiết</a>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>
