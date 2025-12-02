<?php

session_start();

define('APP_RUNNING', true);

require_once __DIR__ . '/vendor/autoload.php';

use App\Router;
use App\Controller\HomeController;

$router = new Router();

global $baseUrl;
$baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');

$router->add('GET', "$baseUrl/home", function ()  {
    $controller = new HomeController();
    return $controller->index();
});


$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['REQUEST_URI'] ?? '/';
$path = parse_url($path, PHP_URL_PATH);

echo $router->dispatch($method, $path);