<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');
into::basic_class('user');

class market extends admin
{
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover();
		if(user::test()){
			$G['identity'] = user::identity();
			$G['field'] = user::field();
			$G['get']['names'] = implode(',',into::load_class('admin','template','template','new')->local());
			if($res = user::curl('templates.php','pages|divide|collect|search|names|param,\d+')){
				$data = json::decode($res);
			}
			echo $this->theme('template/template', $data);
		}else{
			location(url::mpf('template','template','init'));
		}
	}
	
	public function collect()
	{
		global $G;
		$this->cover('template&market','M');
		if($res = user::collect('templates',$G['get']['id'])){
			if(preg_match('/^success_?$/',$res['state'])){
				cache::remove('','user');
				alert($res['msg'],$_SERVER['HTTP_REFERER']);
			}
		}
		alert('收藏失败');
	}
	
	public function info()
	{
		global $G;
		$G['cover'] = $this->cover('template&market');
		if($data = user::info('templates',$G['get']['id'])){
			$G['no_copyright'] = true;
			echo $this->theme('template/info', $data);
		}
	}
	
	public function order()
	{
		global $G;
		$G['cover'] = $this->cover('template&market');
		if(is_numeric($G['get']['orders']) && preg_match('/^\w+$/',$G['get']['name'])){
			$G['no_copyright'] = true;
			echo $this->theme('template/order');
		}
	}
	
	public function make()
	{
		global $G;
		$G['cover'] = $this->cover('template&market');
		if(preg_match('/^\w+$/',$G['get']['name'])){
			$G['no_copyright'] = true;
			echo $this->theme('template/market');
		}
	}
	
	public function pay()
	{
		global $G;
		if(is_numeric($G['get']['orders'])){
			die(user::pay($G['get']['orders']));
		}
		alert('订单错误','close');
	}
	
	public function buy()
	{
		global $G;
		$this->cover('template&market','A');
		if($res = user::buy('templates',$G['get']['id'])){
			if($res['state']=='success'){
				cache::remove('','user');
				switch($G['post']['pay']){
					case 'alipay':
						die('<script>'.
							'window.top.window.open(\''.url::mpf('template','market','pay',array('orders'=>$res['msg'],'name'=>null,'id'=>null)).'\');'.
							'window.parent.document.getElementsByClassName(\'window\').item(0).style.width=\'380px\';'.
							'window.parent.document.getElementsByClassName(\'window\').item(0).style.height=\'290px\';'.
							'window.location.href=\''.url::mpf('template','market','order',array('orders'=>$res['msg'],'name'=>$G['get']['name'],'id'=>null)).'\';'.
							'</script>');
						break;
					case 'balance':
						die('<script>'.
							'window.parent.document.getElementsByClassName(\'window\').item(0).style.width=\'360px\';'.
							'window.parent.document.getElementsByClassName(\'window\').item(0).style.height=\'160px\';'.
							'window.location.href=\''.url::mpf('template','market','make',array('name'=>$G['get']['name'],'id'=>null)).'#_alert='.urlencode($res['msg']).',green\';'.
							'</script>');
						break;
				}
			}else if($res['msg']){
				alert($res['msg']);
			}
		}
		alert('购买失败');
	}
	
	public function inst()
	{
		global $G;
		$G['cover'] = $this->cover('template&market');
		$name = $G['get']['name'];
		if(preg_match('/^\w+$/',$name)){
			if($res = user::inst('templates',$name)){
				if($res['state']=='success'){
					die('<script>
						 window.parent.window.location.href=\''.url::mpf('template','market','install',array('name'=>$name)).'&referer=\'+encodeURIComponent(window.parent.window.location.href);
						 </script>');
				}else if($res['state']=='bind'){
					if(count($res['msg'])==1){
						$r = array_shift($res['msg']);
						$G['get']['orders'] = $r['orders'];
						self::bind();
					}else{
						$G['no_copyright'] = true;
						echo $this->theme('template/inst',$res['msg']);
					}
				}else if($res['msg']){
					alert($res['msg']);
				}
			}else{
				die('<script>window.parent.window._alert(\'安装失败\');</script>');
			}
		}
	}
	
	public function bind()
	{
		global $G;
		$this->cover('template&market','A');
		$name = $G['get']['name'];
		if($res = user::bind('templates',$G['get']['orders'],$name)){
			if($res['state']=='success'){
				die('<script>
					 window.parent.window.location.href=\''.url::mpf('template','market','install',array('name'=>$name)).'&referer=\'+encodeURIComponent(window.parent.window.location.href);
					 </script>');
			}else if($res['msg']){
				alert($res['msg']);
			}
		}
		alert('授权失败');
	}
	
	public function install()
	{
		global $G;
		$this->cover('template&market','A');
		if($G['get']['referer'] && $G['get']['referer']!='[url]'){
			$_SERVER['HTTP_REFERER'] = urldecode(delFilter($G['get']['referer']));
		}
		$update = $G['get']['update'];
		$name = $G['get']['name'];
		if(preg_match('/^\w+$/',$name)){
			$file = user::install('templates',$name,$update);
			into::basic_class('zip');
			$path = ROOT_PATH.'system/web/theme/'.$name.'/';
			if(zip::unzip($file, $path)){
				dir::delete($file);
				if(into::load_json($path.'config.json')){
					if($update){
						alert('升级成功',$_SERVER['HTTP_REFERER']);
					}else{
						mysql::update(array('value'=>$name),'config',"name='web_theme'");
						alert('安装成功',url::mpf('template','template','init',array('name'=>null)));
					}
				}
			}else{
				dir::delete($file);
				alert('解压失败');
			}
		}
		alert('安装失败');
	}
	
	/* 登录界面 */
	public function login()
	{
		global $G;
		$G['no_copyright'] = true;
		echo $this->theme('template/login');
	}
	
	/* 登录官方账号 */
	public function hello()
	{
		global $G;
		if(isset($G['post'])){
			if(preg_match('/^0?1[3|4|5|6|7|8][0-9]\d{8}$/',$G['post']['tel'])){
				if($G['post']['password']){
					if($res = user::curl('login.php',null,'tel|password',0)){
						$json = json::decode($res);
						if($json['state']=='success' && preg_match('/^\d{18}$/',$json['msg'])){
							mysql::select_set(array(
								'name'=>'user_sequence',
								'value'=>$json['msg'],
								'parent'=>'0',
								'type'=>'0',
								'lang'=>'0'
							),'config',array('value'));
							cache::remove('','user');
							alert('登录成功', url::mpf('template','market','login',array('success'=>'ok')));
						}else if($json['msg']){
							alert($json['msg']);
						}
					}
				}else{
					alert('密码不能为空');
				}
			}else{
				alert('手机号错误');
			}
		}
		alert('登录失败');
	}
	
	/* 退出登录 */
	public function logout()
	{
		global $G;
		if(preg_match('/^\d{18}$/',$G['config']['user_sequence'])){
			if($res = user::curl('logout.php',null,null,0)){
				$json = json::decode($res);
				if($json['state']=='success'){
					if(mysql::update(array('value'=>''),'config',"name='user_sequence' AND parent='0' AND type='0' AND lang='0'")){
						cache::remove('','user');
						alert('登出成功',$_SERVER['HTTP_REFERER']);
					}
				}else if($json['msg']){
					alert($json['msg']);
				}
			}
		}
		alert('登出失败');
	}
}
?>