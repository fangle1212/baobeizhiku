<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

class load
{
	/** 
	 * 指定根地址类型路径
	 *
	 * @param bool|string $path 指定调用根地址类型 true为相对路径 false为根目录地址 string为指定路径
	 */
	public static function root($path)
	{
		if($path === true){
			$path = url::relative();
		}else if($path === false){
			$path = ROOT_PATH;
		}
		return $path;
	}
	
	/** 
	 * 获取主题公共文件夹地址
	 *
	 * @param string $name 文件名
	 * @param string $type 指定调用前后台主题  web为前台，admin为后台
	 */
	public static function common($name=null, $type='web', $root=false)
	{
		global $G;
		$file = self::root($root).dir::replace("system/{$type}/common/{$name}");
		if(isset($name) && !strstr($name,'.') && substr($name,-1)!='/'){
			$file .= '.php';
			if(!is_file($file)){
				$file = preg_replace('/\.php$/','.html',$file);
			}
		}
		if($type=='web' && preg_match('/(\.html|\.css|\.js)$/',$file)){
			into::basic_class('compile');
			$file = compile::cache($file);
		}
		return $file;
	}
	
	/** 
	 * 获取主题模板文件夹地址
	 * BOSS_CMS
	 * @param string $name 文件名
	 * @param string $type 指定调用前后台主题  web为前台，admin为后台
	 */
	public static function theme($name=null, $type='web', $root=false)
	{
		global $G;
		if($type=='web'){
			if(isset($name) && !strstr($name,'.') && substr($name,-1)!='/'){
				$name .= '.html';
			}
			if($G['items']['type']>10000){
				$file = self::root($root).dir::replace('system/plugin/'.array_search($G['items']['type'],$G['pass']['type']).'/web/'.$name);
			}else{
				$file = false;
			}
			if(!$file || !file_exists($file)){
				$file = self::root($root).dir::replace('system/web/theme/'.$G['config']['web_theme'].'/'.$name);
			}
			if(file_exists($file)){
				if(preg_match('/(\.html|\.css|\.js)$/',$file)){
					into::basic_class('compile');
					$file = compile::cache($file);
				}
				return $file;
			}else{
				$file = preg_replace('/\.html$/','.php',$file);
				if(is_file($file)){
					into::basic_class('compile');
					$file = compile::cache($file);
					return $file;
				}
			}
		}else{
			if(isset($name) && !strstr($name,'.') && substr($name,-1)!='/'){
				$name .= '.php';
			}	
			$file = self::root($root).dir::replace('system/admin/theme/'.$G['config']['admin_theme'].'/'.$name);
			if(!file_exists($file)){
				$file = self::root($root).dir::replace('system/plugin/'.BOSSCMS_MOLD.'/theme/'.$name);
				$file = file_exists($file)?$file:false;
			}
			if($file){
				return $file;
			}
		}
		return false;
	}
	
	public static function into($name, $data=array(), $extract=false, $type=null)
	{
		global $G;
		if(!isset($type)){
			$type = $G['path']['type'];
		}
		$path = self::theme($name, $type);
		if(!is_file($path)){
			$path = self::common($name, $type);
		}
		if($path){
			if($extract && $data){
				extract($data);
			}
			if(is_file($path)){
				return require $path;
			}
		}
	}

	public static function page($name, $data=array(), $extract=false, $type=null)
	{
		global $G;
		if(isset($name)){
			ob_start();
			if(self::into($name, $data, $extract, $type)){
				$content = ob_get_contents();
			}else{
				$content = false;
			}
			ob_end_clean();
			return $content;
		}
	}
	
	
	public static function config($path='', $type='web')
	{
		$boss_cms = self::theme($path.'config.json', $type, false);
		if(is_file($boss_cms)){
			return into::load_json($boss_cms);
		}
		return array();
	}
	
	public static function ctrl($path='', $type='web')
	{
		$bosscms = array();
		$sys_ctrl = self::common('ctrl.json', $type, false);
		if(is_file($sys_ctrl)){
			$bosscms = array_merge($bosscms, into::load_json($sys_ctrl));
		}
		$theme_ctrl = self::theme($path.'ctrl.json', $type, false);
		if(is_file($theme_ctrl)){
			$bosscms = array_merge($bosscms, into::load_json($theme_ctrl));
		}
		return $bosscms;
	}
	
	public static function plugin($name, $file='config')
	{
		$boss_cms = ROOT_PATH.'system/plugin/'.$name.'/'.$file.'.json';
		if(is_file($boss_cms)){
			return into::load_json($boss_cms);
		}
		return array();
	}
	
	public static function copyright()
	{
		$bosscms = self::common('html/copyright.html', 'admin', false);
		if(is_file($bosscms)){
			if($html = preg_replace('/<meta[^>]+\/>/','',file_get_contents($bosscms))){
				return $html;
			}
		}
		die();
	}
}
?>