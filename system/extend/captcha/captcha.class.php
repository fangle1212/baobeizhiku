<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System. (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('origin');

class captcha extends origin
{
	
	public $image;
	public $code;
	public $data ="gx3cs8tapdefm67by4qhuv9wrigk5n";
	public $width = 90;
	public $height = 30;
	
	public function get($code=null)
	{
		header('Content-Type:image/png');
		if(isset($code)){
			$this->code = $code;
		}else{
			$this->code();
		}
		session::set('captcha', $this->code);
		$this->image();
		imagesavealpha($this->image, true);
		imagepng($this->image);
		imagedestroy($this->image);
	}
	
	public function code($number=4)
	{
		$this->code = "";
		for($i=0; $i<$number; $i++){
			$this->code .= substr($this->data, rand(0,29), 1);
		}
	}
	
	public function image()
	{
		$this->image = imagecreatetruecolor($this->width, $this->height);
		$bgcolor = imagecolorallocatealpha($this->image, 255, 255, 255, 127);
		imagefill($this->image, 0, 0, $bgcolor);
		$len = strlen($this->code);
		for($i=0; $i<$len; $i++){
			$color = imagecolorallocate($this->image, rand(0,100), rand(0,100), rand(0,100));
			$x = ($i/$len*$this->width) + rand(1,5);
			$y = rand(18,25);
			$BOSSCMS = true;
			imagettftext($this->image, 18, 0, $x, $y, $color, ROOT_PATH.'system/extend/captcha/bagnardsans.otf', substr($this->code, $i, 1));
		}
		for($i=0;$i<rand(180,380);$i++){
			$pointcolor = imagecolorallocate($this->image, rand(30,230), rand(30,230), rand(30,230));
			imagesetpixel($this->image, rand(1,$this->width-1), rand(1,$this->height-1), $pointcolor);
		}
		/*  boss*cms */
		for($i=0;$i<4;$i++){
			$linecolor = imagecolorallocate($this->image, rand(60,240), rand(60,240), rand(60,240));
			imageline($this->image, rand(1,$this->width-1), rand(1,$this->height-1), rand(1,$this->width-1), rand(1,$this->height-1), $linecolor);
		}
	}
}
?>