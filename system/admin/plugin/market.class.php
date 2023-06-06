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
			if($res = user::curl('app.php','pages|divide|collect|search|param,\d+')){
				$data = json::decode($res);
				if($data['list']){
					foreach($data['list'] as $k=>$v){
						if(($r=mysql::select_one('id,display,must','plugin',"name='{$v['name']}'")) && is_file(ROOT_PATH.'system/plugin/'.$v['name'].'/config.json')){
							$data['list'][$k]['id'] = $r['id'];
							$data['list'][$k]['display'] = $r['display'];
							$data['list'][$k]['must'] = $r['must'];
						}
					}
				}
			}
			echo $this->theme('plugin/plugin', $data);
		}else{
			location(url::mpf('plugin','plugin','init'));
		}
	}
	
	public function collect()
	{
		global $G;
		$this->cover('plugin&market','M');
		if($res = user::collect('app',$G['get']['id'])){
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
		$G['cover'] = $this->cover('plugin&market');
		if($data = user::info('app',$G['get']['id'])){
			$G['no_copyright'] = true;
			echo $this->theme('plugin/info', $data);
		}
	}
	
	public function order()
	{
		global $G;
		$G['cover'] = $this->cover('plugin&market');
		if(is_numeric($G['get']['orders']) && preg_match('/^\w+$/',$G['get']['name'])){
			$G['no_copyright'] = true;
			echo $this->theme('plugin/order');
		}
	}
	
	public function make()
	{
		global $G;
		$G['cover'] = $this->cover('plugin&market');
		if(preg_match('/^\w+$/',$G['get']['name'])){
			$G['no_copyright'] = true;
			echo $this->theme('plugin/market');
		}
	}
	
	public function buy()
	{
		global $G;
		$this->cover('plugin&market','A');
		if($res = user::buy('app',$G['get']['id'])){
			if($res['state']=='success'){
				cache::remove('','user');
				switch($G['post']['pay']){
					case 'alipay':
						die('<script>'.
							'window.top.window.open(\''.url::mpf('template','market','pay',array('orders'=>$res['msg'],'name'=>null,'id'=>null)).'\');'.
							'window.parent.document.getElementsByClassName(\'window\').item(0).style.width=\'380px\';'.
							'window.parent.document.getElementsByClassName(\'window\').item(0).style.height=\'290px\';'.
							'window.location.href=\''.url::mpf('plugin','market','order',array('orders'=>$res['msg'],'name'=>$G['get']['name'],'id'=>null)).'\';'.
							'</script>');
						break;
					case 'balance':
						die('<script>'.
							'window.parent.document.getElementsByClassName(\'window\').item(0).style.width=\'360px\';'.
							'window.parent.document.getElementsByClassName(\'window\').item(0).style.height=\'160px\';'.
							'window.location.href=\''.url::mpf('plugin','market','make',array('name'=>$G['get']['name'],'id'=>null)).'#_alert='.urlencode($res['msg']).',green\';'.
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
		$G['cover'] = $this->cover('plugin&market');
		$name = $G['get']['name'];
		if(preg_match('/^\w+$/',$name)){
			if($res = user::inst('app',$name)){
				if($res['state']=='success'){
					die('<script>
						 window.parent.window.location.href=\''.url::mpf('plugin','market','install',array('name'=>$name)).'&referer=\'+encodeURIComponent(window.parent.window.location.href);
						 window.top.document.getElementsByClassName(\'category\').item(0).getElementsByClassName(\'plugin\').item(0).className+=\' '.$name.'\';
						 </script>');
				}else if($res['state']=='bind'){
					if(count($res['msg'])==1){
						$r = array_shift($res['msg']);
						$G['get']['orders'] = $r['orders'];
						self::bind();
					}else{
						$G['no_copyright'] = true;
						echo $this->theme('plugin/inst',$res['msg']);
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
		$this->cover('plugin&market','A');
		$name = $G['get']['name'];
		if($res = user::bind('app',$G['get']['orders'],$name)){
			if($res['state']=='success'){
				die('<script>
					 window.parent.window.location.href=\''.url::mpf('plugin','market','install',array('name'=>$name)).'&referer=\'+encodeURIComponent(window.parent.window.location.href);
					 window.top.document.getElementsByClassName(\'category\').item(0).getElementsByClassName(\'plugin\').item(0).className+=\' '.$name.'\';
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
		$this->cover('plugin&market','A');
		if($G['get']['referer'] && $G['get']['referer']!='[url]'){
			$_SERVER['HTTP_REFERER'] = urldecode(delFilter($G['get']['referer']));
		}
		$update = $G['get']['update'];
		$name = $G['get']['name'];
		if(preg_match('/^\w+$/',$name)){
			$file = user::install('app',$name,$update);
			into::basic_class('zip');
			$path = ROOT_PATH.'system/plugin/'.$name.'/';
			if(zip::unzip($file, $path)){
				dir::delete($file);
				if(into::load_json($path.'config.json') && is_file($path.'install.class.php')){
					if(into::load_class('admin',$name,'install','init')){
						if($update){
							alert('升级成功',$_SERVER['HTTP_REFERER']);
						}else{
							alert('安装成功',url::mpf('plugin','plugin','init',array('name'=>null)));
						}
					}
				}
			}else{
				dir::delete($file);
				alert('解压失败');
			}
		}
		alert('安装失败');
	}
}
?>