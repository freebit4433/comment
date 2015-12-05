<?php
//header("content-type:text/html;charset=utf-8");

echo time();
echo "<br>";
date_default_timezone_set("PRC");
$t = time();
echo $t;
echo "<br>";

echo date("Y m d H:i:s",$t);


?>