<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('origin');

class admin extends origin
{
	public function init()
	{
		global $G;
		$manager = session::get('manager');
		if(empty($manager)){
			if(!defined('IS_LOGIN')){
				if(!(BOSSCMS_MOLD!='login' && $G['get']['mold']=='login')){
					location(url::mpf('login','login','init'));
				}
				die('login');
			}
		}else{
			$mgr = explode(P,$manager);
			$result = mysql::select_one('*','manager',"id='{$mgr[0]}'");
			if($result['username']==$mgr[1] && md5($result['password'])==$mgr[2] && ($result['ltime']==$mgr[3] || !isset($mgr[3]))){
				$G['manager'] = $result;
			}else{
				session::clear('manager');
				if(!(BOSSCMS_MOLD!='login' && $G['get']['mold']=='login')){
					location(url::mpf('login','login','init'));
				}
				die('login');
			}
			$this->authorize();
		}
		if($G['path']['plugin'] && !preg_match('/^(install|uninstall)$/',BOSSCMS_PART) && mysql::total('plugin',"name='".BOSSCMS_MOLD."' AND display='0'")){
			alert('当前插件没有启用',url::mpf('plugin','plugin','init'));
		}
	}
	
	/* 页面查增改删权限检测 */
	public function cover($str=null, $ramd='R', $judge=false)
	{
		global $G;
		if($G['manager']['level']!=1){
			if(!isset($str)){
				$str = $this->build(array('mold'=>BOSSCMS_MOLD,'part'=>BOSSCMS_PART,'func'=>BOSSCMS_FUNC));
			}
			$permit = array();
			$arr = json::decode($G['manager']['permit']);
			foreach($arr as $v){
				$p = explode('-',$v);
				$permit[$p[0]] = $p[1]?$p[1]:'RAMD';
			}
			if(!$str || !isset($permit[$str]) || !strstr($permit[$str],$ramd)){
				if(!$judge){
					if($ramd=='R'){
						url::page404();
					}else{
						$arr = array('R'=>'查看','A'=>'新增','M'=>'修改','D'=>'删除');
						alert('当前账号没有'.$arr[$ramd].'权限');
					}
				}
				return false;
			}else{
				return true;
			}
		}else{
			return true;
		}
	}
	
	public function permit($nav)
	{
		global $G;
		if($G['manager']['level']==1){
			return $nav;
		}else{
			$permit = array();
			$arr = json::decode($G['manager']['permit']);
			foreach($arr as $v){
				$p = explode('-',$v);
				$permit[$p[0]] = $p[1]?$p[1]:'RAMD';
			}
			foreach($nav as $k=>$v){
				$str = $this->build($v);
				if(!$str || !isset($permit[$str]) || !strstr($permit[$str],'R')){
					unset($nav[$k]);
				}
			}
			return $nav;
		}
	}
	
	public function build($data)
	{
		$str = $data['mold'];
		if($data['func'] && $data['func']!='init'){
			$str .= '&'.($data['part']?$data['part']:$data['mold']).'&'.$data['func'];
		}else{
			$str .= $data['part']&&$data['mold']!=$data['part']?'&'.$data['part']:'';
		}
		return $str;
	}
	
	/* 判断自动更新站点地图sitemap */
	public function sitemap()
	{
		global $G;
		if($G['config']['sitemap_open'] && $G['config']['sitemap_auto_update']){
			$G['config'] = page::config_option(0, null);
			into::load_class('admin','seo','seo','new')->show(true);
		}
	}
	
	public function theme($name, $data=array())
	{
		global $G;
		$html = load::page($name, $data, false, 'admin');
		/* BOSS-CMS 替换图片地址相对路径 */
		//$html = url::upload($html);
		/* 执行插件中的函数 */
		if(preg_match_all('/<img class="(?:img|ico)" rand src="\.\.\/system\/admin\/common\/img\/logo(?:_ico)?\.png" \/>/',$html)!=2
		&&BOSSCMS_MOLD=='iframe'&&BOSSCMS_PART=='iframe') die();
		foreach($G['plugin'] as $class){
			if($class && method_exists($class, 'over')){
				$html = $class->over($html, 'admin');
			}
		}
		return $html;
	}
	
	/* 通过访问官网检测当前访问域名的授权信息并放置于缓存文件中 */
	public function authorize()
	{
		global $G;
		$file = ROOT_PATH.'cache/authorize/'.md5(rootDomain($G['path']['host']).'authorize');
		if(is_file($file) && TIME-filemtime($file)<604800){
			$G['authorize'] = json::decode(file_get_contents($file));
		}else{
			into::basic_class('curl');
			$dir = dir::read(ROOT_PATH.'system/admin/common/html/');
			$post = array();
			foreach($dir['file'] as $name){
				preg_match('/^oem(\w+)\.html$/',$name,$match);
				if($match[1]){
					$post['oem'] = $match[1];
					break;
				}
			}
			$res = curl::request('https://api.bosscms.net/rest/authorize/face.php',$post);
			dir::create($file, $res);
			$G['authorize'] = json::decode($res);
		}
		if(!$this->face('1234',true)){
			mysql::update(array('value'=>0),'config',"name='area_open' OR name='violation_open' OR name='consult_open'");
		}
	}
	
	/* range 表示授权版本范围；填写该值判断当前版本是否可用功能 */
	public function face($range='1234', $judge=false)
	{
		global $G;
		if(preg_match('/^(1|2|3|4)$/',$G['authorize']['auth'])){
			if(preg_match("/[{$range}]/",$G['authorize']['auth'])){
				return true;
			}
		}
		if($judge){
			return false;
		}else{
			alert($G['authorize']['name'].'不能使用该功能');
		}
	}
}
?>