<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

/* 系统顶级公共基础类 */
class origin
{
	public function init()
	{
		global $G;
		$this->_basic();
		$this->_request();
		$this->_path();
		$this->_mysql();
		$this->_rewrite();
		$this->_language();
		$this->_config();
		$this->_plugin();
	}
	
	private function _basic()
	{
		into::basic_func('global');
		
		into::basic_class('session');
		into::basic_class('dir');
		into::basic_class('json');
		into::basic_class('load');
		into::basic_class('url');
		into::basic_class('form');
		into::basic_class('ctrl');
		into::basic_class('theme');
		into::basic_class('value');
		into::basic_class('page');
		into::basic_class('html');
		
		into::basic_json('pass');
		into::basic_json('option',true);
	}
	
	private function _request()
	{
		global $G;
        foreach ($_COOKIE as $k => $v) {
            $G['cookie'][$k] = strFilter($v);
        }
        foreach ($_POST as $k => $v) {
            $G['post'][$k] = strFilter($v);
        }
        foreach ($_GET as $k => $v) {
            $G['get'][$k] = strFilter($v);
        }
	}
	
	private function _path()
	{
		global $G;
		$type  = defined('IS_INSIDE')?'admin':'web';
		$root  = dir::replace(ROOT_PATH.'/');
        $plugin = defined('IS_PLUGIN')?$root.'system/plugin/'.BOSSCMS_MOLD.'/':false;
		$aisle = isset($_SERVER['DOCUMENT_ROOT'])?str_ireplace(dir::replace($_SERVER['DOCUMENT_ROOT'].'/'),'/',$root):'';
		$host  = (isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:$_SERVER['SERVER_NAME']).((isset($_SERVER['SERVER_PORT'])&&$_SERVER['SERVER_PORT']!=80&&$_SERVER['SERVER_PORT']!=443)?':'.$_SERVER['SERVER_PORT']:'');
		$http  = (isset($_SERVER['HTTP_X_CLIENT_SCHEME'])?$_SERVER['HTTP_X_CLIENT_SCHEME']:(isset($_SERVER['REQUEST_SCHEME'])?$_SERVER['REQUEST_SCHEME']:'http')).'://';
		$site  = $boss_cms = $http.dir::replace($host.$aisle);
		$request = strReplace($aisle,'',isset($_SERVER['REQUEST_URI'])?dir::replace('/'.$_SERVER['REQUEST_URI']):((isset($_SERVER['REDIRECT_URL'])&&isset($_SERVER['QUERY_STRING']))?dir::replace('/'.htmlentities($_SERVER['REDIRECT_URL'])).'?'.htmlentities($_SERVER['QUERY_STRING']):''),1);
		$resource = strSubPos($request,'?');
		if($resource == '404.html') die();
		$quest = strSubPos($request,'?',-1);
		if($type=='web' && ($domain=getDomain($quest)) && in_array($quest,$domain)){
			url::page404();
		}
		$link = $site.$request;
		$relative = '';
		$count = substr_count($resource,'/');
		for($i=1; $i<=$count; $i++){
			$relative .= '../';
		}
		if(!is_file(SYSTEM_PATH.'install.lock')){
			location($relative.'install/index.php');
		}
		$url = $relative.$request;
		preg_match("/([^\/]*)\/.*$/", dir::replace($resource), $folder);
		$folder = isset($folder[1])?$folder[1]:'';
		$G['path'] = array(
			'type' => $type,
			'root' => $root,
            'plugin' => $plugin,
			'http' => $http,
			'aisle' => $aisle,
			'request' => $request,
			'resource' => $resource,
			'quest' => $quest,
			'host' => $host,
			'site' => $site,
			'link' => $link,
			'relative' => $relative,
			'folder' => $folder,
			'url' => $url,
			'home' => $folder?false:true
		);
		$G['view'] = arrExist($G,'get|view');
		if($G['view'] && !session::get('manager')){
			$G['view'] = false;
		}
		if(!$G['view']){
			preg_match('/^http[^\?]+\/index\.php(?:\?|$)/',$link,$match);
			if($match[0]){
				location(str_replace($match[0],str_replace('/index.php','/',$match[0]),$link),301);
			}
		}
	}
	
	private function _mysql()
	{
		global $G;
		into::basic_json('database',true);
		foreach($G['database'] as $key=>$val){
			foreach($val as $k=>$v){
				$G['database_column'][$key] .= ($k=='id'?'':',').$k;
			}
		}
		into::basic_ini('mysql');
		into::basic_class('mysql');
		mysql::connect();
	}
	
	private function _language()
	{
		global $G;
		$id = arrExist($G,'get|lang');
		if(!$id && is_numeric($G['post']['items']) && preg_match('/^api\//',$G['path']['resource'])){
			$id = arrExist(mysql::select_one('lang','items',"id='{$G['post']['items']}' AND lang=lang"),'lang');
		}
		if(is_numeric($id) && $id>0){
			$G['language'] = page::language_one($id);
		}else{
			if($G['language'] = page::language_one(null,'*',"defaults='1'")){
				$G['language'] = page::language_one(null,'*');
			}
		}
		if(!arrExist($G,'language|display')){
			url::page404();
		}
	}
	
	private function _config()
	{
		global $G;
		/* BOSS_CMS */
		$G['config'] = page::config_option(0, 0);
		if(defined('IS_INSIDE')){
			$data = page::config_option(0, 1);
			if(!isset($data['admin_remove_advert'])){
				$data['admin_remove_advert'] = 1;
			}
			if(!isset($data['admin_remote_market'])){
				$data['admin_remote_market'] = 1;
			}
			$G['config'] = array_merge($data, $G['config']);
		}
		if($G['path']['type']=='web' && !$G['view']){
			$result = mysql::select_all('name,value,lang','config',"FIND_IN_SET(name,'rewrite_open,domain,area_open,area_link_type,area_detail_open,area_link_scheme') AND parent='0' AND type='0' AND lang=lang");
			foreach($result as $v){
				$G['config'][$v['name'].$v['lang']] = $v['value'];
			}
		}
	}
	
	private function _rewrite()
	{
		global $G;
		if(arrExist($G,'get|bosscmsrewrite') && $G['path']['type']=='web' && !$G['view']){
			into::basic_class('rewrite');
			if(!rewrite::rule()){
				url::page404();
			}
		}
		if($G['path']['type']=='web' && $G['path']['home'] && getDomain($G['path']['quest'])){
			url::page404();
		}
	}
	
	private function _plugin()
	{
		global $G;
		$list = page::plugin_list();
		$G['plugin'] = array();
		foreach($list as $v){
			if($database = load::plugin($v['name'],'database')){
				$G['database'] = array_merge($G['database'], $database);
				foreach($database as $key=>$val){
					foreach($val as $k=>$str){
						$G['database_column'][$key] .= ($k=='id'?'':',').$k;
					}
				}
			}
			if($class = into::load_class('plugin', $v['name'], $v['name'].'_auto', 'init')){
				$G['plugin'][$v['name']] = $class;
			}
		}
	}
}
?>