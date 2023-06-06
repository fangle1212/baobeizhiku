<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('web');

class member extends web
{
	public function form()
	{
		global $G;
		$action = arrExist($G,'get|action');
		if($action == 'login'){
			$this->login();
		}else if($action == 'register'){
			$this->register();
		}else if($action == 'phonecode'){
			$this->phonecode();
		}else if($action == 'email'){
			$this->email();
		}else if($action == 'information'){
			$this->information();
		}else if($action == 'logout'){
			$this->logout();
		}
	}
	
	public function login()
	{
		global $G;
		if(isset($G['post'])){
			if($G['config']['member_login_captcha']){
				$captcha = arrExist($G['post'],'captcha');
				if(!($captcha && $captcha==session::get('captcha'))){
					alert($G['config']['member_code_error']);
				}
			}
			if(($username=arrExist($G['post'],'username')) && ($password=arrExist($G['post'],'password'))){
				if($result=mysql::select_one('*','member',"username='{$username}' AND password='".md5(stripslashes($password))."' AND open='1'")){
					mysql::update(array('ip'=>getIP(),'ltime'=>TIME,'frequency'=>$result['frequency']+1),'member',"id='{$result['id']}'");
					$member_logout_time = arrExist($G,'config|member_logout_time');
					if(!is_numeric($member_logout_time) || (is_numeric($member_logout_time) && $member_logout_time<60)){
						$member_logout_time = 60;
					}
					session::set('member', $result['id'].P.$result['username'].P.$result['password'].P.TIME, $member_logout_time);
					alert($G['config']['member_login_success'],url::member());
				}else{
					alert($G['config']['member_login_error']);
				}
			}
		}
		alert($G['config']['member_post_error']);
	}
	
	public function register()
	{
		global $G;
		if(isset($G['post'])){
			if($G['config']['member_agreement_open'] && !arrExist($G['post'],'agreement')){
				alert($G['config']['member_agreement_error']);
			}
			if($G['config']['member_register_captcha']){
				$captcha = arrExist($G['post'],'captcha');
				if(!($captcha && $captcha==session::get('captcha'))){
					alert($G['config']['member_code_error']);
				}
			}
			$data = array(
				'username'   => trim($G['post']['username']),
				'email'      => arrExist($G['post'],'email'),
				'phone'      => arrExist($G['post'],'phone')
			);
			if($G['config']['member_captcha_type'] == 1){
				if(!preg_match('/^0?1[3|4|5|6|7|8][0-9]\d{8}$/',$data['phone'])){
					alert($G['config']['member_phone_error']);
				}
				$phonecode = arrExist($G['post'],'phonecode');
				if(!(preg_match('/^\d{6}$/',$phonecode) && $phonecode==session::get('phone_register_code',false) && $data['phone']==session::get('phone_register_tel',false))){
					alert($G['config']['member_phone_code_error']);
				}
			}else if($G['config']['member_captcha_type'] == 2){
				if(!preg_match('/^[\w\-]+@[\w\-]+(\.[a-zA-Z]+){1,2}$/',$data['email'])){
					alert($G['config']['member_email_error']);
				}
			}
			$password = arrExist($G['post'],'password');
			if($password && preg_match('/^(?![a-zA-Z]+$)(?![0-9]+$).{6,}$/',delFilter($password))){
				if($password == arrExist($G['post'],'passwords')){
					$data['password'] = md5(stripslashes($password));
				}else{
					alert($G['config']['member_passwords_error']);
				}
			}else{
				alert($G['config']['member_password_error']);
			}
			if(mb_strlen($data['username'],'utf-8')<2){
				alert($G['config']['member_username_error']);
			}
			if(!$data['username'] || mysql::total('member',"username='{$data['username']}'")){
				alert($G['config']['member_username_has_error']);
			}
			$data['ip'] = getIP();
			$data['avatar'] = '';
			$data['frequency'] = '0';
			$data['ctime'] = TIME;
			$data['ltime'] = $G['config']['member_captcha_type']==2?mt_rand(100000,999999):0;
			$data['open'] =  $G['config']['member_captcha_type']==2?-1:($G['config']['member_register_check']?0:1);
			if($id = mysql::insert($data,'member')){
				if($G['config']['member_captcha_type'] == 2){
					into::basic_class('mailto');
					$url = $G['path']['site'].'api/member/?action=email&t='.TIME.'&e='.$data['email'].'&l='.$data['ltime'];
					$content = str_replace('[url]',"<a href=\"{$url}\" target=\"_blank\" style=\"color:rgb(0,168,238);\">{$url}</a>",$G['config']['member_mail_content']);
					if(mailto::send($data['email'],$G['config']['member_mail_title'],delHtmlspecial($content))){
						alert($G['config']['member_email_send_success'],url::member());
					}else{
						mysql::delete('member',"id='{$id}'");
						alert($G['config']['member_email_send_error']);
					}
				}else{
					alert($G['config']['member_register_check']?$G['config']['member_register_success_check']:$G['config']['member_register_success'],url::member());
				}
			}else{
				alert($G['config']['member_register_error']);
			}
		}
		alert($G['config']['member_post_error']);
	}
	
	public function phonecode()
	{
		global $G;
		header('Content: application/json;chartset=uft-8');
		if($G['config']['member_captcha_type'] == 1){
			$phonerdtime = session::get('phone_rdtime');
			if(arrExist($G,'get|rdtime')){
				$state = 'rdtime';
				$msg = $phonerdtime?60-(TIME-$phonerdtime):0;
				$msg = $msg>=0?$msg:0;
			}else{
				if($phonerdtime && TIME-$phonerdtime<60){
					$state = 'retimeerror';
					$msg = (TIME-$phonerdtime).$G['config']['member_phone_rdtime_min'];
				}else{
					$phone = arrExist($G,'post|phone');
					if(preg_match('/^0?1[3|4|5|6|7|8][0-9]\d{8}$/',$phone)){
						$code = mt_rand(123456,999999);
						into::basic_class('smsto');
						if(smsto::send($phone,array('code'=>$code),$G['config']['member_sms_template'])->Code == 'OK'){
							session::set('phone_register_tel',$phone,60*10);
							session::set('phone_register_code',$code,60*10); //验证码10分钟内有效
							session::set('phone_rdtime',TIME);
							$state = 'success';
							$msg = $G['config']['member_phone_sms_success'];
						}else{
							$state = 'smserror';
							$msg = $G['config']['member_phone_sms_error'];
						}						
					}else{
						$state = 'phoneerror';
						$msg = $G['config']['member_phone_error'];
					}
				}
			}
		}else{
			$state = 'error';
			$msg = $G['config']['member_post_error'];
		}
		echo json::encode(
			array(
				'state' => $state,
				'msg' => $msg
			)
		);
		die();
	}
	
	public function email()
	{
		global $G;
		if($G['config']['member_captcha_type'] == 2){
			mysql::delete('member',"email!='' AND open='-1' AND frequency='0' AND ltime REGEXP '^[0-9]{6}$' AND ctime+1800<".TIME);
			$ctime = $G['get']['t'];
			$email = $G['get']['e'];
			$ltime = $G['get']['l'];
			if(is_numeric($ctime) && $ctime+1800>=TIME && preg_match('/^\d{6}$/',$ltime) &&
				preg_match('/^[\w\-]+@[\w\-]+(\.[a-zA-Z]+){1,2}$/',$email) && 
				$res=mysql::select_one('id','member',"email='{$email}' AND open='-1' AND ltime='{$ltime}' AND frequency=0 AND ctime='{$ctime}'")){
				mysql::update(array('ltime'=>0,'open'=>$G['config']['member_register_check']?0:1),'member',"id='{$res['id']}'");
				alert($G['config']['member_register_check']?$G['config']['member_register_success_check']:$G['config']['member_register_success'],url::member());
			}
		}
		alert($G['config']['member_email_link_error'],url::member());
	}
	
	public function information()
	{
		global $G;
		if($G['member'] && isset($G['post'])){
			$data = array();
			if($G['member']['phone'] != $G['post']['phone']){
				if(preg_match('/^0?1[3|4|5|6|7|8][0-9]\d{8}$/',$G['post']['phone'])){
					$data['phone'] = $G['post']['phone'];
				}else{
					alert($G['config']['member_phone_error']);
				}
			}
			if($G['member']['email'] != $G['post']['email']){
				if(preg_match('/^[\w\-]+@[\w\-]+(\.[a-zA-Z]+){1,2}$/',$G['post']['email'])){
					$data['email'] = $G['post']['email'];
				}else{
					alert($G['config']['member_email_error']);
				}
			}
			if($password = arrExist($G['post'],'password')){
				if(preg_match('/^(?![a-zA-Z]+$)(?![0-9]+$).{6,}$/',delFilter($password))){
					$data['password'] = md5(stripslashes($password));
				}else{
					alert($G['config']['member_password_error']);
				}
			}
			if($G['config']['upload_web_allow'] && arrExist($_FILES,'avatar|error')==0){
				into::basic_class('upload');
				if(upload::files($_FILES['avatar'],'upload/avatar/','photo') && upload::$path){
					$data['avatar'] = str_replace('../../','..//',upload::$path);
				}else{
					alert($G['config']['member_avatar_error']);
				}
			}
			if($data){
				if(mysql::update($data,'member',"id='{$G['member']['id']}'")){
					alert($G['config']['member_information_success']);
				}else{
					alert($G['config']['member_information_error']);
				}
			}
		}
		alert($G['config']['member_post_error']);
	}
	
	public function logout()
	{
		global $G;
		unset($G['member']);
		session::clear('member');
		alert($G['config']['member_logout_success'],url::member());
	}
}
?>