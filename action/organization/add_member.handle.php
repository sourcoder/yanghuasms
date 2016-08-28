<?php
include '../../class/account.class.php';
include '../../class/PatternCheck.class.php';
$A = new account();
$D = new dao();
$PC = new PatternCheck();
$id = $A->getuserid();
$data = array();
$data["state"] = "error";
$permission = $A->getpermission();
if (isset($_POST["username"]) && isset($_POST["organization"]) && isset($id)) {
	$username = $_POST["username"];
	$organization = $_POST["organization"];
	if ($PC->username_check($username) && $PC->uuid_check($organization)) {
		$sql = "SELECT * FROM sms_user WHERE username='$username'";
		$result = $D->getcachequery($sql);
		if ($result) {
			$row = $result[0];
			if (trim($row["organization"]) != trim($organization)) {
				$uid = $row["id"];
				$sql = "UPDATE sms_user SET organization=? WHERE id=?";
				$stmt = $D->getconn()->prepare($sql);
				$stmt->bind_param("ss", $organization, $uid);
				$stmt->execute();
				if ($stmt->affected_rows > 0) {
					$data["state"] = "success";
					$D->flush();
				} else {
					$data["msg"] = "数据库添加失败！";
				}
			} else {
				$data["msg"] = "该用户已加入！";
			}
		} else {
			$data["msg"] = "该用户不存在！";
		}
	} else {
		$data["msg"] = "输入信息格式错误！";
	}
} else {
	$data["msg"] = "输入信息不完整！";
}
header("Content-Type:text/html;charset=utf-8");
echo json_encode($data);
?>