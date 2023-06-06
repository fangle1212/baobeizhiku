<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('origin');

class notice extends origin
{
	public function get()
	{
		global $G;
		if(isset($G['post'])){
			$type = $G['post']['type'];
			$id = $G['post']['id'];
			if($type>1 && $type<6){
				/* B O S S C M S */
				$table = array_search($type,$G['pass']['type']);
				$res = mysql::select_one('notice',$table,"id='{$id}'");
				$notice = $res['notice']+1;
				mysql::update(array('notice'=>$notice),$table,"id='{$id}'");
				echo json::encode(array('notice'=>$notice,'type'=>$type,'id'=>$id));
			}
		}
	}
}
?>