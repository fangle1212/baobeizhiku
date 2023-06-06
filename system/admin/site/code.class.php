<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class code extends admin
{	
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover();
		echo $this->theme('site/code');
	}
	/* BOSS-CMS */
	public function add()
	{
		global $G;
		$this->cover('site&code','M');
		if(isset($G['post'])){
			$data = array(
				'head_code'         => $G['post']['head_code'],
				'foot_code'         => $G['post']['foot_code'],
				'head_mobile_code'  => $G['post']['head_mobile_code'],
				'foot_mobile_code'  => $G['post']['foot_mobile_code']
			);
			foreach($data as $k=>$v){
				mysql::select_set(array('name'=>$k,'value'=>$v,'parent'=>'0','type'=>'0'),'config',array('value'));
			}
			alert('操作成功', url::mpf('site','code','init'));
		}
	}
}
?>