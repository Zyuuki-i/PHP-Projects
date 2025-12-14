<?php
namespace App\Controller;

use App\Model\NguoiDung;
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


    private function view($view, $data = [])
    {
        extract($data);
        ob_start();
        include __DIR__ . '/../View/User/' . $view;
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
