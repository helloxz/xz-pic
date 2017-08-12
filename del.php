<?php
	//设置key
	$ukey = "HZ8QnV2JOYvjgfPO";
	$key = $_GET['key'];
	//正则表达式
	$pre = '/^[0-9]\d*\/\d*\.(jpg|png|gif|bmp|jpeg)$/';
	//获取图片路径
	$picdir = $_GET['path'];

	//正则匹配
	if(!preg_match($pre,$picdir)) {
		echo "路径错误！";
		exit;
	}

	//进行判断
	if((!isset($key)) || ($key != $ukey)) {
		echo "密钥错误！";
		exit;
	}

	//删除图片
	if(($ukey == $key) && ($picdir != '')) {
		$delcode = unlink("./uploads/".$picdir);
		if(!$delcode) {
			echo "删除失败，文件不存在或已删除！";
			exit;
		}
		echo '删除成功!';
	}
?>