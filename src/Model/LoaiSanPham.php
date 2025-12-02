<?php
namespace App\Model;

class LoaiSanPham
{
    public $ma_loai;
    public $tenloai;
    public $mota;

    public function __construct($ma_loai, $tenloai, $mota = '')
    {
        $this->ma_loai = $ma_loai;
        $this->tenloai = $tenloai;
        $this->mota = $mota;
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
            $query = "SELECT ma_loai, tenloai, mota FROM loai_san_pham";
            $stmt = $pdo->query($query);
            while ($row = $stmt->fetch()) {
                $items[] = new self($row['ma_loai'], $row['tenloai'], $row['mota'] ?? '');
            }
        } catch (\Exception) {}
        return count($items) > 0 ? $items : [];
    }
}
