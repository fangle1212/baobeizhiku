<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');
into::basic_class('upload');

class ueditor extends admin
{
	public $config;
	
	public function __construct()
	{
		global $G;
		$this->config = into::load_json("config.json");
	}
	
	public function init()
	{
		global $G;
		if(isset($G['get']['action'])){
			switch($G['get']['action']){
				case 'config':
					$result = json::encode($this->config,true);
					break;
				case 'delete': /* 删除文件 */
					$result = $this->delete();
					break;
				case $this->config['imageActionName']:  /* 上传图片 */
					$result = $this->uploadimage();
					break;
				case $this->config['imageManagerActionName']:  /* 列出图片 */
					$result = $this->listimage();
					break;
				case $this->config['catcherActionName']: /* 抓取远程图片 */
					$result = $this->catchimage();
					break;
				case $this->config['videoActionName']: /* 上传视频 */
					$result = $this->uploadvideo();
					break;
				case $this->config['videoManagerActionName']:  /* 列出视频 */
					$result = $this->listvideo();
					break;
				case $this->config['fileActionName']: /* 上传附件 */
					$result = $this->uploadfile();
					break;
				case $this->config['fileManagerActionName']: /* 列出附件 */
					$result = $this->listfile();
					break;
				default:
					$result = json::encode(
						array(
							'state' => '请求地址出错'
						)
					);
					break;
			}
			echo $this->callback($result);
		}
	}
	
	public function delete()
	{
		global $G;
		$path = arrExist($G,'post|path');
		if($path && preg_match('/^upload\/.+\.\w+$/',$paths=str_replace(self::replacepath(url::upload()),'upload/',$path))){
			if(strstr($paths,'../')){
				$result = json::encode(
					array(
						'state' => '文件地址错误'
					)
				);
			}else{
				$delete = false;
				if($G['config']['store_type']){
					$delete = oss::delete($paths);
				}else{
					$delete = dir::delete(ROOT_PATH.$paths);
				}
				$result = json::encode(
					array(
						'state' => $delete?'SUCCESS':'删除失败'
					)
				);
			}
		}else{
			$result = json::encode(
				array(
					'state' => '没有指定删除文件'
				)
			);
		}
		return $result;
	}
	
	public function uploadimage()
	{
		global $G;
		if(isset($_FILES[$this->config['imageFieldName']])){
			$file = $_FILES[$this->config['imageFieldName']];
			if($file['size'] <= $this->config['imageMaxSize']){
				if(upload::files($file, $this->config['imagePathFormat'], 'photo')){
					$result =  json::encode(
						array(
							'state' => 'SUCCESS',
							'url' => $this->replacepath(upload::$path),
							'title' => $G['config']['title'],
							'original' => $G['config']['title'],
							'sort' => arrExist($G['post'],'sort')
						)
					);
				}else{
					$result = json::encode(
						array(
							'state' => upload::$msg
						)
					);
				}
			}else{
				$result = json::encode(
					array(
						'state' => '超过ueditor的图片上传大小限制'
					)
				);
			}
		}else{
			$result = json::encode(
				array(
					'state' => '没有上传图片'
				)
			);
		}
		return $result;
	}
	
	public function listimage()
	{
		global $G;
		$start = 0;
		if(isset($G['get']['start']) && is_numeric($G['get']['start'])){
			$start = $G['get']['start'] * 1;
		}
		$size =	$this->config['imageManagerListSize']*1;
		if(isset($G['get']['size']) && is_numeric($G['get']['size'])){
			$size = $G['get']['size'] * 1;
		}
		$data = $this->lists($this->config['imageManagerListPath'], $start, $size);
		return json::encode(
			array(
				'state' => 'SUCCESS',
				'list' => $data['list'],
				'start' => $start,
				'size' => $size,
				'total' => $data['total']
			),true
		);
	}
	
	public function catchimage()
	{
		global $G;
		if(isset($G['post'][$this->config['catcherFieldName']])){
			into::basic_class('curl');
			$list = array();
			foreach($G['post'][$this->config['catcherFieldName']] as $url){
				$url = str_replace("&amp;","&",$url);
				$arr = array(
					'source' => $url,
					'url' => $url,
					'state' => 'SUCCESS'
				);
				if($G['config']['ueditor_catchimage']){
					if(strpos($url,"http")===0 && $head=curl::request($url, null, true, true)){
						preg_match('/Content-Type:\s*(.+)/i', $head, $ctype);
						preg_match('/Content-Length:\s*(.+)/i', $head, $clength);
						if(isset($ctype[1]) && isset($clength[1]) && stristr($ctype[1],'image')){
							if($clength[1]*1<=$this->config['catcherMaxSize'] && $clength[1]*1<=$G['config']['upload_maxsize']*1024*1024){
								if($data = curl::request($url)){
									$file = upload::path($url, $this->config['catcherPathFormat']);
									preg_match('/\.\w+$/',$file,$ext);
									if(isset($ext[0]) && in_array($ext[0],$G['extension']['photo'])){
										dir::create($file, $data);
										$arr['url'] = $this->replacepath(url::relative().upload::$path);
										if($G['config']['store_type']){
											oss::upload(upload::$path, ROOT_PATH.upload::$path);
											dir::delete($file);
											$arr['url'] = $G['config']["store_domain"].upload::$path;
										}
									}
								}
							}
						}
					}else{
						$arr['state']= '图片地址出错';
					}
				}
				$list[] = $arr;
			}
			$result =  json::encode(
				array(
					'state' => 'SUCCESS',
					'list' => $list
				)
			);
		}
		return $result;
	}
	
	public function uploadvideo()
	{
		global $G;
		if(isset($_FILES[$this->config['videoFieldName']])){
			$file = $_FILES[$this->config['videoFieldName']];
			if($file['size'] <= $this->config['videoMaxSize']){
				if(upload::files($file, $this->config['videoPathFormat'], 'movie')){
					$result =  json::encode(
						array(
							'state' => 'SUCCESS',
							'url' => $this->replacepath(upload::$path),
							'sort' => arrExist($G['post'],'sort')
						)
					);
				}else{
					$result = json::encode(
						array(
							'state' => upload::$msg
						)
					);
				}
			}else{
				$result = json::encode(
					array(
						'state' => '超过ueditor的视频上传大小限制'
					)
				);
			}
		}else{
			$result = json::encode(
				array(
					'state' => '没有上传视频文件'
				)
			);
		}
		return $result;
	}
	
	public function listvideo()
	{
		global $G;
		$start = 0;
		$size =	$this->config['videoManagerListSize']*1;
		if(isset($G['get']['start']) && is_numeric($G['get']['start'])){
			$start = $G['get']['start'] * 1;
		}
		if(isset($G['get']['size']) && is_numeric($G['get']['size'])){
			$size = $G['get']['size'] * 1;
		}
		$data = $this->lists($this->config['videoManagerListPath'], $start, $size);
		return json::encode(
			array(
				'state' => 'SUCCESS',
				'list' => $data['list'],
				'start' => $start,
				'size' => $size,
				'total' => $data['total']
			),true
		);
	}
	
	public function uploadfile()
	{
		global $G;
		if(isset($_FILES[$this->config['fileFieldName']])){
			$file = $_FILES[$this->config['fileFieldName']];
			if($file['size'] <= $this->config['fileMaxSize']){
				if(upload::files($file, $this->config['filePathFormat'], null)){
					$result =  json::encode(
						array(
							'state' => 'SUCCESS',
							'url' => $this->replacepath(upload::$path),
							'sort' => arrExist($G['post'],'sort')
						)
					);
				}else{
					$result = json::encode(
						array(
							'state' => upload::$msg
						)
					);
				}
			}else{
				$result = json::encode(
					array(
						'state' => '超过ueditor的附件上传大小限制'
					)
				);
			}
		}else{
			$result = json::encode(
				array(
					'state' => '没有上传附件'
				)
			);
		}
		return $result;
	}
	
	public function listfile()
	{
		global $G;
		$start = 0;
		$size =	$this->config['fileManagerListSize']*1;
		if(isset($G['get']['start']) && is_numeric($G['get']['start'])){
			$start = $G['get']['start'] * 1;
		}
		if(isset($G['get']['size']) && is_numeric($G['get']['size'])){
			$size = $G['get']['size'] * 1;
		}
		$data = $this->lists($this->config['fileManagerListPath'], $start, $size);
		return json::encode(
			array(
				'state' => 'SUCCESS',
				'list' => $data['list'],
				'start' => $start,
				'size' => $size,
				'total' => $data['total']
			),true
		);
	}
	
	public function lists($path, $start=0, $size=0)
	{
		global $G;
		$folder = str_replace('../','',arrExist($G,'get|folder'));
		$path = str_replace('../','',dir::replace($path.'/'.$folder));
		$list = array();
		$total = 0;
		if($G['config']['store_type']){
			if($G['get']['type']=='on'){
				$data = oss::read($path);
			}else{
				$data['file'] = oss::readall($path);
				$path = '';
			}
			$url = $G['config']['store_domain'];
		}else{
			if($G['get']['type']=='on'){
				$data = dir::read(ROOT_PATH.$path);
			}else{
				$data['file'] = dir::readall(ROOT_PATH.$path);
			}
			$url = self::replacepath(url::relative());
		}
		if($data['dir']){
			arsort($data['dir'],1);
		}
		if($data['file']){
			if($G['config']['store_type']){
				krsort($data['file']);
			}else{
				arsort($data['file'],1);
				$file = array();
				foreach($data['file'] as $k=>$name){
					$file[filemtime(ROOT_PATH."{$path}/{$name}").'.'.$k] = $name;
				}
				krsort($file);
				$data['file'] = $file;
			}
		}
		foreach($data['dir'] as $name){
			$name = strUTF8($name);
			if($total>=$start && $total<$start+$size){
				$arr = array(
					'folder' => dir::replace("{$folder}/{$name}/"),
					'dir' => true,
					'url' => dir::replace("{$url}/{$path}/{$name}")
				);
				$list[] = $arr;
			}
			$total++;
		}
		foreach($data['file'] as $name){
			$name = strUTF8($name);
			if($total>=$start && $total<$start+$size){
				$arr = array(
					'folder' => $name,
					'dir' => false,
					'url' => dir::replace("{$url}/{$path}/{$name}")
				);
				$list[] = $arr;
			}
			$total++;
		}
		
		return array('list'=>$list, 'total'=>$total);
	}

	public function replacepath($path)
	{
		global $G;
		return str_replace('../../../','',$path);
	}

	/* 输出结果 */
	public function callback($json)
	{
		global $G;
		if(isset($G['get']['callback'])){
			return $G['get']['callback']."({$json})";
		}else{
			return $json;
		}
	}
}
?>