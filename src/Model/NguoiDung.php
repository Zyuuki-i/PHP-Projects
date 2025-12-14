<?php
namespace App\Model;

class NguoiDung
{
    public $ma_nd;
    public $tennd;
    public $matkhau;
    public $sdt;
    public $diachi;
    public $email;
    public $hinh;
    public $trangthai;

    public function __construct($ma_nd, $tennd, $matkhau, $email, $sdt = '', $diachi = '', $hinh = '', $trangthai = 0)
    {
        $this->ma_nd = $ma_nd;
        $this->tennd = $tennd;
        $this->matkhau = $matkhau;
        $this->email = $email;
        $this->sdt = $sdt;
        $this->diachi = $diachi;
        $this->hinh = $hinh;
        $this->trangthai = $trangthai;
    }

    public function __destruct()
    {}

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
        return null;
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }

    public static function getAll($pdo)
    {
        $items = [];
        try {
            $query = "SELECT ma_nd, tennd, matkhau, sdt, diachi, email, hinh, trangthai FROM nguoi_dung";
            $stmt = $pdo->query($query);
            while ($row = $stmt->fetch()) {
                $items[] = new self(
                    $row['ma_nd'],
                    $row['tennd'],
                    $row['matkhau'],
                    $row['email'],
                    $row['sdt'] ?? '',
                    $row['diachi'] ?? '',
                    $row['hinh'] ?? '',
                    $row['trangthai'] ?? 0
                );
            }
        } catch (\Exception) {}
        return count($items) > 0 ? $items : [];
    }

    public static function getByEmail($pdo, $email)
    {
        try {
            $query = "SELECT ma_nd, tennd, matkhau, sdt, diachi, email, hinh, trangthai FROM nguoi_dung WHERE email = :email LIMIT 1";
            $stmt = $pdo->prepare($query);
            $stmt->execute(['email' => $email]);
            $row = $stmt->fetch();
            if ($row) {
                return new self(
                    $row['ma_nd'],
                    $row['tennd'],
                    $row['matkhau'],
                    $row['email'],
                    $row['sdt'] ?? '',
                    $row['diachi'] ?? '',
                    $row['hinh'] ?? '',
                    $row['trangthai'] ?? 0
                );
            }
        } catch (\Exception) {}
        return null;
    }

    public static function create($pdo, $tennd, $matkhau, $email, $sdt = '', $diachi = '', $hinh = '', $trangthai = 1)
    {
        try {
            $stmt = $pdo->query("SELECT MAX(ma_nd) AS m FROM nguoi_dung");
            $row = $stmt->fetch();
            $next = ($row && $row['m']) ? ((int)$row['m'] + 1) : 1;
            $query = "INSERT INTO nguoi_dung (ma_nd, tennd, matkhau, sdt, diachi, email, hinh, trangthai) VALUES (:ma_nd, :tennd, :matkhau, :sdt, :diachi, :email, :hinh, :trangthai)";
            $p = $pdo->prepare($query);
            $p->execute([
                'ma_nd' => $next,
                'tennd' => $tennd,
                'matkhau' => $matkhau,
                'sdt' => $sdt,
                'diachi' => $diachi,
                'email' => $email,
                'hinh' => $hinh,
                'trangthai' => $trangthai
            ]);
            return self::getByEmail($pdo, $email);
        } catch (\Exception) {}
        return null;
    }
}
