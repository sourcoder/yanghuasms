<?php
class redirect {
	function toindex() {
		header("Location:index.php");
	}
	function tologin() {
		header("Location:login.php");
	}
}
?>