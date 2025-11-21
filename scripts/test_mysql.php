<?php
$config = require __DIR__ . '/../config/config.php';

if($config != null)
    echo "Kết nối thành công!";

else{
    echo "Lỗi kết nối: \n";
}
?>