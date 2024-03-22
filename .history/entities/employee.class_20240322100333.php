<?php
require_once("config/db.class.php");
class Employee {
    public $ma_nv;
    public $ten_nv;
    public $phai;
    public $noi_sinh;
    public $ma_phong;
    public $luong;

    public function __construct($ma_nv, $ten_nv, $phai, $noi_sinh, $ma_phong, $luong) {
        $this->ma_nv = $ma_nv;
        $this->ten_nv = $ten_nv;
        $this->phai = $phai;
        $this->noi_sinh = $noi_sinh;
        $this->ma_phong = $ma_phong;
        $this->luong = $luong;
    }

   public static function list_employee($start = null, $limit = null) {
        $db = new Db();
        $sql = "SELECT Ma_Nv, Ten_Nv, Phai, Noi_Sinh, Ten_Phong, Luong
                FROM nhanvien n, phongban p
                WHERE n.Ma_Phong = p.Ma_Phong";
        
        if ($start !== null && $limit !== null) {
            $sql .= " LIMIT $start, $limit";
        }

        $result = $db->select_to_array($sql);
        return $result;
    }

    public static function count_employees() {
        $db = new Db();
        $sql = "SELECT COUNT(*) AS total FROM nhanvien";
        $result = $db->select_one($sql);
        return $result['total'];
    }
}
