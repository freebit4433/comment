<?php
header("content-type:application/json;charset=utf-8");

$commentObj = new comment();
$data = $commentObj->achieveData();
$action = $_POST['action'];
// print_r($commentObj->mysqli);

switch ($action) {
	case 'refresh':{
		$sql = "SELECT * FROM table1";
		$res = $commentObj->mysqli->query($sql);
		if($res){
			/*$row = $res->fetch_assoc();
			print_r($row);*/
			while($row=$res->fetch_assoc()) {
				//print_r($row);
				date_default_timezone_set("PRC");
				$row["date"] = date("Y-m-d H:i:s",$row["date"]);
				$rows[]=$row;
			}
			$rowsJSON = json_encode($rows);
			echo $rowsJSON;
		}
		else{
			echo "select error : " . $commentObj->mysqli->error;
		}

		break;
	}
	case 'insert':{
		date_default_timezone_set("PRC");
		$sql = "INSERT table1 VALUES(null,'" . $data['userName'] . "'," . time() . "," . $data['imgNum'] . ",'" . $data['webPage'] . "','" . $data['commCon'] ."')";
		// echo $sql;
		$res = $commentObj->mysqli->query($sql);
		if ($res) {
			echo "insert success";
		}
		else{
			echo "insert error : " . $commentObj->mysqli->error;
		}
		break;
	}
	default:
		# code...
		break;
}

$commentObj = NULL;




class comment{
	public $mysqli;
	function __construct(){
		//初始化数据库
		$this->mysqli = new mysqli('localhost','root','raspberry','comment');
		if ($this->mysqli->connect_errno) {
			echo "Connect error : " . $this->mysqli->connect_error;
		}
		$this->mysqli->set_charset("utf8");
	}
	function __destruct(){
		$this->mysqli->close();
	}
	public function achieveData(){
		$data['userName'] = $_POST["userName"];
		$data['imgNum'] = $_POST["imgNum"];
		$data['webPage'] = $_POST["webPage"];
		//$data['teleNum'] = $_POST["teleNum"];
		$data['commCon'] = $_POST["commCon"];
		return $data;
	}
}

?>