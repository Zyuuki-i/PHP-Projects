<?php
namespace App\Model;

class Product
{
    public $ma_sp;
    public $tensp;
    public $ma_nsx;
    public $ma_loai;
    public $giasp;
    public $soluongton;
    public $mota;

    public function __construct($ma_sp, $tensp, $giasp, $soluongton, $mota = '', $ma_nsx = '', $ma_loai = '')
    {
        $this->ma_sp = $ma_sp;
        $this->tensp = $tensp;
        $this->giasp = $giasp;
        $this->soluongton = $soluongton;
        $this->mota = $mota;
        $this->ma_nsx = $ma_nsx;
        $this->ma_loai = $ma_loai;
    }

    public function __destruct()
    {}

    public function __get($property) {
        if (property_exists($this, $property)) {
            if($property === 'ma_sp'){
                return "Không thể truy cập mã sản phẩm";
            }            
            return $this->$property;           
        }
        return null;
    }

    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }

    public static function getAll($pdo)
    {
        $products = [];
            try {
                $query = "SELECT ma_sp, tensp, ma_nsx, ma_loai, giasp, soluongton, mota FROM san_pham";
                $stmt = $pdo->query($query);
                while ($row = $stmt->fetch()) {
                    $products[] = new self(
                        $row['ma_sp'],
                        $row['tensp'],
                        $row['giasp'],
                        $row['soluongton'] ?? 0,
                        $row['mota'] ?? '',
                        $row['ma_nsx'] ?? '',
                        $row['ma_loai'] ?? ''
                    );
                }
            } catch (\Exception) {}
        return count($products) > 0 ? $products : [];
    }
}
