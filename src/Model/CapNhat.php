<?php
namespace App\Model;

class CapNhat
{
    public $ma_nv;
    public $ma_sp;
    public $ngaycapnhat;

    public function __construct($ma_nv, $ma_sp, $ngaycapnhat = null)
    {
        $this->ma_nv = $ma_nv;
        $this->ma_sp = $ma_sp;
        $this->ngaycapnhat = $ngaycapnhat;
    }

    public static function getAll($pdo)
    {
        $items = [];
        try {
            $query = "SELECT ma_nv, ma_sp, ngaycapnhat FROM cap_nhat";
            $stmt = $pdo->query($query);
            while ($row = $stmt->fetch()) {
                $items[] = new self($row['ma_nv'], $row['ma_sp'], $row['ngaycapnhat'] ?? null);
            }
        } catch (\Exception) {}
        return count($items) > 0 ? $items : [];
    }
}
