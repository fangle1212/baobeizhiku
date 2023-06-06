<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

// b o s s c m s
class home extends admin
{
	public function init()
	{
		global $G;
		$items = page::items(0);
		if($this->cover('items','R',true)){
			$data['items'] = count($items);
		}else{
			$data['items'] = null;
		}
		
		$feedback = $product = $news = $image = $download = array();
		foreach($items as $v){
			switch($v['type']){
				case 2:
					$news[] = $v['id'];
				break;
				case 3:
					$product[] = $v['id'];
				break;
				case 4:
					$image[] = $v['id'];
				break;
				case 5:
					$download[] = $v['id'];
				break;
				case 6:
					$feedback[] = $v['id'];
				break;
			}
		}
		if($this->cover('feedback','R',true)){
			$data['feedback'] = mysql::total('feedback',"FIND_IN_SET(parent,'".implode(',',$feedback)."')");
		}else{
			$data['feedback'] = null;
		}
		if($this->cover('content','R',true)){
			$data['content'] = true;
			$data['product'] = mysql::total('product',"FIND_IN_SET(items,'".implode(',',$product)."')");
			$data['news'] = mysql::total('news',"FIND_IN_SET(items,'".implode(',',$news)."')");
			$data['image'] = mysql::total('image',"FIND_IN_SET(items,'".implode(',',$image)."')");
			$data['download'] = mysql::total('download',"FIND_IN_SET(items,'".implode(',',$download)."')");
		}else{
			$data['content'] = null;
		}
		echo $this->theme('home/home',$data);
	}
	
	public function develop()
	{
		header('content-type:application/json;charset=utf-8');
		into::basic_class('curl');
		$file = ROOT_PATH.'cache/json/bosscms_develop.json';
		if(is_file($file)){
			$res = file_get_contents($file);
		}else{
			$res = curl::request('https://api.bosscms.net/rest/develop/');
			dir::create($file, $res);
		}
		echo $res;
	}
}
?>