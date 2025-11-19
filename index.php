<?php
    $config = require __DIR__ . '/../scripts/test_mysql.php';
    if(isset($isConnected) && $isConnected) {
        require __DIR__ . '/../templates/home.php';
        
    } else {
        echo "Kết nối MySQL thất bại từ index.php\n";
    }
?>
