<?php
return [
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
