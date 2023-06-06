<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('curl');
into::basic_class('cache');

class user
{
	public static $url='https://api.bosscms.net/rest/user/';
	
	public static function curl($file, $get=null, $post=null, $timeout=30)
	{
		global $G;
		$url = self::$url.$file;
		if($get){
			foreach($G['get'] as $k=>$v){
				if(preg_match('/^('.$get.')$/',$k)){
					$url = url::param($url,$k,$v);
				}
			}
		}
		$arr = array(
			'system_version' => $G['config']['version']
		);
		if(preg_match('/^\d{18}$/',$G['config']['user_sequence'])){
			$arr['user_sequence'] = $G['config']['user_sequence'];
		}
		if($post){
			foreach($G['post'] as $k=>$v){
				if(preg_match('/^('.$post.')$/',$k)){
					$arr[$k] = $v;
				}
			}
		}
		if($G['config']['admin_remote_market']){
			if($timeout && $res=cache::auto(md5($G['path']['host'].$url.json::decode($arr)),'user',$timeout)){
				return $res;
			}else if(self::test() == 200){
				$res = curl::request($url, $arr);
				if($timeout){
					cache::set(md5($G['path']['host'].$url.json::decode($arr)),$res,'user');
				}
				return $res;
			}
		}
	}
	
	public static function test()
	{
		global $G;
		$url = self::$url.'test.php';
		$res = cache::auto(md5($url), 'user', 3600);
		if($G['config']['admin_remote_market']){
			if(is_numeric($res)){
				return $res;
			}else{
				$res = curl::code($url, 3);
				cache::set(md5($url), $res, 'user');
				return $res;
			}
		}
	}
	
	public static function inst($type, $name)
	{
		global $G;
		$data = array();
		if(preg_match('/^\w+$/',$type.$name)){
			$G['post']['type'] = $type;
			$G['post']['name'] = $name;
			if($res = self::curl('inst.php',null,'type|name',0)){
				$data = json::decode($res);
			}
		}
		return $data;
	}
	
	public static function bind($type, $orders, $name)
	{
		global $G;
		$data = array();
		if(preg_match('/^\d{18}$/',$G['config']['user_sequence']) && preg_match('/^\w+$/',$orders.$type.$name)){
			$G['post']['orders'] = $orders;
			$G['post']['type'] = $type;
			$G['post']['name'] = $name;
			if($res = self::curl('bind.php',null,'orders|type|name',0)){
				$data = json::decode($res);
			}
		}
		return $data;
	}
	
	public static function install($type, $name, $update=null)
	{
		global $G;
		if(preg_match('/^\w+$/',$name.$type)){
			$G['get']['type'] = $type;
			$G['get']['name'] = $name;
			$G['get']['update'] = preg_match('/^[V\d\.]+$/i',$update)?$update:null;
			if($res = self::curl('install.php','type|name|update',null,800)){
				$data = json::decode($res);
				if($data['state']=='success'){
					if(curl::code($data['msg']) == 200){
						$file = cache::get($name.'.zip',false,'zip/'.$type);
						curl::files($data['msg'], $file);
						if(filesize($file)){
							return $file;
						}else{
							dir::delete($file);
						}
					}
				}else if($data['msg']){
					alert($res['msg']);
				}
			}
		}
		alert('下载失败');
	}
	
	public static function pay($orders)
	{
		global $G;
		if(preg_match('/^\d{18}$/',$G['config']['user_sequence'])){
			$G['get']['orders'] = $orders;
			return self::curl('pay.php','orders',null,0);
		}
		return ;
	}
	
	public static function buy($type, $id)
	{
		global $G;
		$data = array();
		if(preg_match('/^\d{18}$/',$G['config']['user_sequence'])){
			$G['post']['type'] = $type;
			$G['post']['id'] = $id;
			if($res = self::curl('buy.php',null,'type|id|pi|price|protocol|pay|password',0)){
				$data = json::decode($res);
			}
		}
		return $data;
	}
	
	/* 产品详情页 */
	public static function info($type, $id)
	{
		global $G;
		$data = array();
		if(preg_match('/^\d{18}$/',$G['config']['user_sequence']) && is_numeric($id)){
			$G['post']['type'] = $type;
			$G['post']['id'] = $id;
			if($res = self::curl('info.php',null,'type|id',0)){
				$data = json::decode($res);
			}
		}
		return $data;
	}
	
	/* 添加、取消收藏 */
	public static function collect($type, $id)
	{
		global $G;
		$data = array();
		if(preg_match('/^\d{18}$/',$G['config']['user_sequence']) && is_numeric($id)){
			$G['post']['type'] = $type;
			$G['post']['id'] = $id;
			if($res = self::curl('collect.php',null,'type|id',0)){
				$data = json::decode($res);
			}
		}
		return $data;
	}
	
	/* 获取商城分类 */
	public static function field()
	{
		if($res = self::curl('field.php',null,null,8640000)){
			return json::decode($res);
		}
	}
	
	/* 获取登录者信息 */
	public static function identity()
	{
		global $G;
		$data = array();
		if(preg_match('/^\d{18}$/',$G['config']['user_sequence'])){
			if($res = self::curl('identity.php',null,null,60)){
				$data = json::decode($res);
			}
		}
		return $data;
	}
}
?>