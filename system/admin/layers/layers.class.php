<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class layers extends admin
{
	public function init()
	{
		global $G;
		$data = array();
		$core = arrExist($G['get'],'core');
		$parent = arrExist($G['get'],'parent');
		$parent = $parent?$parent:0;
		$series = arrExist($G['get'],'series');
		$series = $series?$series:'';
		$data = page::layers_series($core, $series, $parent);
		echo $this->theme('layers/layers', $data);
	}
	
	public function modify()
	{
		global $G;
		if(isset($G['post']['id'])){
			$error=array();
			foreach($G['post']['id'] as $id){
				if(isset($G['post']['sort'.$id])){
					$data = array(
						'display'=>$G['post']['display'.$id],
						'sort'=>$G['post']['sort'.$id]
					);
					if(!is_numeric(mysql::update($data,"layers","id='{$id}'"))){
						$error[]=$id;
					}
				}
			}
			if($error){
				alert('ID为'.implode(',',$error).'修改失败');
			}else{
				alert('修改成功！', url::mpf('layers','layers','init'));
			}
		}else{
			alert('没有提交信息！');
		}
	}
	
	public function edit(){
		global $G;
		$data = array();
		if(isset($G['get']['id'])){
			$id = $G['get']['id'];
			$data = mysql::select_one('*','layers',"id='{$id}'");
			if($data){
				/* 获取主题后台设置项的值 */
				$result = mysql::select_all('core,name,value','theme',"extent='88' AND parent='{$id}'");
				foreach($result as $v){
					$data[$v['core']][$v['name']] = $v["value"];
				}
			}
		}
		$data['ctrl'] = array();
		$r = theme::core_series($G['get']['core'], 88, $G['get']['series']);
		foreach($r as $k=>$v){
			$data['ctrl'][$k] = $v;
		}
		echo $this->theme('layers/edit', $data);
	}
	
	public function add()
	{	
		global $G;
		if(isset($G['post'])){
			$data = array(
				'id'          => arrExist($G['get'],'id'),
				'name'        => $G['post']['name'],
				'sort'        => $G['post']['sort'],
				'core'       => $G['get']['core'],
				'series'      => $G['get']['series'],
				'display'     => $G['post']['display']
			);
			if(!is_numeric(arrExist($G['get'],'id'))){
				$data['parent'] = arrExist($G['get'],'parent')?$G['get']['parent']:0;
			}
			$id = mysql::select_set($data,"layers",array('parent','name','sort','core','series','display'));
			$id = $data['id']?$data['id']:$id;
			value::set(arrExist($G,'post|tc'), $id, 88);
			alert('操作成功', url::mpf('layers','layers','edit',array('id'=>$id,'success'=>'ok')));
		}else{
			alert('没有提交信息！');
		}
	}
	
	public function delete()
	{
		global $G;	
		if(isset($G['post']['url']) && isset($G['get']['id'])){
			$del = array();
			$arr = explode(',',$G['get']['id']);
			foreach($arr as $id){
				if(is_numeric($id)){
					if($result = mysql::select_one('name','layers',"id='{$id}'")){
						$del[$id] = $result['name'];
					}
				}
			}
			if($del){
				$error=array();
				foreach($del as $id=>$name){
					if(is_numeric(mysql::delete("layers","id='{$id}'"))){
						
					}else{
						$error[]=$id;
					}
				}
				if($error){
					alert('ID为'.implode(',',$error).'删除失败');
				}else{
					alert('删除成功', url::mpf('layers','layers','init',array('id'=>null)));
				}
			}else{
				alert('没有删除对象id！');
			}			
		}
		alert('没有提交信息！');
	}
}
?>