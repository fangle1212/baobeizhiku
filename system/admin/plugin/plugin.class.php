<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');
into::basic_class('user');

class plugin extends admin
{
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover('plugin&market');
		$list = $this->local();
		if(user::test()){
			$G['identity'] = user::identity();
			$G['field'] = user::field();
			$G['get']['names'] = implode(',',$list);
			if($res = user::curl('app.php','names')){
				$data = json::decode($res);
				foreach($data['list'] as $v){
					$app[$v['name']] = $v;
				}
			}
		}
		$plugin = page::plugin();
		$id = arrOption($plugin,'name','id');
		$display = arrOption($plugin,'name','display');
		$must = arrOption($plugin,'name','must');
		
		into::basic_class('pages');
		$pages = $G['get']['pages'];
		$pages = is_numeric($pages)?$pages:1;
		$rows = 20;
		$start = ($pages-1) * $rows;
		$end = $start+$rows;
		$data = array('total'=>0,'list'=>array(),'pages'=>array());
		foreach($list as $k=>$v){
			if($k>=$start && $k<$end){
				$json = into::load_json(ROOT_PATH.'system/plugin/'.$v.'/config.json');
				if($i = $id[$v]){
					$data['list'][$i]['id'] = $id[$v];
					$data['list'][$i]['display'] = $display[$v];
					$data['list'][$i]['must'] = $must[$v];
				}else{
					$i = $v;
				}
				$data['list'][$i]['path'] = $G['path']['relative'].'system/plugin/'.$v.'/';
				$data['list'][$i]['image'] = $data['list'][$i]['path'].'image.png';
				$data['list'][$i]['name'] = $v;
				$data['list'][$i]['version'] = $json['version'];
				$data['list'][$i]['title'] = $json['title'];
				$data['list'][$i]['description'] = $json['description'];
				$data['list'][$i]['author'] = $json['author'];
				if($data['list'][$i]['groups'] = $app[$v]['groups']){
					$data['list'][$i]['price'] = $app[$v]['price'];
					$data['list'][$i]['buy_duration'] = $app[$v]['buy_duration'];
					$data['list'][$i]['remark'] = $app[$v]['remark'];
				}
			}
		}
		krsort($data['list']);
		$data['total'] = count($list);
		$data['pages'] = pages::btns(ceil($data['total']/$rows), $pages);
		$G['get']['names'] = implode(',',$list);
		$G['get']['type'] = 'app';
		if($res = user::curl('update.php','names|type',null,86400)){
			$G['update'] = json::decode($res);
		}
		unset($G['get']['type']);
		echo $this->theme('plugin/plugin', $data);
	}
	
	public function local()
	{
		global $G;
		$app = array();
		$list = dir::read(ROOT_PATH.'system/plugin/');
		foreach($list['dir'] as $v){
			if(is_file(ROOT_PATH.'system/plugin/'.$v.'/config.json')){
				$app[] = $v;
			}
		}
		return $app;
	}
	
	public function modify()
	{
		global $G;
		$this->cover('plugin&market','M');
		$type = $G['get']['type'];
		if(preg_match('/^(display|must)$/',$type)){
			if(isset($G['post']) && mysql::update(array($type=>$G['post'][$type]),"plugin","id='{$G['post']['id']}'")){
				if($G['post'][$type]){
					alert(1);
				}else{
					alert(0);
				}
			}
		}
		alert('修改失败');
	}
	
	public function delete()
	{
		global $G;
		$this->cover('plugin&market','D');
		if(isset($G['post']['url']) && isset($G['get']['name'])){
			if($G['get']['name'] && preg_match("/^\w+$/",$G['get']['name'])){
				if(!mysql::total('plugin',"name='{$G['get']['name']}'")){
					cache::remove('','user');
					dir::remove(ROOT_PATH.'system/plugin/'.$G['get']['name'].'/');
					alert('删除成功',url::mpf('plugin','plugin','init'));
				}else{
					alert('插件使用中，不能删除');
				}
			}
		}
		alert('删除失败');
	}
}
?>