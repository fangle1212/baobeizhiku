<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class control extends admin
{
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover();
		$G['navs1'] = into::load_class('admin','feedback','feedback','new')->nav();
		$G['navs1']['control']['active'] = true;
		$data = array();
		$items = into::load_class('admin','feedback','feedback','new')->items();
		$data['list'] = page::form($items);
		echo $this->theme('feedback/control', $data);
	}
	
	public function modify()
	{
		global $G;
		if(is_array($G['post']['id'])){
			foreach($G['post']['id'] as $k=>$v){
				if(mysql::total('form',"id='{$v}'")){
					$this->cover('feedback&control','M');
				}else{
					$this->cover('feedback&control','A');
				}
			}
		}
		$items = arrExist($G['get'],'items');
		if(isset($G['post']['id']) && is_array($G['post']['id']) && is_numeric($items)){
			foreach($G['post']['id'] as $k=>$v){
				$data = array(
					'id' => $v,
					'parent' => $items,
					'style' => $G['post']['style'.$v],
					'title' => $G['post']['title'.$v],
					'description' => $G['post']['description'.$v],
					'prompt' => $G['post']['prompt'.$v],
					'must' => arrExist($G,'post|must'.$v.'|0') *1,
					'sort' => $G['post']['sort'.$v],
					'param' => $G['post']['param'.$v]
				);
				mysql::select_set($data, 'form', array('parent','style','title','description','prompt','must','sort','param'));
			}
			alert('保存成功',url::mpf('feedback','control','init'));
		}else{
			alert('没有提交信息');
		}
	}
	
	 
	public function delete()
	{
		global $G;
		$this->cover('feedback&control','D');	
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
				foreach($del as $id){
					if(is_numeric(mysql::delete("form","id='{$id}'"))){
						
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