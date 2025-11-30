<?php
namespace App\Model;

class DanhGia
{
    public $ma_nd;
    public $ma_sp;
    public $noidung;
    public $sosao;

    public function __construct($ma_nd, $ma_sp, $noidung = '', $sosao = null)
    {
        $this->ma_nd = $ma_nd;
        $this->ma_sp = $ma_sp;
        $this->noidung = $noidung;
        $this->sosao = $sosao;
    }

    public static function getAll($pdo)
    {
        $items = [];
        try {
            $query = "SELECT ma_nd, ma_sp, noidung, sosao FROM danh_gia";
            $stmt = $pdo->query($query);
            while ($row = $stmt->fetch()) {
                $items[] = new self($row['ma_nd'], $row['ma_sp'], $row['noidung'] ?? '', $row['sosao'] ?? null);
            }
        } catch (\Exception) {}
        return count($items) > 0 ? $items : [];
    }
}
