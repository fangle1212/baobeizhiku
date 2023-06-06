<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class state extends admin
{	
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover();
		echo $this->theme('site/state');
	}
	
	public function add()
	{
		global $G;
		$this->cover('site&state','M');
		if(isset($G['post'])){
			$data = array(
				'state_open'       => $G['post']['state_open'],
				'state_title'      => $G['post']['state_title'],
				'state_content'    => $G['post']['state_content']
			);
			foreach($data as $k=>$v){
				mysql::select_set(array('name'=>$k,'value'=>$v,'parent'=>'0','type'=>'0'),'config',array('value'));
			}
			alert('操作成功', url::mpf('site','state','init'));
		}
	}
}
?>