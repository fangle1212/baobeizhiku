<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
$is_mobile = isMobile();
/* 加载模板各板块的数据 */
$data['common'] = array();
$json = load::ctrl();
foreach($json as $core=>$arr){
	$data[$core] = value::get($core, 0, 0);
}

/* 判断是否打开在线客服，是则加载特定风格的样式文件 */
if($G['config']['consult_open']){ 
	$G['website']['consult'] = load::page('consult/'.$G['config']['consult_theme'].'/consult.html',$data,true);
}
/* 城市分站 */
if($G['config']['area_open'] && $G['config']['area_foot_open'] && preg_match('/"'.$G['items']['type'].'"/',$G['config']['area_foot_type'])){
	$G['area_foot_insert'] = load::page('html/area.html',$data,true);
	if(!$G['config']['area_foot_insert']){
		$G['website']['area'] = $G['area_foot_insert'];
	}
}
/* 判断是否为手机端，手机菜单内容列表 Boss——Cms */
if($G['menu_open']=page::menu_list() && $is_mobile){
	$G['website']['menu'] = load::page('html/menu.html',$data,true);
}

/* 在cache缓存文件夹中生成公共的css和js文件 */
$gfname = 'global.'.substr(md5($G['config']['web_theme'].$G['language']['id']),0,8).($is_mobile?'.mobile':'');
/* 站点公共css文件 */
$G['website']['global_css'] = html::link(
	cache::setfunc(
		"{$gfname}.css",
		function($data){
			global $G;
			/* 公共的css */
			$global_css = load::page('css/global.css',$data,true)."\n";
			if($G['config']['consult_open']){
				$global_css .= load::page('consult/'.$G['config']['consult_theme'].'/consult.css',$data,true)."\n";
			}
			if($G['config']['area_open'] && $G['config']['area_foot_open']){
				$global_css .= load::page('css/area.css',$data,true)."\n";
			}
			if($G['menu_open']){
				$global_css .= load::page('css/menu.css',$data,true)."\n";
			}
			/* 模板公共的css */
			$global_css .= load::page('com/global.css',$data,true,'web');
			return url::upload($global_css,'sub','../../');
		},
		$data,
		'css'
	)
);
/* 站点公共js文件 */
$G['website']['global_js'] = html::script(
	cache::setfunc(
		"{$gfname}.js",
		function($data){
			global $G;
			/* 公共的js */
			$global_js = load::page('js/global.js',$data,true)."\n";
			if($G['config']['consult_open']){
				$global_js .= load::page('consult/'.$G['config']['consult_theme'].'/consult.js',$data,true)."\n";
			}
			if($G['config']['area_open'] && $G['config']['area_foot_open']){
				$global_js .= load::page('js/area.js',$data,true)."\n";
			}
			if($G['menu_open']){
				$global_js .= load::page('js/menu.js',$data,true)."\n";
			}
			/* 模板公共的js */
			$global_js .= load::page('com/global.js',$data,true,'web');
			return url::upload($global_js,'sub','../../');
		},
		$data,
		'js'
	)
);

/* 生成各页面的独立css和js文件名称 */
$tfname = 'theme.'.substr(md5($G['config']['web_theme'].$G['language']['id'].$G['items']['id'].$G['theme']['path']),0,8).($is_mobile?'.mobile':'');
/* 模板页面独立css文件 */
$G['website']['tname_css'] = html::link(
	cache::setfunc(
		"{$tfname}.css",
		function($data){
			global $G;
			return url::upload(
				load::page('css/'.str_replace('.html','.css',$G['theme']['path']),$data,true),
				'sub',
				'../../'
			);
		},
		$data,
		'css'
	)
);
/* 模板页面独立js文件 */
$G['website']['tname_js'] = html::script(
	cache::setfunc(
		"{$tfname}.js",
		function($data){
			global $G;
			return url::upload(
				load::page('js/theme.js',$data,true)."\n".
				load::page('js/'.str_replace('.html','.js',$G['theme']['path']),$data,true),
				'sub',
				'../../'
			);
		},
		$data,
		'js'
	)
);

/* 移动web公共目录下的font文件到cache缓存文件夹，并加载font图标 */
if($dir = load::common('font/')){
	$font = dir::read($dir);
	foreach($font['file'] as $filename){
		$file = cache::move($filename, $dir.$filename, 'font', null);
		if(preg_match('/\.css$/',$filename)){
			$font_css[$filename] = html::link($file);
		}
	}
	if(isset($font_css)){
		$G['website']['font_css'] = implode("\n",$font_css);
	}
}

/* 移动模板目录中的box文件夹到cache缓存文件夹，并加载box目录下的css和js文件 */
if($dir = load::theme('box/')){
	$box = dir::read($dir);
	foreach($box['file'] as $filename){
		$file = cache::move($filename, $dir.$filename, 'box', null);
		if(preg_match('/\.css$/',$filename)){
			$box_css[$filename] = html::link($file);
		}
		if(preg_match('/\.js$/',$filename)){
			$box_js[$filename] = html::script($file);
		}
	}
	foreach($box['dir'] as $dirname){
		$drs = dir::readall($dir.$dirname.'/');
		foreach($drs as $fname){
			cache::move($dirname.'/'.$fname, $dir.$dirname.'/'.$fname, 'box', null);
		}
	}
	if(isset($box_css)){
		$G['website']['box_css'] = implode("\n",$box_css);
	}
	if(isset($box_js)){
		$G['website']['box_js'] = implode("\n",$box_js);
	}
}

/* 顶部底部的代码配置 */
$G['website']['head_code'] = htmlspecialchars_decode($is_mobile?$G['config']['head_mobile_code']:$G['config']['head_code'], ENT_NOQUOTES);
$G['website']['foot_code'] = htmlspecialchars_decode($is_mobile?$G['config']['foot_mobile_code']:$G['config']['foot_code'], ENT_NOQUOTES);
/* 站点图标icon图片 */
$G['website']['link_icon'] = html::link($G['config']['icon'],'shortcut icon',array('type'=>'image/x-icon'));
/* jquery地址 */
$G['website']['jquery'] = html::script(cache::move('jquery-1.10.2.min.js',SYSTEM_PATH.'/extend/ueditor/third-party/jquery-1.10.2.min.js','box',null));
/* seo三要素 */
$G['website']['seo_title'] = seo::title();
$G['website']['seo_keywords'] = seo::keywords();
$G['website']['seo_description'] = seo::description();
/* 分离板块数据数组并删除总数组 */
extract($data);
unset($data);
?>