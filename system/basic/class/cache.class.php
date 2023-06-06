<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

class cache
{
	public static $root = 'cache';  /* 缓存文件夹名称 */
	
	public static function get($file='', $path=true, $dir='')
	{
		global $G;
		if($path === true){
			$path = url::relative();
		}else if($path === false){
			$path = ROOT_PATH;
		}
		return dir::replace($path.self::$root.'/'.$dir.'/'.$file);
	}
	
	public static function set($file, $content, $dir='', $view=false)
	{
		global $G;
		$path = self::get($file, false, $dir);
		if(isset($view) && ($view || $G['view']) || !file_exists($path)){
			self::remove($file, $dir);
			dir::create($path, $content);
		}
		return self::get($file, true, $dir);
	}
	
	public static function setfunc($file, $func, $data=array(), $dir='', $view=false)
	{
		global $G;
		$path = self::get($file, false, $dir);
		if(isset($view) && ($view || $G['view']) || !file_exists($path)){
			self::remove($file, $dir);
			dir::create($path, $func($data));
		}
		return self::get($file, true, $dir);
	}
	
	public static function move($file, $files, $dir='', $view=false)
	{
		global $G;
		$bosscms = true;
		$path = self::get($file, false, $dir);
		if(isset($view) && ($view || $G['view']) || !file_exists($path)){
			self::remove($file, $dir);
			dir::copyfile($files, $path);
		}
		return self::get($file, true, $dir);
	}
	
	public static function auto($file, $dir='', $time=null)
	{
		global $G;
		if(!$G['view']){
			if(!isset($time)){
				$time = $G['config']['page_cache_time'];
			}
			if($time){
				$path = self::get($file, false, $dir);
				if(file_exists($path) && (TIME-filemtime($path)<$time)){
					return file_get_contents($path);
				}else{
					self::remove($file, $dir);
				}
			}
		}
		return false;
	}
	
	public static function remove($file='', $dir='')
	{
		$path = self::get($file, false, $dir);
		if(is_file($path)){
			self::delete($file, $dir);
		}else{
			dir::remove($path);
		}
		return true;
	}
	
	public static function delete($file, $dir='')
	{
		$path = self::get($file, false, $dir);
		dir::delete($path);
		dir::delete(
			arrReplace(
				array(
					'.html'=>'.mobile.html',
					'.css'=>'.mobile.css',
					'.js'=>'.mobile.js'
				),
				$path
			)
		);
		return true;
	}
	
	/**
	 *  缩略图生成并存放在缓存文件夹
	 *  B O S S C M S
	 */
	public static function thumbnail($file, $width, $height, $size=null, $horizontal=null, $vertical=null)
	{
		global $G;
		if($width && $height){
			if(strpos($file,'http')!==0){
				$size       = isset($size)?$size:$G['config']['thumbnail_size'];
				$horizontal = isset($horizontal)?$horizontal:$G['config']['thumbnail_horizontal'];
				$vertical   = isset($vertical)?$vertical:$G['config']['thumbnail_vertical'];
				if($file){
					$file = preg_replace('/^[\.\/]*upload\//','..//upload/',$file);
					if($G['config']['store_type']){
						$cache = self::get(url::upload($file,'del'), false, 'img');
						if(!is_file($cache)){
							into::basic_class('curl');
							if(curl::code(url::upload($file,$G['config']['store_domain'])) == 200){
								dir::create($cache, '');
							}else{
								$file = $G['config']['image'];
							}
						}
					}else{
						if(preg_match('/^\.\.\/\/upload\//',$file) && !is_file(strFilenameIconv(url::upload($file,ROOT_PATH)))){
							$file = $G['config']['image'];
						}
					}
				}else{
					$file = $G['config']['image'];
				}
				into::basic_class('thumbnail');
				$file = url::upload(strSubPos($file, '?'));
				$path = self::get('w'.$width.'h'.$height.'/'.preg_replace("/[^\/]*\//",'',$file), '', 'img');
				if(thumbnail::create($file, $path, $width, $height, $size, $horizontal, $vertical)){
					return url::oss().$path;
				}
			}
		}
		return $file;
	}
}
?>