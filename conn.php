<?php
$conn = null;
$mem = null;
header ( "Content-type: text/html; charset=utf-8" );
function connect() {
  $conn = new mysqli ( "localhost", "root", "", "SMS_Yanghua_Msg" );
  $mem = new Memcache ();
  $mem->connect ( "127.0.0.1", 11211 );
}
function close() {
  global $conn;
  $conn->close ();
}
$conn = new mysqli ( "localhost", "root", "", "nineoneporn" );
$mem = new Memcache ();
$mem->connect ( "127.0.0.1", 11211 );
$sql = "SELECT * FROM t_video LIMIT 0,10";
$result = $conn->query ( $sql );
$data = array ();
$label = array ();
while ( ($filed = $result->fetch_field ()) ) {
  $label [] = $filed->name;
}
while ( $row = $result->fetch_array () ) {
  $rowdata = array ();
//   for($i=0;$i<count($label);$i++){
//     $rowdata[$label[$i]] = $row[$label[$i]];
//   }
//   $data[] = $rowdata;
  $data[] = $row;
}
//var_dump ( $data );
$mem->set ( hash ( "md5", $sql ), $data, 0, 180 );
$res = $mem->get ( hash ( "md5", $sql ) );
$te = $mem->get("haha");

var_dump ( $res );
$mem->close ();
$conn->close ();

// phpinfo ();
?>