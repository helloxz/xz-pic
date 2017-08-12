$(document).ready(function(){
	//上传选项
	$("#localhost").click(function(){
				$("#upform").attr("action", "./upload.php");
			});
	$("#qiniu").click(function(){
		$("#upform").attr("action", "./qnupload.php");
	});
	
	$("#close").click(function(){
		$("#instructions").hide();
	});
	$("#btn").click(function(){
		//判断上传文件的类型
		filepath=$("#file").val();
		var extStart=filepath.lastIndexOf(".");
		var ext=filepath.substring(extStart,filepath.length).toUpperCase();
		if(ext!=".BMP"&&ext!=".PNG"&&ext!=".GIF"&&ext!=".JPG"&&ext!=".JPEG"){
			$("#uperror").show();
			$("#uperror").fadeOut(3000);
			return false;
		}
		//正在上传
		$("#loading_up").show();
		//使用jquery.form插件异步提交表单，详细内容参考官方文档
		$("#upform").ajaxForm(function(data,status){
			//输出返回结果
			//alert(data);
			var imginfo = new Function("return" + data)();//转换后的JSON对象
			
			if(imginfo.status != 'ok') {
				alert('Error!请检查文件类型或大小!');
				return false;
			}
			//获取图片宽度
			var img_width = imginfo.width;
			//获取图片高度
			var img_height = imginfo.height;
			

			//如果图片像素大于600px，则等比例缩放
			if(img_width >= 600){
				var b = img_width / 580;		//计算缩小倍数
				img_width = img_width / b;
				img_height = img_height / b;
			}
			if(status == "success") {
				$("#show").show();
				$("#loading_up").hide();
				$("#success_up").show();
				$("#success_up").hide(3000);
				document.getElementById("linkurl").value = imginfo.linkurl;
				document.getElementById("htmlurl").value = "<img src = '" + imginfo.linkurl + "' />";
				document.getElementById("mdurl").value = "![](" + imginfo.linkurl + ")";
				//添加图片链接
				$("#show_img").attr('src',imginfo.linkurl);
				//添加图片地址
				$("#img-url").attr('href',imginfo.linkurl);
				//改变图片宽、高
				$("#show_img").css("width",img_width);
				$("#show_img").css("height",img_height);
				//显示图片
				$("#img-box").show();
				//alert(imginfo.linkurl);
				//$("#show_img").src = data.linkurl;
			}
			else{
				alert('上传错误！请重新上传图片。');
			}
		});
	});
});

function use(){
	var b_width = document.body.clientWidth;                  //获取浏览器宽度
    var u_width = (b_width - 500) / 2;
	$("#instructions").css("left",u_width);
	$("#instructions").show();
}

//复制按钮
$(document).ready(function(){
	$("#copyhtml").click(function(){
		new clipBoard($("#htmlurl"),{
			copy: function() {
				return $("#htmlurl").val();	
			},
			afterCopy: function() {
				$("#copyok").show();
				$("#copyok").fadeOut(3000);
			}
		});
	});
	$("#copymd").click(function() {
		new clipBoard($("#mdurl"),{
			copy: function() {
				return $("#mdurl").val();
			},
			afterCopy: function() {
				$("#copyok").show();
				$("#copyok").fadeOut(3000);
			}
		});
	});
});