<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class anchor extends admin
{
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover();
		$data = mysql::select_all('*','anchor');
		echo $this->theme('anchor/anchor', $data);
	}
	
	public function modify()
	{
		global $G;
		$this->cover('anchor','M');
		if(isset($G['post']['id'])){
			$error=array();
			foreach($G['post']['id'] as $id){
				if(isset($G['post']['open'.$id])){
					$data = array(
						'nofollow'=>$G['post']['nofollow'.$id],
						'target'=>$G['post']['target'.$id],
						'open'=>$G['post']['open'.$id]
					);
					if(!is_numeric(mysql::update($data,"anchor","id='{$id}'"))){
						$error[]=$id;
					}
				}
			}
			if($error){
				alert('ID为'.implode(',',$error).'修改失败');
			}else{
				alert('修改成功', url::mpf('anchor','anchor','init'));
			}
		}else{
			alert('没有提交信息');
		}
	}
	
	
	/* b o s s c m s */
	public function edit()
	{
		global $G;
		$G['cover'] = $this->cover('anchor');
		$data = array();
		if(isset($G['get']['id'])){
			$data = mysql::select_one('*','anchor',"id='{$G['get']['id']}'");
		}
		echo $this->theme('anchor/edit', $data);
	}
	
	public function add()
	{	
		global $G;
		$this->cover('anchor',$G['get']['id']?'M':'A');
		if(isset($G['post'])){
			$data = array(
				'old'       => $G['post']['old'],
				'new'       => $G['post']['new'],
				'title'     => $G['post']['title'],
				'link'      => $G['post']['link'],
				'nofollow'  => $G['post']['nofollow'],
				'target'    => $G['post']['target'],
				'open'      => $G['post']['open']
			);
			if($id = $G['get']['id']){
				if($result = mysql::select_one('id','anchor',"id='{$id}'")){
					mysql::update($data,"anchor","id='{$id}'");
				}else{
					alert('没有内容');
				}
			}else{
				$id = mysql::insert($data,"anchor");
			}
			alert('操作成功', url::mpf('anchor','anchor','edit',array('id'=>$id,'success'=>'ok')));
		}else{
			alert('没有提交信息');
		}
	}
	
	public function delete()
	{
		global $G;	
		$this->cover('anchor','D');
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
					if(is_numeric(mysql::delete("anchor","id='{$id}'"))){
						
					}else{
						$error[]=$id;
					}
				}
				if($error){
					alert('ID为'.implode(',',$error).'删除失败');
				}else{
					alert('删除成功',url::mpf('anchor','anchor','init',array('id'=>null)));
				}
			}else{
				alert('没有删除对象id');
			}			
		}
		alert('没有提交信息');
	}
}
?>