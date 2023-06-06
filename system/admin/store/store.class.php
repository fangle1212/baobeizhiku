<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class store extends admin
{	
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover();
		$pf = $G['config']['store_platform'];
		$G['config']["store_id{$pf}"] = arrExist($G['config'],'store_id');
		$G['config']["store_key{$pf}"] = arrExist($G['config'],'store_key');
		$G['config']["store_bucket{$pf}"] = arrExist($G['config'],'store_bucket');
		$G['config']["store_region{$pf}"] = arrExist($G['config'],'store_region');
		$G['config']["store_domain{$pf}"] = arrExist($G['config'],'store_domain');
		echo $this->theme('store/store');
	}
	
	public function add()
	{
		global $G;
		$this->cover('store','M');
		if(isset($G['post'])){
			$pf = $G['post']['store_platform'];
			$data = array(
				'store_type'     => $G['post']['store_type'],
				'store_platform' => $pf,
				"store_id"       => $G['post']["store_id{$pf}"],
				"store_key"      => $G['post']["store_key{$pf}"],
				"store_bucket"   => $G['post']["store_bucket{$pf}"],
				"store_region"   => $G['post']["store_region{$pf}"],
				"store_domain"   => $G['post']["store_domain{$pf}"]
			);
			foreach($data as $k=>$v){
				mysql::select_set(array('name'=>$k,'value'=>$v,'parent'=>'0','type'=>'0'),'config',array('value'));
			}
			alert('操作成功', url::mpf('store','store','init'));
		}
	}
}
?>