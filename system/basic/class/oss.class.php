<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

class oss
{
	/*
	 * 操作远程oss文件
	 * @params string $path 存放oss的文件路径
	 * @params string $file 本地的文件路径
	 */
	public static function upload($path, $file)
	{
		global $G;
		switch($G['config']['store_platform']){
			case 0:
				into::load_class('extend','oss_aliyun','save','new')->upload($path, $file);
			break;
		}
	}
	
	public static function read($path)
	{
		global $G;
		switch($G['config']['store_platform']){
			case 0:
				return into::load_class('extend','oss_aliyun','save','new')->read($path);
			break;
		}
	}
	
	public static function readall($path)
	{
		global $G;
		switch($G['config']['store_platform']){
			case 0:
				return into::load_class('extend','oss_aliyun','save','new')->readall($path);
			break;
		}
	}
	
	public static function remove($path)
	{
		global $G;
		switch($G['config']['store_platform']){
			case 0:
				return into::load_class('extend','oss_aliyun','save','new')->remove($path);
			break;
		}
	}
	
	/* BOSS-CMS */
	public static function delete($file)
	{
		global $G;
		switch($G['config']['store_platform']){
			case 0:
				return into::load_class('extend','oss_aliyun','save','new')->delete($file);
			break;
		}
	}
}
?>