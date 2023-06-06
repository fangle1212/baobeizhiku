<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class site extends admin
{
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover();
		echo $this->theme('site/site');
	}
	/* BOSS_CMS */
	public function add()
	{
		global $G;
		$this->cover('site','M');
		if(isset($G['post'])){
			$domain = $G['post']['domain'];
			$domain_mobile = $G['post']['domain_mobile'];
			if($domain && $domain_mobile){
				$dn = parse_url($domain);
				$mdn = parse_url($domain_mobile);
				if($dn['host']==$mdn['host'] || rootDomain($dn['host'])!=rootDomain($mdn['host'])){
					alert('手机域名必须为站点域名的二级域名');
				}
			}
			$data = array(
				'title'            => $G['post']['title'],
				'domain'           => $domain,
				'domain_mobile'    => $domain_mobile,
				'logo'             => $G['post']['logo'],
				'logo_mobile'      => $G['post']['logo_mobile'],
				'icon'             => $G['post']['icon'],
				'image'            => $G['post']['image'],
				'miit_beian'       => $G['post']['miit_beian'],
				'beian'            => $G['post']['beian'],
				'foot'             => $G['post']['foot']
			);
			foreach($data as $k=>$v){
				mysql::select_set(array('name'=>$k,'value'=>$v,'parent'=>'0','type'=>'0'),'config',array('value'));
			}
			into::basic_class('cache');
			dir::remove(cache::get('',false,'authorize'), false);
			$this->sitemap();
			alert('操作成功', url::mpf('site','site','init'));
		}
	}
}
?>