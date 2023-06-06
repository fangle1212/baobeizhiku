<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

class session
{
	public function __construct(){
		session_name('bosscms');
		session_start();
		setcookie('bosscms', session_id(), null, '/', null, null, true);
	}
	
	/** 
	 * 设置session
	 *
	 * @param string $name
	 * @param string|array $data
	 * @param integer $expire 默认超时时间为一天
	 */
	public static function set($name, $data, $expire=86400){
		$session = array();
		$session['data'] = $data;
		$session['time'] = TIME;
		$session['expire'] = $expire;
		$_SESSION[$name] = $session;
	}

	/**
	 * 读取session
	 * b o s s c m s
	 * @param string $name
	 * @param boolean $retime 是否重新定时
	 * @param boolean $group 是否返回完整数组
	 */
	public static function get($name, $retime=true, $group=false){
		if(isset($_SESSION[$name])){
			$session = $_SESSION[$name];
			if($session['time']+$session['expire'] > TIME){
				if($retime){
					$session['time'] = TIME;
					$_SESSION[$name] = $session;
				}
				if($group){
					return $session;
				}else{
					return $session['data'];
				}
			}else{
				self::clear($name);
			}
		}
		return false;
	}

	/**
	 * 清除session
	 * @param  string $name
	 */  
	public static function clear($name){
		unset($_SESSION[$name]);
	}
}
?>