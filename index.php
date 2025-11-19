<?php
    $config = require __DIR__ . '/../scripts/test_mysql.php';
    if(isset($isConnected) && $isConnected) {
        echo "Kết nối MySQL thành công từ index.php\n";
    } else {
        echo "Kết nối MySQL thất bại từ index.php\n";
    }
?>
