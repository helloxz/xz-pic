<?php
	//载入七牛SDK
	require_once './qnsdk/autoload.php';
	//载入七牛配置文件
	require_once './qnconfig.php';
    // 引入鉴权类
    use Qiniu\Auth;

    // 引入上传类
    use Qiniu\Storage\UploadManager;
    //echo $qnkey['saveType'];
    //$qconfig
	error_reporting(E_ALL^E_NOTICE^E_WARNING^E_DEPRECATED);
	$img_name = $_FILES["file"]["name"];	//文件名称
	$suffix = substr(strrchr($img_name, '.'), 1);//文件后缀
	$suffix = strtolower($suffix);				//文件后缀转换为小写
	$new_name = date('dhis',time()).rand(1000,9999).'.'.$suffix;		//新的文件名
	$img_type = $_FILES["file"]["type"];	//文件类型
	$img_size = $_FILES["file"]["size"];	//文件大小
	$img_tmp = $_FILES["file"]["tmp_name"];	//临时文件名称
	$img_error = $_FILES["file"]["error"];	//错误代码

	$max_size = 2097152;		//最大上传大小2M
	$current_time = date('ym',time());	//当前月份
	$dir = 'uploads/'.$current_time;	//图片目录
	$dir_name = $dir.'/'.$new_name;		//完整路径

	//使用exif_imagetype函数来判断文件类型
	$file_type = exif_imagetype($img_tmp);
	switch ( $file_type )
	{
		case IMAGETYPE_GIF:
			$status = 1;
			break;
		case IMAGETYPE_JPEG:
			$status = 1;
			break;
		case IMAGETYPE_PNG:
			$status = 1;
			break;
		case IMAGETYPE_BMP:
			$status = 1;
			break;	
		default:
			$status = 0;
			break;
	}

	//判断文件后缀
	switch ( $suffix )
	{
		case jpg:
			$suffix_status = 1;
			break;
		case png:
			$suffix_status = 1;
			break;
		case jpeg:
			$suffix_status = 1;
			break;
		case bmp:
			$suffix_status = 1;
			break;
		case gif:
			$suffix_status = 1;
			break;					
		default:
			$suffix_status = 0;
			break;
	}

	//判断文件夹是否存在，不存在则创建目录
	if(!file_exists($dir)){
		mkdir($dir,0777,true);
	}

	
	//开始上传
	if(($img_size <= $max_size) && ($status == 1) && ($suffix_status == 1)) {
		if ($_FILES["file"]["error"] > 0)
	    {
	    	echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
	    }
	    else {
		 	//获取图片信息
		 	$img_info = getimagesize($img_tmp);
		 	
		 	//仅保存到七牛
		 	if($qnkey['saveType'] == 'FALSE') {
			 	move_uploaded_file($img_tmp,qnup($qnkey,$img_tmp,$dir_name));
		 	}
		 	//本地和七牛同时保存
		 	if($qnkey['saveType'] == 'TRUE') {
				move_uploaded_file($img_tmp,$dir_name);
				//echo $dir_name;
			 	move_uploaded_file("./$dir_name",qnup($qnkey,$dir_name,$dir_name));
		 	}
		    
		    $img_url = $qnkey['domain'].$dir_name;		//自定义图片路径
		    
		    $img_width = $img_info['0'];	//图片宽度
		    $img_height = $img_info['1'];	//图片高度
		    $re_data = array("linkurl" => $img_url,width => $img_width,"height" => $img_height,"status" => 'ok');
		    //返回json格式
		    echo json_encode($re_data);
	    }
	}
	else{
		$re_data = array("linkurl" => $img_url,width => $img_width,"height" => $img_height,"status" => 'no');
		//返回json格式
		echo json_encode($re_data);
	}
?>


<?php
	//七牛上传方法
	function qnup($qnkey,$filePath,$fileName) {
		//$filePath = $filePath;
	    // 需要填写你的 Access Key 和 Secret Key
	    $accessKey = $qnkey['accessKey'];
	    $secretKey = $qnkey['secretKey'];

	    // 构建鉴权对象
	    $auth = new Auth($accessKey, $secretKey);

	    // 要上传的空间
	    $bucket = $qnkey['bucket'];

	    // 生成上传 Token
	    $token = $auth->uploadToken($bucket);

	    // 要上传文件的本地路径
	    //$filePath = './yun360.jpg';

	    // 上传到七牛后保存的文件名
	    //$key = 'test/yun360.jpg';
	    $key = $fileName;

	    // 初始化 UploadManager 对象并进行文件的上传
	    $uploadMgr = new UploadManager();

	    // 调用 UploadManager 的 putFile 方法进行文件的上传
	    list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
	    //echo "\n====> putFile result: \n";
	    if ($err !== null) {
	        var_dump($err);
	    } else {
	        return true;
	    }
	}
?>