<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

class zip
{
	/*
	 ** 压缩zip文件
	 *
	 * params string $file zip文件地址
	 * params string $path 压缩文件或文件地址
	 * params string $dir 压缩文件包里的路径
	*/
	public static function add($file, $path, $dir='')
	{
        if($file && $path && class_exists("ZipArchive")){
			if(!is_file($file)){
				dir::create($file);
			}
			if($dir){
				$dir = dir::replace($dir.'/');
			}
			$zip = new ZipArchive();
			if(!$zip->open($file)){
				return false;
			}
			if(is_file($path)){
				$name = basename($path);
				$zip->addFile($path, $dir.$name);
			}else if(is_dir($path)){
				$all = dir::readall($path);
				foreach($all as $v){
					$zip->addFile($path.$v, $dir.$v);
				}
			}
			$zip->close();
			return true;
        }
		return false;
	}
	
	/*
	 ** 解压zip文件
	 *
	 * params string $file zip文件地址
	 * params string $path 解压文件存放地址
	*/
	public static function unzip($file, $path)
	{
        if($file && $path && class_exists("ZipArchive")){
			$zip = new ZipArchive();
			if(!$zip->open($file)){
				return false;
			}
			$zip->extractTo($path);
			$zip->close();
			return true;
        }
		return false;
	}
}
?>