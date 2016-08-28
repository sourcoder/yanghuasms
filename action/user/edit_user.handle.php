<?php
include '../../class/account.class.php';
$A = new account();
$id = $A->getuserid();
$data = array();
$data["state"] = "error";
//if ($id) {
$uid = null;
$name = null;
$tel = null;
if (isset($_POST["userid"])) {
	$uid = $_POST["userid"];
}
if (isset($_POST["name"])) {
	$name = $_POST["name"];
}
if (isset($_POST["tel"])) {
	$tel = $_POST["tel"];
}
if ($uid && $name && $tel && $id) {

	$D = new dao();
	$conn = $D->getconn();
	$sql = "UPDATE sms_user SET name=?,tel=? WHERE id=?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("sss", $name, $tel, $uid);
	$stmt->execute();
	if ($stmt->affected_rows > 0) {
		$data["state"] = "success";
		$D->flush();
	}
}
echo json_encode($data);
//}
?>