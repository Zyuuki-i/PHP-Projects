<?php
namespace App\Model;

class Hinh
{
    public $ma_hinh;
    public $ma_sp;
    public $tenhinh;

    public function __construct($ma_hinh, $ma_sp, $tenhinh = '')
    {
        $this->ma_hinh = $ma_hinh;
        $this->ma_sp = $ma_sp;
        $this->tenhinh = $tenhinh;
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
            $query = "SELECT ma_hinh, ma_sp, tenhinh FROM hinh";
            $stmt = $pdo->query($query);
            while ($row = $stmt->fetch()) {
                $items[] = new self($row['ma_hinh'], $row['ma_sp'], $row['tenhinh'] ?? '');
            }
        } catch (\Exception) {}
        return count($items) > 0 ? $items : [];
    }
}
