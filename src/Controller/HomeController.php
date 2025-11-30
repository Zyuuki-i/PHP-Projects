<?php
namespace App\Controller;

use App\Model\Product;
use App\Model\Hinh;

class HomeController
{
    public function index()
    {
        $pdo = require __DIR__ . '/../../config/config.php';
        $products = Product::getAll($pdo);
        $hinhList = Hinh::getAll($pdo);

        if($products != null) {
            $products = array_slice($products, 0, 6);
        }

        $content = $this->render('home.php', ['products' => $products, 'hinhList' => $hinhList]);

        return $this->render('layout.php', ['content' => $content]);
    }

    private function render($template, $data = [])
    {
        extract($data);
        ob_start();
        include __DIR__ . '/../../templates/' . $template;
        return ob_get_clean();
    }
}
