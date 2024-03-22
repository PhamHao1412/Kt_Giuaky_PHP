<?php
  require_once("config/db.class.php");
  class Employee{
    public $ma_nv;
    public $ten_nv;
    public $phai;
    public $noi_sinh;
    public $ma_phong;
    public $luong;

    public function __construct($ma_nv,$ten_nv, $phai, $noi_sinh, $ma_phong, $luong){
    $this->ma_nv = $ma_nv;
      $this->ten_nv = $ten_nv;
      $this->phai= $phai;
      $this->noi_sinh= $noi_sinh;
      $this->ma_phong= $ma_phong;
      $this->luong= $luong;
    }
    // public function save(){
    //   $db= new Db();
    //   $sql = "INSERT INTO NHANVIEN (Ma_NV, Ten_NV,Phai,Noi_Sinh,Luong,Ten_Phong) VALUES
    //   ('$this->productName','$this->cateID','$this->price','$this->quantity','$this->description','$this->picture')";
    //   $result = $db->query_execute($sql);
    //   return $result;
    // }
    public static function list_product(){
			$db=new Db();
			$sql="SELECT Ma_Nv,Ten_Nv,Phai,Noi_Sinh,Ten_Phong, Luong
            FROM nhanvien n, phongban p
            WHERE n.Ma_Phong = p.Ma_Phong ";
			$result = $db->select_to_array($sql);
			return $result;
		}
  }