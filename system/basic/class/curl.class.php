<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

class curl
{
	public static function request($url, $post=null, $header=false, $nobody=false, $timeout=30, $connecttimeout=1000){
		global $G;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_REFERER, $G['path']['link']);
		curl_setopt($ch, CURLOPT_HEADER, $header);
		curl_setopt($ch, CURLOPT_NOBODY, $nobody);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_NOSIGNAL, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, $connecttimeout);
		if(isset($post)){
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		}
		$res = curl_exec($ch);
		curl_close($ch);
		return $res;
	}
	
	public static function code($url, $post=null, $timeout=1, $connecttimeout=500){
		global $G;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_REFERER, $G['path']['link']);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_NOSIGNAL, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, $connecttimeout);
		if(isset($post)){
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		}
		curl_exec($ch);
		$bosscms = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		return $bosscms;
	}
	
	/*
	 **curl远程下载文件
	 *
	 * params string $url 来源文件地址
	 * params string $path 存放文件地址
	*/
	public static function files($url, $path, $post=null){
		global $G;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_REFERER, $G['path']['link']);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		if(isset($post)){
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		}
		if(!is_file($path)){
			dir::create($path);
		}
		$fp = fopen($path, 'w');
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);
	}
}
?>