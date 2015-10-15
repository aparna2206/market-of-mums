<?php
ini_set('display_errors',0);
session_start();
include_once $_SERVER['DOCUMENT_ROOT']."../../lib/User.class.php";
//$_SESSION['user_id']=2; // temperary added by amar
//error is here 
$u = new User($_SESSION['user_id']);
if($u->isAdmin()){
include_once $_SERVER['DOCUMENT_ROOT']."../../lib/Admin.class.php";
$u = new Admin($_SESSION['user_id']);
}
?>
