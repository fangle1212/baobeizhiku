<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class tag extends admin
{
	public function nav2()
	{
		global $G;
		$nav = array();
		foreach(array(2,3,4,5) as $v){
			$nav[$v] = array(
				'name' => $G['option']['type'][$v].'类型',
				'mold' => 'tag',
				'param' => array('type'=>$v)
			);
		}
		return $nav;
	}
	
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover();
		$G['navs0'] = self::nav2();
		
		$type = arrExist($G['get'],'type');
		if(!$type){
			$G['get']['type'] = $type = key($G['navs0']);
		}
		$G['navs0'][$type]['active'] = true;
		$data = page::tag_pages($type);		
		echo $this->theme('tag/tag', $data);
	}
	
	
	public function edit()
	{
		global $G;
		/* boss_CMS */
		$G['cover'] = $this->cover('tag');
		$data = array();
		foreach(array(2,3,4,5) as $v){
			$G['type'][$v] = $G['option']['type'][$v];
		}
		if(isset($G['get']['id'])){
			$data = mysql::select_one('*','tag',"id='{$G['get']['id']}'");
		}
		echo $this->theme('tag/edit', $data);
	}
	
	public function add()
	{	
		global $G;
		$this->cover('tag',$G['get']['id']?'M':'A');
		if($title = arrExist($G['post'],'title')){
			if($id = $G['get']['id']){
				$data = array(
					'type'        => $G['get']['type'],
					'name'        => $G['post']['name'],
					'title'       => $title,
					'seo_title'   => $G['post']['seo_title'],
					'keywords'    => $G['post']['keywords'],
					'description' => $G['post']['description']
				);
				if($result = mysql::select_one('id','tag',"id='{$id}'")){
					if(mysql::total("tag","title='{$data['title']}' AND type='{$G['get']['type']}' AND id!='{$id}'")){
						alert('该标签名称已经存在，请重新填写');
					}
					if(preg_match('/^\d+$/',$data['name'])){
						alert('路径名称不能为纯数字，请重新填写');
					}
					if($data['name'] && mysql::total("tag","name='{$data['name']}' AND type='{$G['get']['type']}' AND id!='{$id}'")){
						alert('该路径名称已经存在，请重新填写');
					}
					mysql::update($data,"tag","id='{$id}'");
				}
				alert('操作成功', url::mpf('tag','tag','edit',array('id'=>$id,'success'=>'ok')));
			}else{
				$has = array();
				$title = json::defilter($title);
				foreach($title as $v){
					if($v !== ''){
						$data = array(
							'type'        => $G['post']['type'],
							'name'        => '',
							'title'       => $v,
							'parent'      => '',
							'seo_title'   => '',
							'keywords'    => '',
							'description' => ''
						);
						if(mysql::total("tag","title='{$v}' AND type='{$G['get']['type']}'")){
							$has[] = $v;
						}else{
							$id = mysql::insert($data,"tag");
						}
					}
				}
				alert('操作成功'.($has?'标签名称为：“'.stripslashes(implode('”，“',$has)).'”已经存在，保存时自动过滤已有标签。':''), url::mpf('tag','tag','edit',array('id'=>$id,'success'=>'ok')));
			}
		}else{
			alert('没有提交信息');
		}
	}
	
	
	public function select()
	{
		global $G;
		$G['cover'] = $this->cover('tag');
		$type = arrExist($G['get'],'type');
		if(is_numeric($type)){
			$res = mysql::select_all('*','tag',"type='{$type}'");
			echo json::encode($res);
		}
	}
	
	 
	public function delete()
	{
		global $G;	
		$this->cover('tag','D');
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
					if(is_numeric(mysql::delete("tag","id='{$id}'"))){
						
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
				$_booscms;
				alert('没有删除对象id');
			}			
		}
		alert('没有提交信息');
	}
}
?>