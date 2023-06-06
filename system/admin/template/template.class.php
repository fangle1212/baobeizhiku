<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');
into::basic_class('user');

class template extends admin
{
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover('template&market');
		$G['identity'] = user::identity();
		$G['field'] = user::field();
		into::basic_class('pages');
		$pages = $G['get']['pages'];
		$pages = is_numeric($pages)?$pages:1;
		$rows = 20;
		$start = ($pages-1) * $rows;
		$end = $start + $rows;
		$data = array('total'=>0,'list'=>array(),'pages'=>array());
		$list = $this->local();
		foreach($list as $k=>$v){
			if($k>=$start && $k<$end){
				$json = into::load_json(ROOT_PATH.'system/web/theme/'.$v.'/config.json');
				$data['list'][$v]['path'] = $G['path']['relative'].'system/web/theme/'.$v.'/';
				$data['list'][$v]['image'] = $data['list'][$v]['path'].'image.png';
				$data['list'][$v]['name'] = $json['serial'];
				$data['list'][$v]['title'] = $json['title'];
				$data['list'][$v]['version'] = $json['version'];
			}
		}
		$data['total'] = count($list);
		$data['pages'] = pages::btns(ceil($data['total']/$rows), $pages);
		$G['get']['names'] = implode(',',$list);
		$G['get']['type'] = 'templates';
		if($res = user::curl('update.php','names|type',null,86400)){
			$G['update'] = json::decode($res);
		}
		unset($G['get']['type']);
		echo $this->theme('template/template', $data);
	}
	
	public function local()
	{
		global $G;
		$template = array();
		$list = dir::read(ROOT_PATH.'system/web/theme/');
		foreach($list['dir'] as $v){
			if(is_file(ROOT_PATH.'system/web/theme/'.$v.'/config.json')){
				$template[] = $v;
			}
		}
		return $template;
	}
	
	public function modify()
	{
		global $G;
		$this->cover('template&market','M');
		if(preg_match('/^\w+$/',$G['get']['name'])){
			mysql::update(array('value'=>$G['get']['name']),'config',"name='web_theme'");
			alert('启用成功！',url::mpf('template','template','init',array('name'=>null)));
		}
		alert('启用失败！');
	}
	
	public function delete()
	{
		global $G;
		$this->cover('template&market','D');
		if(isset($G['post']['url']) && isset($G['get']['name'])){
			if($G['get']['name'] && preg_match("/^\w+$/",$G['get']['name'])){
				if(!mysql::total('config',"name='web_theme' AND value='{$G['get']['name']}' AND type='0' AND parent='0' AND lang=lang")){
					cache::remove('','user');
					dir::remove(ROOT_PATH.'system/web/theme/'.$G['get']['name'].'/');
					alert('删除成功',url::mpf('template','template','init'));
				}else{
					alert('模板使用中，不能删除');
				}
			}
		}
		alert('删除失败');
	}
}
?>