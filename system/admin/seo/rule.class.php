<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class rule extends admin
{
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover();
		$G['navs1'] = into::load_class('admin','seo','rewrite','new')->nav();
		$G['navs1']['rule']['active'] = true;
		
		$data = array();
		if(arrExist($G['config'],'rule')){
			$data = json::decode($G['config']['rule']);
		}
		into::basic_json('rule');
		foreach($G['rule'] as $k=>$v){
			if(!arrExist($data,$k)){
				$data[$k] = $v;
			}
		}
		echo $this->theme('seo/rule', $data);
	}
	
	public function add()
	{
		global $G;
		$this->cover('seo&rule','M');
		if(isset($G['post'])){
			$data = array(
				'rule_extension' => $G['post']['rule_extension'],
				'rule_pages' => $G['post']['rule_pages'],
				'rule_lang' => $G['post']['rule_lang'],
				'rule_lang_sign' => $G['post']['rule_lang_sign'],
				'rule_filename' => $G['post']['rule_filename']
			);
			foreach($data as $k=>$v){
				mysql::select_set(array('name'=>$k,'value'=>$v,'parent'=>'0','type'=>'0','lang'=>'0'),'config',array('value'));
			}

			$data = array();
			foreach($G['post']['rule'] as $k=>$v){
				if(is_numeric($k)){
					$data[$k] = $v;
				}
			}
			mysql::select_set(array('name'=>'rule','value'=>json::encode($data),'parent'=>'0','type'=>'0','lang'=>'0'),'config',array('value'));
			dir::delete(ROOT_PATH.'cache/rule.json');
			$this->sitemap();
			alert('操作成功', url::mpf('seo','rule','init'));
		}
	}
}
?>