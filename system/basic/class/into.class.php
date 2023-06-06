<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

class into
{
	/* 加载class类文件 */
	public static function load_class($type=null, $mold, $part, $func=null)
	{
		if(!isset($type)){
			$type = defined('IS_INSIDE')?'admin':'web';
		}
		if(!preg_match('/^[\w\/]+$/',$mold) || !preg_match('/^\w+$/',$part) || ($func&&!preg_match('/^\w+$/',$func))){
			die();
		}
		$file = SYSTEM_PATH.$type.'/'.$mold.'/'.$part.'.class.php';
		if(!is_file($file)){
			/* 尝试加载plugin插件路径下是否有文件 BOSSCMS */
			$plugin = SYSTEM_PATH.'plugin/'.$mold.'/'.$part.'.class.php';
			if(is_file($plugin)){
				$file = $plugin;
				if($mold == BOSSCMS_MOLD){
					define('IS_PLUGIN', true);
				}
			}else{
				$file = false;
			}
		}
		if($file){
			require_once $file;
			if(!class_exists($part)){
				return false;
			}
		}else{
			return false;
		}
		if(isset($func)){
			$class = new $part;
			if($func != 'new'){
				if(method_exists($class, $func)){
					call_user_func(array($class, $func));
				}
			}
			return $class;
		}
		return true;
	}
	
	/* 加载function方法文件 boss_cms */
	public static function load_func($path, $name=null)
	{
		$file = isset($name)?SYSTEM_PATH.$path.'/'.$name.'.func.php':$path;
		if(is_file($file)){
			require_once $file;
		}
	}
	
	/* 加载json数据文件 */
	public static function load_json($path, $name=null)
	{
		$file = isset($name)?SYSTEM_PATH.$path.'/'.$name.'.json':$path;
		if(is_file($file)){
			return json::get($file);
		}
	}
	
	/* 加载ini配置文件 b o s s c m s */
	public static function load_ini($path, $name=null)
	{
		$file = isset($name)?SYSTEM_PATH.$path.'/'.$name.'.ini.php':$path;
		if(is_file($file)){
			return parse_ini_file($file, true);
		}
	}
	
	
	public static function load()
	{
		return self::load_class(defined('BOSSCMS_TYPE')?BOSSCMS_TYPE:null, BOSSCMS_MOLD, BOSSCMS_PART, BOSSCMS_FUNC);
	}
	
	public static function basic_class($name, $func=null)
	{
		global $_CLASS;
		if(!isset($func)){
			$func = 'init';
			if(isset($_CLASS['basic'][$name]['init'])) return false;
		}
		$_CLASS['basic'][$name][$func] = true;
		return self::load_class('basic','class',$name, $func);
	}
	
	public static function basic_func($name)
	{
		return self::load_func('basic/func', $name);
	}
	
	public static function basic_json($name, $more=false, $cache=true)
	{
		global $G;
		if($more){
			$file = ROOT_PATH.'cache/json/'.md5($name);
			if(is_file($file) && $cache){
				$data = json::get($file);
			}else{
				$data = self::load_json('basic/json', $name);
				$dir = dir::read(SYSTEM_PATH.'basic/json/');
				foreach($dir['file'] as $v){
					if(preg_match('/^'.$name.'_\w+\.json$/',$v)){
						$json = json::get(SYSTEM_PATH.'basic/json/'.$v);
						$data = array_merge($data, $json);
					}
				}
				dir::create($file, json::encode($data));
			}
			$G[$name] = $data;
		}else{
			$G[$name] = self::load_json('basic/json', $name);
		}
	}
	
	public static function basic_ini($name)
	{
		global $G;
		$G[$name] = self::load_ini('basic/ini', $name);
	}
}

?>