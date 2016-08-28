<?php
include "./class/PatternCheck.class.php";
include "./class/account.class.php";
include "./class/date.class.php";
$PC = new PatternCheck();
$uid = null;
$id = null;
logcheck();
$A = new account();
$uid = $_SESSION["login"];
if (!isset($_GET["id"])) {
	header("Location:profile.php?uid=" . $uid);
} else {
	$id = $_GET["id"];
	if (!$PC->uuid_check($id)) {
		header("Location:profile.php?uid=" . $uid);
	}
//验证完成，开始请求数据。
	$id = $_GET["id"];
	date_default_timezone_set('prc');
	$D = new dao();
	$todayapp1 = 0;
	$todayapp2 = 0;
	$monthapp1 = 0;
	$monthapp2 = 0;
	$membercount = 0;
	$app_count_1 = 0;
	$app_count_2 = 0;
	$app_title = null;
	$date = new date(time());
	$starttime = $date->getTodayStart();
	$endtime = $date->getTodayEnd();
	$sql = "SELECT COUNT(*) FROM sms_sendlog,sms_send WHERE sms_send.sendlog=sms_sendlog.id AND sms_sendlog.app=1 AND sms_sendlog.organization='$id' AND sms_sendlog.time BETWEEN '$starttime' AND '$endtime'";
	$result = $D->getcachequery($sql);
	if ($result) {
		$todayapp1 = intval($result[0][0]);
	}
	$sql = "SELECT COUNT(*) FROM sms_sendlog,sms_send WHERE sms_send.sendlog=sms_sendlog.id AND sms_sendlog.app=2 AND sms_sendlog.organization='$id' AND sms_sendlog.time BETWEEN '$starttime' AND '$endtime'";
	$result = $D->getcachequery($sql);
	if ($result) {
		$todayapp2 = intval($result[0][0]);
	}
	$starttime = $date->getMonthStart();
	$endtime = $date->getMonthEnd();
	$sql = "SELECT COUNT(*) FROM sms_sendlog,sms_send WHERE sms_send.sendlog=sms_sendlog.id AND sms_sendlog.app=1 AND sms_sendlog.organization='$id' AND sms_sendlog.time BETWEEN '$starttime' AND '$endtime'";
	$result = $D->getcachequery($sql);
	if ($result) {
		$monthapp1 = intval($result[0][0]);
	}
	$sql = "SELECT COUNT(*) FROM sms_sendlog,sms_send WHERE sms_send.sendlog=sms_sendlog.id AND sms_sendlog.app=2 AND sms_sendlog.organization='$id' AND sms_sendlog.time BETWEEN '$starttime' AND '$endtime'";
	$result = $D->getcachequery($sql);
	if ($result) {
		$monthapp2 = intval($result[0][0]);
	}
	$sql = "SELECT COUNT(*) FROM sms_user WHERE sms_user.organization='$id'";
	$result = $D->getcachequery($sql);
	if ($result) {
		$membercount = $result[0][0];
	}
	$sql = "SELECT COUNT(*) FROM sms_group,sms_contacts WHERE sms_group.organization='$id' AND sms_group.app=1 AND sms_contacts.groups=sms_group.id";
	$result = $D->getcachequery($sql);
	if ($result) {
		$app_count_1 = $result[0][0];
	}
	$sql = "SELECT COUNT(*) FROM sms_group,sms_contacts WHERE sms_group.organization='$id' AND sms_group.app=2 AND sms_contacts.groups=sms_group.id";
	$result = $D->getcachequery($sql);
	if ($result) {
		$app_count_2 = $result[0][0];
	}
	$sql = "SELECT name FROM sms_organization WHERE id='$id'";
	$result = $D->getcachequery($sql);
	if ($result) {
		$app_title = $result[0][0];
	}
}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="css/signin.css">
		<link type="image/x-icon" rel="shortcut icon" href="favicon.ico" />
		<title>扬华SMS-控制台</title>
	</head>
	<body class="fix-top">
		<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-responsive-collapse">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</button>
					<a href="#" class="navbar-brand">扬华SMS</a>
				</div>
				<div class="collapse navbar-collapse navbar-responsive-collapse">
					<ul class="nav navbar-nav">
						<li class="active"><a href="console.php?id=<?php echo $id; ?>">控制台</a></li>
						<li><a href="notice_manage.html">通知</a></li>
						<li><a href="fresh_manage.html">招新管理</a></li>
						<li><a href="member_manage.php?id=<?php echo $id; ?>">成员管理</a></li>
						<li><a href="send_log.html">历史记录</a></li>
						<li><a href="profile.php"><span class="glyphicon glyphicon-user" aria-hidden="true"></span><?php echo $A->getusername(); ?></a></li>
						<li><a href="logout.php">退出登录</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-lg-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<h1 class="text-center text-primary"><strong><?php echo $app_title; ?></strong></h1>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<span class="glyphicon glyphicon-stats" aria-hidden="true"></span>
							<label>使用统计</label>
						</div>
						<table class="table table-responsive">
							<thead>
								<tr>
									<th>成员人数</th>
									<th>今日使用</th>
									<th>本月使用</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><a href="#"><?php echo $membercount; ?></a></td>
									<td><?php echo $todayapp1 + $todayapp2; ?></td>
									<td><?php echo $monthapp1 + $monthapp2; ?></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<span class="glyphicon glyphicon-scale" aria-hidden="true"></span>
							<label>应用统计</label>
						</div>
						<table class="table table-responsive">
							<thead>
								<tr>
									<th>应用名</th>
									<th>今日使用</th>
									<th>今月使用</th>
									<th>联系人数</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><a href="#">通知</a></td>
									<td><?php echo $todayapp1; ?></td>
									<td><?php echo $monthapp1; ?></td>
									<td><?php echo $app_count_1; ?></td>
								</tr>
								<tr>
									<td><a href="#">招新管理</a></td>
									<td><?php echo $todayapp2; ?></td>
									<td><?php echo $monthapp2; ?></td>
									<td><?php echo $app_count_2; ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.js"></script>
	</body>
</html>