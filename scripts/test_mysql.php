<?php
$config = require __DIR__ . '/../config/config.php';
$db = $config['mysql'];

$dsn = "mysql:host={$db['host']};dbname={$db['database']};charset={$db['charset']}";
global $isConnected;
$isConnected = false;
try {
    $pdo = new PDO($dsn, $db['user'], $db['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $isConnected = true;
} catch (PDOException $e) {
    echo "Lỗi kết nối: " . $e->getMessage() . "\n";
}

?>