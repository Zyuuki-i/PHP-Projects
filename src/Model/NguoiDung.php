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

    public function __construct($ma_nd, $tennd, $matkhau, $email, $sdt = '', $diachi = '', $hinh = '')
    {
        $this->ma_nd = $ma_nd;
        $this->tennd = $tennd;
        $this->matkhau = $matkhau;
        $this->email = $email;
        $this->sdt = $sdt;
        $this->diachi = $diachi;
        $this->hinh = $hinh;
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
            $query = "SELECT ma_nd, tennd, matkhau, sdt, diachi, email, hinh FROM nguoi_dung";
            $stmt = $pdo->query($query);
            while ($row = $stmt->fetch()) {
                $items[] = new self(
                    $row['ma_nd'],
                    $row['tennd'],
                    $row['matkhau'],
                    $row['email'],
                    $row['sdt'] ?? '',
                    $row['diachi'] ?? '',
                    $row['hinh'] ?? ''
                );
            }
        } catch (\Exception) {}
        return count($items) > 0 ? $items : [];
    }
}
