<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class language extends admin
{
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover();
		$data = page::language();
		echo $this->theme('language/language', $data);
	}
	
	public function edit()
	{
		global $G;
		$G['cover'] = $this->cover('language');
		$data = array();
		if(isset($G['get']['id'])){
			$data = mysql::select_one('*','language',"id='{$G['get']['id']}'");
		}
		echo $this->theme('language/edit', $data);
	}
	
	public function add()
	{
		global $G;
		$this->cover('language',$G['get']['id']?'M':'A');
		if(isset($G['post'])){
			$data = array(
				'name'        => $G['post']['name'],
				'image'       => $G['post']['image'],
				'sign'        => $G['post']['sign'],
				'description' => $G['post']['description'],
				'defaults'    => $G['post']['defaults'],
				'display'     => $G['post']['display'],
				'target'      => $G['post']['target']
			);
			if($G['post']['defaults']){
				mysql::update(array('defaults'=>0),"language");
			}else{
				unset($data['defaults']);
			}
			if($id = $G['get']['id']){
				if($id==$G['language']['id'] && $data['display']==0){
					$data['display'] = 1;
				}
				if($result = mysql::select_one('id','language',"id='{$id}'")){
					mysql::update($data,"language","id='{$id}'");
				}
			}else{
				$id = mysql::insert($data,"language");
				if($id){
					/* 添加必要config数据库参数 */
					into::basic_json('must');
					foreach($G['must'] as $val){
						$val['lang'] = $id;
						if($val['name']=='domain'){
							$val['value'] = $G['config']['domain'];
						}
						mysql::select_set($val,'config',array('value'));
					}
				}else{
					alert('添加失败');
				}
			}
			$this->sitemap();
			alert('操作成功', url::mpf('language','language','edit',array('id'=>$id,'success'=>'ok')));
		}else{
			alert('没有提交信息');
		}		
	}
	
	public function modify()
	{
		global $G;
		$this->cover('language','M');
		if(isset($G['post']['id'])){
			$error=array();
			foreach($G['post']['id'] as $id){
				if(isset($G['post']['sort'.$id])){
					$data = array(
						'target' => $G['post']['target'.$id],
						'display' => $G['post']['display'.$id],
						'sort' => $G['post']['sort'.$id]
					);
					if($id==$G['language']['id'] && $data['display']==0){
						$data['display'] = 1;
					}
					if(!is_numeric(mysql::update($data,"language","id='{$id}'"))){
						$error[]=$id;
					}
				}
			}
			if($error){
				alert('ID为'.implode(',',$error).'修改失败');
			}else{
				$this->sitemap();
				alert('修改成功', url::mpf('language','language','init'));
			}
		}else{
			alert('没有提交信息');
		}
	}
	
	public function defaults()
	{
		global $G;
		$this->cover('language','M');
		if(isset($G['post']['id'])){
			if(isset($G['post']['default'])){
				mysql::update(array('defaults'=>0),'language');
				mysql::update(array('defaults'=>1),'language',"id='{$G['post']['id']}'");
				$this->sitemap();
			}
			alert('操作成功',url::mpf('language','language','init'));
		}
		alert('操作失败');
	}
	
	public function delete()
	{
		global $G;	
		$this->cover('language','D');
		if(isset($G['post']['url']) && isset($G['get']['id'])){
			$del = array();
			$arr = explode(',',$G['get']['id']);
			foreach($arr as $id){
				if(is_numeric($id)){
					if($id == $G['language']['id']){
						alert('不能删除包含当前正在操作的语言');
					}
					if($result = mysql::select_one('name','language',"id='{$id}'")){
						$del[$id] = $result['name'];
					}
				}
			}
			if($del){
				into::basic_json('database',true);
				$error=array();
				foreach($del as $id=>$name){
					if(mysql::delete("language","id='{$id}'")){
						foreach($G['database'] as $table=>$arr){
							if(isset($arr['lang'])){
								mysql::delete($table," lang='{$id}'");
							}
						}
					}else{
						$error[]=$id;
					}
				}
				if($error){
					alert('ID为'.implode(',',$error).'删除失败');
				}else{
					$this->sitemap();
					alert('删除成功', url::mpf('language','language','init',array('id'=>null)));
				}
			}else{
				alert('没有删除对象id');
			}			
		}
		alert('没有提交信息');
	}
}
?>