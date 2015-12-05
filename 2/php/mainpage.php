<?php
session_start();
header("content-type:application/json;charset=utf-8");
require 'dbInit.class.php';

$dbObj = new dbInitClass();
$action = $_POST['action'];
$username = $_SESSION['username'];

switch ($action) {
	case 'refresh':{
		$sql = "SELECT * FROM table2comment";
		$mysqli_result_comment = $dbObj->mysqli->query($sql);
		if ($dbObj->mysqli->errno) {
			echo "select comment error :" . $dbObj->mysqli->error;
			die();
		}
		$i = 0;
		while ($row = $mysqli_result_comment->fetch_assoc()) {
			date_default_timezone_set('PRC');
			$row['commenttime'] = date("Y年m月d日 H:i:s",$row['commenttime']);
			$rows[$i] = $row;
			$sql = null;
			$dbObj = null;
			$dbObj = new dbInitClass();
			$sql = "SELECT imgnum,webpage FROM table2user WHERE username='{$rows[$i]['username']}'";
			$mysqli_result_user = $dbObj->mysqli->query($sql);
			if ($dbObj->mysqli->errno) {
				echo "select user error :" . $dbObj->mysqli->error;
				die();
			}
			$rowUser = $mysqli_result_user->fetch_assoc();
			$rows[$i]['imgnum'] = $rowUser['imgnum'];
			$rows[$i]['webpage'] = $rowUser['webpage'];
			$mysqli_result_user->free();
			
			$i++;
		}
		$mysqli_result_comment->free();
		$dbObj = null;
		$txJSON = json_encode($rows);
		echo $txJSON;
		break;
	}
	case 'insert':{
		$comment = $_POST['comment'];
		$commenttime = time();
		$sql = "INSERT table2comment VALUES(null,'{$username}','{$comment}',{$commenttime})";
		$res = $dbObj->mysqli->query($sql);
		if ($dbObj->mysqli->errno) {
			echo "insert error :" . $dbObj->mysqli->error;
			die();
		}
		if ($res) {
			$txData['username'] = $username;
			$txData['flag'] = true;
			$txDataJSON = json_encode($txData);
			echo $txDataJSON;
		}
		else{
			$txData['username'] = $username;
			$txData['flag'] = false;
			$txDataJSON = json_encode($txData);
			echo $txDataJSON;
		}

		$dbObj = null;
		break;
	}
	case 'delete':{
		/*$txDataDelete['username'] = 'zhangtao';
		$txDataDelete['id'] = $_POST['deleteid'];
		$txDataJSONDelete = json_encode($txDataDelete);
		echo $txDataJSONDelete;*/
		$deleteID = $_POST['deleteid'];
		$sql = "DELETE FROM table2comment WHERE id={$deleteID}";
		$res = $dbObj->mysqli->query($sql);
		if ($dbObj->mysqli->errno) {
			echo "delete error:" . $dbObj->mysqli->error;
		}else{
			$txData['deleteflag'] = true;
		}
		$txDataJSON = json_encode($txData);
		echo $txDataJSON;
		break;
	}
	default:
		echo "action error";
		break;
}


?>