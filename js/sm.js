$(document).ready(function(){
	$("#btn").click(function(){
		$("#upform").ajaxForm(function(data,status){
			//上传成功
			if(data.code == 'success') {
				//图片地址
				var url = data.data.url;
				//图片宽度
				img_width = data.data.width;
				//图片高度
				img_height = data.data.height;
				if(img_width >= 600){
					var b = img_width / 580;		//计算缩小倍数
					img_width = img_width / b;
					img_height = img_height / b;
				}
				$("#show").show();
				$("#loading_up").hide();
				$("#success_up").show();
				$("#success_up").hide(3000);
				document.getElementById("linkurl").value = url;
				document.getElementById("htmlurl").value = "<img src = '" + url + "' />";
				document.getElementById("mdurl").value = "![](" + url + ")";
				//添加图片链接
				$("#show_img").attr('src',url);
				//添加图片地址
				$("#img-url").attr('href',url);
				//改变图片宽、高
				$("#show_img").css("width",img_width);
				$("#show_img").css("height",img_height);
				//显示图片
				$("#img-box").show();
			}
			//上传失败
			else {
				//错误原因
				var msg = data.msg;
				$("#uperror").html(msg);
				$("#uperror").show();
				$("#uperror").fadeOut(3000);
			}
		});
	});
});
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