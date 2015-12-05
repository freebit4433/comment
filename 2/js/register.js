$(document).ready(function(){
	$("#login").bind('click',function(event) {
		registerButton();
	});
	$(document).bind('keydown',function(event) {
		var keynum = event.which;
		if (keynum == 13) {
			registerButton();
		};
	});
})

function registerButton(){
	var username = $("#userName").val();
	var password = $("#password").val();
	password = hex_md5(password);
	var sex = $("input[name='sex']:checked").attr('value');
	var imgnum = $("input[name='image']:checked").attr('value');
	var webpage = $("#webpage").val();
	var txDateObj = {username:username,password:password,sex:sex,imgnum:imgnum,webpage:webpage};
	var url = "/comment/2/php/register.php";
	$.post(url,txDateObj,function(rxDataObj){
		if(rxDataObj.register){
			$.messager.alert("success",rxDataObj.username + "注册成功！");
			window.location.href = "/comment/2/login.html";
		}else{
			$.messager.alert("error","注册失败！");
		}
	});
}