<?php
include "class/account.class.php";
include "class/config_var.class.php";
logcheck();
$A = new account();
$D = new dao();
$P = new PER();
$id = $A->getuserid();
$sql = "SELECT sms_user.username,sms_user.name,sms_user.tel,sms_user.organization,sms_user.permission,sms_organization.name AS oname FROM sms_user,sms_organization WHERE sms_user.organization=sms_organization.id AND sms_user.id='$id'";
$result = $D->getcachequery($sql);
$row = $result[0];
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="css/signin.css">
		<link type="image/x-icon" rel="shortcut icon" href="favicon.ico" />
		<title>扬华SMS-个人中心</title>
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
						<li><a href="console.php?id=<?php echo $row["organization"]; ?>">控制台</a></li>
						<li><a href="notice_manage.html">通知</a></li>
						<li><a href="fresh_manage.html">招新管理</a></li>
						<li><a href="member_manage.php?id=<?php echo $row["organization"]; ?>">成员管理</a></li>
						<li><a href="send_log.html">历史记录</a></li>
						<li class="active"><a href="profile.php"><span class="glyphicon glyphicon-user" aria-hidden="true"></span><?php echo $A->getusername(); ?></a></li>
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
							<div class="btn-group btn-group-lg" role="group" aria-label="">
								<button type="button" class="btn btn-default" data-target="#edit-info-modal" data-toggle="modal">编辑信息</button>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<span class="glyphicon glyphicon-stats" aria-hidden="true"></span>
							<label>个人信息</label>
						</div>
						<table class="table table-responsive">
							<thead>
								<tr>
									<th>用户名</th>
									<th>姓名</th>
									<th>电话号码</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $row["username"]; ?></td>
									<td><?php echo $row["name"]; ?></td>
									<td><?php echo $row["tel"]; ?></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<span class="glyphicon glyphicon-scale" aria-hidden="true"></span>
							<label>参与部门</label>
						</div>
						<table class="table table-responsive">
							<thead>
								<tr>
									<th>部门名</th>
									<th>权限</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><a href="console.php?id=<?php echo $row["organization"]; ?>"><?php echo $row["oname"]; ?></a></td>
									<td><?php echo $P->getname($row["permission"]); ?></td>
									<td>
										<div class="btn-group btn-group-sm" role="group" aria-label="">
											<button type="button" class="btn btn-default btn-edit">退出</button>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="edit-info-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title">编辑信息</h4>
						<input type="hidden" id="user-id" value="<?php echo $id; ?>">
					</div>
					<div class="modal-body">
						<label class="form-control"><?php echo $row["username"]; ?></label>
						<input type="text" placeholder="请输入姓名" id="modal-text-name" class="form-control" value="<?php echo $row["name"]; ?>">
						<input type="text" placeholder="请输入电话号码" id="modal-text-tel" class="form-control" value="<?php echo $row["tel"]; ?>">
						<div class="alert alert-dismissible hidden" id="modal-alert" role="alert">...</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
						<button type="button" id="edit-submit" class="btn btn-primary">确定</button>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.js"></script>
		<script type="text/javascript" src="js/edit.js"></script>
	</body>
</html>