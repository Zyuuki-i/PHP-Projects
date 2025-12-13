<?php
namespace App\Controller;

use App\Model\Product;
use App\Model\Hinh;

class SanPhamController
{
    public function index()
    {
        $pdo = require __DIR__ . '/../../config/config.php';
        $products = Product::getAll($pdo);
        $hinhList = Hinh::getAll($pdo);

        $content = $this->view('sanpham.php', ['products' => $products, 'hinhList' => $hinhList]);

        $contentZ = $this->render('sanpham_layout.php', ['content' => $content]);

        return $this->render('main_layout.php', ['content'=> $contentZ]);
    }

    public function chiTietSP($id)
    {
        echo 'Chi tiết sản phẩm có mã: ' . htmlspecialchars($id);
    }

    private function view($view, $data = [])
    {
        extract($data);
        ob_start();
        include __DIR__ . '/../View/SanPham/' . $view;
        return ob_get_clean();
    }

    private function render($template, $data = [])
    {
        extract($data);
        ob_start();
        include __DIR__ . '/../../templates/' . $template;
        return ob_get_clean();
    }
}