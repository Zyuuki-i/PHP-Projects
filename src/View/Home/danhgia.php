<?php
    if (!defined('APP_RUNNING')) {
    header('Location: /home');
    exit;
    }
    $max = 10;
?>
<div class="text-center mt-5 mb-5">
    <h2 class="section-title text-uppercase">Khách hàng nói gì về chúng tôi</h2>
    <p class="text-muted">Những đánh giá chân thực từ khách hàng đã trải nghiệm sản phẩm tại Zyuuki Music</p>
</div>
<?php foreach ($danhgias as $item): ?>
    <?php if($item->sosao >= 4) {
        if($max-- <= 0) {
            break;
        }
        ?>
        <section class="mb-4 bg-light p-3 border-start border-primary border-3 rounded-2 row">
            <div class="col-sm-4 d-flex align-items-center mb-2">
                <?php
                    $url = "../assets/images/anhnd/";
                    foreach($nguoidungs as $nd)
                    {
                        if($nd->ma_nd == $item->ma_nd)
                        {
                            $url .= $nd->hinh;
                            echo '<img src="' . $url . '" alt="Avatar" class="rounded-circle me-3" style="width:50px; height:50px; object-fit:cover;">';
                            echo '<h5 class="mb-0">' . $nd->tennd . '</h5>';
                        }
                    }
                ?>
            </div>
            <div class="col-sm-4 ">
                <p><?php echo $item->noidung; ?></p>
                <div>
                    <?php for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $item->sosao)
                        {
                            echo '<i class="bi bi-star-fill text-warning"></i>';
                        }
                        else
                        {
                            echo '<i class="bi bi-star accept-policy text-warning"></i>';
                        }
                    }
                    ?>
                </div>
            </div>
        </section>
    <?php } ?>
<?php endforeach; ?>
<div style="height: 100px;"></div>