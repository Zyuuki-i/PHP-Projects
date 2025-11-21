<?php
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

$db = [
    'mysql' => [
        'host' => $_ENV['MYSQL_HOST'] ?? '',
        'dbname' => $_ENV['MYSQL_DB'] ?? '',
        'user' => $_ENV['MYSQL_USER'] ?? '', 
        'pass' => $_ENV['MYSQL_PASS'] ?? '',
        'charset' => 'utf8mb4',
    ],
    'app' => [
        'base_url' => $_ENV['BASE_URL'] ?? '',
    ],
];
$dsn = "mysql:host={$db['mysql']['host']};dbname={$db['mysql']['dbname']};charset={$db['mysql']['charset']}";

try {
    return $pdo = new PDO($dsn, $db['mysql']['user'], $db['mysql']['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

} catch (PDOException $e) {
    echo "Lỗi kết nối: " . $e->getMessage() . "\n";
}