<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class search extends admin
{
    public function nav()
    {
        global $G;
		return $this->permit(
			array(
				'search' => array(
					'name' => '搜索列表',
					'mold' => 'search',
					'param' => array('items'=>$G['get']['items']),
					'check' => 'RD'
				),
				'config' => array(
					'name' => '表单设置',
					'mold' => 'search',
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
		$search = array();
		$option = page::items_option(0,false,array(),false,7);
		$fd = null;
		foreach($option as $k=>$v){
			$search[$k] = array(
				'name' => $v,
				'mold' => 'search',
				'part' => $G['get']['part'],
				'param' => array('items'=>$k)
			);
			$fd = isset($fd)?$fd:$k;
		}
		return $search?$search:null;
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
		alert('没有搜索栏目，请先配置栏目',url::mpf('items','items','init'));
	}
	
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover();
		$G['navs1'] = self::nav();
		$G['navs1']['search']['active'] = true;
		$items = self::items();
		$data = page::search($items,50);
		echo $this->theme('search/search', $data);
	}
	 
	public function delete()
	{
		global $G;
		$this->cover('search','D');
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
					if(is_numeric(mysql::delete("search","id='{$id}'"))){
						
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