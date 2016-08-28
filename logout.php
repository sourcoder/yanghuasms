<?php
include 'class/account.class.php';
$A = new account();
$A->logout();
header("Location:index.php");
?>