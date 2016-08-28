<?php
include 'class/account.class.php';
$username = null;
$password = null;
$captcha = null;
$flag = 0;
$msg = null;
if (isset($_SESSION["login"])) {
	header("Location:profile.php");
}
if (isset($_POST["username"])) {
	$username = $_POST["username"];
}
if (isset($_POST["password"])) {
	$password = $_POST["password"];
}
if (isset($_POST["captcha"])) {
	$captcha = $_POST["captcha"];
}
if ($username && $password && $captcha) {
	$flag = 1;
	$A = new account();
	$response = $A->login($username, $password, $captcha);
	if ($response["code"] == 0) {
		$flag = 2;
	}
	$msg = $response["info"];
} elseif (!$username && !$password && !$captcha) {
} else {
	$flag = 1;
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
		<title>扬华SMS-登录</title>
	</head>
	<body>
		<div class="container">
			<form class="form-signin" action="login.php" method="post">
				<h2 class="form-signin-heading">扬华SMS</h2>
				<label for="inputUsername" class="sr-only">Username</label>
				<input type="text" name="username" id="inputUsername" class="form-control" placeholder="Username" required autofocus>
				<label for="inputPassword" class="sr-only">Password</label>
				<input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
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
				<button class="btn btn-lg btn-primary btn-block" type="submit">登录</button>
				<a class="btn btn-lg btn-default btn-block"
				href="register.php" >注册</a>
			</form>
		</div>
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.js"></script>
			<?php
if ($flag == 2) {
	$script = "<script type='text/javascript'> $(function(){var seconds = 3;var str1 = '登陆成功！ ';var str2 = ' 秒后跳转！<a href=\'profile.php\' class=\'alert-link\' >立即跳转</a>';$('#success-msg').html(str1+seconds+str2);var timer = window.setInterval(update,1000);function update(){seconds--;$('#success-msg').html(str1+seconds+str2);if(seconds <= 0){window.clearInterval(timer);window.location.href = 'profile.php';}}});</script>";
	echo $script;
}
?>

	</body>
</html>