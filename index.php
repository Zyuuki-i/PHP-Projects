<?php

session_start();

define('APP_RUNNING', true);

require_once __DIR__ . '/vendor/autoload.php';

use App\Router;
use App\Controller\HomeController;

$router = new Router();

$router->add('GET', '/index', function () {
    header("Location: /home");
    exit;
});

$router->add('GET', '/home', function () {
    $controller = new HomeController();
    return $controller->index();
});


$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['REQUEST_URI'] ?? '/';
$path = parse_url($path, PHP_URL_PATH);

echo $router->dispatch($method, $path);