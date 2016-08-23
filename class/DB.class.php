<?php
class DB{
	private $mem;
	private $dbconn;
	function __construct($database){
		global $dbconn,$mem;
		$dbconn = new mysqli("localhost:", "root", "", $database);
		$mem = new Memcached();
		$mem->addServer("localhost",11211);
	}
	function __destruct(){
		global $dbconn,$mem;
		$dbconn->close();
	}
	function query($sql){
		global $dbconn,$mem;
		$key = hash("MD5", $sql);
		$result = $mem->get($key);
		if($result == null){
			$result = array();
			$res = $dbconn->query($sql);
			while($row = $dbconn->fetch_array()){
				$result[] = $row;
			}
			$mem->set($key, $result,10800);
		}
	}
	function clear(){
		global $mem;
		$mem->flush();
	}
	function __get($dbconn){
		return $this->dbconn;
	}
}
?>