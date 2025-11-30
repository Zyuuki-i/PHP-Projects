<?php
namespace App\Model;

class NhaSanXuat
{
    public $ma_nsx;
    public $tennsx;
    public $diachi;
    public $sdt;
    public $email;

    public function __construct($ma_nsx, $tennsx, $diachi = '', $sdt = '', $email = '')
    {
        $this->ma_nsx = $ma_nsx;
        $this->tennsx = $tennsx;
        $this->diachi = $diachi;
        $this->sdt = $sdt;
        $this->email = $email;
    }

    public static function getAll($pdo)
    {
        $items = [];
        try {
            $query = "SELECT ma_nsx, tennsx, diachi, sdt, email FROM nha_san_xuat";
            $stmt = $pdo->query($query);
            while ($row = $stmt->fetch()) {
                $items[] = new self($row['ma_nsx'], $row['tennsx'], $row['diachi'] ?? '', $row['sdt'] ?? '', $row['email'] ?? '');
            }
        } catch (\Exception) {}
        return count($items) > 0 ? $items : [];
    }
}
