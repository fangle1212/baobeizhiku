<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class member extends admin
{
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover();
		mysql::delete('member',"email!='' AND open='-1' AND frequency='0' AND ltime REGEXP '^[0-9]{6}$' AND ctime+1800<".TIME);
		$data = page::member_pages();
		echo $this->theme('member/member',$data);
	}
	
	public function edit()
	{
		global $G;
		$G['cover'] = $this->cover('member');
		$data = array();
		if(isset($G['get']['id'])){
			$data['member'] = mysql::select_one('*','member',"id='{$G['get']['id']}'");
		}
		echo $this->theme('member/edit',$data);
	}
	
	public function modify()
	{
		global $G;
		$this->cover('member','M');
		if(isset($G['post']['id'])){
			$error=array();
			foreach($G['post']['id'] as $id){
				if(isset($G['post']['open'.$id])){
					$data = array(
						'open' => $G['post']['open'.$id]
					);
					if(!is_numeric(mysql::update($data,"member","id='{$id}'"))){
						$error[]=$id;
					}
				}
			}
			if($error){
				alert('ID为'.implode(',',$error).'修改失败');
			}else{
				alert('修改成功', url::mpf('member','member','init'));
			}
		}else{
			alert('没有提交信息');
		}
	}
	
	public function add()
	{
		global $G;
		$this->cover('member',arrExist($G,'get|id')?'M':'A');
		if(isset($G['post'])){
			$data = array(
				'email'    => $G['post']['email'],
				'phone'    => $G['post']['phone'],
				'open'     => $G['post']['open']
			);
			if($password = arrExist($G,'post|password')){
				if($password && preg_match('/^(?![a-zA-Z]+$)(?![0-9]+$).{6,}$/',delFilter($password))){
					if($password == arrExist($G,'post|passwords')){
						$data['password'] = md5(stripslashes($G['post']['password']));
					}else{
						alert('两次密码输入不同，请重新输入');
					}
				}else{
					alert('密码必须含有英文字母和数字，且长度大于6位字符');
				}
			}
			if($id = arrExist($G,'get|id')){
				if($res = page::member_one($id)){
					if($res['email'] && preg_match('/^\d{6}$/',$res['ltime']) && $res['open']==-1){
						alert('账号邮箱未验证，不能修改');
					}
					mysql::update($data,'member',"id='{$id}'");
				}else{
					alert('会员错误');
				}
			}else{
				if(!$password){
					alert('密码不能为空');
				}
				$data['username'] = $G['post']['username'];
				if(mb_strlen($data['username'],'utf-8')<2){
					alert('账户名称必须大于2个字符');
				}
				if(mysql::total('member',"username='{$data['username']}'")){
					alert('该账号已经存在，请重新输入');
				}
				$data['ip'] = '';
				$data['frequency'] = '0';
				$data['ctime'] = TIME;
				$data['ltime'] = 0;
				$id = mysql::insert($data,'member');
			}
			alert('保存成功',url::mpf('member','member','edit',array('id'=>$id,'success'=>'ok')));
		}else{
			alert('没有提交信息');
		}
	}
	
	public function delete()
	{
		global $G;
		$this->cover('member','D');
		if(isset($G['post']['url']) && isset($G['get']['id'])){
			$id = $G['get']['id'];
			if($id){
				if(is_numeric(mysql::delete('member',"id='{$id}'"))){
					alert('删除成功',url::mpf('member','member','init',array('id'=>null)));
				}else{
					alert('删除失败');
				}
			}else{
				alert('没有删除对象id');
			}			
		}
		alert('没有提交信息');
	}
}
?>