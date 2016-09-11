<?php
include 'class/dao.class.php';
header("Content-type: text/html; charset=utf-8");
/*
$mem = new Memcache();
$mem->addServer("127.0.0.1", 11211);
$mem->set("123", "321", MEMCACHE_COMPRESSED, 30);
echo md5($mem->get("123"));
 */
$D = new dao();
?>
//$D->flush();
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript">
var obj = {
	""
};
</script>
</body>
</html>

