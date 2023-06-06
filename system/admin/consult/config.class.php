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
		$G['navs1'] = into::load_class('admin','consult','consult','new')->nav();
		$G['navs1']['config']['active'] = true;
		
		$data['theme'] = array();
		$res = dir::read(load::common().'consult/');
		foreach($res['dir'] as $k=>$v){
			$data['theme'][$v] = '风格'.($k+1);
		}
		
		echo $this->theme('consult/config', $data);
	}
	
	public function add()
	{
		global $G;
		$this->face();
		$this->cover('consult&config','M');
		/* b o s s c m s */
		if(isset($G['post'])){
			$data = array(
				'consult_theme'   => $G['post']['consult_theme'],
				'consult_open'    => $G['post']['consult_open'],
				'consult_side'    => $G['post']['consult_side'],
				'consult_top'     => $G['post']['consult_top'],
				'consult_right'   => $G['post']['consult_right'],
				'consult_color'   => $G['post']['consult_color'],
				'consult_bgcolor' => $G['post']['consult_bgcolor'],
				'consult_hrcolor' => $G['post']['consult_hrcolor'],
				'consult_content' => $G['post']['consult_content'],
				'consult_title'   => $G['post']['consult_title'],
				'consult_backtop' => $G['post']['consult_backtop']
			);
			foreach($data as $k=>$v){
				mysql::select_set(array('name'=>$k,'value'=>$v,'parent'=>'0','type'=>'0'),'config',array('value'));
			}
			into::load_class('admin','clear','clear','new')->globals(false);
			alert('操作成功', url::mpf('consult','config','init'));
		}
	}
}
?>