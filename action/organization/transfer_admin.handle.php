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
if (isset($_POST["userid"]) && isset($_POST["organization"]) && isset($id)) {
	$userid = $_POST["userid"];
	$organization = $_POST["organization"];
	if ($PC->uuid_check($userid) && $PC->uuid_check($organization)) {
		if (intval($permission) >= 80) {
			$sql = "SELECT COUNT(*) FROM sms_organization WHERE id='$organization' UNION ALL SELECT COUNT(*) FROM sms_user WHERE id='$id'";
			$result = $D->getcachequery($sql);
			$exist_or = $result[0][0];
			$exist_uid = $result[1][0];
			if ($exist_uid > 0 && $exist_or > 0) {
				$sql = "UPDATE sms_organization SET admin=? WHERE id=?";
				$stmt = $D->getconn()->prepare($sql);
				$stmt->bind_param("ss", $userid, $organization);
				$stmt->execute();
				$A->setpermission($userid, 80);
				$A->setpermission($id, 60);
				$D->flush();
				$data["state"] = "success";

			} else {
				$data["msg"] = "该社团或该用户不存在！";
			}
		} else {
			$data["msg"] = "权限不足!";
		}
	} else {
		$data["msg"] = "输入信息格式错误！";
	}
} else {
	$data["msg"] = "输入信息格式错误！";
}
echo json_encode($data);
?>