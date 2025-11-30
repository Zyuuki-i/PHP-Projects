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

    public function __construct($ma_nv, $tennv, $matkhau, $email, $cccd = '', $sdt = '', $diachi = '', $hinh = '', $ma_vt = '')
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
    }

    public static function getAll($pdo)
    {
        $items = [];
        try {
            $query = "SELECT ma_nv, tennv, matkhau, sdt, email, cccd, diachi, hinh, ma_vt FROM nhan_vien";
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
                    $row['ma_vt'] ?? ''
                );
            }
        } catch (\Exception) {}
        return count($items) > 0 ? $items : [];
    }
}
