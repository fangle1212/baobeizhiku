<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class menu extends admin
{
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover();
		$data = page::menu();
		echo $this->theme('menu/menu', $data);
	}
	
	public function modify()
	{
		global $G;
		$this->cover('menu','M');
		if(isset($G['post']['id'])){
			/* BOSS=CMS */
			$error=array();
			foreach($G['post']['id'] as $id){
				if(isset($G['post']['sort'.$id])){
					$data = array(
						'target'=>$G['post']['target'.$id],
						'display'=>$G['post']['display'.$id],
						'sort'=>$G['post']['sort'.$id]
					);
					if(!is_numeric(mysql::update($data,"menu","id='{$id}'"))){
						$error[]=$id;
					}
				}
			}
			if($error){
				alert('ID为'.implode(',',$error).'修改失败');
			}else{
				alert('修改成功', url::mpf('menu','menu','init'));
			}
		}else{
			alert('没有提交信息');
		}
	}
	
	
	public function edit()
	{
		global $G;
		$G['cover'] = $this->cover('menu');
		$data = array();
		if(isset($G['get']['id'])){
			$data = mysql::select_one('*','menu',"id='{$G['get']['id']}'");
			$data["value{$data['type']}"] = $data["value"];		
	
			$result = mysql::select_all('core,name,value','theme',"extent='8' AND parent='{$G['get']['id']}'");
			foreach($result as $v){
				$data[$v['core']][$v['name']] = $v["value"];
			}
		}
		
		$data['ctrl'] = array();
		$data['subarr'] = page::items_option(0,false,array(),true);
		echo $this->theme('menu/edit', $data);
	}
	
	public function add()
	{	
		global $G;
		$this->cover('menu',$G['get']['id']?'M':'A');
		if(isset($G['post']['type'])){
			$data = array(
				'name'        => $G['post']['name'],
				'type'        => $G['post']['type'],
				'value'       => $G['post']["value{$G['post']['type']}"],
				'icon'        => $G['post']['icon'],
				'color'       => $G['post']['color'],
				'bgcolor'     => $G['post']['bgcolor'],
				'target'      => $G['post']['target'],
				'display'     => $G['post']['display'],
				'sort'        => $G['post']['sort']
			);
			if($id = $G['get']['id']){
				if($result = mysql::select_one('id','menu',"id='{$id}'")){
					mysql::update($data,"menu","id='{$id}'");
				}else{
					alert('没有内容');
				}
			}else{
				$id = mysql::insert($data,"menu");
			}
			into::load_class('admin','clear','clear','new')->globals(false);
			alert('操作成功', url::mpf('menu','menu','edit',array('id'=>$id,'success'=>'ok')));
		}else{
			alert('没有提交信息');
		}
	}
	
	public function delete()
	{
		global $G;	
		$this->cover('menu','D');
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
					if(is_numeric(mysql::delete("menu","id='{$id}'"))){
						
					}else{
						$error[]=$id;
					}
				}
				if($error){
					alert('ID为'.implode(',',$error).'删除失败');
				}else{
					alert('删除成功');
				}
			}else{
				alert('没有删除对象id');
			}			
		}
		alert('没有提交信息');
	}
}
?>