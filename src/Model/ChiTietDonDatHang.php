<?php
namespace App\Model;

class ChiTietDonDatHang
{
    public $ma_ddh;
    public $ma_sp;
    public $soluong;
    public $gia;
    public $thanhtien;

    public function __construct($ma_ddh, $ma_sp, $soluong = 0, $gia = 0, $thanhtien = 0)
    {
        $this->ma_ddh = $ma_ddh;
        $this->ma_sp = $ma_sp;
        $this->soluong = $soluong;
        $this->gia = $gia;
        $this->thanhtien = $thanhtien;
    }

    public static function getAll($pdo)
    {
        $items = [];
        try {
            $query = "SELECT ma_ddh, ma_sp, soluong, gia, thanhtien FROM chi_tiet_don_dat_hang";
            $stmt = $pdo->query($query);
            while ($row = $stmt->fetch()) {
                $items[] = new self(
                    $row['ma_ddh'],
                    $row['ma_sp'],
                    $row['soluong'] ?? 0,
                    $row['gia'] ?? 0,
                    $row['thanhtien'] ?? 0
                );
            }
        } catch (\Exception) {}
        return count($items) > 0 ? $items : [];
    }
}
