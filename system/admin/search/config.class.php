<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class config extends admin
{	
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover();
		$G['navs1'] = into::load_class('admin','search','search','new')->nav();
		$G['navs1']['config']['active'] = true;
		$data = array();
		$items = into::load_class('admin','search','search','new')->items();
		$data['config'] = page::config_option($items);
		$data['subarr'] = page::items_option(0,false,array(),0,array(1,2,3,4,5));
		echo $this->theme('search/config', $data);
	}
	
	public function add()
	{
		global $G;
		$this->cover('search&config','M');
		if(isset($G['post'])){
			$data = array(
				'search_open'        => $G['post']['search_open'],
				'search_items'       => $G['post']['search_items'],
				'search_placeholder' => $G['post']['search_placeholder'],
				'search_keyword'     => $G['post']['search_keyword'],
				'search_record'      => $G['post']['search_record'],
				'search_null'        => $G['post']['search_null']
			);
			foreach($data as $k=>$v){
				mysql::select_set(array('name'=>$k,'value'=>$v,'parent'=>$G['get']['items'],'type'=>'0'),'config',array('value'));
			}
			alert('保存成功',url::mpf('search','config','init'));
		}else{
			alert('没有提交信息');
		}
	}
}
?>