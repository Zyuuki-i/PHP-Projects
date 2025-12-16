<?php
namespace Admin;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION["admin"])) {
    header('Location: index.php');
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Vui lòng nhập tên đăng nhập và mật khẩu.';
    } else {
        try {
            $pdo = require __DIR__ . '/../config/config.php';
            $sql = "SELECT ma_nv, tennv, matkhau, email, ma_vt FROM nhan_vien WHERE tennv = :u OR email = :u LIMIT 1";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':u' => $username]);
            $user = $stmt->fetch(
                \PDO::FETCH_ASSOC
            );
            if ($user) {
                $hash = $user['matkhau'];
                $ok = false;
                if (password_verify($password, $hash)) {
                    $ok = true;
                } elseif ($password === $hash) {
                    $ok = true; 
                }

                if ($ok) {
                    $_SESSION['admin'] = [
                        'ma_nv' => $user['ma_nv'],
                        'tennv' => $user['tennv'],
                        'email' => $user['email'] ?? '',
                        'ma_vt' => $user['ma_vt'] ?? ''
                    ];
                    header('Location: index.php');
                    exit();
                }
            }
            $error = 'Tên đăng nhập hoặc mật khẩu không đúng.';
        } catch (\Throwable $e) {
            $error = 'Lỗi hệ thống. Vui lòng thử lại.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Admin Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body{font-family:Arial,Helvetica,sans-serif;margin:40px} .login{max-width:360px;margin:0 auto;padding:20px;border:1px solid #ddd;border-radius:6px} input[type=text],input[type=password]{width:100%;padding:8px;margin:6px 0 12px;border:1px solid #ccc;border-radius:4px} .error{color:#b00;margin-bottom:12px}</style>
</head>
<body>
    <div class="login shadow p-4 mb-5 rounded">
        <div style="text-align:center;margin-bottom:20px;">
            <img src="./resources/images/logo.png" alt="Logo" style="max-width:150px;">
        </div>
        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <label for="username">Tên đăng nhập hoặc email</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required>

            <label for="password">Mật khẩu</label>
            <input type="password" id="password" name="password" required>
            <div>
                <input type="checkbox" id="show_password" onclick="document.getElementById('password').type = this.checked ? 'text' : 'password';">
                <label for="show_password">Hiển thị mật khẩu</label>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Đăng nhập</button>
            </div>
        </form>
    </div>
</body>
</html>