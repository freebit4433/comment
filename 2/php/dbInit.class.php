<?php
define("DATABASE_NAME","comment");
define("TABLE_NAME","");
define("USERNAME","root");
define("PASSWORD","raspberry");


class dbInitClass{
	public $mysqli;
	function __construct(){
		$this->mysqli = new mysqli("localhost",USERNAME,PASSWORD,DATABASE_NAME);
		if ($this->mysqli->connect_errno) {
			echo "Connect error : " . $this->mysqli->connect_error;
			die();
		}
		$this->mysqli->set_charset("utf8");
		return $this->mysqli;
	}
	function __destruct(){
		$this->mysqli->close();
	}
}

?>