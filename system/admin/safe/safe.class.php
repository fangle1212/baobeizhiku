<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');
into::basic_class('captcha');

class safe extends admin
{
	/* BOSS_CMS */
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover();
		if(preg_match("/^\w+$/", $old=arrExist($G['get'],'old_folder'))){
			if(is_file(ROOT_PATH.$old.'/index.php')){
				$str = file_get_contents(ROOT_PATH.$old.'/index.php');
				$res = dir::read(ROOT_PATH.$old.'/');
				if(strstr($str,"define('IS_INSIDE',true);") && count($res['file'])==1){
					dir::remove(ROOT_PATH.$old.'/');
				}
			}
		}
		echo $this->theme('safe/safe');
	}
	
	public function captcha()
	{
		global $G;
		$this->cover('safe','M');
		if(isset($G['post'])){
			if(!$G['post']['admin_captcha_type'] || captcha::describe($G['post']['randstr'],$G['post']['ticket'])){
				mysql::select_set(array('name'=>'admin_captcha_type','value'=>$G['post']['admin_captcha_type'],'parent'=>'0','type'=>'0','lang'=>'0'),'config',array('value'));
				alert('success');
			}else{
				alert('图形验证错误');
			}
		}
	}
	
	public function add()
	{
		global $G;
		$this->cover('safe','M');
		if(isset($G['post'])){
			if(!$G['post']['admin_folder']){
				alert('后台文件夹不能为空！');
			}
			$BOSSCMS;
			$data = array(
				'page_cache_time'    => $G['post']['page_cache_time'],
				'upload_rename'      => $G['post']['upload_rename'],
				'upload_maxsize'     => $G['post']['upload_maxsize'],
				'upload_extension'   => preg_replace('/\\\"(\w)/','\".$1',$G['post']['upload_extension']),
				'upload_web_allow'   => $G['post']['upload_web_allow'],
				'upload_repeat'      => $G['post']['upload_repeat'],
				'ueditor_catchimage' => $G['post']['ueditor_catchimage']
			);
			foreach($data as $k=>$v){
				mysql::select_set(array('name'=>$k,'value'=>$v,'parent'=>'0','type'=>'0','lang'=>'0'),'config',array('value'));
			}
			
			$data = array(
				'admin_login_captcha' => $G['post']['admin_login_captcha'],
				'admin_logout_time'   => $G['post']['admin_logout_time'],
				'admin_login_errnum'  => $G['post']['admin_login_errnum'],
				'admin_login_errtime' => $G['post']['admin_login_errtime'],
				'window_full'         => $G['post']['window_full']
			);
			foreach($data as $k=>$v){
				mysql::select_set(array('name'=>$k,'value'=>$v,'parent'=>'0','type'=>'1','lang'=>'0'),'config',array('value'));
			}
			
			if($G['path']['folder'] != $G['post']['admin_folder']){
				if(!preg_match("/^\w+$/", $G['post']['admin_folder'])){
					alert('文件夹名称必须为英文、数字、下划线等字符');
				}
				dir::copydir(ROOT_PATH.$G['path']['folder'].'/', ROOT_PATH.$G['post']['admin_folder'].'/');
				alert('操作成功', '../'.$G['post']['admin_folder'].'/'.url::mpf('safe','safe','init',array('admin_folder'=>$G['post']['admin_folder'],'old_folder'=>$G['path']['folder'])));
			}else{
				alert('操作成功', url::mpf('safe','safe','init'));
			}
		}
	}
}
?>