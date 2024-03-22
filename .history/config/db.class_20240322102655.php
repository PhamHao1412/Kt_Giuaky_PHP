<?php // IDEA:
  class Db
  {
    protected static $connection;
    public function connect()
    {
      if(!isset(self::$connection)){
        $config = parse_ini_file("config.ini");
        self::$connection = new mysqli("localhost", $config["username"], $config["password"], $config["databasename"]);
      }
      if(self::$connection== false)
      {
        return false;
      }
      return self::$connection;
    }
   public function query_execute($queryString){
    $connection = $this->connect();
    $result = $connection->query($queryString);
    
    // Kiểm tra nếu truy vấn không thành công
    if($result === false) {
        echo "Lỗi truy vấn: " . $connection->error;
        return false;
    }
    
    // Thu thập dữ liệu từ kết quả truy vấn
    $rows = array();
    while ($item = $result->fetch_assoc()) {
        $rows[] = $item;
    }
    
    // Đóng kết nối sau khi thu thập dữ liệu
    $connection->close();
    
    return $rows;
}

    public function select_to_array($queryString){
      $rows = array();
      $result = $this->query_execute($queryString);
      if ($result == false)
          return false;
      while ($item = $result->fetch_assoc()) {
          $rows[] = $item;
      }
      return $rows;
  }
  }
?>
