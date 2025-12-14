<?php
namespace App\Controller;

use App\Model\Product;
use App\Model\Hinh;
use App\Model\DonDatHang;
use App\Model\NguoiDung;
require_once __DIR__ . '/../../include/function.php';
global $pdo;
$pdo = require __DIR__ . '/../../config/config.php';
use App\Model\ChiTietDonDatHang;

class DonDatHangController
{
    public function gioHang()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $cart = $_SESSION['dondathang'] ?? ['items' => []];
        $items = $cart['items'] ?? [];

        $totalQty = 0;
        $totalPrice = 0;
        foreach ($items as $it) {
            if ($it instanceof ChiTietDonDatHang) {
                $qty = (int)($it->soluong ?? 0);
                $price = (float)($it->gia ?? 0);
                $totalQty += $qty;
                $totalPrice += $qty * $price;
            } elseif (is_array($it)) {
                $qty = (int)($it['soluong'] ?? 0);
                $price = (float)($it['giasp'] ?? 0);
                $totalQty += $qty;
                $totalPrice += $qty * $price;
            }
        }

        $content = $this->view('giohang.php', [
            'items' => $items,
            'totalQty' => $totalQty,
            'totalPrice' => $totalPrice,
        ]);

        return $this->render('main_layout.php', ['content' => $content]);
    }

    public function ThemVaoGio()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        global $pdo;
        $id = $_POST['id'] ?? $_GET['id'] ?? null;
        $soluong = isset($_POST['soluong']) ? (int)$_POST['soluong'] : (isset($_GET['soluong']) ? (int)$_GET['soluong'] : 1);
        $referer = $_SERVER['HTTP_REFERER'] ?? ($GLOBALS['baseUrl'] ?? '/');

        if (!$id) {
            header('Location: ' . $referer);
            exit;
        }

        $product = Product::getById($pdo, $id);
        if (!$product) {
            header('Location: ' . $referer);
            exit;
        }

        $cart = &$_SESSION['dondathang'];
        if (!isset($cart) || !is_array($cart)) $cart = ['items' => []];

        $existingQty = 0;
        if (isset($cart['items'][$product->ma_sp])) {
            $existing = $cart['items'][$product->ma_sp];
            if ($existing instanceof ChiTietDonDatHang) {
                $existingQty = (int)($existing->soluong ?? 0);
            } elseif (is_array($existing)) {
                $existingQty = (int)($existing['soluong'] ?? 0);
            }
        }

        $requested = max(1, $soluong);
        $available = (int)($product->soluongton ?? 0);
        if ($existingQty + $requested > $available) {
            $_SESSION['MessageError_GioHang'] = 'Số lượng yêu cầu vượt quá tồn kho.';
            header('Location: ' . $referer);
            exit;
        }

        if (!isset($cart['items'][$product->ma_sp])) {
            $ct = new ChiTietDonDatHang(null, $product->ma_sp, $requested, $product->giasp, $requested * $product->giasp);
            $cart['items'][$product->ma_sp] = $ct;
        } else {
            $existing = $cart['items'][$product->ma_sp];
            if ($existing instanceof ChiTietDonDatHang) {
                $existing->soluong += $requested;
                $existing->thanhtien = $existing->soluong * $existing->gia;
            } elseif (is_array($existing)) {
                $existing['soluong'] += $requested;
                $existing['thanhtien'] = $existing['soluong'] * $existing['giasp'];
                $cart['items'][$product->ma_sp] = $existing;
            }
        }

        $_SESSION['MessageSuccess_GioHang'] = 'Đã thêm sản phẩm vào giỏ hàng.';
        header('Location: ' . $referer);
        exit;
    }

    public function MuaNgay()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        global $pdo;
        $id = $_POST['id'] ?? $_GET['id'] ?? null;
        $soluong = isset($_POST['soluong']) ? (int)$_POST['soluong'] : (isset($_GET['soluong']) ? (int)$_GET['soluong'] : 1);
        $referer = $_SERVER['HTTP_REFERER'] ?? ($GLOBALS['baseUrl'] ?? '/');

        if (!$id) {
            header('Location: ' . $referer);
            exit;
        }

        $product = Product::getById($pdo, $id);
        if (!$product) {
            header('Location: ' . $referer);
            exit;
        }

        $cart = &$_SESSION['dondathang'];
        if (!isset($cart) || !is_array($cart)) $cart = ['items' => []];

        $increment = max(1, $soluong);

        $existingQty = 0;
        if (isset($cart['items'][$product->ma_sp])) {
            $existing = $cart['items'][$product->ma_sp];
            if ($existing instanceof ChiTietDonDatHang) {
                $existingQty = (int)($existing->soluong ?? 0);
            } elseif (is_array($existing)) {
                $existingQty = (int)($existing['soluong'] ?? 0);
            }
        }

        $available = (int)($product->soluongton ?? 0);
        if ($existingQty + $increment > $available) {
            $_SESSION['MessageError_GioHang'] = 'Số lượng yêu cầu vượt quá tồn kho.';
            header('Location: ' . $referer);
            exit;
        }

        if (!isset($cart['items'][$product->ma_sp])) {
            $ct = new ChiTietDonDatHang(null, $product->ma_sp, $increment, $product->giasp, $increment * $product->giasp);
            $cart['items'][$product->ma_sp] = $ct;
        } else {
            $existing = $cart['items'][$product->ma_sp];
            if ($existing instanceof ChiTietDonDatHang) {
                $existing->soluong += $increment;
                $existing->thanhtien = $existing->soluong * $existing->gia;
            } elseif (is_array($existing)) {
                $existing['soluong'] += $increment;
                $existing['thanhtien'] = $existing['soluong'] * $existing['giasp'];
                $cart['items'][$product->ma_sp] = $existing;
            }
        }

        $baseUrl = $GLOBALS['baseUrl'] ?? '';
        header('Location: ' . ($baseUrl ?: '') . '/DonDatHang/GioHang');
        exit;
    }

    public function XoaItem()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $ma_sp = $_POST['ma_sp'] ?? $_GET['ma_sp'] ?? null;
        $referer = $_SERVER['HTTP_REFERER'] ?? ($GLOBALS['baseUrl'] ?? '/');
        if ($ma_sp && isset($_SESSION['dondathang']['items'][$ma_sp])) {
            unset($_SESSION['dondathang']['items'][$ma_sp]);
        }
        header('Location: ' . $referer);
        exit;
    }

    public function ClearCart()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $referer = $_SERVER['HTTP_REFERER'] ?? ($GLOBALS['baseUrl'] ?? '/');
        unset($_SESSION['dondathang']);
        header('Location: ' . $referer);
        exit;
    }

    private function view($view, $data = [])
    {
        extract($data);
        ob_start();
        include __DIR__ . '/../View/DonDatHang/' . $view;
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
