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

    public static function getById($pdo, $id){
        $sql = 'select ma_sp, tensp, ma_nsx, ma_loai, giasp, soluongton, mota from san_pham where ma_sp = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch();
        if ($row) {
            return new self(
                $row['ma_sp'],
                $row['tensp'],
                $row['giasp'],
                $row['soluongton'] ?? 0,
                $row['mota'] ?? '',
                $row['ma_nsx'] ?? '',
                $row['ma_loai'] ?? ''
            );
        }
        return null;
    }

    public static function getByNSX($pdo, $nsxID){
        $sql = 'select ma_sp, tensp, ma_nsx, ma_loai, giasp, soluongton, mota from san_pham where ma_nsx = :nsxID';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nsxID', $nsxID);
        $stmt->execute();
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
        return $products ?? [];
    }

    public static function getByLoai($pdo, $loaiID){
        $sql = 'select ma_sp, tensp, ma_nsx, ma_loai, giasp, soluongton, mota from san_pham where ma_loai = :loaiID';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':loaiID', $loaiID);
        $stmt->execute();
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
        return $products ?? [];
    }

    public static function search($pdo, $keyword){
        $sql = 'select ma_sp, tensp, ma_nsx, ma_loai, giasp, soluongton, mota from san_pham where tensp like :keyword';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':keyword', "%$keyword%");
        $stmt->execute();
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
        return $products ?? [];
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

    public static function countAll($pdo)
    {
        try {
            $query = "SELECT COUNT(*) FROM san_pham";
            $stmt = $pdo->query($query);
            return (int) $stmt->fetchColumn();
        } catch (\Exception) {
            return 0;
        }
    }

    public static function getPage($pdo, $limit, $offset, $products = [])
    {
        if(is_array($products)){
            $products = array_slice($products, $offset, $limit);
        }else{
            try {
                $query = "SELECT ma_sp, tensp, ma_nsx, ma_loai, giasp, soluongton, mota FROM san_pham LIMIT :limit OFFSET :offset";
                $stmt = $pdo->prepare($query);
                $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
                $stmt->bindValue(':offset', (int)$offset, \PDO::PARAM_INT);
                $stmt->execute();
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
        }
        return count($products) > 0 ? $products : [];
    }

    public static function getRelatedProducts($pdo, $ma_loai, $ma_sp, $limit){
        $products = [];
        try {
            $query = "SELECT ma_sp, tensp, ma_nsx, ma_loai, giasp, soluongton, mota FROM san_pham WHERE ma_loai = :ma_loai AND ma_sp != :ma_sp LIMIT :limit";
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':ma_loai', $ma_loai);
            $stmt->bindValue(':ma_sp', $ma_sp);
            $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
            $stmt->execute();
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
