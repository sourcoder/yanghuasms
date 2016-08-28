<?php
include "class/account.class.php";
include "class/PatternCheck.class.php";
include "class/redirect.class.php";
include "class/config_var.class.php";
logcheck();
$PC = new PatternCheck();
$A = new account();
$R = new redirect();
$D = new dao();
$P = new PER();
$uid = $A->getuserid();
$uinfo = null;
$id = null;
$row = null;
$result = null;
if (isset($_GET["id"])) {
	$id = $_GET["id"];
	if ($PC->uuid_check($id)) {
		$sql = "SELECT name,admin,invite FROM sms_organization WHERE id='$id'";
		$result = $D->getcachequery($sql);
		$row = $result[0];
		$sql = "SELECT id,username,name,permission FROM sms_user WHERE organization='$id' ORDER BY permission DESC";
		$result = $D->getcachequery($sql);
		for ($i = 0; $i < count($result); $i++) {
			if ($result[$i]["id"] == $uid) {
				$uinfo = $result[$i];
				break;
			}
		}
	} else {
		$R->toindex();
	}
} else {
	$R->toindex();
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
		<title>扬华SMS-成员管理</title>
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
						<li><a href="notice_manage.html">通知</a></li>
						<li><a href="fresh_manage.html">招新管理</a></li>
						<li class="active"><a href="javascript:location.reload();">成员管理</a></li>
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
							<?php
if (intval($uinfo["permission"]) >= 60) {
	echo "<div class=\"panel panel-default\">\n<div class=\"panel-body\">\n";
	echo "<div class=\"btn-group btn-group-lg\" role=\"group\" aria-label=\"\">";
	echo "<button type=\"button\" class=\"btn btn-default\" id=\"add-member\">添加成员</button>";
}
if (intval($uinfo["permission"]) >= 80) {
	echo "<button type=\"button\" class=\"btn btn-default\" id=\"transfer-admin\">转让管理员</button>";
}

if (intval($uinfo["permission"]) >= 60) {
	echo "</div>\n</div>\n</div>\n";
}
?>


					<div class="panel panel-defalut">
						<div class="panel-body">
							<input type="hidden" id="oid" value="<?php echo $id; ?>">
							<label>邀请码：</label>
							<label><?php echo $row["invite"]; ?></label>
							<div class="pull-right">
							<?php
if (intval($uinfo["permission"]) >= 60) {
	echo "<button class=\"btn btn-primary\">重置邀请码</button>";
}
?>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<table class="table table-responsive">
							<thead>
								<th>用户名</th>
								<th>姓名</th>
								<th>级别</th>
								<?php if (intval($uinfo["permission"]) >= 60) {
	echo "<th>操作</th>";
}
?>
							</thead>
							<tbody>
							<?php
for ($i = 0; $i < count($result); $i++) {
	?>
								<tr>
									<td><?php echo $result[$i]["username"]; ?></td>
									<td><?php echo $result[$i]["name"]; ?></td>
									<td><?php echo $P->getname(intval($result[$i]["permission"])); ?></td>
									<?php
if (intval($uinfo["permission"]) >= 60) {
		echo "<td>\n";
		echo "<div class=\"btn-group btn-group-sm\" role=\"group\" aria-label=\"\">\n";
	}
	if (intval($uinfo["permission"]) > intval($result[$i]["permission"])) {
		echo "<button type=\"button\" class=\"btn btn-default btn-edit\" uid=\"" . $result[$i]["id"] . "\">权限编辑</button>\n";
		echo "<button type=\"button\" class=\"btn btn-default btn-delete\" uid=\"" . $result[$i]["id"] . "\">删除</button>\n";
	}
	if (intval($uinfo["permission"]) >= 60) {
		echo "</div>\n";
		echo "</td>\n";
	}
	?>
								</tr>
							<?php
}
?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="add-member-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" id="member-title">添加用户</h4>
					</div>
					<div class="modal-body">
						<input type="text" class="form-control" id="add-member-name" placeholder="请输入用户名">
						<div class="alert alert-success alert-dismissible hidden" role="alert">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
						<button type="button" class="btn btn-primary" id="add-member-btn">确定</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="transfer-member-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title">转让管理员</h4>
					</div>
					<div class="modal-body">
						<select class="form-control" id="userlist">
						<?php
for ($i = 0; $i < count($result); $i++) {
	echo "<option value=\"" . $result[$i]["id"] . "\">" . $result[$i]["username"] . "</option>\n";
}
?>
						</select>
						<div class="alert alert-success alert-dismissible hidden" role="alert">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
						<button type="button" class="btn btn-danger id="add-member-btn"">确定</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="edit-member-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title">编辑成员</h4>
					</div>
					<div class="modal-body">
						<input type="text" class="form-control" readOnly="true" id="member-username">
						<input type="text" class="form-control" readOnly="true" id="member-name">
						<select class="form-control" name="member_permision" id="member-permission">
							<?php
if (intval($uinfo["permission"]) > 60) {
	echo "<option value=\"60\">协管员</option>\n";
}
if (intval($uinfo["permission"]) > 40) {
	echo "<option value=\"40\">成员</option>\n";
}
?>
						</select>
						<div class="alert alert-success alert-dismissible hidden" role="alert">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
						<button type="button" class="btn btn-primary">确定</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="delete-member-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title">删除成员</h4>
					</div>
					<div class="modal-body">
						确定要删除 <strong class="modal-msg"></strong> 吗？
						<div class="alert alert-success alert-dismissible hidden" role="alert">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
						<button type="button" class="btn btn-danger">删除</button>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.js"></script>
		<script type="text/javascript" src="js/member.js"></script>
	</body>
</html>