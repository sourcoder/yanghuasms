<?php
include "dao.class.php";
session_start();
class account {
	function login($username, $password) {
		$response = array();
		$D = new dao();
		$conn = $D->getConn();
		$sql = "SELECT COUNT(*) AS count FROM sms_user WHERE username='?'";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("s", $username);
		$result = $stmt->execute();
		$row = $result->fetch_array();
		$count = $row["count"];
		if ($count == 0) {
			$response["code"] = 2;
			$response["info"] = "该用户名不存在";
			return $response;
		}
		$sql = "SELECT id AS count FROM sms_user WHERE username='?' AND password='?'";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("ss", $username, $password);
		$result = $stmt->execute();
		$row = $result->fetch_array();
		$count = $stmt->affected_rows;
		if ($count == 0) {
			$response["code"] = 1;
			$response["info"] = "用户名或者密码错误";
			return $response;
		} else {
			$response["code"] = 0;
			$response["info"] = "登陆成功";
			$SESSION["login"] = $row["id"];
			return $response;
		}
	}
	function getlogstate() {
		if (isset($SESSION["login"])) {
			return true;
		} else {
			return false;
		}
	}
	function logout() {
		unset($SESSION["login"]);
	}
}
?>