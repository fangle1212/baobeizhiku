<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');
into::basic_class('user');

class software extends admin
{
	public function init()
	{
		global $G;
		echo $this->theme('software/software');
	}

	public function field()
	{
		global $G;
		$field = user::field();
		$list = array(array(
			'on' => !$G['get']['divide']?'on':'',
			'url' => url::param(url::mpf('software','software','init'),'divide',null),
			'name' => '全部'
		));
		foreach($field['software']['divide'] as $k=>$v){
			$list[] = array(
				'on' => $G['get']['divide']==$k?'on':'',
				'url' => url::param(url::mpf('software','software','init'),'divide',$k),
				'name' => $v
			);
		}
		$content = htmlspecialchars_decode($field['software']['content'],ENT_NOQUOTES);
		echo json::encode(array(
			'list' => $list,
			'content' => $content
		));
	}

	public function data()
	{
		global $G;
		$res = json::decode(user::curl('software.php','pages|divide|search'));
		foreach($res['list'] as $k=>$v){
			$res['list'][$k]['price'] = $v['list'][0]['pr'][0]['price'];
			$res['list'][$k]['buy_duration'] = $v['list'][0]['pr'][0]['buy_duration'];
			$res['list'][$k]['remark'] = $v['list'][0]['pr'][0]['remark'];
			unset($res['list'][$k]['list']);
		}
		echo json::encode($res, true);
	}

	public function identity()
	{
		global $G;
		if($G['config']['admin_remote_market']){
			echo json::encode(user::identity());
		}
	}
}
?>