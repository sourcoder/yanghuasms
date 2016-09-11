<?php
include "dao.class.php";
session_start();
class account {
	private $D;
	function __construct() {
		$this->D = new dao();
	}
	function login($username, $password, $captcha) {
		$response = array();
		if (strtolower($captcha) != $_SESSION["captcha_session"]) {
			$response["code"] = 3;
			$response["info"] = "验证码错误";
			return $response;
		}
		$conn = $this->D->getconn();
		$sql = "SELECT COUNT(*) AS count FROM sms_user WHERE username=?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("s", $username);
		$stmt->bind_result($count);
		$stmt->execute();
		$stmt->store_result();
		$stmt->fetch();
		$stmt->free_result();
		$stmt->close();
		if ($count == 0) {
			$response["code"] = 2;
			$response["info"] = "该用户名不存在";
			return $response;
		}
		$sql = "SELECT id,permission AS count FROM sms_user WHERE username=? AND password=?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("ss", $username, $password);
		$stmt->bind_result($count, $per);
		$stmt->execute();
		$stmt->store_result();
		$stmt->fetch();
		$stmt->free_result();
		$stmt->close();
		if (!$count) {
			$response["code"] = 1;
			$response["info"] = "用户名或者密码错误";
			return $response;
		} else {
			$response["code"] = 0;
			$response["info"] = "登陆成功";
			$_SESSION["login"] = $count;
			$_SESSION["username"] = $username;
			$_SESSION["permission"] = $per;
			return $response;
		}
	}
	function register($data) {
		$conn = $this->D->getConn();
		$sql = "INSERT INTO sms_user(id,username,password,name,tel,organization,permission) values(uuid(),?,?,?,?,?,20)";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("sssss", $data["username"], $data["password"], $data["name"], $data["tel"], $data["oid"]);
		$stmt->execute();
		if ($stmt->affected_rows > 0) {
			$id = $stmt->insert_id;
			$_SESSION["login"] = $id;
			$stmt->close();
			return true;
		}
		$stmt->close();
		return false;
	}
	function checkusername($username) {
		$sql = "SELECT COUNT(*) FROM sms_user WHERE username='$username'";
		$result = $this->D->getquery($sql);
		$count = $result[0][0];
		if ($count == 0) {
			return true;
		}
		return false;
	}
	function checkinvitecode($code) {

		$sql = "SELECT id FROM sms_organization WHERE invite='$code' ";
		$result = $this->D->getquery($sql);
		$oid = $result[0][0];
		return $oid;
	}
	function getuserid() {
		if (isset($_SESSION["login"])) {
			return $_SESSION["login"];
		} else {
			return null;
		}
	}
	function getusername() {
		if (isset($_SESSION["username"])) {
			return $_SESSION["username"];
		} else {
			return null;
		}
	}
	function getpermission() {
		if (isset($_SESSION["permission"])) {
			return intval($_SESSION["permission"]);
		} else {
			return null;
		}
	}
	function setpermission($uid, $permission) {
		$sql = "UPDATE sms_user SET permission=? WHERE id=?";
		$stmt = $this->D->getconn()->prepare($sql);
		$stmt->bind_param("ss", $permission, $uid);
		if ($this->getuserid() == $uid) {
			$_SESSION["permission"] = $permission;
		}
		return $stmt->execute();
	}
	function logout() {
		unset($_SESSION["login"]);
		unset($_SESSION["username"]);
		unset($_SESSION["permission"]);
	}
}
function logcheck() {
	if (!isset($_SESSION["login"])) {
		header("Location:login.php");
	}
}
?>