<?php

session_start();

define('APP_RUNNING', true);

require_once __DIR__ . '/vendor/autoload.php';

use App\Router;
use App\Controller\HomeController;
use App\Controller\SanPhamController;

$router = new Router();

global $baseUrl;
$parts = explode('/', trim($_SERVER['SCRIPT_NAME'], '/'));
$base = $parts[0];

if ($base === '' || strpos($base, '.php') !== false) {
    $baseUrl = '';
} else {
    $baseUrl = '/' . $base;
}
//HOME ROUTES
$router->add('GET', "$baseUrl/", function ()  {
    $controller = new HomeController();
    return $controller->index();
});

$router->add('GET', "$baseUrl/GioiThieu", function ()  {
    $controller = new HomeController();
    return $controller->gioiThieu();
});

$router->add('GET', "$baseUrl/DanhGia", function ()  {
    $controller = new HomeController();
    return $controller->danhGia();
});

//SAN PHAM ROUTES
$router->add('GET', "$baseUrl/SanPham", function ()  {
    $controller = new SanPhamController();
    return $controller->index();
});

$router->add("GET","$baseUrl/SanPham/ChiTiet", function () {
    $controller = new SanPhamController();
    $id = $_GET['id'] ?? null; 
    if ($id) {
        return $controller->chiTietSP($id);
    } else {
        return $controller->index();;
    }
});

$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['REQUEST_URI'] ?? '/';
$path = parse_url($path, PHP_URL_PATH);

echo $router->dispatch($method, $path);