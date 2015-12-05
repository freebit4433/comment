$(document).ready(function(){
	init();
})

function init(){
	$("#login").bind('click',function(){loginClick();});
	$("#register").bind('click',function(){registerClick();});
	$("#vcodeimg").bind('click',function(event) {
		var d = new Date();
		var time = d.getTime();
		var url = "/comment/2/php/vcode.php?time=" + time;
		$("#vcodeimg").attr('src',url);
	});
	$(document).bind('keydown',function(event) {
		var keynum = event.which;
		if (keynum == 13) {
			loginClick();
		};
	});
}

function loginClick(){
	var username = $("#userName").val();
	var password = $("#password").val();
	var vcode = $("#vcode").val();
	if (username.length == 0) {
		$.messager.alert("error","请输入用户名！");
		return;
	};
	if (password.length == 0) {
		alert("请输入密码！");
		return;
	};
	if (vcode.length == 0) {
		alert("请输入验证码！");
		return;
	};
	passwordMD5 = hex_md5(password);
	var data = {username : username,password : passwordMD5,vcode:vcode};
	var url = "/comment/2/php/login.php";
	$.post(url,data,function(rxData){
		if (rxData.login) {
			//$.messager.alert("success",rxData.username + " 登陆成功！");
			//alert(rxData.username + " 登陆成功！");
			//执行页面跳转
			/*********
			*
			*
			**********/
			window.location.href = "/comment/2/index.php";
		}else{
			$.messager.alert("error",rxData.username + " 用户名或密码或验证码不正确");
		}
	});
}

function registerClick(){
	//alert("registerClick");
	window.location.href = "/comment/2/register.html";
}