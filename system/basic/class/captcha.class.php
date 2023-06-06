<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::load_class('extend','captcha_tencent','verify','new');

class captcha extends verify
{
	public static function describe($randstr, $ticket)
	{
		global $G;
		$res = verify::_describe($randstr, $ticket);
		if($res->CaptchaCode===1){
			return true;
		}else{
			return false;
		}
	}
}
?>