<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class sms extends admin
{
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover();
		echo $this->theme('site/sms');
	}
	
	public function add()
	{
		global $G;
		$this->cover('site&sms','M');
		if(isset($G['post'])){
			$data = array(
				'sms_id'         => $G['post']['sms_id'],
				'sms_key'        => $G['post']['sms_key'],
				'sms_sign'       => $G['post']['sms_sign'],
				'sms_template'   => $G['post']['sms_template'],
				'sms_tel'        => $G['post']['sms_tel']
			);
			foreach($data as $k=>$v){
				mysql::select_set(array('name'=>$k,'value'=>$v,'parent'=>'0','type'=>'0','lang'=>'0'),'config',array('value'));
			}
			alert('操作成功', url::mpf('site','sms','init'));
		}
	}
	
	public function send()
	{
		global $G;
		$this->cover('site&sms','M');
		if($G['config']['sms_id'] && $G['config']['sms_key'] && $G['config']['sms_sign'] && $G['config']['sms_template'] && $G['config']['sms_tel']){
			into::basic_class('smsto');
			$sign = json::decode(smsto::sign($G['config']['sms_sign']));
			if(isset($sign['SignStatus'])){
				switch($sign['SignStatus']){
					case 0:
						alert('短信签名审核中');
					break;
					case 2:
						alert('短信签名审核失败');
					break;
				}
			}else if(isset($sign['Message'])){
				alert($sign['Message']);
			}else{
				alert('短信签名获取失败');
			}
			$template = json::decode(smsto::template($G['config']['sms_template']));
			if(isset($template['TemplateStatus'])){
				switch($template['TemplateStatus']){
					case 0:
						alert('短信模板CODE审核中');
					break;
					case 1:
						if(!strstr($template['TemplateContent'],'${code}')){
							alert('短信模板CODE中没有含有 ${code} 短信参数，请重新申请短信验证码模板');
						}
					break;
					case 2:
						alert('短信模板CODE审核失败');
					break;
				}
			}else if(isset($template['Message'])){
				alert($template['Message']);
			}else{
				alert('短信模板CODE获取失败');
			}		
			if(smsto::send($G['config']['sms_tel'],array('code'=>mt_rand(100000,999999)),$G['config']['sms_template'])){
				alert('发送成功', url::mpf('site','sms','init'));
			}else{
				alert('发送失败！');
			}
		}else{
			alert('请先配置好短信接口等信息！');
		}
	}
	
	public function template()
	{
		global $G;
		into::basic_class('smsto');
		if($code = arrExist($G['get'],'code')){
			if($res = smsto::template($code)){
				header('Content-Type:application/json; charset=utf-8');
				echo json::encode($res);
			}
		}
	}
}
?>