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
		$G['navs1'] = into::load_class('admin','area','area','new')->nav();
		$G['navs1']['config']['active'] = true;
		
		$data['typearr'] = array_merge(array($G['config']['home']),$G['option']['type']);
		unset($data['typearr'][9]);
		$data['subarr'] = page::items_option(0,null,array(),1);
		echo $this->theme('area/config', $data);
	}
	
	public function add()
	{
		global $G;
		$this->face();
		$this->cover('area&config','M');
		/* b o s s c m s */
		if(isset($G['post'])){
			if($G['post']['area_link_type'] && !getDomain($G['config']['domain'])){
				alert('非正常域名，不能开启二级域名模式');
			}
			$data = array(
				'area_open'         => $G['post']['area_open'],
				'area_items'        => $G['post']['area_items'],
				'area_insert'       => $G['post']['area_insert'],
				'area_name_type'    => $G['post']['area_name_type'], 
				'area_link_type'    => $G['post']['area_link_type'], 
				'area_link_scheme'  => $G['post']['area_link_scheme'], 
				'area_foot_open'    => $G['post']['area_foot_open'], 
				'area_foot_insert'  => $G['post']['area_foot_insert'],
				'area_foot_type'    => $G['post']['area_foot_type'],
				'area_foot_show'    => $G['post']['area_foot_show'],
				'area_detail_open'  => $G['post']['area_detail_open'],
				'area_sitemap_open' => $G['post']['area_sitemap_open']
			);
			foreach($data as $k=>$v){
				mysql::select_set(array('name'=>$k,'value'=>$v,'parent'=>'0','type'=>'0'),'config',array('value'));
			}
			$data = array(
				'area_rule_home' => $G['post']['area_rule_home'],
				'area_rule_folder' => $G['post']['area_rule_folder']
			);
			foreach($data as $k=>$v){
				mysql::select_set(array('name'=>$k,'value'=>$v,'parent'=>'0','type'=>'0','lang'=>'0'),'config',array('value'));
			}
			into::load_class('admin','clear','clear','new')->globals(false);
			dir::delete(ROOT_PATH.'cache/rule.json');
			$this->sitemap();
			alert('操作成功', url::mpf('area','config','init'));
		}
	}
}
?>