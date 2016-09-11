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
if (isset($_POST["userid"]) && isset($_POST["organization"]) && isset($_POST["permission"]) && isset($id)) {
	$userid = $_POST["userid"];
	$organization = $_POST["organization"];
	$topermission = $_POST["permission"];
	if ($PC->uuid_check($userid) && $PC->uuid_check($organization) && $PC->permission_check($topermission)) {
		$sql = "SELECT permission FROM sms_user WHERE id='$userid'";
		$result = $D->getcachequery($sql);
		$upermission = intval($result[0][0]);
		if ($permission > $upermission && (intval($topermission) == 20 || intval($topermission) == 60)) {
			$sql = "UPDATE sms_user SET permission=? WHERE id=?";
			$stmt = $D->getconn()->prepare($sql);
			$stmt->bind_param("ss", $topermission, $userid);
			$stmt->execute();
			if ($stmt->affected_rows > 0) {
				$data["state"] = "success";
				$D->flush();
			} else {
				$data["msg"] = "数据录入失败！";
			}
		} else {
			$data["msg"] = "没有权限";
		}
	} else {
		$data["msg"] = "信息格式错误";
	}
} else {
	$data["msg"] = "信息输入错误";
}
echo json_encode($data);
?>