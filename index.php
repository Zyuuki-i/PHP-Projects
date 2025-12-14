<?php

define('APP_RUNNING', true);

require_once __DIR__ . '/vendor/autoload.php';
session_start();

use App\Router;
use App\Controller\HomeController;
use App\Controller\SanPhamController;
use App\Controller\UserController;

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

// USER ROUTES
$router->add('POST', "$baseUrl/User/Login", function() {
    $c = new UserController();
    return $c->login();
});

$router->add('POST', "$baseUrl/User/Register", function() {
    $c = new UserController();
    return $c->register();
});

$router->add('GET', "$baseUrl/User/Logout", function() {
    $c = new UserController();
    return $c->logout();
});

// CART ROUTES
$router->add('POST', "$baseUrl/DonDatHang/ThemVaoGio", function() {
    $c = new App\Controller\DonDatHangController();
    return $c->ThemVaoGio();
});

$router->add('POST', "$baseUrl/DonDatHang/MuaNgay", function() {
    $c = new App\Controller\DonDatHangController();
    return $c->MuaNgay();
});

$router->add('GET', "$baseUrl/DonDatHang/GioHang", function() {
    $c = new App\Controller\DonDatHangController();
    return $c->gioHang();
});
// allow POST for form redirects
$router->add('POST', "$baseUrl/DonDatHang/GioHang", function() {
    $c = new App\Controller\DonDatHangController();
    return $c->gioHang();
});

$router->add('POST', "$baseUrl/DonDatHang/XoaItem", function() {
    $c = new App\Controller\DonDatHangController();
    return $c->XoaItem();
});

$router->add('POST', "$baseUrl/DonDatHang/ClearCart", function() {
    $c = new App\Controller\DonDatHangController();
    return $c->ClearCart();
});

$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['REQUEST_URI'] ?? '/';
$path = parse_url($path, PHP_URL_PATH);

echo $router->dispatch($method, $path);