<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class config extends admin
{
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover();
		$G['navs1'] = into::load_class('admin','feedback','feedback','new')->nav();
		$G['navs1']['config']['active'] = true;
		$data = array();
		$items = into::load_class('admin','feedback','feedback','new')->items();
		$data['config'] = page::config_option($items);
		$result = page::form($items);
		foreach($result as $v){
			$data['name']['params'.$v['id']] = $v['title'];
			$data['show']['params'.$v['id']] = $v['title'];
			$data['form'][$v['id']] = $v['title'];
			$data['table']['params'.$v['id']] = $v['title'];
		}
		echo $this->theme('feedback/config', $data);
	}
	
	public function add()
	{
		global $G;
		$this->cover('feedback&config','M');
		if(isset($G['post'])){
			$data = array(
				'feedback_open'                => $G['post']['feedback_open'],
				'feedback_name'                => $G['post']['feedback_name'],
				'feedback_show'                => $G['post']['feedback_show'],
				'feedback_captcha'             => $G['post']['feedback_captcha'],
				'feedback_captcha_title'       => $G['post']['feedback_captcha_title'],
				'feedback_captcha_placeholder' => $G['post']['feedback_captcha_placeholder'],
				'feedback_captcha_error'       => $G['post']['feedback_captcha_error'],
				'feedback_display'             => $G['post']['feedback_display'],
				'feedback_submit'              => $G['post']['feedback_submit'],
				'feedback_success'             => $G['post']['feedback_success'],
				'feedback_quick'               => $G['post']['feedback_quick'],
				'feedback_form'                => json::encode($G['post']['feedback_form']),
				'feedback_mail'                => $G['post']['feedback_mail'],
				'feedback_recipient'           => $G['post']['feedback_recipient'],
				'feedback_title'               => $G['post']['feedback_title']
			);
			foreach($data as $k=>$v){
				mysql::select_set(array('name'=>$k,'value'=>$v,'parent'=>$G['get']['items'],'type'=>'0'),'config',array('value'));
			}
			alert('保存成功！',url::mpf('feedback','config','init',array('feedback'=>$G['get']['items'])));
		}else{
			alert('没有提交信息！');
		}
	}
}
?>