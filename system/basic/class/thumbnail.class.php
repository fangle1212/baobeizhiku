<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

class thumbnail{

	public static function create($file, $path, $width, $height, $size='fill', $horizontal='center', $vertical='center')
	{
		global $G;
		$dir = ROOT_PATH.strFilenameIconv($path);
		if(!is_file($dir)){
			if(strpos($file,'http')===0){
				if(is_file(ROOT_PATH.$path.'.bak')){
					return true;
				}
				into::basic_class('curl');
				$content = $file?curl::request($file):'';
			}else{
				$file = ROOT_PATH.preg_replace('/^(\.\.\/)+/','',$file);
				$iconv = strFilenameIconv($file);
				$content = $iconv?file_get_contents($iconv):'';
			}
			if(empty($content)) return false;
			dir::create($dir, self::resize($content, $width, $height, $size, $horizontal, $vertical));
			if($G['config']['store_type']){
				into::basic_class('oss');
				oss::upload($path, ROOT_PATH.$path);
				dir::create(ROOT_PATH.$path.'.bak', '');
				dir::delete($dir);
			}
		}
		return true;
	}
	
	public static function resize($data, $width, $height, $size, $horizontal, $vertical)
	{
		list($img_width, $img_height, $img_type) = getimagesizefromstring($data);
		$image = imagecreatetruecolor($width, $height);
		imagealphablending($image, false);
		imagesavealpha($image, true);
		$img = imagecreatefromstring($data);
		imagesavealpha($img, true);
		list($x, $y, $w, $h) = self::position($width, $height, $img_width, $img_height, $size, $horizontal, $vertical);
		imagecopyresampled($image, $img, $x, $y, 0, 0, $w, $h, $img_width, $img_height);
		$temp = tempnam(sys_get_temp_dir(), 'photo_');
		switch($img_type) {
			case 1:
				imagegif($image, $temp);
				break;
			case 2:
				imagejpeg($image, $temp, 100);
				break;
			case 3:
				imagepng($image, $temp);
				break;
			default:
				return $data;
		}
		imagedestroy($image);
		$data = file_get_contents($temp);
		unlink($temp);
		return $data;
	}
	
	/**
	 * 给生成缩略图的过程进行定位
	 * bosscms
	 * @param string size        缩略图拉伸方式（值：fill, cover, contain）
	 * @param string horizontal  缩略图横向对齐方式（值：left, center, right）
	 * @param string vertical    缩略图纵向对齐方式（值：top, center, bottom）
	 */
	public static function position($width, $height, $img_width, $img_height, $size, $horizontal, $vertical)
	{
		$x = $y = $w = $h = 0;
		if($size == 'fill'){
			$w = $width;
			$h = $height;
		}else{
			$bosscms = true;
			$scaleX = $img_width / $width;
			$scaleY = $img_height / $height;
			if(($scaleX>$scaleY && $size=='cover') || ($scaleX<=$scaleY && $size=='contain')){
				$w = $img_width / $scaleY;
				$h = $height; 
				if($horizontal=='center'){
					$x = ceil(($width - $w) / 2);
				}else if($horizontal=='right'){
					$x = $width - $w;
				}
			}else if(($scaleX<=$scaleY && $size=='cover') || ($scaleX>$scaleY && $size=='contain')){
				$w = $width;
				$h = $img_height / $scaleX; 
				if($vertical=='center'){
					$y = ceil(($height - $h) / 2);
				}else if($vertical=='bottom'){
					$y = $height - $h;
				}
			}
		}				
		return array($x, $y, $w, $h);
	}
}
?>