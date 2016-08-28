<?php
class PER {
	private $perm_name;
	function __construct() {
		$this->perm_name = array(20 => "成员", 60 => "协管员", 80 => "管理员", 90 => "超级管理员");
	}
	function getname($param) {
		return $this->perm_name[$param];
	}
}

?>