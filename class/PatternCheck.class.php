<?php
class PatternCheck {
	function uuid_check($str) {
		$pattern = "/^[0-9a-f]{8}[-][0-9a-f]{4}[-][0-9a-f]{4}[-][0-9a-f]{4}[-][0-9a-f]{12}$/i";
		if (preg_match($pattern, $str)) {
			return true;
		}
		return false;
	}
}
?>