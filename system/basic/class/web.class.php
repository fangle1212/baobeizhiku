<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('origin');
into::basic_class('cache');
into::basic_class('seo');

class web extends origin
{	
	public function init()
	{
		global $G;
		if(!$G['config']['domain'] && !$G['config']['domain_mobile']){
			die('未设置访问域名');  // 如果未设置访问域名网站将无法访问
		}
		$ht = parse_url($G['path']['site']);
		$mdn = parse_url($G['config']['domain_mobile']);
		if($G['config']['domain_mobile'] && isMobile() && $ht['host']!=$mdn['host']){
			location($G['config']['domain_mobile'], 301);
		}
		$dn = $G['config']['domain']?parse_url($G['config']['domain']):$mdn;
		if(rootDomain($ht['host']) != rootDomain($dn['host'])){
			die('当前域名非后台填写站点域名');  // 判断当前访问域名是否为所填站点域名，是则可以访问
		}
		
		$this->authorize();
		
		if(arrExist($G['config'],'state_open')){
			if($G['path']['home']){
				echo url::upload(load::page('close'));
				die();
			}else{
				url::page404();
			}
		}
		$this->reserved();
		$G['member'] = $this->member();
		$G['home'] = page::items_one(88888);
	}
	
	/* 获得会员信息 */
	public function member()
	{
		global $G;
		if($G['config']['member_open'] && $member=session::get('member')){
			$mbr = explode(P,$member);
			$result = page::member_one($mbr[0]);	
			if($result['username']==$mbr[1] && $result['password']==$mbr[2] && $result['ltime']==$mbr[3]){
				return $result;
			}
		}
		return false;
	}

	public function theme($name)
	{
		global $G;
		$file = md5($G['path']['link']).(isMobile()?'.mobile':'').'.html';
		$html = cache::auto($file, 'html');
		if($html === false){
			$html = load::page('html/'.$name, null, false, 'web');
			$html = $this->replace($html);
			if($G['view']){
				cache::remove('', 'html');
				/* 站点编辑模式添加必要css和js * boss-cms */
				session::set("view{$G['language']['id']}", $G['path']['link']);
				$html .= html::link(load::common('css/edit.css','admin',true));
				$html .= html::script(load::common('js/edit.js','admin',true));
			}else if($G['config']['page_cache_time']){
				cache::set($file, $html, 'html', true);
			}
		}
		/* 执行插件中的函数 */
		foreach($G['plugin'] as $class){
			if($class && method_exists($class, 'over')){
				$html = $class->over($html, 'web');
			}
		}
		return $html;
	}
	
	public function replace($html)
	{
		global $G;
		/* 违禁词替换操作 */
		if(arrExist($G,'config|violation_open') && $violation = json::decode(arrExist($G,'config|violation_table'))){
			$replace = arrExist($G,'config|violation_replace');
			foreach($violation as $v){
				$html = str_replace($v,$replace,$html);
			}
		}
		/* 锚文本替换 */
		if($anchor = mysql::select_all('*','anchor',"open='1'",'id ASC')){
			preg_match("/<body[\S\s]+<\/body>/", $html, $body);
			if($body){
				$Boss_CMS = false;
				$old_body = $new_body = $body[0];
				preg_match_all("/<a [\S\s]+?<\/a>|<img [\S\s]+?>/", $new_body, $alink);
				$arep = array();
				if($alink && !$Boss_CMS){
					foreach($alink[0] as $k=>$v){
						$rep = 'alink_'.$k.'_'.P;
						$new_body = str_replace($v, $rep, $new_body);
						$arep[$rep] = $v;
					}
				}
				foreach($anchor as $v){
					$replace = '<a href="'.$v['link'].'" title="'.($v['title']?$v['title']:$v['new']).'"'.($v['target']?' target="_blank"':'').($v['nofollow']?' rel="nofollow"':'').'>'.$v['new'].'</a>';
					$new_body = strReplace($v['old'], $replace, $new_body, 1);
				}
				foreach($arep as $k=>$v){
					$new_body = str_replace($k, $v, $new_body);
				}
				$html = str_replace($old_body, $new_body, $html);
			}
		}
		/* 城市分站列表 */
		if($G['area_foot_insert'] && $G['config']['area_open'] && $G['config']['area_foot_open'] && $G['config']['area_foot_insert'] && preg_match('/"'.$G['items']['type'].'"/',$G['config']['area_foot_type'])){
			$html = preg_replace('#'.preg_quote($G['config']['area_foot_insert']).'#',$G['area_foot_insert'].$G['config']['area_foot_insert'],$html,1);
		}
		/* 城市分站添加独立页面内容 */
		if($G['config']['area_open'] && isset($G['area']) && $G['area']['content'] && !isset($G['group']) && preg_match('/"'.$G['items']['id'].'"/',$G['config']['area_items'])){
			$html = preg_replace('#'.preg_quote($G['config']['area_insert']).'#',"<article {$G['area']['_content']}>{$G['area']['content']}</article>{$G['config']['area_insert']}",$html,1);
		}
		/* 网页描述判断 */
		$html = seo::replace($html);
		/* 给没有图片地址的img标签添加默认图片 */
		$html = preg_replace('/(<img [^>]*?src=)("\s*"|\'\s*\'|\s)/',"\\1\"{$G['config']['image']}\"",$html);
		/* 替换图片地址相对路径 BOSS_CMS */
		$html = url::upload($html);
		/* 网页去除标签 */
		$html = preg_replace('/<!--[\W]*?-->/','',$html);
		if(!$G['view']){
			/* 编辑模式去除标签 */
			$html = preg_replace_callback('/<[a-zA-Z0-9][^>]*?\sbosscms\=([\'"]{0,1})[\s\w]*?\\1[^>]*?>/',function($match){
				return preg_replace('/\s(?:bosscms|items|groups|group|link|feedback|consult|menu|banner|content|layers|complex|area)(?:\s*=([\'"]{0,1})([\s\w]*?)\\1){0,1}/','',$match[0]);				
			},$html);
		}
		/* 首页替换掉地址头部带 ../ 的地址 */
		if($G['path']['home'] && !$G['path']['relative']){
			$html = preg_replace('/(=["\'\s]*)\.\.\/(\w)/',"\\1\\2",$html);
		} /* 内页当相对地址带有两个以上../时，替换掉地址头部带 ../ 的地址 */
		else if(strstr($G['path']['relative'],'../../')){
			$html = preg_replace('/(=["\'\s]*)\.\.\/(\w)/',"\\1{$G['path']['relative']}\\2",$html);
		}
		return $html;
	}
	
	/* 对保留字段进行屏蔽不调取 */
	public function reserved()
	{
		global $G;
		into::basic_json('transfer');
		$config = load::config();
		if(isset($G['transfer']) && isset($config['transfer'])){
			unset($G['database_column']);
			foreach($G['database'] as $key=>$val){
				foreach($val as $k=>$v){
					if(!(isset($G['transfer'][$key])&&in_array($k,$G['transfer'][$key])) || (isset($config['transfer'][$key])&&in_array($k,$config['transfer'][$key]))){
						$G['database_column'][$key] .= ($k=='id'?'':',').$k;
					}
				}
			}
		}
	}
	
	public function authorize()
	{
		global $G;
		$path = ROOT_PATH.'cache/authorize/';
		$config = load::config();
		if(preg_match('/^RJUI\d+$/i',$config['serial'])){
			$file = $path.md5(rootDomain($G['path']['host']).'template'.$config['serial']);
			if(is_file($file) && TIME-filemtime($file)<604800){
				$res = file_get_contents($file);
			}else{
				into::basic_class('curl');
				if(curl::code('https://api.bosscms.net/rest/authorize/template.php')==200){
					$res = curl::request('https://api.bosscms.net/rest/authorize/template.php?serial='.$config['serial']);
					dir::create($file, $res);
				}else{
					$res = 1;
				}
			}
			if(!$res) die('当前域名未授权商业模板'.$config['serial'].'，禁止访问');
		}
		
	}
}
?>