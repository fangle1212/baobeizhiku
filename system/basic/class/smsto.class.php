<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

class smsto
{
	/* 发送短信 */
	public static function send($tel, $param, $template=null)
	{
		global $G;
		return into::load_class('extend','sms_aliyun','sample','new')->send($tel, $param, $template);
	}
	
	/* 获取短信签名信息 */
	public static function sign($name)
	{
		global $G;
		return into::load_class('extend','sms_aliyun','sample','new')->sign($name);
	}
	
	/* 获取短信模板信息 */
	public static function template($code)
	{
		global $G;
		return into::load_class('extend','sms_aliyun','sample','new')->template($code);
	}
}
?>