<?php
namespace App\Controller;

use App\Model\NguoiDung;
use App\Model\DonDatHang;
use App\Model\Product;
use App\Model\Hinh;
use App\Model\DanhGia;
require_once __DIR__ . '/../../include/function.php';

global $pdo;
$pdo = require __DIR__ . '/../../config/config.php';

class UserController
{
    public function index()
    {

    }

    public function login()
    {
        $pdo = require __DIR__ . '/../../config/config.php';
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $referer = $_SERVER['HTTP_REFERER'] ?? ($GLOBALS['baseUrl'] ?? '/');

        if ($email === '' || $password === '') {
            $_SESSION['login_error'] = 'Vui lòng nhập email và mật khẩu.';
            header('Location: ' . $referer);
            exit;
        }

        $user = NguoiDung::getByEmail($pdo, $email);
        if (!$user) {
            $_SESSION['login_error'] = 'Email hoặc mật khẩu không đúng.';
            header('Location: ' . $referer);
            exit;
        }

        if ((int)($user->trangthai ?? 0) !== 1) {
            $_SESSION['login_error'] = 'Tài khoản hiện không được phép đăng nhập.';
            header('Location: ' . $referer);
            exit;
        }

        if ($user->matkhau === $password) {
            $_SESSION['user'] = [
                'ma_nd' => $user->ma_nd,
                'tennd' => $user->tennd,
                'email' => $user->email,
            ];
            unset($_SESSION['login_error']);
            header('Location: ' . $referer);
            exit;
        }

        $_SESSION['login_error'] = 'Email hoặc mật khẩu không đúng.';
        header('Location: ' . $referer);
        exit;
    }

    public function register()
    {
        $pdo = require __DIR__ . '/../../config/config.php';
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $referer = $_SERVER['HTTP_REFERER'] ?? ($GLOBALS['baseUrl'] ?? '/');

        if ($name === '' || $email === '' || $password === '') {
            $_SESSION['register_error'] = 'Vui lòng điền đầy đủ thông tin.';
            header('Location: ' . $referer);
            exit;
        }

        if (!preg_match('/^[\p{L}0-9\s\-\.]{2,100}$/u', $name)) {
            $_SESSION['register_error'] = 'Họ tên không hợp lệ.';
            header('Location: ' . $referer);
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['register_error'] = 'Email không đúng định dạng.';
            header('Location: ' . $referer);
            exit;
        }

        if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/', $password)) {
            $_SESSION['register_error'] = 'Mật khẩu phải có ít nhất 6 ký tự, gồm chữ và số.';
            header('Location: ' . $referer);
            exit;
        }

        $existing = NguoiDung::getByEmail($pdo, $email);
        if ($existing) {
            $_SESSION['register_error'] = 'Email đã được sử dụng.';
            header('Location: ' . $referer);
            exit;
        }

        $new = NguoiDung::create($pdo, $name, $password, $email);
        if ($new) {
            $_SESSION['user'] = [
                'ma_nd' => $new->ma_nd,
                'tennd' => $new->tennd,
                'email' => $new->email,
            ];
            unset($_SESSION['register_error']);
            header('Location: ' . $referer);
            exit;
        }

        $_SESSION['register_error'] = 'Không thể tạo tài khoản.';
        header('Location: ' . $referer);
        exit;
    }

    public function logout()
    {
        $referer = $_SERVER['HTTP_REFERER'] ?? ($GLOBALS['baseUrl'] ?? '/');
        unset($_SESSION['user']);
        header('Location: ' . $referer);
        exit;
    }

    public function xemThongTin()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $pdo = require __DIR__ . '/../../config/config.php';
        $user = $_SESSION['user'] ?? null;
        if (!$user) {
            header('Location: ' . ($GLOBALS['baseUrl'] ?? '/') . '/');
            exit;
        }

        $nguoidung = NguoiDung::getByEmail($pdo, $user['email']);
        if (!$nguoidung) {
            header('Location: ' . ($GLOBALS['baseUrl'] ?? '/') . '/');
            exit;
        }
        try {
            $sql = "SELECT DISTINCT c.ma_sp
                    FROM chi_tiet_don_dat_hang c
                    JOIN don_dat_hang d ON c.ma_ddh = d.ma_ddh
                    LEFT JOIN danh_gia g ON g.ma_sp = c.ma_sp AND g.ma_nd = :ma_nd
                    WHERE d.ma_nd = :ma_nd AND g.ma_sp IS NULL";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['ma_nd' => $nguoidung->ma_nd]);
            $dgia = [];
            while ($row = $stmt->fetch()) {
                $prod = Product::getById($pdo, $row['ma_sp']);
                if ($prod) {
                    $images = Hinh::getByProductId($pdo, $prod->ma_sp);
                    $img = $images[0]->tenhinh ?? null;
                    $dgia[] = ['product' => $prod, 'image' => $img];
                }
            }
        } catch (\Exception $e) {
            $dgia = [];
        }

        try {
            $sql = "SELECT DISTINCT c.ma_sp
                    FROM chi_tiet_don_dat_hang c
                    JOIN don_dat_hang d ON c.ma_ddh = d.ma_ddh
                    LEFT JOIN danh_gia g ON g.ma_sp = c.ma_sp AND g.ma_nd = :ma_nd
                    WHERE d.ma_nd = :ma_nd AND g.ma_sp IS NOT NULL";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['ma_nd' => $nguoidung->ma_nd]);
            $dadanhgia = [];
            while ($row = $stmt->fetch()) {
                $prod = Product::getById($pdo, $row['ma_sp']);
                if ($prod) {
                    $images = Hinh::getByProductId($pdo, $prod->ma_sp);
                    $danhg = DanhGia::getByUserAndProduct($pdo, $nguoidung->ma_nd, $prod->ma_sp);
                    $img = $images[0]->tenhinh ?? null;
                    $dadanhgia[] = ['product' => $prod, 'danhgia' => $danhg, 'image' => $img];
                }
            }
        } catch (\Exception $e) {
            $dadanhgia = [];
        }

        $content = view('thongtin.php', ['nguoidung' => $nguoidung, 'canDanhGia' => $dgia, 'daDanhGia' => $dadanhgia], 'User');
        return render('main_layout.php', ['content' => $content]);
    }

    public function edit()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $pdo = require __DIR__ . '/../../config/config.php';
        $user = $_SESSION['user'] ?? null;
        if (!$user) {
            header('Location: ' . ($GLOBALS['baseUrl'] ?? '/') . '/');
            exit;
        }

        $nguoidung = NguoiDung::getByEmail($pdo, $user['email']);
        if (!$nguoidung) {
            header('Location: ' . ($GLOBALS['baseUrl'] ?? '/') . '/');
            exit;
        }

        $content = view('edit.php', ['nguoidung' => $nguoidung], 'User');
        return render('main_layout.php', ['content' => $content]);
    }

    public function update()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $pdo = require __DIR__ . '/../../config/config.php';
        $user = $_SESSION['user'] ?? null;
        if (!$user) {
            header('Location: ' . ($GLOBALS['baseUrl'] ?? '/') . '/');
            exit;
        }

        $ma_nd = $user['ma_nd'];
        $tennd = trim($_POST['tennd'] ?? '');
        $sdt = trim($_POST['sdt'] ?? '');
        $diachi = trim($_POST['diachi'] ?? '');

        if ($tennd === '') {
            $_SESSION['user_update_error'] = 'Họ tên không được để trống.';
            header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? ($GLOBALS['baseUrl'] ?? '/')));
            exit;
        }

        $hinhFilename = null;
        if (!empty($_FILES['avatar']['name'])) {
            $uploadDir = __DIR__ . '/../../assets/images/anhnd/';
            if (!is_dir($uploadDir)) @mkdir($uploadDir, 0755, true);
            $tmp = $_FILES['avatar']['tmp_name'];
            $orig = basename($_FILES['avatar']['name']);
            $ext = pathinfo($orig, PATHINFO_EXTENSION);
            $hinhFilename = $user['ma_nd'] . '_' . time() . '.' . $ext;
            $dest = $uploadDir . $hinhFilename;
            if (!move_uploaded_file($tmp, $dest)) {
                $hinhFilename = null;
            }
        }

        $ok = NguoiDung::update($pdo, $ma_nd, $tennd, $sdt, $diachi, $hinhFilename);
        if ($ok) {
            $_SESSION['user']['tennd'] = $tennd;
            $_SESSION['MessageSuccess_User'] = 'Cập nhật thông tin thành công.';
        } else {
            $_SESSION['MessageError_User'] = 'Không cập nhật được thông tin.';
        }

        $base = rtrim($GLOBALS['baseUrl'] ?? '', '/');
        $redirect = ($base === '') ? '/User/ThongTin?id=' . $ma_nd : $base . '/User/ThongTin?id=' . $ma_nd;
        header('Location: ' . $redirect);
        exit;
    }

    public function changePassword()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $pdo = require __DIR__ . '/../../config/config.php';
        $user = $_SESSION['user'] ?? null;
        if (!$user) {
            header('Location: ' . ($GLOBALS['baseUrl'] ?? '/') . '/');
            exit;
        }

        $old = $_POST['old_password'] ?? '';
        $new = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        if ($new === '' || $confirm === '' || $old === '') {
            $_SESSION['MessageError_User'] = 'Vui lòng điền đầy đủ các trường.';
            header('Location: ' . ($GLOBALS['baseUrl'] ?? '') . '/User/ThongTin?id=' . $user['ma_nd']);
            exit;
        }

        if ($new !== $confirm) {
            $_SESSION['MessageError_User'] = 'Mật khẩu mới và xác nhận không khớp.';
            header('Location: ' . ($GLOBALS['baseUrl'] ?? '') . '/User/ThongTin?id=' . $user['ma_nd']);
            exit;
        }

        if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/', $new)) {
            $_SESSION['MessageError_User'] = 'Mật khẩu mới cần ít nhất 6 ký tự, gồm chữ và số.';
            header('Location: ' . ($GLOBALS['baseUrl'] ?? '') . '/User/ThongTin?id=' . $user['ma_nd']);
            exit;
        }

        $nguoi = NguoiDung::getByEmail($pdo, $user['email']);
        if (!$nguoi) {
            $_SESSION['MessageError_User'] = 'Không tìm thấy người dùng.';
            header('Location: ' . ($GLOBALS['baseUrl'] ?? '') . '/User/ThongTin?id=' . $user['ma_nd']);
            exit;
        }

        if ($nguoi->matkhau !== $old) {
            $_SESSION['MessageError_User'] = 'Mật khẩu cũ không chính xác.';
            header('Location: ' . ($GLOBALS['baseUrl'] ?? '') . '/User/ThongTin?id=' . $user['ma_nd']);
            exit;
        }

        $ok = NguoiDung::updatePassword($pdo, $nguoi->ma_nd, $new);
        if ($ok) {
            $_SESSION['MessageSuccess_User'] = 'Đổi mật khẩu thành công.';
        } else {
            $_SESSION['MessageError_User'] = 'Không thể đổi mật khẩu.';
        }

        header('Location: ' . ($GLOBALS['baseUrl'] ?? '') . '/User/ThongTin?id=' . $user['ma_nd']);
        exit;
    }

    public function danhGiaSP()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $pdo = require __DIR__ . '/../../config/config.php';
        $user = $_SESSION['user'] ?? null;
        if (!$user) {
            header('Location: ' . ($GLOBALS['baseUrl'] ?? '/') . '/');
            exit;
        }

        $ma_sp = $_POST['ma_sp'] ?? null;
        $noidung = trim($_POST['noidung'] ?? '');
        $sosao = (int)($_POST['sosao'] ?? 5);

        if (!$ma_sp) {
            header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
            exit;
        }

        $check = $pdo->prepare('SELECT COUNT(*) FROM danh_gia WHERE ma_sp = :ma_sp AND ma_nd = :ma_nd');
        $check->execute(['ma_sp' => $ma_sp, 'ma_nd' => $user['ma_nd']]);
        if ((int)$check->fetchColumn() === 0) {
            $ins = $pdo->prepare('INSERT INTO danh_gia (ma_nd, ma_sp, noidung, sosao) VALUES (:ma_nd, :ma_sp, :noidung, :sosao)');
            $ins->execute(['ma_nd' => $user['ma_nd'], 'ma_sp' => $ma_sp, 'noidung' => $noidung, 'sosao' => $sosao]);
        }

        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
        exit;
    }

    public function lichSuDatHang()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $pdo = require __DIR__ . '/../../config/config.php';
        $user = $_SESSION['user'] ?? null;
        if (!$user) {
            header('Location: ' . ($GLOBALS['baseUrl'] ?? '/') . '/');
            exit;
        }

        $donhangs = DonDatHang::getByNguoiDung($pdo, $user['ma_nd']);
        
        $content = view('lichsuDDH.php', ['donhangs' => $donhangs], 'User');
        return render('main_layout.php', ['content' => $content]);
    }

}
