<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

class dir
{
	
	/**
	 * 替换路径分隔字符
	 * @bosscms
	 * @param string path 文件夹路径
	 * @return string  
	 */
	public static function replace($path){
		$path = str_replace('://',':'.P,$path);
		$path = str_replace('//','/',str_replace('///','/',str_replace('\\','/',$path)));
		$path = str_replace(':'.P,'://',$path);
		return $path;
	}
	
	/**
	 * 按路径循环新建文件夹
	 * @boss_cms
	 * @param string path 需要新建的文件夹路径
	 * @return boolean  
	 */
	public static function make($path){
		$path = self::replace($path.'/');
		$dir = self::replace(ROOT_PATH);
		$path = str_replace($dir,'',$path);
		$arr = explode('/', $path);
		foreach($arr as $v){
			$dir .= $v.'/';
			if(!file_exists($dir)){
				if(!mkdir($dir)){
					return false;
				}
			}
		}
		return true;
	}
	
	/**
	 * 删除文件夹
	 * @boss-cms
	 * @param string path 文件夹路径
	 * @return boolean  
	 */
	public static function remove($path, $rmdir=true){
		$path = self::replace($path.'/');
		if($path!=self::replace(ROOT_PATH) && $path!=self::replace(SYSTEM_PATH) && !strstr($path,'../') &&  file_exists($path)){
			$files = self::read($path);
			foreach($files['file'] as $name){
				self::delete($path.$name);
			}
			foreach($files['dir'] as $name){
				self::remove($path.$name);
			}
			if($rmdir){
				rmdir($path);
			}
			return true;
		}
		return false;
	}
	
	/**
	 * 复制文件夹
	 * b o s s c m s
	 * @param string path 原文件夹路径
	 * @param string paths 新文件夹路径
	 * @return boolean  
	 */
	public static function copydir($path, $paths){
		$path = self::replace($path.'/');
		$paths = self::replace($paths.'/');
		if(file_exists($path)){
			if(self::make($paths)){
				$files = self::read($path);
				foreach($files['file'] as $name){
					self::copyfile($path.$name, $paths.$name);
				}
				foreach($files['dir'] as $name){
					self::copydir($path.$name, $paths.$name);
				}
				return true;
			}
		}
		return false;
	}
	
	/**
	 * 移动文件夹
	 * 
	 * @param string path 原文件夹路径
	 * @param string paths 新文件夹路径
	 * @return boolean  
	 */
	public static function turn($path, $paths){
		$path = self::replace($path.'/');
		$paths = self::replace($paths.'/');
		if(file_exists($path)){
			if(self::make($paths)){
				$files = self::read($path);
				foreach($files['file'] as $name){
					self::move($path.$name, $paths.$name);
				}
				foreach($files['dir'] as $name){
					self::turn($path.$name, $paths.$name);
				}
				return rmdir($path);
			}
		}
		return false;
	}
	
	/**
	 * 读取文件夹
	 * 
	 * @param string path 文件夹路径
	 * @return array  
	 */
	public static function read($path){
		$dir = $file = array();
		$path = self::replace($path.'/');
		if(file_exists($path)){
			$handle = opendir($path);
			while(($name=readdir($handle)) !== false){
				if($name!='.' && $name!='..'){
					if(is_dir($path.'/'.$name)){
						$dir[] = $name;
					}else{
						$file[] = $name;
					}
				}
			}
			closedir($handle);
		}
		return array('dir'=>$dir, 'file'=>$file);
	}
	
	/**
	 * 读取文件夹
	 * boss*cms
	 * @param string path 文件夹路径
	 * @param string str 文件上级文件夹名称
	 * @param array files 循环用保存数组
	 * @param boolean type 单层数组为true，多层数组为false
	 * @return array  返回文件夹目录数组
	 */
	public static function readall($path, $str=null, $files=array(), $type=true){
		$path = self::replace($path.'/');
		$dir = self::read($path);
		foreach($dir['dir'] as $name){
			if($type){
				$files = self::readall($path.$name, ($str?$str.'/':'').$name, $files);
			}else{
				$files[$name] = self::readall($path.$name);
			}
		}
		foreach($dir['file'] as $name){
			if($type){
				$files[] = ($str?$str.'/':'').self::replace($name);
			}else{
				$files[] = self::replace($name);
			}
		}
		return $files;
	}
	
	/***************** File class bosscms *****************/
	
	/**
	 * 移动文件
	 * 
	 * @param string path 原文件路径
	 * @param string paths 新文件路径
	 * @return boolean  
	 */
	public static function move($path, $paths){
		$path = self::replace($path);
		$paths = self::replace($paths);
		if(is_file($path)){
			$dir = dirname($paths);
			if(self::make($dir)){
				if(rename($path, $paths)){
					return true;
				}
			}
		}
		return false;
	}
	
	/**
	 * 复制文件
	 * 
	 * @param string path 原文件路径
	 * @param string paths 新文件路径
	 * @return boolean  
	 */
	public static function copyfile($path, $paths){
		$path = self::replace($path);
		$paths = self::replace($paths);
		if(is_file($path)){
			$dir = dirname($paths);
			if(self::make($dir)){
				if(copy($path, $paths)){
					return true;
				}
			}
		}else{
			return self::copydir($path, $paths);
		}
	}
	
	/**
	 * 新建文件
	 * 
	 * @param string path 文件路径
	 * @param string content 写入文件的内容
	 * @return boolean  
	 */
	public static function create($path, $content=null){
		$path = self::replace($path);
		if(!is_file($path)){
			$dir = dirname($path);
			if(self::make($dir)){
				if(!touch($path)){
					return false;
				}
			}
		}
		if(isset($content)){
			file_put_contents($path, $content);
		}
		return true;
	}
	
	/**
	 * 删除文件
	 * 
	 * @param string path 文件路径
	 * @return boolean  
	 */
	public static function delete($path, $remove=false){
		$path = self::replace($path);
		if(!strstr($path,'../') && is_file($path)){
			if(unlink($path)){
				return true;
			}
		}
		return false;
	}
}
?>