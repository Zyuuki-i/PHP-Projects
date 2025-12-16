<?php
namespace App\Controller;
require_once __DIR__ . '/../../include/function.php';
use App\Model\Product;
use App\Model\NhaSanXuat;
use App\Model\LoaiSanPham;
use App\Model\Hinh;
use App\Model\DanhGia;
use App\Model\NguoiDung;

class HomeController
{
    public function index()
    {
        $pdo = require __DIR__ . '/../../config/config.php';
        $products = Product::getAll($pdo);
        $hinhList = Hinh::getAll($pdo);
        $nsxList = NhaSanXuat::getAll($pdo);
        $loaiList = LoaiSanPham::getAll($pdo);

        if($products != null) {
            $products = array_slice($products, 0, 8);
        }

        $content = view('index.php', ['products' => $products, 'hinhList' => $hinhList, 'nsxList' => $nsxList, 'loaiList' => $loaiList], 'Home');

        return render('main_layout.php', ['content' => $content]);
    }

    public function gioiThieu()
    {
        $content = view('gioithieu.php', [], 'Home');

        return render('main_layout.php', ['content' => $content]);
    }

    public function danhGia()
    {
        $pdo = require __DIR__ . '/../../config/config.php';
        $nguoidungs = NguoiDung::getAll($pdo);
        $danhgias = DanhGia::getAll($pdo);
        $content = view('danhgia.php', ['danhgias' => $danhgias, 'nguoidungs' => $nguoidungs], 'Home');

        return render('main_layout.php', ['content' => $content]);
    }
}
