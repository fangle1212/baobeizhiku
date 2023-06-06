<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');
into::basic_class('cache');

class clear extends admin
{
	public function cache($alt=true)
	{
		dir::remove(cache::get('',false), false);
		if($alt){
			alert('操作成功');
		}
	}
	
	public function files($alt=true)
	{
		$dir = cache::get('', false);
		$files = dir::readall($dir);
		foreach($files as $v){
			if(!preg_match("/img\//",$v)){
				dir::delete($dir.$v);
			}
		}
		if($alt){
			alert('操作成功');
		}
	}
	/* boss_cms */
	public function thumbnail($alt=true)
	{
		dir::remove(cache::get('',false,'img'), false);
		if($G['config']['store_type']){
			into::basic_class('oss');
			oss::remove(cache::get('','','img'));
		}
		if($alt){
			alert('操作成功');
		}
	}
	
	public function globals($alt=true)
	{
		$dir = cache::get('',false,'css');
		$files = dir::readall($dir);
		foreach($files as $v){
			if(preg_match("/^global\./",$v)){
				dir::delete($dir.$v);
			}
		}
		$dir = cache::get('',false,'js');
		$files = dir::readall($dir);
		foreach($files as $v){
			if(preg_match("/^global\./",$v)){
				dir::delete($dir.$v);
			}
		}
		if($alt){
			alert('操作成功');
		}
	}
}
?>