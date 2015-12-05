<?php
header("content-type:application/json;charset=utf-8");

require 'dbInit.class.php';

$username = $_POST['username'];
$password = $_POST['password'];
$registertime = time();
$imgnum = $_POST['imgnum'];
$sex = $_POST['sex'];
$webpage = $_POST['webpage'];

$dbObj = new dbInitClass();
$sql = "INSERT table2user VALUES(null,'{$username}','{$password}',{$registertime},{$imgnum},'{$sex}','{$webpage}')";
$res = $dbObj->mysqli->query($sql);
if ($res) {
	$txData['username'] = $username;
	$txData['register'] = true;
	$txDataJSON = json_encode($txData);
	echo $txDataJSON;
}else{
	$txData['username'] = $username;
	$txData['register'] = false;
	$txData['error'] = $dbObj->mysqli->error;
	$txDataJSON = json_encode($txData);
	echo $txDataJSON;
}


$dbObj = NULL;
?>