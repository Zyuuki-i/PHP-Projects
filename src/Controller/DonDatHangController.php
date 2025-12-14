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
    public function index(){
        if (session_status() === PHP_SESSION_NONE) session_start();
        $baseUrl = $GLOBALS['baseUrl'] ?? '';
        if (empty($_SESSION['user'])) {
            header('Location: ' . $baseUrl . '/');
            exit;
        }

        global $pdo;
        $ma_ddh = $_GET['id'] ?? '';
        if (!$ma_ddh) {
            header('Location: ' . $baseUrl . '/');
            exit;
        }

        $donhang = DonDatHang::getById($pdo, $ma_ddh);
        if (!$donhang) {
            header('Location: ' . $baseUrl . '/');
            exit;
        }

        $items = [];
        $total = 0;
        try {
            $sql = 'SELECT ma_sp, soluong, gia, thanhtien FROM chi_tiet_don_dat_hang WHERE ma_ddh = :ma_ddh';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['ma_ddh' => $ma_ddh]);
            while ($r = $stmt->fetch()) {
                $prod = Product::getById($pdo, $r['ma_sp']);
                $images = Hinh::getByProductId($pdo, $r['ma_sp']);
                $img = $images[0]->tenhinh ?? null;
                $subtotal = $r['thanhtien'] ?? ($r['soluong'] * $r['gia']);
                $items[] = [
                    'product' => $prod,
                    'ma_sp' => $r['ma_sp'],
                    'soluong' => (int)($r['soluong'] ?? 0),
                    'gia' => (float)($r['gia'] ?? 0),
                    'thanhtien' => (float)$subtotal,
                    'image' => $img,
                ];
                $total += (float)$subtotal;
            }
        } catch (\Exception $e) {
            $items = [];
        }

        $content = $this->view('chitiet.php', [
            'donhang' => $donhang,
            'items' => $items,
            'total' => $total,
        ]);

        return $this->render('main_layout.php', ['content' => $content]);
    }

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
            if($available <= 0){
                $_SESSION['MessageError_GioHang'] = 'Sản phẩm hiện đã hết hàng.';
            }
            else{
                $_SESSION['MessageError_GioHang'] = 'Số lượng yêu cầu vượt quá tồn kho.';
            }
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
        $_SESSION['SoLuongGioHang'] = count($cart['items']);
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
             if($available <= 0){
                $_SESSION['MessageError_GioHang'] = 'Sản phẩm hiện đã hết hàng.';
            }
            else{
                $_SESSION['MessageError_GioHang'] = 'Số lượng yêu cầu vượt quá tồn kho.';
            }
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
        $_SESSION['SoLuongGioHang'] = count($cart['items']);
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
        $_SESSION['SoLuongGioHang'] = count($_SESSION['dondathang']['items']);
        header('Location: ' . $referer);
        exit;
    }

    public function ClearCart()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $referer = $_SERVER['HTTP_REFERER'] ?? ($GLOBALS['baseUrl'] ?? '/');
        unset($_SESSION['dondathang']);
        unset($_SESSION['SoLuongGioHang']);
        header('Location: ' . $referer);
        exit;
    }

    public function ThanhToanCart()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $pdo = require __DIR__ . '/../../config/config.php';
        $baseUrl = $GLOBALS['baseUrl'] ?? '';
        $user = $_SESSION['user'] ?? null;
        if (!$user) {
            header('Location: ' . $baseUrl . '/');
            exit;
        }

        $cart = $_SESSION['dondathang'] ?? ['items' => []];
        $items = $cart['items'] ?? [];
        if (empty($items)) {
            $_SESSION['MessageError_User'] = 'Giỏ hàng trống.';
            header('Location: ' . ($baseUrl ?: '/'));
            exit;
        }

        $paymentMethod = $_POST['payment_method'] ?? 'cod';

        $total = 0;
        foreach ($items as $it) {
            if ($it instanceof ChiTietDonDatHang) {
                $total += ((int)($it->soluong ?? 0)) * ((float)($it->gia ?? 0));
            } elseif (is_array($it)) {
                $total += ((int)($it['soluong'] ?? 0)) * ((float)($it['giasp'] ?? 0));
            }
        }

        try {
            $stmt = $pdo->query('SELECT MAX(ma_ddh) AS m FROM don_dat_hang');
            $row = $stmt->fetch();
            $next = ($row && $row['m']) ? ((int)$row['m'] + 1) : 1;

            $nguoi = NguoiDung::getByEmail($pdo, $user['email']);
            $diachi = $nguoi->diachi ?? '';
            $ngaydat = date('Y-m-d H:i:s');

            $tt_thanhtoan = ($paymentMethod === 'vnpay') ? 'Đã thanh toán' : 'Chưa thanh toán';
            $trangthai = ($paymentMethod === 'vnpay') ? 'Đã xác nhận' : 'Đang xử lý';

            $ins = $pdo->prepare('INSERT INTO don_dat_hang (ma_ddh, ma_nd, ma_nv, diachi, ngaydat, tongtien, trangthai, tt_thanhtoan) VALUES (:ma_ddh, :ma_nd, :ma_nv, :diachi, :ngaydat, :tongtien, :trangthai, :tt_thanhtoan)');
            $ma_nv = ($paymentMethod === 'vnpay') ? 1 : null; 
            $ins->execute([
                'ma_ddh' => $next,
                'ma_nd' => $user['ma_nd'],
                'ma_nv' => $ma_nv,
                'diachi' => $diachi,
                'ngaydat' => $ngaydat,
                'tongtien' => $total,
                'trangthai' => $trangthai,
                'tt_thanhtoan' => $tt_thanhtoan,
            ]);

            $stmtItem = $pdo->prepare('INSERT INTO chi_tiet_don_dat_hang (ma_ddh, ma_sp, soluong, gia, thanhtien) VALUES (:ma_ddh, :ma_sp, :soluong, :gia, :thanhtien)');
            foreach ($items as $it) {
                if ($it instanceof ChiTietDonDatHang) {
                    $ma_sp = $it->ma_sp;
                    $soluong = (int)($it->soluong ?? 0);
                    $gia = (float)($it->gia ?? 0);
                    $thanhtien = $it->thanhtien ?? ($soluong * $gia);
                } elseif (is_array($it)) {
                    $ma_sp = $it['ma_sp'] ?? null;
                    $soluong = (int)($it['soluong'] ?? 0);
                    $gia = (float)($it['giasp'] ?? 0);
                    $thanhtien = $it['thanhtien'] ?? ($soluong * $gia);
                } else {
                    continue;
                }
                if ($ma_sp) {
                    $stmtItem->execute([
                        'ma_ddh' => $next,
                        'ma_sp' => $ma_sp,
                        'soluong' => $soluong,
                        'gia' => $gia,
                        'thanhtien' => $thanhtien,
                    ]);

                    try {
                        $u = $pdo->prepare('UPDATE san_pham SET soluongton = GREATEST(soluongton - :qty, 0) WHERE ma_sp = :ma_sp');
                        $u->execute(['qty' => $soluong, 'ma_sp' => $ma_sp]);
                    } catch (\Exception $ex) {
                    }
                }
            }

            unset($_SESSION['dondathang']);
            $_SESSION['SoLuongGioHang'] = 0;

            $_SESSION['MessageSuccess_User'] = 'Đặt hàng thành công.';
            $redirectBase = rtrim($baseUrl, '/');
            $redirect = ($redirectBase === '') ? '/DonDatHang/ChiTiet?id=' . $next : $redirectBase . '/DonDatHang/ChiTiet?id=' . $next;
            header('Location: ' . $redirect);
            exit;

        } catch (\Exception $e) {
            $_SESSION['MessageError_User'] = 'Không thể tạo đơn hàng.';
            header('Location: ' . ($baseUrl ?: '/'));
            exit;
        }
    }

    public function thanhToan()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $pdo = require __DIR__ . '/../../config/config.php';
        $user = $_SESSION['user'] ?? null;
        $baseUrl = $GLOBALS['baseUrl'] ?? '';
        if (!$user) {
            header('Location: ' . $baseUrl . '/');
            exit;
        }

        $ma_ddh = $_POST['ma_ddh'] ?? null;
        $method = $_POST['payment_method'] ?? 'cod';
        if (!$ma_ddh) {
            header('Location: ' . $baseUrl . '/');
            exit;
        }

        // Load order and verify ownership
        $order = DonDatHang::getById($pdo, $ma_ddh);
        if (!$order) {
            $_SESSION['MessageError_User'] = 'Đơn hàng không tồn tại.';
            header('Location: ' . $baseUrl . '/');
            exit;
        }
        if ($order->ma_nd != $user['ma_nd']) {
            $_SESSION['MessageError_User'] = 'Bạn không có quyền thao tác trên đơn này.';
            header('Location: ' . $baseUrl . '/');
            exit;
        }

        // Assign staff 01 and set payment flag
        $ma_nv = 1; // temporary
        $tt_thanhtoan = ($method === 'vnpay') ? 'Đã thanh toán' : 'Chưa thanh toán';
        $trangthai = ($method === 'vnpay') ? 'Đã xác nhận' : $order->trangthai;

        $ok = DonDatHang::updatePayment($pdo, $ma_ddh, $ma_nv, $tt_thanhtoan, $trangthai);
        if ($ok) {
            $_SESSION['MessageSuccess_User'] = 'Cập nhật trạng thái thanh toán thành công.';
        } else {
            $_SESSION['MessageError_User'] = 'Không thể cập nhật trạng thái thanh toán.';
        }

        $redirectBase = rtrim($baseUrl, '/');
        $redirect = ($redirectBase === '') ? '/DonDatHang/ChiTiet?id=' . $ma_ddh : $redirectBase . '/DonDatHang/ChiTiet?id=' . $ma_ddh;
        header('Location: ' . $redirect);
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
