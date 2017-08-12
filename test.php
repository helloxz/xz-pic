<?php
	$aaa = "1708/120957302";
	$pre = '/^[0-9]\d*\/\d*\.(jpg|png|gif)$/';
	if(preg_match($pre,$aaa)) {
		echo 'ok';
	}
	else {
		echo 'no';
	}
?>