<?php
namespace App\Model;

class NhanVien
{
    public $ma_nv;
    public $tennv;
    public $matkhau;
    public $sdt;
    public $email;
    public $cccd;
    public $diachi;
    public $hinh;
    public $ma_vt;

    public $trangthai;

    public function __construct($ma_nv, $tennv, $matkhau, $email, $cccd = '', $sdt = '', $diachi = '', $hinh = '', $ma_vt = '', $trangthai = 0)
    {
        $this->ma_nv = $ma_nv;
        $this->tennv = $tennv;
        $this->matkhau = $matkhau;
        $this->email = $email;
        $this->cccd = $cccd;
        $this->sdt = $sdt;
        $this->diachi = $diachi;
        $this->hinh = $hinh;
        $this->ma_vt = $ma_vt;
        $this->trangthai = $trangthai;
    }

    public function __destruct()
    {
        
    }

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
            $query = "SELECT ma_nv, tennv, matkhau, sdt, email, diachi, hinh, ma_vt, trangthai FROM nhan_vien";
            $stmt = $pdo->query($query);
            while ($row = $stmt->fetch()) {
                $items[] = new self(
                    $row['ma_nv'],
                    $row['tennv'],
                    $row['matkhau'],
                    $row['email'],
                    $row['cccd'] ?? '',
                    $row['sdt'] ?? '',
                    $row['diachi'] ?? '',
                    $row['hinh'] ?? '',
                    $row['ma_vt'] ?? '',
                    $row['trangthai'] ?? 0
                );
            }
        } catch (\Exception) {}
        return count($items) > 0 ? $items : [];
    }
}
