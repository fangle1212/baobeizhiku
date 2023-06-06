<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

class json
{
	public static function encode($array, $print=false, $options=null)
	{
		if(isset($array)){
			$string = json_encode($array, isset($options)?$options:($print?JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT:JSON_UNESCAPED_UNICODE));
		}else{
			$string = null;
		}
		return $string;
	}
	
	public static function decode($string)
	{
		if($string){
			if(is_string($string)){
				if($array = json_decode($string, true)){
					return is_array($array)?$array:array();
				}
			}else if(is_array($string)){
				return $string;
			}
		}
		return array();
	}
	
	public static function enfilter($data){
		return strSlashes(self::encode(delSlashes($data)));
	}
	
	public static function defilter($data){
		return strSlashes(self::decode(delSlashes($data)));
	}
	
	public static function first($string)
	{
		$array = self::decode($string);
		return $array?$array[0]:null;
	}
	
	public static function last($string)
	{
		$array = self::decode($string);
		return $array?$array[count($array)-1]:null;
	}
	
	public static function put($file, $array)
	{
		return dir::create($file, self::encode($array,true));
	}
	
	public static function get($file)
	{
		$content = '';
		/* BOSS_CMS */
		if(is_file($file)){
			ob_start();
			require($file);
			$content = ob_get_contents();
			ob_end_clean();
		}
		return self::decode(preg_replace("/\/\*[\s\S]+?\*\//", '', $content));
	}
}
?>