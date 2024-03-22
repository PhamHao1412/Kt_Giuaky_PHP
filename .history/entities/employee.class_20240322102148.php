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

    public static function list_employee() {
        $db = new Db();
        $sql = "SELECT Ma_Nv, Ten_Nv, Phai, Noi_Sinh, Ten_Phong, Luong
                FROM nhanvien n, phongban p
                WHERE n.Ma_Phong = p.Ma_Phong ";
        $result = $db->select_to_array($sql);
        return $result;
    }
    public static function addEmployee($ma_nv, $ten_nv, $phai, $noi_sinh, $ma_phong, $luong) {
    $db = new Db();
    $sql = "INSERT INTO nhanvien (Ma_Nv, Ten_Nv, Phai, Noi_Sinh, Ma_Phong, Luong) 
            VALUES ('$ma_nv', '$ten_nv', '$phai', '$noi_sinh', '$ma_phong', '$luong')";
    $result = $db->query_execute($sql);
    return $result;
}
public static function editEmployee($ma_nv, $ten_nv, $phai, $noi_sinh, $ma_phong, $luong) {
    $db = new Db();
    $sql = "UPDATE nhanvien SET Ten_Nv='$ten_nv', Phai='$phai', Noi_Sinh='$noi_sinh', Ma_Phong='$ma_phong', Luong='$luong' WHERE Ma_Nv='$ma_nv'";
    $result = $db->query_execute($sql);
    return $result;
}
public static function getEmployeeById($id) {
    $db = new Db();
    $sql = "SELECT Ma_Nv, Ten_Nv, Phai, Noi_Sinh, Ma_Phong, Luong
            FROM nhanvien
            WHERE Ma_Nv = '$id'";
    $result = $db->select_to_array($sql);
    return isset($result[0]) ? $result[0] : null;
}

public static function updateEmployee($ma_nv, $ten_nv, $phai, $noi_sinh, $ma_phong, $luong) {
    $db = new Db();
    $sql = "UPDATE nhanvien
            SET Ten_Nv = '$ten_nv', Phai = '$phai', Noi_Sinh = '$noi_sinh', Ma_Phong = '$ma_phong', Luong = '$luong'
            WHERE Ma_Nv = '$ma_nv'";
    $result = $db->query_execute($sql);
    return $result;
}



}
