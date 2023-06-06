<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class config extends admin
{
    public function nav()
    {
        global $G;
		return $this->permit(
			array(
				'config' => array(
					'name' => '会员设置',
					'mold' => 'member',
					'part' => 'config',
					'check' => 'RM'
				),
				'content' => array(
					'name' => '文字设置',
					'mold' => 'member',
					'part' => 'config',
					'func' => 'content',
					'check' => 'RM'
				)
			)
		);
    }
	
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover();
		
		$G['navs1'] = $this->nav();
		$G['navs1']['config']['active'] = true;
		
		echo $this->theme('member/config', $data);
	}
	
	public function content()
	{
		global $G;
		$G['cover'] = $this->cover('member&config');
		
		$G['navs1'] = $this->nav();
		$G['navs1']['content']['active'] = true;
		
		echo $this->theme('member/content', $data);
	}
	
	public function add()
	{
		global $G;
		$this->cover('member&config','M');
		if(isset($G['post'])){
			$data = array(
				'member_open' => $G['post']['member_open'],
				'member_login_captcha' => $G['post']['member_login_captcha'],
				'member_logout_time' => $G['post']['member_logout_time'],
				'member_register_captcha' => $G['post']['member_register_captcha'],
				'member_register_check' => $G['post']['member_register_check'],
				'member_captcha_type' => $G['post']['member_captcha_type'],
				'member_sms_template' => $G['post']['member_sms_template'],
				'member_agreement_open' => $G['post']['member_agreement_open'],
				'member_agreement_link' => $G['post']['member_agreement_link'],
				'member_agreement_yes' => $G['post']['member_agreement_yes'],
				'member_agreement_name' => $G['post']['member_agreement_name'],
				'member_mail_title' => $G['post']['member_mail_title'],
				'member_mail_content' => $G['post']['member_mail_content']
			);
			foreach($data as $k=>$v){
				mysql::select_set(array('name'=>$k,'value'=>$v,'parent'=>'0','type'=>'0'),'config',array('value'));
			}
			alert('操作成功', url::mpf('member','config','init'));
		}
	}
	
	public function content_add()
	{
		global $G;
		$this->cover('member&config','M');
		if(isset($G['post'])){
			$data = array(
				'member_username' => $G['post']['member_username'],
				'member_password' => $G['post']['member_password'],
				'member_passwords' => $G['post']['member_passwords'],
				'member_code' => $G['post']['member_code'],
				'member_email' => $G['post']['member_email'],
				'member_phone' => $G['post']['member_phone'],
				'member_phone_code' => $G['post']['member_phone_code'],
				'member_phone_button' => $G['post']['member_phone_button'],
				'member_phone_retime' => $G['post']['member_phone_retime'],
				'member_login_button' => $G['post']['member_login_button'],
				'member_register_button' => $G['post']['member_register_button'],
				'member_code_error' => $G['post']['member_code_error'],
				'member_agreement_error' => $G['post']['member_agreement_error'],
				'member_phone_error' => $G['post']['member_phone_error'],
				'member_email_error' => $G['post']['member_email_error'],
				'member_login_success' => $G['post']['member_login_success'],
				'member_post_error' => $G['post']['member_post_error'],
				'member_login_error' => $G['post']['member_login_error'],
				'member_avatar_error' => $G['post']['member_avatar_error'],
				'member_avatar_size_error' => $G['post']['member_avatar_size_error'],
				'member_logout_success' => $G['post']['member_logout_success'],
				'member_password_error' => $G['post']['member_password_error'],
				'member_information_success' => $G['post']['member_information_success'],
				'member_information_error' => $G['post']['member_information_error'],
				'member_email_link_error' => $G['post']['member_email_link_error'],
				'member_register_success' => $G['post']['member_register_success'],
				'member_register_success_check' => $G['post']['member_register_success_check'],
				'member_phone_rdtime_min' => $G['post']['member_phone_rdtime_min'],
				'member_phone_sms_success' => $G['post']['member_phone_sms_success'],
				'member_phone_sms_error' => $G['post']['member_phone_sms_error'],
				'member_phone_code_error' => $G['post']['member_phone_code_error'],
				'member_passwords_error' => $G['post']['member_passwords_error'],
				'member_username_error' => $G['post']['member_username_error'],
				'member_username_has_error' => $G['post']['member_username_has_error'],
				'member_email_send_success' => $G['post']['member_email_send_success'],
				'member_email_send_error' => $G['post']['member_email_send_error'],
				'member_register_error' => $G['post']['member_register_error']
			);
			foreach($data as $k=>$v){
				mysql::select_set(array('name'=>$k,'value'=>$v,'parent'=>'0','type'=>'0'),'config',array('value'));
			}
			alert('操作成功', url::mpf('member','config','content'));
		}
	}
}
?>