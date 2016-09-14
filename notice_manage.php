<?php
include "class/account.class.php";
include "class/PatternCheck.class.php";
include "class/redirect.class.php";
include "class/date.class.php";
logcheck();
$PC = new PatternCheck();
$A = new account();
$R = new redirect();
$D = new dao();
$PC = new PatternCheck();
$P = new PER();
$uid = $A->getuserid();
if (!isset($_GET["id"])) {
	$R->toprofile();
} else {
	$id = $_GET["id"];
	if (!$PC->uuid_check($id)) {
		$R->toprofile();
	}
//验证完成，开始请求数据。
	date_default_timezone_set('prc');
	$todayapp1 = 0;
	$monthapp1 = 0;
	$membercount = 0;
	$app_count_1 = 0;
	$app_title = null;
	$date = new date(time());
	//通知－今日
	$starttime = $date->getTodayStart();
	$endtime = $date->getTodayEnd();
	$sql = "SELECT COUNT(*) FROM sms_sendlog,sms_send WHERE sms_send.sendlog=sms_sendlog.id AND sms_sendlog.app=1 AND sms_sendlog.organization='$id' AND sms_sendlog.time BETWEEN '$starttime' AND '$endtime'";
	$result = $D->getcachequery($sql);
	if ($result) {
		$todayapp1 = intval($result[0][0]);
	}
	//通知－本月
	$starttime = $date->getMonthStart();
	$endtime = $date->getMonthEnd();
	$sql = "SELECT COUNT(*) FROM sms_sendlog,sms_send WHERE sms_send.sendlog=sms_sendlog.id AND sms_sendlog.app=1 AND sms_sendlog.organization='$id' AND sms_sendlog.time BETWEEN '$starttime' AND '$endtime'";
	$result = $D->getcachequery($sql);
	if ($result) {
		$monthapp1 = intval($result[0][0]);
	}
	//成员数
	$sql = "SELECT COUNT(*) FROM sms_user WHERE sms_user.organization='$id'";
	$result = $D->getcachequery($sql);
	if ($result) {
		$membercount = $result[0][0];
	}
	//应用1联系人数
	$sql = "SELECT COUNT(*) FROM sms_group,sms_contacts WHERE sms_group.organization='$id' AND sms_group.app=1 AND sms_contacts.groups=sms_group.id";
	$result = $D->getcachequery($sql);
	if ($result) {
		$app_count_1 = $result[0][0];
	}
	//应用2联系人数
	$sql = "SELECT COUNT(*) FROM sms_group,sms_contacts WHERE sms_group.organization='$id' AND sms_group.app=2 AND sms_contacts.groups=sms_group.id";
	$result = $D->getcachequery($sql);
	if ($result) {
		$app_count_2 = $result[0][0];
	}
	//组织名
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
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.js"></script>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="css/signin.css">
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
					<a href="##" class="navbar-brand">扬华SMS</a>
				</div>
				<div class="collapse navbar-collapse navbar-responsive-collapse">
					<ul class="nav navbar-nav">
						<li><a href="console.php?id=<?php echo $id; ?>">控制台</a></li>
						<li class="active"><a href="javascript:location.reload();">通知</a></li>
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
				<div class="col-md-3 col-lg-2">
					<div class="list-group">
						<a href="javascript:location.reload();" class="list-group-item active">概述</a>
						<a href="notice_contacts.html" class="list-group-item">通讯录管理</a>
						<a href="notice_send.html" class="list-group-item">信息发送</a>
					</div>
				</div>
				<div class="col-md-9 col-lg-10">
					<div class="panel panel-default">
						<div class="panel-heading">
							<span class="glyphicon glyphicon-stats" aria-hidden="true"></span>
							<label>使用统计</label>
						</div>
						<table class="table table-responsive">
							<thead>
								<tr>
									<th>今日使用</th>
									<th>本月使用</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>30</td>
									<td>80</td>
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
									<th>近一个月使用量</th>
									<th>联系人数</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>通知</td>
									<td>23</td>
									<td>30</td>
									<td>50</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>