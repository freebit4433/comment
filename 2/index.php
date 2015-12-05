<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>comment page</title>
	<script type="text/javascript" src="easyui/jquery.min.js"></script>
	<style type="text/css">
		#wrapper {
			width: 600px;
			height: 500px;
			margin: 50px auto 0 auto;
		}
		#submit {
			display: block;
			width: 66px;
			height: 24px;
			margin: 5px 0;
			color: white;
			text-decoration: none;
			text-align: center;
			background-color: #9dd6c5;
			line-height:24px;
			font-size: 12px;

		}
		#submit:hover {
			background-color: #AFE0D1;
		}
		#commentContent {
			width: 550px;
			height: 100px;
			resize:none;
			font-family: 宋体;
			font-size: 13px;
		}
		#content {

		}
		.cX {
			position: relative;
			width: 540px;
			margin: 50px 0;
			padding-left: 60px;

			font-size: 12px;
			line-height: 14px;

			
		}
		.img {
			display: block;
			position: absolute;
			top: 0;
			left: 0px;
		}
		.userName {
			font-size: 11px;
			color: #888;
			text-decoration: none;
		}
		.userName:hover {
			color: #9dd6c5
		}
		.date {
			color: #888;
		}
		.delete {

			display: none;
			position: absolute;
			top: 0;
			right: 0;
			color: #888;
			text-decoration: none;
		}
		.delete:hover {
			color: #9dd6c5;
			cursor: pointer;
		}
		#logout {
			padding-left: 400px;
		}
	</style>
</head>
<body>
<?php
	session_start();
	header("content-type:text/html;charset=utf-8");

	if (isset($_SESSION['login'])) {
		$username = $_SESSION['username'];
	}
	else{
		echo "plase login，1秒后跳转！";
		echo "<meta http-equiv='refresh' content='1;url=login.html' />";
		die();
	}
?>

	<div id="wrapper">
		<div id="comment">
			<hr />
			<p>你好，<span id="loginUserName"><?php echo $username ?></span><a id="logout" href="#">退出登陆</a></p>
			<p>最近留言</p>
			<textarea id="commentContent" wrap="soft" maxlength=100></textarea>
			<br />
			<a id="submit" href="#">提 交</a>
		</div>
		<div id="content">
			<!-- <div id="c1" class="cX">
				<img class="img" id="c1Img" src="img/1.jpg" />
				<a class="userName" id="c1UserName" href="">米卡</a>&nbsp;&nbsp;&nbsp;&nbsp;
				<span class="date" id="c1Date">2015-11-16 21:22:29</span>
				<p clasa="text" id="c1Text">这是html里的评论</p>
				<a class="delete" id="c1Delete" href="">删除</a>
			</div> -->
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			//alert("hello");
			refresh();
			$(document).bind('keydown', function(event) {
				var keynum = event.which;
				if (keynum == 13) {
					submitClick();
				};
			});
			$("#logout").bind('click',function(event) {
				logoutClick();
			});
			$("#submit").bind('click',function(event) {
				submitClick();
			});
		})

		function logoutClick(){
			$.post("/comment/2/php/logout.php",function(){
				window.location.href = "/comment/2/login.html";
			});
		}

		function submitClick(){
			var comment = $("#commentContent").val();
			var txData = new Object();
			txData.action = "insert";
			//需要过滤
			txData.comment = comment;
			$.post('/comment/2/php/mainpage.php',txData, function(data) {
				if (data.flag){
					alert("评论插入成功！");
					refresh();
				};
			});

		}

		function refresh(){
			var txData = new Object();
			txData.action = "refresh";
			var username = $("#loginUserName").text();
			var indexWrapper;

			$("#commentContent").val('');
			$("#content").empty();

			$.post('/comment/2/php/mainpage.php',txData, function(data) {
				for(var row in data){
					//alert(data[row]["id"]);
					
					var htmlCont = '\
						<div id="indexWrapper" class="cX">\
							<span class="indexid" hidden="hidden">indexidcontent</span>\
							<img class="img" src="img/imgnum.jpg" />\
							<a class="userName" href="webpage">username</a>&nbsp;&nbsp;&nbsp;&nbsp;\
							<span class="date">datee</span>\
							<p clasa="text">commcon</p>\
							<a class="delete">删除</a>\
						</div>\
					';
					htmlCont = htmlCont.replace(/indexidcontent/,data[row]["id"]);
					htmlCont = htmlCont.replace(/username/,data[row]["username"]);
					htmlCont = htmlCont.replace(/datee/,data[row]["commenttime"]);
					htmlCont = htmlCont.replace(/imgnum/,data[row]["imgnum"]);
					htmlCont = htmlCont.replace(/webpage/,data[row]["webpage"]);
					htmlCont = htmlCont.replace(/commcon/,data[row]["comment"]);
					if (data[row]["username"] == username){
						indexWrapper = "indexWrapper" + data[row]["id"];
						htmlCont = htmlCont.replace(/indexWrapper/,indexWrapper);
					}else{
						htmlCont = htmlCont.replace(/indexWrapper/,"");
					}
					$("#content").prepend(htmlCont);
					if (data[row]["username"] == username) {
						//alert(indexWrapper);
						$("#"+indexWrapper).bind('mouseenter',{indexWrapper:indexWrapper},function(event) {
							//alert($(this .indexid).text());
							//$(this).slideToggle();
							//alert(event.data.indexWrapper);
							//alert($(this + " .indexid").text());
							
							//alert($("#" + event.data.indexWrapper + " .indexid").text());
							$("#" + event.data.indexWrapper + " .delete").css('display', 'block');
						});
						$("#" + indexWrapper).bind('mouseleave',{indexWrapper:indexWrapper}, function(event) {
							$("#" + event.data.indexWrapper + " .delete").css('display', 'none');
						});
						$("#" + indexWrapper + " .delete").bind('click',{id:data[row]["id"]}, function(event) {
							//alert(event.data.id);
							var txid = event.data.id;
							var txDataDelete = new Object();
							txDataDelete.action = "delete";
							txDataDelete.deleteid = txid;
							$.post('/comment/2/php/mainpage.php',txDataDelete,function(rxData){
								if (rxData.deleteflag) {
									alert("删除成功！");
									//window.location.reload();
									refresh();
								};
							});
						});
					};
					indexWrapper = null;
					htmlCont = null;
				}
			});
			/*alert("refresh done");
			$("#indexWrapper9").bind('mouseenter',function() {
				alert($("#indexWrapper9 .indexid").text());
			});*/
			//再循环遍历评论列表，如果是当前用户的评论，则设置hover显示删除操作
			/*******************************
			*
			*coding暂置
			*
			*******************************/
		}
	</script>
</body>
</html>


