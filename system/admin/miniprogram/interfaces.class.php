<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');
into::basic_class('curl');

class interfaces extends admin
{
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover();
		$G['navs1'] = into::load_class('admin','miniprogram','miniprogram','new')->nav();
		$G['navs1']['interfaces']['active'] = true;
		
		echo $this->theme('miniprogram/interfaces', $data);
	}
	
	public function edit()
	{
		global $G;
		$G['cover'] = $this->cover('miniprogram&interfaces');
		echo $this->theme('miniprogram/minpg');
	}
	
	public function add()
	{
		global $G;
		$this->face();
		$this->cover('miniprogram&interfaces','M');
		/* b o s s c m s */
		if(isset($G['post'])){
			switch($G['get']['type']){
				case 'weixin':
					$data = array(
						'minpg_wxapiid' => $G['post']['minpg_wxapiid'],
						'minpg_wxapisecret' => $G['post']['minpg_wxapisecret']
					);
					break;
			}
			foreach($data as $k=>$v){
				mysql::select_set(array('name'=>$k,'value'=>$v,'parent'=>'0','type'=>'0'),'config',array('value'));
			}
			alert('操作成功', url::mpf('miniprogram','interfaces','edit',array('success'=>'ok')));
		}
	}

	
	public function audit_edit()
	{
		global $G;
		$G['cover'] = $this->cover('miniprogram&interfaces');
		if($G['config']['miniprogram_open']){
			$data['state'] = 8;
			$arr = $this->expose();
			switch($G['get']['type']){
				case 'weixin':
					$arr['apiid'] = $G['config']['minpg_wxapiid'];
					$arr['apisecret'] = $G['config']['minpg_wxapisecret'];
					if($res = json::decode(curl::request('https://api.bosscms.net/rest/miniprogram/wxadinfo.php', $arr))){
						foreach($res['category_list'] as $v){
							$category_list[base64_encode(json::encode($v))] = $v['first_class'].'>>'.$v['second_class'].($v['third_class']?'>>'.$v['third_class']:'');
						}
					}
					break;
			}
			$data['ctrl'] = json::get(ROOT_PATH.'system/admin/miniprogram/common/audit.json');
			$data['ctrl'][0]['ctrl'][3]['param'] = $category_list;
			echo $this->theme('miniprogram/publish',$data);
		}else{
			alert('小程序为关闭状态', url::mpf('miniprogram','interfaces','edit',array('success'=>'ok')), 'red');
		}
	}
	
	public function publish()
	{
		global $G;
		$_SERVER['HTTP_REFERER'] = url::param($_SERVER['HTTP_REFERER'],'success','ok');
		$this->face();
		$this->cover('miniprogram&interfaces','M');
		if($G['config']['miniprogram_open']){
			if($ctrl = json::encode(into::load_class('extend','miniprogram','miniprogram','new')->ctrl())){
				url::$domain = $G['path']['relative'];
				$arr = $this->expose();
				$arr['json_ctrl'] = $ctrl;
				switch($G['get']['type']){
					case 'weixin':
						if(preg_match('/\w+/',$G['config']['minpg_wxapiid']) && preg_match('/\w+/',$G['config']['minpg_wxapisecret'])){
							$arr['apiid'] = $G['config']['minpg_wxapiid'];
							$arr['apisecret'] = $G['config']['minpg_wxapisecret'];
							if($res = json::decode(curl::request('https://api.bosscms.net/rest/miniprogram/wxpublish.php', $arr))){
								echo $this->theme('miniprogram/publish',$res);
							}
						}else{
							alert('接口配置错误');
						}
						break;
				}
			}else{
				alert('模板配置错误');
			}
		}else{
			alert('小程序为关闭状态');
		}
	}
	
	public function audit()
	{
		global $G;
		$this->face();
		$this->cover('miniprogram&interfaces','M');
		if($G['config']['miniprogram_open']){
			$post = $G['post'];
			foreach($post['item_list'] as $k=>$v){
				if($v['category']){
					$post['item_list'][$k] = array_merge($v,json::decode(base64_decode($v['category'])));
				}
				unset($post['item_list'][$k]['category']);
			}
			if(!$post['feedback_info']){
				unset($post['feedback_info']);
			}
			$arr = $this->expose();
			$arr['data'] = json::encode($post);
			switch($G['get']['type']){
				case 'weixin':
					$arr['apiid'] = $G['config']['minpg_wxapiid'];
					$arr['apisecret'] = $G['config']['minpg_wxapisecret'];
					if($res = json::decode(curl::request('https://api.bosscms.net/rest/miniprogram/wxaudit.php', $arr))){
						echo $this->theme('miniprogram/publish',$res);
					}
					break;
			}
		}else{
			alert('小程序为关闭状态', url::mpf('miniprogram','interfaces','edit',array('success'=>'ok')), 'red');
		}
	}
	
	public function process()
	{
		global $G;
		$this->face();
		$this->cover('miniprogram&interfaces','M');
		if($G['config']['miniprogram_open']){
			if($ctrl = json::encode(into::load_class('extend','miniprogram','miniprogram','new')->ctrl())){
				url::$domain = $G['path']['relative'];
				$data['state'] = 8;
				$arr = $this->expose();
				$arr['json_ctrl'] = $ctrl;
				switch($G['get']['type']){
					case 'weixin':
						$arr['apiid'] = $G['config']['minpg_wxapiid'];
						$arr['apisecret'] = $G['config']['minpg_wxapisecret'];
						if($res = json::decode(curl::request('https://api.bosscms.net/rest/miniprogram/wxprocess.php', $arr))){
							echo $this->theme('miniprogram/publish',$res);
						}
						break;
				}
			}
		}else{
			alert('小程序为关闭状态', url::mpf('miniprogram','interfaces','edit',array('success'=>'ok')), 'red');
		}
	}
	
	public function release()
	{
		global $G;
		$this->face();
		$this->cover('miniprogram&interfaces','M');
		if($G['config']['miniprogram_open']){
			$data['state'] = 8;
			$arr = $this->expose();
			switch($G['get']['type']){
				case 'weixin':
					$arr['apiid'] = $G['config']['minpg_wxapiid'];
					$arr['apisecret'] = $G['config']['minpg_wxapisecret'];
					if($res = json::decode(curl::request('https://api.bosscms.net/rest/miniprogram/wxrelease.php', $arr))){
						echo $this->theme('miniprogram/publish',$res);
					}
					break;
			}
		}else{
			alert('小程序为关闭状态', url::mpf('miniprogram','interfaces','edit',array('success'=>'ok')), 'red');
		}
	}

	public function expose()
	{
		global $G;
		return array(
			'domain' => $G['config']['domain'],
			'system_version' => $G['config']['version'],
			'user_token' => $G['config']['miniprogram_token'],
			'user_oem' => $G['authorize']['oem'],
			'user_sequence' => $G['config']['user_sequence']
		);
	}
}
?>