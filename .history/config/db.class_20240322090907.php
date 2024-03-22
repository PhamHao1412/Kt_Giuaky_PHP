<?php // IDEA:
  class Db
  {
    protected static $connection;
   # server name
protected static $sName = "localhost";
# user name
protected static $uName = "root";
# password
protected static $pass = "";

# database name
protected static $db_name = "chatapp";

#creating database connection
try {
    $conn = new PDO("mysql:host=$sName;dbname=$db_name", 
                    $uName, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
  echo "Connection failed : ". $e->getMessage();
}
    public function query_execute($queryString){
      $connection = $this->connect();
      $result=  $connection-> query($queryString);
      $connection -> close();
      return $result;
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
