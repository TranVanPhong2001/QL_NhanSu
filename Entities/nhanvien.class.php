<?php 
require_once("config/db.class.php");
class NhanVien{
    public $maNV;
    public $tenNV;
    public $phai;
    public $noiSinh;
    public $maPhong;
    public $luong;

    public function __construct($maNV, $tenNV, $phai, $noiSinh, $maPhong, $luong){
        $this -> maNV =$maNV;
        $this -> tenNV = $tenNV;
        $this -> phai = $phai;
        $this -> noiSinh = $noiSinh;
        $this -> maPhong = $maPhong;
        $this -> luong = $luong;
    }
    public function save(){
        $db = new Db();
        $sql = "INSERT INTO nhanvien (Ma_NV, Ten_NV, Phai, Noi_Sinh, Ma_Phong, Luong) VALUES
        ('$this->maNV','$this->tenNV','$this->phai','$this->noiSinh','$this->maPhong','$this->luong')";

        $result = $db->query_excute($sql);
        return $result;
    }
    public static function list_Nhanvien(){
        $db = new Db();
        $sql = "SELECT * FROM nhanvien";
        $result = $db-> seelect_to_array($sql);
        return $result;
    }
    public static function getAllPhongban()
    {
        $db = new Db();
        $sql = "SELECT * FROM phongban"; 
        $phongbans = $db-> seelect_to_array($sql);
        return $phongbans;
    }
}

?>