<?php
namespace App\Controller;
require_once __DIR__ . '/../../include/function.php';
global $pdo;
$pdo = require __DIR__ . '/../../config/config.php';

use App\Model\DanhGia;
use App\Model\Product;
use App\Model\Hinh;
use App\Model\NguoiDung;
use App\Model\NhaSanXuat;

class SanPhamController
{
    public function index()
    {
        $loaiID = $_GET['maloai'] ?? null;
        $nsxID = $_GET['mansx'] ?? null;
        $keyword = $_GET['keyword'] ?? null;
        if (session_status() === PHP_SESSION_NONE) session_start();
        $_SESSION['loaiID'] = $loaiID;
        $_SESSION['nsxID'] = $nsxID;
        $_SESSION['keyword'] = $keyword;
        global $pdo;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $hienthi = 8;
        $sp = [];
        if ($loaiID != null && $loaiID != '') {
            $sp = Product::getByLoai($pdo, $loaiID);
        } elseif ($nsxID != null && $nsxID != '') {
            $sp = Product::getByNSX($pdo, $nsxID);
        } elseif ($keyword != null && $keyword != '') {
            $sp = Product::search($pdo, $keyword);
        } else {
            $sp = Product::getAll($pdo);
        }

        $tongsp = count($sp);
        $tongtrang = $tongsp > 0 ? (int)ceil($tongsp / $hienthi) : 1;
        if ($page > $tongtrang) $page = $tongtrang;
        $offset = ($page - 1) * $hienthi;
        $products = Product::getPage($pdo, $hienthi, $offset, $sp);
        $hinhList = Hinh::getAll($pdo);

        $content = view('sanpham.php', [
            'products' => $products,
            'hinhList' => $hinhList,
            'tranghientai' => $page,
            'tongtrang' => $tongtrang,
            'hienthi' => $hienthi,
        ], 'SanPham');

        $contentZ = render('sanpham_layout.php', ['content' => $content]);

        return render('main_layout.php', ['content'=> $contentZ]);
    }

    public function chiTietSP($id)
    {
        global $pdo;
        $sp = Product::getById($pdo, $id);
        if ($sp == null) {
            $content = render('sanpham_layout.php', ['content' => 'Sản phẩm không tồn tại.']);
            return render('main_layout.php', ['content' => $content]);
        }
        $dsHinh = Hinh::getByProductId($pdo, $id);
        $dsdg = DanhGia::getByProductId($pdo, $id);
        $relatedProducts = Product::getRelatedProducts($pdo, $sp->ma_loai, $sp->ma_sp, 4);
        $dsnx = NhaSanXuat::getAll($pdo);
        $dskh = NguoiDung::getAll($pdo);
        $relatedHinh = [];
        foreach ($relatedProducts as $rp) {
            $imgs = Hinh::getByProductId($pdo, $rp->ma_sp);
            $relatedHinh[$rp->ma_sp] = $imgs;
        }
        $content = view('chitiet.php', [
            'sp' => $sp,
            'dsHinh' => $dsHinh,
            'dsdg' => $dsdg,
            'relatedProducts' => $relatedProducts,
            'relatedHinh' => $relatedHinh,
            'dsnx' => $dsnx,
            'dskh' => $dskh,
        ], 'SanPham');
        $contentZ = render('sanpham_layout.php', ['content' => $content]);
        return render('main_layout.php', ['content'=> $contentZ]);
    }
}