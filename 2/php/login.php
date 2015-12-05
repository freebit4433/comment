<?php
session_start();
header("content-type:application/json;charset=utf-8");

require 'dbInit.class.php';

$dbObject = new dbInitClass();
$username = $_POST["username"];
$password = $_POST["password"];
$vcode = $_POST['vcode'];
$sessionVcode = $_SESSION['vcode'];

if ($sessionVcode != $vcode) {
	$txData['login'] = false;
	$txDataJSON = json_encode($txData);
	echo $txDataJSON;
	die();
}

$sql = "SELECT * FROM table2user WHERE username='{$username}' AND password='{$password}'";
$mysqli_result = $dbObject->mysqli->query($sql);
if ($dbObject->mysqli->errno) {
	echo "select error : " . $dbObject->mysqli->error;
}else{
	if ($mysqli_result->num_rows) {
		//说明能够查询到，即用户合法，则写session
		$_SESSION['username'] = $username;
		$_SESSION['login'] = true;
		//返回json字符串格式的数据，说登陆成功
		$txData['username'] = $username;
		$txData['login'] = true;
		$txDataJSON = json_encode($txData);
		echo $txDataJSON;
	}
	else{
		$txData['username'] = $username;
		$txData['login'] = false;
		$txDataJSON = json_encode($txData);
		echo $txDataJSON;
	}
}


$dbObject = NULL;
?>