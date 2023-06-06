<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class banner extends admin
{
	public function init()
	{
		global $G;
		$G['option']['type'][0] = $G['config']['home'];
		$data = page::banner();
		foreach($data as $k=>$v){
			$data[$k]['place'] = '';
			if($v['type']){
				$type = json::decode($v['type']);
				foreach($type as $t){
					$data[$k]['place'] .= ($data[$k]['place']?' - ':'').$G['option']['type'][$t];
				}
			}
			if($v['items']){
				$items = json::decode($v['items']);
				$option = page::items_option('0','',array(),true);
				foreach($items as $i){
					$data[$k]['place'] .= ($data[$k]['place']?' - ':'').$option[$i];
				}
			}
		}
		echo $this->theme('banner/banner', $data);
	}
	
	public function modify()
	{
		global $G;
		if(isset($G['post']['id'])){
			$error=array();
			foreach($G['post']['id'] as $id){
				if(isset($G['post']['sort'.$id])){
					$data = array(
						'target'=>$G['post']['target'.$id],
						'display'=>$G['post']['display'.$id],
						'sort'=>$G['post']['sort'.$id]
					);
					if(!is_numeric(mysql::update($data,"banner","id='{$id}'"))){
						$error[]=$id;
					}
				}
			}
			if($error){
				alert('ID为'.implode(',',$error).'修改失败');
			}else{
				alert('修改成功！', url::mpf('banner','banner','init'));
			}
		}else{
			alert('没有提交信息！');
		}
	}
	
	public function edit()
	{
		global $G;
		$data = array();
		if(isset($G['get']['id'])){
			$data = mysql::select_one('*','banner',"id='{$G['get']['id']}'");
		}
		$data['subarr'] = page::items_option(0,false,array(),false);
		$G['type'][0] = $G['config']['home'];
		foreach($G['option']['type'] as $k=>$v){
			if($k != 9){
				$G['type'][$k] = $v;
			}
		}
		echo $this->theme('banner/edit', $data);
	}
	
	public function add()
	{	
		global $G;
		$bosscms = true;
		if(isset($G['post'])){
			$data = array(
				'name'        => $G['post']['name'],
				'image'       => $G['post']['image'],
				'screen'      => $G['post']['screen'],
				'site'        => $G['post']['site'],
				'type'        => $G['post']['type'],
				'items'       => $G['post']['items'],
				'link'        => $G['post']['link'],
				'target'      => $G['post']['target'],
				'sort'        => $G['post']['sort'],
				'display'     => $G['post']['display'],
				'content'     => $G['post']['content']
			);
			if(isset($G['get']['id'])){
				$id = $G['get']['id'];
				if($result = mysql::select_one('id','banner',"id='{$id}'")){
					mysql::update($data,"banner","id='{$id}'");
				}
			}else{
				$id = mysql::insert($data,"banner");
			}
			alert('操作成功', url::mpf('banner','banner','edit',array('id'=>$id,'success'=>'ok')));
		}else{
			alert('没有提交信息！');
		}
	}
	
	
	
	/* b o s s c m s */
	public function delete()
	{
		global $G;	
		if(isset($G['post']['url']) && isset($G['get']['id'])){
			$del = array();
			$arr = explode(',',$G['get']['id']);
			foreach($arr as $id){
				if(is_numeric($id)){
					$del[$id] = $id;
				}
			}
			if($del){
				$error=array();
				foreach($del as $id=>$name){
					if(is_numeric(mysql::delete("banner","id='{$id}'"))){
						
					}else{
						$error[]=$id;
					}
				}
				if($error){
					alert('ID为'.implode(',',$error).'删除失败');
				}else{
					alert('删除成功',url::mpf('banner','banner','init',array('id'=>null)));
				}
			}else{
				alert('没有删除对象id！');
			}			
		}
		alert('没有提交信息！');
	}
}
?>