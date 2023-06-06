<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class feedback extends admin
{
    public function nav()
    {
        global $G;
		return $this->permit(
			array(
				'feedback' => array(
					'name' => '反馈列表',
					'mold' => 'feedback',
					'param' => array('items'=>$G['get']['items']),
					'check' => 'RMD'
				),
				'control' => array(
					'name' => '控件配置',
					'mold' => 'feedback',
					'part' => 'control',
					'param' => array('items'=>$G['get']['items']),
					'check' => 'RAMD'
				),
				'config' => array(
					'name' => '表单设置',
					'mold' => 'feedback',
					'part' => 'config',
					'param' => array('items'=>$G['get']['items']),
					'check' => 'RM'
				)
			)
		);
    }
	
    public function nav0()
    {
		global $G;
		$feedback = array();
		$option = page::items_option(0,false,array(),false,6);
		$fd = null;
		foreach($option as $k=>$v){
			$feedback[$k] = array(
				'name' => $v,
				'mold' => 'feedback',
				'part' => $G['get']['part'],
				'param' => array('items'=>$k)
			);
			$fd = isset($fd)?$fd:$k;
		}
		return $feedback?$feedback:null;
	}
	
	public function items()
	{
		global $G;
		$items = $G['get']['items'];
		$G['navs0'] = self::nav0();
		if(is_numeric($items) && $G['navs0'][$items]){
			if(count($G['navs0'])>1){
				$G['navs0'][$items]['active'] = true;
			}else{
				$G['navs0'] = null;
			}
			return $items;
		}else if($G['navs0']){
			foreach($G['navs0'] as $k=>$v){
				location(url::mpf($v['mold'],$v['part'],'init',$v['param']));
			}
		}
		alert('没有反馈栏目，请先配置栏目',url::mpf('items','items','init'));
	}
	
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover();
		$G['navs1'] = self::nav();
		$G['navs1']['feedback']['active'] = true;
		$items = self::items();
		$data = page::feedback($items,50);
		$data['config'] = page::config_option($items);
		$data['form'] = page::form($items);
		echo $this->theme('feedback/feedback', $data);
	}
	
	public function modify()
	{
		global $G;
		$this->cover('feedback','M');
		if(isset($G['post']['id'])){
			$error=array();
			foreach($G['post']['id'] as $id){
				if(isset($G['post']['reading'.$id])){
					$data = array(
						'reading'=>$G['post']['reading'.$id]
					);
					if(!is_numeric(mysql::update($data,"feedback","id='{$id}'"))){
						$error[]=$id;
					}
				}
			}
			if($error){
				alert('ID为'.implode(',',$error).'修改失败');
			}else{
				alert('修改成功', url::mpf('feedback','feedback','init'));
			}
		}else{
			alert('没有提交信息');
		}
	}
	
	public function edit()
	{
		global $G;
		$G['cover'] = $this->cover('feedback');
		$data = array();
		if(isset($G['get']['id'])){
			/* 直接已读 BOSSCMS */
			mysql::update(array('reading'=>1),'feedback',"id='{$G['get']['id']}'");
			
			$data['form'] = page::form($G['get']['items']);
			$data['feedback'] = mysql::select_one('*','feedback',"id='{$G['get']['id']}'");
			$data['param'] = json::decode($data['feedback']['param']);
			echo $this->theme('feedback/edit', $data);
		}else{
			alert('没有指定反馈id');
		}
	}
	
	public function add()
	{
		global $G;
		$this->cover('feedback','M');
		if(isset($G['post'])){
			$data = array(
				'reply' => $G['post']['reply'],
				'manager' => $G['manager']['id'],
				'mtime' => TIME,
				'display' => $G['post']['display']
			);
			if(mysql::update($data,'feedback',"id='{$G['get']['id']}'")){
				alert('保存成功',url::mpf('feedback','feedback','edit',array('success'=>'ok')));
			}else{
				alert('保存失败');
			}
		}
	}
	 
	public function delete()
	{
		global $G;
		$this->cover('feedback','D');
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
					if(is_numeric(mysql::delete("feedback","id='{$id}'"))){
						
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
	
	public function reading()
	{
		$G['cover'] = $this->cover('feedback');
		$items = page::items(0);
		$feedback = array();
		foreach($items as $v){
			if($v['type']==6){
				$feedback[] = $v['id'];
			}
		}
		echo mysql::total('feedback',"reading='0' AND FIND_IN_SET(parent,'".implode(',',$feedback)."')");
	}
}
?>