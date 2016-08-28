<?php
include "class/account.class.php";
include "class/PatternCheck.class.php";
$PC = new PatternCheck();
$A = new account();
$invitecode = null;
$username = null;
$password = null;
$cpassword = null;
$tel = null;
$name = null;
$captcha = null;
$msg = null;
$flag = 0;
if (isset($_POST["invitecode"])) {
	$invitecode = $_POST["invitecode"];
}
if (isset($_POST["username"])) {
	$username = $_POST["username"];
}
if (isset($_POST["password"])) {
	$password = $_POST["password"];
}
if (isset($_POST["confirmpassword"])) {
	$cpassword = $_POST["confirmpassword"];
}
if (isset($_POST["tel"])) {
	$tel = $_POST["tel"];
}
if (isset($_POST["name"])) {
	$name = $_POST["name"];
}
if (isset($_POST["captcha"])) {
	$captcha = $_POST["captcha"];
}
if ($invitecode && $username && $password && $cpassword && $tel && $name && $captcha) {
	$flag = 1;
	if (strtolower($captcha) != $_SESSION["captcha_session"]) {
		$msg = "验证码错误";
	} else {
		if ($PC->invite_check($invitecode)) {
			$oid = $A->checkinvitecode($invitecode);
			if ($oid) {
				if (!$A->checkusername($username)) {
					$msg = "该用户名已存在";
				} else {
					if (!$PC->username_check($username)) {
						$msg = "用户名格式错误";
					} else {
						if ($password != $cpassword) {
							$msg = "两次输入的密码不同";
						} else {
							if (!$PC->password_check($password)) {
								$msg = "密码格式错误";
							} else {
								$msg = "注册成功";
								$data = array();
								$data["oid"] = $oid;
								$data["username"] = $username;
								$data["password"] = $password;
								$data["name"] = $name;
								$data["tel"] = $tel;
								$A->register($data);
								$flag = 2;
							}
						}
					}
				}
			} else {
				$msg = "邀请码不存在";
			}
		} else {
			$msg = "邀请码格式错误";
		}
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
		<title>扬华SMS-注册</title>
	</head>
	<body>
		<div class="container">
			<form class="form-signin" action="register.php" method="post">
				<h2 class="form-signin-heading">扬华SMS－注册</h2>
				<label for="inviteCode" class="sr-only">邀请码</label>
				<input type="text" id="inviteCode" name="invitecode" class="form-control" placeholder="请输入邀请码" required value="<?php echo $invitecode; ?>">
				<label for="inputUsername" class="sr-only">Username</label>
				<input type="text" id="inputUsername" name="username" class="form-control" placeholder="请输入用户名" required autofocusrel="txtTooltip" data-trigger="hover" data-toggle="tooltip"
				data-placement="top" title="请输入6-30位用户名，仅支持大小写字母和数字" value="<?php echo $username; ?>">
				<label for="inputPassword" class="sr-only">Password</label>
				<input type="password" id="inputPassword" name="password" class="form-control" placeholder="请输入密码" required rel="txtTooltip" data-trigger="hover" data-toggle="tooltip"
				data-placement="top" title="请输入8-20位密码，必须包括数字和字母">
				<label for="confirmPassword" class="sr-only">Confirm Password</label>
				<input type="password" id="confirmPassword" name="confirmpassword" class="form-control" placeholder="请再次输入密码" required>
				<label for="inputName" class="sr-only">请输入姓名</label>
				<input type="text" id="inputName" name="name" class="form-control" placeholder="请输入姓名" required value="<?php echo $name; ?>">
				<label for="inputTel" class="sr-only">请输入电话号码</label>
				<input type="tel" id="inputTel" name="tel" class="form-control" placeholder="请输入电话号码" required value="<?php echo $tel; ?>">
				<div class="row">
					<div class="col-xs-6" style="padding-right:0px">
						<label for="inputVerificationCode" class="sr-only">请输入验证码</label>
						<input type="tel" name="captcha" id="inputVerificationCode" class="form-control" placeholder="请输入验证码" required>
					</div>
					<div class="col-xs-6" style="padding-left:2px">
						<img title="点击刷新" src="captcha.php" onclick="this.src='captcha.php?'+Math.random();">
					</div>
				</div>
				<?php
if ($flag == 2) {
	$success_msg = "<div class='alert alert-success' id='success-msg' role='alert'>...</div>";
	echo $success_msg;
} elseif ($flag == 1) {
	$danger_msg = "<div class='alert alert-danger' role='alert'>" . $msg . "</div>";
	echo $danger_msg;
}
?>
				<button class="btn btn-lg btn-primary btn-block" type="submit">注册</button>
				<a class="btn btn-lg btn-default btn-block"
				href="javascript:window.location.href='login.php';" >取消</a>
			</form>
		</div>
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript">
		$(function(){
			$("#inputPassword").tooltip();
			$("#inputUsername").tooltip();
		});
		</script>
		<?php
if ($flag == 2) {
	$script = "<script type='text/javascript'> $(function(){var seconds = 3;var str1 = '注册成功！ ';var str2 = ' 秒后跳转！<a href=\'profile.php\' class=\'alert-link\' >立即跳转</a>';$('#success-msg').html(str1+seconds+str2);var timer = window.setInterval(update,1000);function update(){seconds--;$('#success-msg').html(str1+seconds+str2);if(seconds <= 0){window.clearInterval(timer);window.location.href = 'profile.php';}}});</script>";
	echo $script;
}
?>
	</body>
</html>