<?php
include 'config.php';
class dao {
  var $conn;
  var $mem;
  function _construct($config){
    $this->conn = new mysqli($config[$SQL_HOST], $config[$SQL_USERNAME], $config[$SQL_PASSWORD], $config[$SQL_DATABASE]);
    $this->mem = new Memcache();
    $this->mem->connect($config[$MEMCACHE_HOST],$config[$MEMCACHE_PORT]);
  }
  
  function close(){
    $this->conn->close();
    $this->mem->close();
  }
}
?>