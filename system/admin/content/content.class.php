<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class content extends admin
{
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover();
		$url = '';
		$items = page::items();
		$type = arrExist($G,'get|type');
		foreach($items as $v){
			if($type){
				if($v['type']==$type){
					$url = url::mpf('group','group','init',array('items'=>$v['id'],'type'=>$v['type']));
					break;
				}
			}else{
				if($v['type']==1){
					$url = url::mpf('items','content','edit',array('id'=>$v['id']));
					break;
				}else if($v['type']>1 && $v['type']<6){
					$url = url::mpf('group','group','init',array('items'=>$v['id'],'type'=>$v['type']));
					break;
				}
			}
		}
		if($url){
			setcookie('iframeContentTreeScroll','0',TIME-1,'/');
			location($url);
		}else{
			alert('没有内容栏目管理',url::mpf('items','items','init'));
		}
	}
}
?>