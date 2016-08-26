<?php
include "class/PatternCheck.class.php";
include "class/account.class.php";
include "class/dao.class.php";
$P = new PatternCheck();
$uid = null;
$id = null;
session_start();
if (!isset($SESSION["login"])) {
	header("Location:login.php");
} else {
	$uid = $SESSION["login"];
	if (!$P->uuid_check($uid)) {
		$L = new account();
		$L->logout();
		header("Location:login.php");
	}
	if (!isset($GET["id"])) {
		header("Location:profile.php?uid=" . $uid);
	} else {
		$id = $GET["id"];
		if (!$P->uuid_check($id)) {
			header("Location:profile.php?uid=" . $uid);
		}
		//验证完成，开始请求数据。
		$D = new dao();
		$sql = "SELECT COUNT(*) FROM sms_sendlog,sms_send WHERE sms_send.sendlog=sms_sendlog.id AND sms_sendlog.app=1 AND sms_sendlog.organization='' AND time="
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
					<a href="#" class="navbar-brand">扬华SMS</a>
				</div>
				<div class="collapse navbar-collapse navbar-responsive-collapse">
					<ul class="nav navbar-nav">
						<li class="active"><a href="console.php<?php echo "?id=" . $id; ?>">控制台</a></li>
						<li><a href="notice_manage.html">通知</a></li>
						<li><a href="fresh_manage.html">招新管理</a></li>
						<li><a href="member_manage.html">成员管理</a></li>
						<li><a href="send_log.html">历史记录</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-lg-12">
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
									<td><a href="#">20</a></td>
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
									<th>今月使用</th>
									<th>联系人数</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><a href="#">通知</a></td>
									<td>23</td>
									<td>30</td>
									<td>50</td>
								</tr>
								<tr>
									<td><a href="#">招新管理</a></td>
									<td>30</td>
									<td>50</td>
									<td>100</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>