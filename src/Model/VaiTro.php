<?php
namespace App\Model;

class VaiTro
{
    public $ma_vt;
    public $tenvt;
    public $mota;

    public function __construct($ma_vt, $tenvt, $mota = '')
    {
        $this->ma_vt = $ma_vt;
        $this->tenvt = $tenvt;
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
            $query = "SELECT ma_vt, tenvt, mota FROM vai_tro";
            $stmt = $pdo->query($query);
            while ($row = $stmt->fetch()) {
                $items[] = new self($row['ma_vt'], $row['tenvt'], $row['mota'] ?? '');
            }
        } catch (\Exception) {}
        return count($items) > 0 ? $items : [];
    }
}
