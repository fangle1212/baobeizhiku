<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class violation extends admin
{	
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover();
		echo $this->theme('seo/violation');
	}
	
	public function add()
	{
		global $G;
		$this->face();
		$this->cover('seo&violation','M');
		if(isset($G['post'])){
			$data = array(
				'violation_open'       => $G['post']['violation_open'],
				'violation_replace'    => $G['post']['violation_replace'],
				'violation_table'      => $G['post']['violation_table']
			);
			foreach($data as $k=>$v){
				mysql::select_set(array('name'=>$k,'value'=>$v,'parent'=>'0','type'=>0),'config',array('value'));
			}
			alert('操作成功', url::mpf('seo','violation','init'));
		}
	}
}
?>