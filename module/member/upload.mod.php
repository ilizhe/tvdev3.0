<?php
if(!defined("UPLOAD")) define("UPLOAD",2);

class upload {

	function swf(){
	global $CONF,$ARGV;
	$this->A = $ARGV;
	$POST_MAX_SIZE = ini_get('upload_max_filesize');
	$unit = strtoupper(substr($POST_MAX_SIZE, -1));
	$multiplier = ($unit == 'M' ? 1048576 : ($unit == 'K' ? 1024 : ($unit == 'G' ? 1073741824 : 1)));
	/*if ((int)$_SERVER['CONTENT_LENGTH'] > $multiplier*(int)$POST_MAX_SIZE && $POST_MAX_SIZE) {
		header("HTTP/1.1 500 Internal Server Error");
		echo "POST exceeded maximum allowed size.";
		exit(0);
	}
*/
// Settings
	$save_path = TTROOT."/static/temp/";
	$upload_name = "Filedata";
	$max_file_size_in_bytes = 2147483647;				// 2GB in bytes
	$extension_whitelist = array("jpg", "gif", "png","apk");	//允许的文件
	$valid_chars_regex = '.A-Z0-9_ !@#$%^&()+={}\[\]\',~`-';				//允许的文件名字符
	$app = "app_";
	$app_width = 100;
	$app_height = 100;
	
// Other variables	
	$MAX_FILENAME_LENGTH = 260;
	$file_name = "";
	$file_extension = "";
	$uploadErrors = array(
        0=>"文件上传成功",
        1=>"上传的文件超过了 php.ini 文件中的 upload_max_filesize directive 里的设置",
        2=>"上传的文件超过了 HTML form 文件中的 MAX_FILE_SIZE directive 里的设置",
        3=>"上传的文件仅为部分文件",
        4=>"没有文件上传",
        6=>"缺少临时文件夹"
	);

	if (!isset($_FILES[$upload_name])) {
		$this->HandleError("No upload found in \$_FILES for " . $upload_name);
		exit(0);
	} else if (isset($_FILES[$upload_name]["error"]) && $_FILES[$upload_name]["error"] != 0) {
		$this->HandleError($uploadErrors[$_FILES[$upload_name]["error"]]);
		exit(0);
	} else if (!isset($_FILES[$upload_name]["tmp_name"]) || !@is_uploaded_file($_FILES[$upload_name]["tmp_name"])) {
		$this->HandleError("Upload failed is_uploaded_file test.");
		exit(0);
	} else if (!isset($_FILES[$upload_name]['name'])) {
		$this->HandleError("File has no name.");
		exit(0);
	}
	
	$file_size = @filesize($_FILES[$upload_name]["tmp_name"]);
	if (!$file_size || $file_size > $max_file_size_in_bytes) {
		$this->HandleError("File exceeds the maximum allowed size");
		exit(0);
	}
	
	if ($file_size <= 0) {
		$this->HandleError("File size outside allowed lower bound");
		exit(0);
	}
	

	$file_name = preg_replace('/[^'.$valid_chars_regex.']|\.+$/i', "", basename($_FILES[$upload_name]['name']));
	$fn = explode('.',$file_name);
	$num = count($fn);
	$ext=$fn[$num-1];
	$fn = session_id()."_".time().rand(0,99).".".$ext;
	if (strlen($file_name) == 0 || strlen($file_name) > $MAX_FILENAME_LENGTH) {
		$this->HandleError("Invalid file name");
		exit(0);
	}


	if (file_exists($save_path . $file_name)) {
		$this->HandleError("File with this name already exists");
		exit(0);
	}

// Validate file extension
	$path_info = pathinfo($_FILES[$upload_name]['name']);
	$file_extension = $path_info["extension"];
	$is_valid_extension = false;
	foreach ($extension_whitelist as $extension) {
		if (strcasecmp($file_extension, $extension) == 0) {
			$is_valid_extension = true;
			break;
		}
	}
	if (!$is_valid_extension) {
		$this->HandleError("Invalid file extension");
		exit(0);
	}
   	if (!@move_uploaded_file($_FILES[$upload_name]["tmp_name"], $save_path.$fn)) {
		$this->HandleError("文件无法保存.");
		exit(0);
	}else{
		$oldimg =$save_path.$fn;
		$newimg = $save_path.$app.$fn;
		$return  = $save_path.$app.$fn;
		Image::thumb($oldimg,$newimg,'',$app_width,$app_height);
		$newfn = $app.$fn;
		$array = array("filename"=>$fn,"filetype"=>$ext,"url"=>$CONF->APP['static']."/temp/","newfn"=>$newfn);
		$serverData= json_encode($array);
	}
	echo $serverData;
	exit(0);


	}
	function HandleError($message) {
//		header("HTTP/1.1 500 Internal Server Error");
		echo json_encode(array('error'=>$message));
	}
}
?>