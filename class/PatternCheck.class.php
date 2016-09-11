<?php
class PatternCheck {
	function uuid_check($str) {
		$pattern = "/^[0-9a-f]{8}[-][0-9a-f]{4}[-][0-9a-f]{4}[-][0-9a-f]{4}[-][0-9a-f]{12}$/i";
		if (preg_match($pattern, $str)) {
			return true;
		}
		return false;
	}
	function invite_check($str) {
		$pattern = "/^[0-9a-f]{8}$/i";
		if (preg_match($pattern, $str)) {
			return true;
		}
		return false;
	}
	function username_check($str) {
		$len = strlen($str);
		if ($len < 6 || $len > 30) {
			return false;
		}
		$pattern = "/^[0-9A-Za-z]*$/i";
		return preg_match($pattern, $str);
	}
	function password_check($str) {
		$len = strlen($str);
		if ($len < 8 || $len > 20) {
			return false;
		}
		$pattern = "/^[0-9A-Za-z]*$/i";
		return preg_match($pattern, $str) && preg_match("/[A-Za-z]/", $str) && preg_match("/\d/", $str);
	}
	function permission_check($str) {
		$pattern = "/^[0-9]{2,3}$/i";
		return preg_match($pattern, $str);
	}
}
?>