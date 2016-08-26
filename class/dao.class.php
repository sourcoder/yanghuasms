<?php
include "config.php";
class dao {
	private $conn;
	private $mem;
	private $time;
	function __construct() {
		global $config;
		$this->conn = new mysqli($config[SQL_HOST], $config[SQL_USERNAME], $config[SQL_PASSWORD], $config[SQL_DATABASE]);
		$this->mem = new Memcache();
		$this->mem->connect($config[MEMCACHE_HOST], $config[MEMCACHE_PORT]);
		$this->time = (int) $config[MEMCACHE_TIME];
	}
	function getquery($sql) {
		$query = $this->mem->get(md5($sql));
		if ($query == null) {
			$result = $this->conn->query($sql);
			$query = array();
			while ($row = $result->fetch_array()) {
				$rowdata = array();
				$query[] = $row;
			}
			$this->mem->set(md5($sql), $query, MEMCACHE_COMPRESSED, $this->time);
		} else {
			echo "MEM";
			$this->mem->set(md5($sql), $query, MEMCACHE_COMPRESSED, $this->time);
		}
		return $query;
	}
	function getConn() {
		return $this->conn;
	}
	function close() {
		$this->conn->close();
		$this->mem->close();
	}
	function __destruct() {
		$this->conn->close();
		$this->mem->close();
	}
}
?>