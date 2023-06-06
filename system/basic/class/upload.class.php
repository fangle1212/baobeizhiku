<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_json('extension');
into::basic_class('oss');

class upload{
	
	public static $msg = '上传失败';
	public static $path = '';
	
	/**  
	 * 文件上传
	 *
	 * @param array $file 前台通过http post上传来的$_FILES数据
	 * @param strong $path 保存文件的文件夹，为空则保存在根目录upload的对应文件夹中
	 * @param strong $type 允许上传的文件类型，为空则支持系统设置的所有类型
	 * @return boolean
	 */
	public static function files($file, $path=null, $type=null){
		global $G;
		if(($G['config']['upload_web_allow'] && $G['path']['type']=='web') || $G['path']['type']=='admin'){
			if(is_uploaded_file($file['tmp_name'])){
				if($file['error']==0){
					if($G['config']['upload_repeat'] && !$G['config']['store_type'] && ($tmp_path=array_search(sha1_file($file['tmp_name']), self::shax()))){
						self::$path = url::relative().$tmp_path;
						self::$msg = '文件已存在';
						return true;
					}
					$ext = '.'.pathinfo($file['name'],PATHINFO_EXTENSION);
					$extension = json::decode($G['config']['upload_extension']);
					$in = false;
					if($type){
						$tarr = explode('|',$type);
						foreach($G['extension'] as $k=>$v){
							if(in_array($ext, $v)){
								if(in_array($k, $tarr)){
									$type = null;
									break;
								}
								$in = true;
							}
						}
					}
					if(preg_match('/^\.[A-Za-z0-9]+$/i',$ext) && !preg_match('/^\.(php\d*|aspx*|jsp*)$/i',$ext) && in_array($ext,$extension) && (!$type || ($type && !$in))){
						$photo = in_array($ext,$G['extension']['photo']);
						if($file['size'] <= $G['config']['upload_maxsize']*1024*1024){
							if(!$photo || ($photo && getimagesize($file['tmp_name']))){
								if(move_uploaded_file($file['tmp_name'], $path=self::path($file['name'],$path))){
									if(preg_match('/^\.(png|jpg|jpeg|gif)$/i',$ext) && arrExist($G['config'],'watermark_open') && ($class=into::load_class('plugin','watermark','waterimg','new'))){
										if($data = $class->set($path)){
											if($G['config']['upload_repeat'] && !$G['config']['store_type'] && ($tmp_path=array_search(sha1($data), self::shax()))){
												self::$path = url::relative().$tmp_path;
												self::$msg = '文件已存在';
												dir::delete($path);
												return true;
											}else{
												file_put_contents(ROOT_PATH.self::$path, $data);
											}
										}
									}
									if($G['config']['store_type']){
										oss::upload(self::$path, ROOT_PATH.self::$path);
										dir::delete($path);
										self::$path = $G['config']["store_domain"].self::$path;
									}else{
										if($G['config']['upload_repeat']){
											self::shax('upload', self::$path);
										}
										self::$path = url::relative().self::$path;
									}
									self::$msg = '上传成功';
									return true;
								}else{
									self::$msg = '上传失败';
								}
							}else{
								self::$msg = '上传文件不是有效的图片';
							}
						}else{
							self::$msg = '上传文件超过后台管理设定的大小；当前允许的大小为'.$G['config']['upload_maxsize'].'M';
						}
					}else{
						self::$msg = '该文件扩展名不允许上传';
					}				
				}else{
					switch($file['error']){
						case 1: self::$msg = '超过服务器的“php.ini”所设置允许上传文件的大小';
						case 2: self::$msg = '超过“MAX_FILE_SIZE”允许上传的大小';
						case 3: self::$msg = '文件已部分上传';
						case 4: self::$msg = '没有上传文件';
						case 5: self::$msg = '文件大小为0';
					}
				}
			}else{
				self::$msg = '没有上传文件';
			}
		}else{
			self::$msg = '没有开启上传权限';
		}
		return false;
	}

	/**
	 * 文件上传地址
	 *
	 * @param strong $name 上传的文件名称，可设置是否重命名文件
	 * @param strong $path 保存文件的文件夹，为空则保存在根目录upload的对应文件夹中 boss cms（路径必须为根目录下文件相对路径）
	 * @return strong
	 */	
	public static function path($name, $path=null, $exist=0){
		global $G;
		$extension = '.'.pathinfo($name,PATHINFO_EXTENSION);
		if($G['config']['upload_rename']){
			$name = date('dHis',TIME).mt_rand(0,9).$extension;
		}else{
			$name = preg_replace('/\.[^\.]+$/',mt_rand(0,9).'\\0',$name);
		}
		$Ym = date('Ym',TIME);
		if($path){
			$dir = $path.'/'.(strpos($path,'upload/')===0?$Ym.'/':'');
			dir::make(ROOT_PATH.$dir);
		}else{
			$dir = '';
			foreach($G['extension'] as $k=>$v){
				if(in_array($extension, $v)){
					$dir = $k;
					break;
				}
			}
			$dir = 'upload/'.($dir?$dir:'file').'/'.$Ym.'/';
			dir::make(ROOT_PATH.$dir);
		}
		$src = dir::replace(ROOT_PATH.$dir).strFilenameIconv($name);
		self::$path = dir::replace($dir).$name;
		if(is_file($src) && $exist<9){
			sleep(1);
			return self::path($name, $path, $exist++);
		}else{
			return $src;
		}
	}
	
	
	/**
	 * 文件保存
	 *
	 * @param strong $name 文件名称
	 * @param strong $path 新增文件插入保存sha1
	 * @param strong $cache 是否查看缓存中的文件
	 * @return strong
	 */	
	public static function shax($name='upload', $path=null, $cache=true){
		$file = ROOT_PATH.'cache/sha1/'.md5($name);
		$sha1 = array();
		if($cache && is_file($file)){
			$sha1 = json::get($file);
			if($path){
				$sha1 = array_merge($sha1, array($path=>sha1_file(ROOT_PATH.$path)));
				dir::create($file, json::encode($sha1));
			}
			if(is_file(ROOT_PATH.$sha1)){
				return $sha1;
			}else{
				return self::shax($name, $path, false);
			}
		}else{
			$res = dir::readall(ROOT_PATH.$name,$name);
			foreach($res as $v){
				$sha1[$v] = sha1_file(ROOT_PATH.$v);
			}
			if($path){
				$sha1 = array_merge($sha1, array($path=>sha1_file(ROOT_PATH.$path)));
			}
			dir::create($file, json::encode($sha1));
			return $sha1;
		}
	}
}
?>