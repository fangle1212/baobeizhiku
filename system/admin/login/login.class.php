<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
define('IS_LOGIN', true);

into::basic_class('admin');

class login extends admin
{
	public function init()
	{
		global $G;
		$G['no_copyright'] = true;
		$G['no_easy'] = true;
		$data['username'] = isset($G['get']['username'])?$G['get']['username']:arrExist($G,'cookie|admin_login_username');
		echo $this->theme('login/login',$data);
	}
	
	public function check()
	{
		global $G;
		into::basic_class('captcha');
		if($G['config']['admin_login_captcha']){
			if($G['config']['admin_captcha_type']){
				if(!captcha::describe($G['post']['randstr'],$G['post']['ticket'])){
					alert('图形验证错误');
				}
			}else{
				if(!isset($G['post']['captcha']) || empty($G['post']['captcha'])){
					alert('请填写验证码');
				}
				if($G['post']['captcha']!=session::get('captcha')){
					alert('验证码错误');
				}
			}
		}
		if(isset($G['post']['password']) && !empty($G['post']['username'])){
			$login_error_num = session::get('login_error',false);
			if($login_error_num >= $G['config']['admin_login_errnum']){
				$login_error_time = $_SESSION['login_error']['time']+$_SESSION['login_error']['expire']-TIME;
				if($login_error_time>=3600){
					$login_error_time = ceil($login_error_time/3600).'小时';
				}else if($login_error_time>=60){
					$login_error_time = ceil($login_error_time/60).'分钟';
				}else{
					$login_error_time = $login_error_time.'秒';
				}
				alert("登录已失败{$login_error_num}次，请{$login_error_time}后重试");
			}else{
				if($result = mysql::select_one('*','manager',"username='{$G['post']['username']}' AND password='".md5($G['post']['password'])."'")){
					if($result['open']){
						mysql::update(array('ip'=>getIP(),'ltime'=>TIME,'frequency'=>$result['frequency']+1),'manager',"id='{$result['id']}'");
						$admin_logout_time = arrExist($G,'config|admin_logout_time');
						if(!is_numeric($admin_logout_time)|| (is_numeric($admin_logout_time) && $admin_logout_time<60)){
							$admin_logout_time = 60;
						}
						session::set('manager',$result['id'].P.$result['username'].P.md5($result['password']).P.TIME, $admin_logout_time);
						if(arrExist($G['post'],'save') || ($G['post']['username']==arrExist($G,'cookie|admin_login_username'))){
							setcookie("admin_login_username", $G['post']['username'], TIME+3122064000, '/', null, null, true);
						}
						session::clear('login_error');
						alert('登陆成功','./');
					}else{
						alert('该用户没有启用');
					}
				}else{
					if($G['post']['username']==arrExist($G,'cookie|admin_login_username')){
						setcookie("admin_login_username", '', TIME-1, '/', null, null, true);
					}
					if($G['config']['admin_login_errtime']){
						session::set('login_error', $login_error_num?($login_error_num+1):1, $G['config']['admin_login_errtime']);
					}
					alert('用户或密码错误，请重新输入');
				}
			}
		}else{
			alert('没有提交信息');
		}
	}
	
	public function logout()
	{
		global $G;
		session::clear('manager');
		alert('登出成功',url::mpf('login','login','init'));
	}
}
?>