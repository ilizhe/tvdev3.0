<?php


/**
 +------------------------------------------------------------------------------
 * 图像操作类库
 +------------------------------------------------------------------------------
 */
class Image
{//类定义开始

    /**
     +----------------------------------------------------------
     * 取得图像信息
     *
     +----------------------------------------------------------
     * @static
     * @access public
     +----------------------------------------------------------
     * @param string $image 图像文件名
     +----------------------------------------------------------
     * @return mixed
     +----------------------------------------------------------
     */
    static function getImageInfo($img) {
        $imageInfo = getimagesize($img);
        if( $imageInfo!== false) {
            $imageType = strtolower(substr(image_type_to_extension($imageInfo[2]),1));
            $imageSize = filesize($img);
            $info = array(
                "width"=>$imageInfo[0],
                "height"=>$imageInfo[1],
                "type"=>$imageType,
                "size"=>$imageSize,
                "mime"=>$imageInfo['mime']
            );
            return $info;
        }else {
            return false;
        }
    }

    /**
     +----------------------------------------------------------
     * 生成缩略图
     +----------------------------------------------------------
     * @static
     * @access public
     +----------------------------------------------------------
     * @param string $image  原图
     * @param string $type 图像格式
     * @param string $thumbname 缩略图文件名
     * @param string $maxWidth  宽度
     * @param string $maxHeight  高度
     * @param string $position 缩略图保存目录
     * @param boolean $interlace 启用隔行扫描
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    static function thumb($image,$thumbname,$type='',$maxWidth=200,$maxHeight=50,$interlace=true)
    {
        // 获取原图信息
        $info  = Image::getImageInfo($image);
         if($info !== false) {
            $srcWidth  = $info['width'];
            $srcHeight = $info['height'];
            $type = empty($type)?$info['type']:$type;
			$type = strtolower($type);
            $interlace  =  $interlace? 1:0;
            unset($info);
            $scale = min($maxWidth/$srcWidth, $maxHeight/$srcHeight); // 计算缩放比例
            if($scale>=1) {
                // 超过原图大小不再缩略
                $width   =  $srcWidth;
                $height  =  $srcHeight;
            }else{
                // 缩略图尺寸
                $width  = (int)($srcWidth*$scale);
                $height = (int)($srcHeight*$scale);
            }

            // 载入原图
            $createFun = 'ImageCreateFrom'.($type=='jpg'?'jpeg':$type);
            $srcImg     = $createFun($image);

            //创建缩略图
            if($type!='gif' && function_exists('imagecreatetruecolor'))
                $thumbImg = imagecreatetruecolor($width, $height);
            else
                $thumbImg = imagecreate($width, $height);

            // 复制图片
            if(function_exists("ImageCopyResampled"))
                imagecopyresampled($thumbImg, $srcImg, 0, 0, 0, 0, $width, $height, $srcWidth,$srcHeight);
            else
                imagecopyresized($thumbImg, $srcImg, 0, 0, 0, 0, $width, $height,  $srcWidth,$srcHeight);
            if('gif'==$type || 'png'==$type) {
                //imagealphablending($thumbImg, false);//取消默认的混色模式
                //imagesavealpha($thumbImg,true);//设定保存完整的 alpha 通道信息
                $background_color  =  imagecolorallocate($thumbImg,  0,255,0);  //  指派一个绿色
				imagecolortransparent($thumbImg,$background_color);  //  设置为透明色，若注释掉该行则输出绿色的图
            }

            // 对jpeg图形设置隔行扫描
            if('jpg'==$type || 'jpeg'==$type) 	imageinterlace($thumbImg,$interlace);

            //$gray=ImageColorAllocate($thumbImg,255,0,0);
            //ImageString($thumbImg,2,5,5,"ThinkPHP",$gray);
            // 生成图片
            $imageFun = 'image'.($type=='jpg'?'jpeg':$type);
            $imageFun($thumbImg,$thumbname);
            imagedestroy($thumbImg);
            imagedestroy($srcImg);
            return $thumbname;
         }
         return false;
    }
    /**
     * 切割图片到批定的大小，用于头像上传时的图片切割
     * @param char $thumb_image_name 最后生成的图片路径加名称
     * @param char $image 原图
     * @param int $width 需要切割的宽度
     * @param int $height 切割的高度
     * @param int $start_width 切割的开始宽度
     * @param int $start_height 切割时的高度
     * @param int $scale 与原图比例  （使用原图宽度/切割的宽度）
     */
	 static function resize($image, $thumb_image_name, $width, $height){
		list($imagewidth, $imageheight, $imageType) = getimagesize($image);
		$imageType = image_type_to_mime_type($imageType);
		switch($imageType) {
			case "image/gif":
				$source=imagecreatefromgif($image);
				break;
		    case "image/pjpeg":
			case "image/jpeg":
			case "image/jpg":
				$source=imagecreatefromjpeg($image);
				break;
		    case "image/png":
			case "image/x-png":
				$source=imagecreatefrompng($image);
				break;
	  	}

		if( $width>0 && $height>0 ){
			$p = $width/$height;
			if( $imagewidth > $imageheight ){
				$srcH = $imageheight;
				$srcW = intval(($imageheight * $p));
				$dstH = 0;
				$dstW = intval(($imagewidth - $srcW)/2);
			}else{
				if( $width<$height ){
					$srcH = intval(($imagewidth * $p));
					$srcW = $imagewidth;
					$dstW = 0;
					$dstH = intval(($imageheight-$srcH)/2);
				}else{
					$srcH = $imageheight;
					$srcW = intval(($imageheight * $p));
					$dstH = 0;
					$dstW = intval(($imagewidth - $srcW)/2);
				}
			}
		}else{
			if($width>0){
				$dstW = 0;
				$dstH = 0;
				$srcH = $imageheight;
				$srcW = $imagewidth;
				$height = intval( ( $width * $imageheight  ) / $imagewidth);
			}else{
				$dstW = 0;
				$dstH = 0;
				$srcH = $imageheight;
				$srcW = $imagewidth;
				$width = intval( ( $height * $imagewidth  ) / $imageheight);
			}
		}
		if( $imagewidth>=$imageheight ){
			$srcH = $imageheight;
			$srcW = intval( ( $width * $imageheight  ) / $height );
			$dstH = 0;
			$dstW = intval(($imagewidth - $srcW ) / 2);
		}else{
			$srcW = $imagewidth;
			$srcH = intval( ( $height * $imagewidth  ) / $width);
			$dstW = 0;
			$dstH = intval( ($imageheight - $srcH) / 2);
		}

/*
echo "sw=".$imagewidth." sh=".$imageheight."<br>";
echo "width=".$width." h=".$height."<br>";
echo "srcw=".$srcW." srcH=".$srcH."<br>";
echo "dstW=".$dstW." dstH=".$dstH."<br>";
exit;
*/
		$newImage = imagecreatetruecolor($width,$height);

		$white = imagecolorallocate($newImage, 255, 255, 255);
		imagefill($newImage, 0, 0, $white);
		imagecolortransparent($newImage,$white);
		imagecopyresampled($newImage,$source,0,0,$dstW,$dstH,$width,$height,$srcW,$srcH);
//		imagealphablending($newImage,false);
//		imagesavealpha($newImage,true);
		switch($imageType) {
			case "image/gif":
		  		imagegif($newImage,$thumb_image_name);
				break;
	      	case "image/pjpeg":
			case "image/jpeg":
			case "image/jpg":
		  		imagejpeg($newImage,$thumb_image_name,99);
				break;
			case "image/png":
			case "image/x-png":
		  		imagejpeg($newImage,$thumb_image_name,99);
//				imagepng($newImage,$thumb_image_name);
				break;
	    }
		chmod($thumb_image_name, 0777);
		return $thumb_image_name;
	 }
	static function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale){
		list($imagewidth, $imageheight, $imageType) = getimagesize($image);
		$imageType = image_type_to_mime_type($imageType);
		$newImageWidth = ceil($width * $scale);
		$newImageHeight = ceil($height * $scale);
		$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
		switch($imageType) {
			case "image/gif":
				$source=imagecreatefromgif($image);
				break;
		    case "image/pjpeg":
			case "image/jpeg":
			case "image/jpg":
				$source=imagecreatefromjpeg($image);
				break;
		    case "image/png":
			case "image/x-png":
				$source=imagecreatefrompng($image);
				break;
	  	}
		imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
		switch($imageType) {
			case "image/gif":
		  		imagegif($newImage,$thumb_image_name);
				break;
	      	case "image/pjpeg":
			case "image/jpeg":
			case "image/jpg":
		  		imagejpeg($newImage,$thumb_image_name,99);
				break;
			case "image/png":
			case "image/x-png":
				imagepng($newImage,$thumb_image_name);
				break;
	    }
		chmod($thumb_image_name, 0777);
	return $thumb_image_name;
}

/**
* 生成唯一的序列
* @param      string 前缀
* @return     string 返回唯一序列
*/
static function uuid($prefix = '')
{
    $chars = md5(uniqid(mt_rand(), true));
    $uuid = substr($chars,0,8) . '-';
    $uuid .= substr($chars,8,4) . '-';
    $uuid .= substr($chars,12,4) . '-';
    $uuid .= substr($chars,16,4) . '-';
    $uuid .= substr($chars,20,12);

    return $prefix . $uuid;
}
    
    static public function check_image($image_file) {
        if ($data = GetImageSize($image_file)) {
            if($data[2] <= 3 ){
                return $data;
            }else{
                return false;
            }
        }
        return false;
    }
    
    /**
     * 生成缩略图
     * @param 源图片路径 $srcFile
     * @param 缩略图路径 $dstFile
     * @param 缩略图宽度 $dstW
     * @param 缩略图高度 $dstH
     */
	 function getwidth($img,$h){
		$d = getimagesize($img);
		return intval($d[0] * $h / $d[1]);
	 }
	 function getheight($img,$w){
		$d = getimagesize($img);
		return intval($d[1] * $w / $d[0]);
	 }
	 function err($src,$msg,$w,$h){
		$dst = imagecreatetruecolor($w,$h);
	 }
    static public function create_thumb($srcFile, $dstFile, $dstW, $dstH, $fill = false)
    {
        $data = getimagesize($srcFile);
        switch ($data[2]) {
            case 1:
                $srcImg = @ImageCreateFromGIF($srcFile);
                break;
            case 2:
                $srcImg = @ImageCreateFromJPEG($srcFile);
                break;
            case 3:
                $srcImg = @ImageCreateFromPNG($srcFile);
                break;
            default:
                return;
                break;
        }
        if ($srcImg) {
            $srcW = ImageSX($srcImg);
            $srcH = ImageSY($srcImg);
            $dstX = 0;
            $dstY = 0;
        
            if ($srcW * $dstH > $srcH * $dstW) {// srcW/srcH > dstW/dstH ，源比目标扁
                $dstRealW = max($dstW, 1);
                $dstRealH = max(round($srcH * $dstRealW / $srcW), 1);
            } else {
                $dstRealH = max($dstH, 1);
                $dstRealW = max(round($srcW * $dstRealH / $srcH), 1);
            }
			if( $srcW > $srcH || $dstW>0){
				$dstRealW = $dstW;
				$dstRealH = intval(( $dstW * $srcH ) / $srcW);
			}else{
				$dstRealH = $dstH;
				$dstRealW = intval(($dstH * $srcW) / $srcH);
			}

            if ($fill) {
                $dstX = floor(($dstW - $dstRealW) / 2);
                $dstY = floor(($dstH - $dstRealH) / 2);
                $dstImg = ImageCreateTrueColor($dstW, $dstH);
                $backColor = ImageColorAllocate($dstImg, 255, 255, 255);//缩图空出部分的背景色
                ImageFilledRectangle($dstImg, 0, 0, $dstW, $dstH, $backColor);
            } else {
                $dstImg = ImageCreateTrueColor($dstRealW, $dstRealH);   
            }
            
            //ImageCopyResized($dstImg, $srcImg, 0, 0, 0, 0, $dstRealW, $dstRealH, $srcW, $srcH);
            imagecopyresampled($dstImg, $srcImg, $dstX, $dstY, 0, 0, $dstRealW, $dstRealH, $srcW, $srcH);

            ImageJPEG($dstImg, $dstFile, 85);
            chmod($dstFile, 0644);
            ImageDestroy($srcImg);
            ImageDestroy($dstImg);
        }
    }

    /**
     * 裁剪缩略图，保留最窄一边内容，剪去长边两侧
     * @param string $srcFile
     * @param string $dstFile
     * @param int $dstW
     * @param int $dstH
     * @author yinzhigang
     */
    static public function crop_thumb($srcFile, $dstFile, $dstW, $dstH) {
        list($srcW, $srcH, $type, $attr) = GetImageSize($srcFile);
        switch ($type) {
            case 1:
                $srcImg = @ImageCreateFromGIF($srcFile);
                break;
            case 2:
                $srcImg = @ImageCreateFromJPEG($srcFile);
                break;
            case 3:
                $srcImg = @ImageCreateFromPNG($srcFile);
                break;
            default:
                return;
                break;
        }
        if ($srcImg) {
            if ($srcW > $srcH) {
                $dstWH = $srcH; //定义原图宽高
                $srcY = 0;
                $srcX = floor(($srcW - $srcH) / 2);
            } else {
                $dstWH = $srcW;
                $srcY = floor(($srcH - $srcW) / 2);
                $srcX = 0;
            }
            
            $dstImg = ImageCreateTrueColor($dstW, $dstH);
            
            imagecopyresampled($dstImg, $srcImg, 0, 0, $srcX, $srcY, $dstW, $dstH, $dstWH, $dstWH);

            ImageJPEG($dstImg, $dstFile, 85);
            chmod($dstFile, 0644);
            ImageDestroy($srcImg);
            ImageDestroy($dstImg);
        }
    }
}
?>