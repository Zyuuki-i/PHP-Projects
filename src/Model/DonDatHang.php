<?php
namespace App\Model;

class DonDatHang
{
    public $ma_ddh;
    public $ma_nd;
    public $ma_nv;
    public $diachi;
    public $ngaydat;
    public $tongtien;
    public $trangthai;
    public $tt_thanhtoan;

    public function __construct($ma_ddh, $ma_nd, $diachi, $ngaydat = null, $tongtien = 0, $trangthai = '', $tt_thanhtoan = 'Chưa thanh toán', $ma_nv = null)
    {
        $this->ma_ddh = $ma_ddh;
        $this->ma_nd = $ma_nd;
        $this->ma_nv = $ma_nv;
        $this->diachi = $diachi;
        $this->ngaydat = $ngaydat;
        $this->tongtien = $tongtien;
        $this->trangthai = $trangthai;
        $this->tt_thanhtoan = $tt_thanhtoan;
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
            $query = "SELECT ma_ddh, ma_nd, ma_nv, diachi, ngaydat, tongtien, trangthai, tt_thanhtoan FROM don_dat_hang";
            $stmt = $pdo->query($query);
            while ($row = $stmt->fetch()) {
                $items[] = new self(
                    $row['ma_ddh'],
                    $row['ma_nd'],
                    $row['diachi'],
                    $row['ngaydat'] ?? null,
                    $row['tongtien'] ?? 0,
                    $row['trangthai'] ?? '',
                    $row['tt_thanhtoan'] ?? 'Chưa thanh toán',
                    $row['ma_nv'] ?? null
                );
            }
        } catch (\Exception) {}
        return count($items) > 0 ? $items : [];
    }
}
