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
		$G['navs1'] = into::load_class('admin','miniprogram','miniprogram','new')->nav();
		$G['navs1']['config']['active'] = true;
		
		echo $this->theme('miniprogram/config', $data);
	}
	
	public function add()
	{
		global $G;
		$this->face();
		$this->cover('miniprogram&config','M');
		/* b o s s c m s */
		if(isset($G['post'])){
			$data = array(
				'miniprogram_open' => $G['post']['miniprogram_open'],
				'miniprogram_token' => $G['post']['miniprogram_token']
			);
			foreach($data as $k=>$v){
				mysql::select_set(array('name'=>$k,'value'=>$v,'parent'=>'0','type'=>'0'),'config',array('value'));
			}
			alert('操作成功', url::mpf('miniprogram','config','init'));
		}
	}
}
?>