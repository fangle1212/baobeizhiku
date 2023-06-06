<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class email extends admin
{
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover();
		echo $this->theme('site/email');
	}
	
	public function add()
	{
		global $G;
		$this->cover('site&email','M');
		if(isset($G['post'])){
			$data = array(
				'mail_user'        => $G['post']['mail_user'],
				'mail_password'    => $G['post']['mail_password'],
				'mail_host'        => $G['post']['mail_host'],
				'mail_port'        => $G['post']['mail_port'],
				'mail_recipient'   => $G['post']['mail_recipient'],
				'mail_title'       => $G['post']['mail_title'],
				'mail_content'     => $G['post']['mail_content']
			);
			foreach($data as $k=>$v){
				mysql::select_set(array('name'=>$k,'value'=>$v,'type'=>'0','parent'=>'0','lang'=>'0'),'config',array('value'));
			}
			alert('操作成功', url::mpf('site','email','init'));
		}
	}
	
	public function send()
	{
		global $G;
		$this->cover('site&email','M');
		if($G['config']['mail_user'] && $G['config']['mail_password'] && $G['config']['mail_host'] && $G['config']['mail_port']){
			if($G['config']['mail_recipient'] && $G['config']['mail_title'] && $G['config']['mail_content']){
				into::basic_class('mailto');
				if(mailto::send($G['config']['mail_recipient'],$G['config']['mail_title'],delHtmlspecial($G['config']['mail_content']))){
					alert('发送成功！', url::mpf('site','email','init'));
				}else{
					alert('发送失败！');
				}
			}else{
				alert('请先设置好接收方邮箱信息！');
			}
		}else{
			alert('请先配置好发送邮箱的信息！');
		}
	}
}
?>