$(document).ready(function(){
	init();
	refresh();
})
function init(){
	$("#submit").bind('click',function() {
		submitAction();
	});
}
function refresh(){
	var data = achieveFormData();
	data.action = "refresh";
	$.post('/comment/1/comment.php',data, function(data) {
		for(var row in data){
			//alert(data[row]["id"]);
			
			var htmlCont = '\
				<div class="cX">\
					<img class="img" src="img/imgnum.jpg" />\
					<a class="userName" href="webpage">username</a>&nbsp&nbsp&nbsp&nbsp\
					<span class="date">datee</span>\
					<p clasa="text">commcon</p>\
					<a class="delete" href="">删除</a>\
				</div>\
			';
			htmlCont = htmlCont.replace(/username/,data[row]["username"]);
			htmlCont = htmlCont.replace(/datee/,data[row]["date"]);
			htmlCont = htmlCont.replace(/imgnum/,data[row]["imgnum"]);
			htmlCont = htmlCont.replace(/webpage/,data[row]["webpage"]);
			htmlCont = htmlCont.replace(/commcon/,data[row]["commcon"]);
			$("#content").prepend(htmlCont);
			htmlCont = null;
		}
	});
}

function submitAction(){
	var data = achieveFormData();
	data.action = 'insert';
	$.post('/comment/1/comment.php',data, function(data) {
	});
}
function achieveFormData(){
	var userName = $("#userName").val();
	var imgNum = $("input[name='image']:checked").attr('val');
	var webPage = $("#persionalPageAddress").val();
	var teleNum = $("#telephoneNum").val();
	var commCon = $("#commentContent").val();
	var data = {
		userName : userName,
		imgNum : imgNum,
		webPage : webPage,
		teleNum : teleNum,
		commCon : commCon
	};
	//var dataJSON = JSON.stringify(data);
	//alert(dataJSON);
	return data;
}