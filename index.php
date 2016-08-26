<?php
include 'dao.class.php';
header("Content-type: text/html; charset=utf-8");
/*
$mem = new Memcache();
$mem->addServer("127.0.0.1", 11211);
$mem->set("123", "321", MEMCACHE_COMPRESSED, 30);
echo md5($mem->get("123"));
 */
$test = new dao();
$sql = "SELECT * FROM t_video LIMIT 0,10";
var_dump($test->getquery($sql));
?>
