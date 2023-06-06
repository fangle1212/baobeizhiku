<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class captcha extends admin
{
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover();
		echo $this->theme('site/captcha');
	}
	/* BOSS_CMS */
	public function add()
	{
		global $G;
		$this->cover('site&captcha','M');
		if(isset($G['post'])){
			$data = array(
				'captcha_id'      => $G['post']['captcha_id'],
				'captcha_key'     => $G['post']['captcha_key'],
				'captcha_appid'  => $G['post']['captcha_appid'],
				'captcha_appkey' => $G['post']['captcha_appkey'],
				'admin_captcha_type' => 0
			);
			foreach($data as $k=>$v){
				mysql::select_set(array('name'=>$k,'value'=>$v,'parent'=>'0','type'=>'0','lang'=>0),'config',array('value'));
			}
			alert('操作成功', url::mpf('site','captcha','init'));
		}
	}
}
?>