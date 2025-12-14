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
            $query = "SELECT ma_nd, ma_sp, noidung, sosao FROM danh_gia";
            $stmt = $pdo->query($query);
            while ($row = $stmt->fetch()) {
                $items[] = new self($row['ma_nd'], $row['ma_sp'], $row['noidung'] ?? '', $row['sosao'] ?? null);
            }
        } catch (\Exception) {}
        return count($items) > 0 ? $items : [];
    }

    public static function getByProductId($pdo, $id){
        $items = [];
        try {
            $query = "SELECT ma_nd, ma_sp, noidung, sosao FROM danh_gia WHERE ma_sp = :id";
            $stmt = $pdo->prepare($query);
            $stmt->execute(['id' => $id]);
            while ($row = $stmt->fetch()) {
                $items[] = new self($row['ma_nd'], $row['ma_sp'], $row['noidung'] ?? '', $row['sosao'] ?? null);
            }
        } catch (\Exception) {}
        return count($items) > 0 ? $items : [];
    }

    public static function getByUserAndProduct($pdo, $ma_nd, $ma_sp)
    {
        try {
            $query = "SELECT ma_nd, ma_sp, noidung, sosao FROM danh_gia WHERE ma_nd = :ma_nd AND ma_sp = :ma_sp LIMIT 1";
            $stmt = $pdo->prepare($query);
            $stmt->execute(['ma_nd' => $ma_nd, 'ma_sp' => $ma_sp]);
            if ($row = $stmt->fetch()) {
                return new self($row['ma_nd'], $row['ma_sp'], $row['noidung'] ?? '', $row['sosao'] ?? null);
            }
        } catch (\Exception) {}
        return null;
    }

}