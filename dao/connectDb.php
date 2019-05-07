<?php
class ConnectDB{
    /**
     * 全局连接数据库
     */
     const url = "localhost";
     const username = "root";
     const password = "";
     const dbName = "news_system";
     public $dbHandle;
     public function __construct(){
          $this->dbHandle = new mysqli(self::url, self::username, self::password, self::dbName);
          if ($this->dbHandle->connect_error) {
               throw Exception($this->dbHandle->connect_error);
          }
     }

     public function __destruct(){
          if($this->dbHandle){
               $this->dbHandle->close();
          }
     }

}
