<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('web');
into::basic_class('cache');
into::basic_class('compile');

class view extends web
{
	public $path = 'system/admin/miniprogram/';
	public $arrayCtrl = array();
	public $theme = '';

	public function init()
	{
		global $G;
		$this->theme = preg_match('/^\w+$/',$G['get']['theme'])?$G['get']['theme']:$G['config']['miniprogram_theme'];
		if($this->arrayCtrl = into::load_class('extend','miniprogram','miniprogram','new')->ctrl($this->theme)){
			$this->classpage($G['get']['class'], $G['get']['diypage']);
		}
	}

	public function classpage($class, $diypage=false){
		if(!$class){
			$class = 'home';
		}
		$display = false;
		if($diypage){
			foreach($this->arrayCtrl['diypage'] as $v){
				if($v['class']==$class && $v['id']==$diypage){
					$this->display($v);
					$display = true;
					break;
				}
			}
		}
		if(!$display){
			foreach($this->arrayCtrl['diypage'] as $v){
				if($v['class'] == $class){
					$this->display($v);
					$display = true;
					break;
				}
			}
		}
	}

	public function display($data)
	{
		global $G;
		$res = $this->structure($data['module']);
		$title = $data['title'];
		if($this->arrayCtrl['cut_bar']){
			extract($this->arrayCtrl['cut_bar']);
		}
		if($this->arrayCtrl['tab_bar']['display']){
			$tbs = $this->module('tab_bar', $this->arrayCtrl['tab_bar']);
			$tabbar = $this->pages(url::upload($tbs['html']));
		}
		$globalname = 'miniprogram.'.substr(md5("miniprogram_global_{$G['language']['id']}"),8,8);
		$filename = 'diypage.'.substr(md5("miniprogram_{$this->theme}_{$data['class']}_{$data['id']}_{$G['language']['id']}"),8,8);
		$css = html::link(cache::setfunc($globalname.'.css', function($css){
				return file_get_contents(ROOT_PATH.$this->path.'common/fontawesome.css').
					file_get_contents(ROOT_PATH.$this->path.'common/global.css').$css;
			}, $tbs['css'], 'css')).
			html::link(cache::set($filename.'.css', $res['css'], 'css')).
			html::link($G['config']['icon'],'shortcut icon',array('type'=>'image/x-icon'));
		$js = html::script(cache::move('jquery-1.10.2.min.js',ROOT_PATH.'/system/extend/ueditor/third-party/jquery-1.10.2.min.js','box',null)).
			html::script(cache::move('swiper.jquery.min.js',ROOT_PATH.'/system/extend/ueditor/third-party/swiper/swiper.jquery.min.js','box',null)).
			html::script(cache::setfunc($globalname.'.js', function($js){
				return file_get_contents(ROOT_PATH.$this->path.'common/global.js').$js;
			}, $tbs['js'], 'js')).
			html::script(cache::set($filename.'.js', $res['js'], 'js'));
		$html = $this->pages(url::upload($res['html']));
		require compile::cache(ROOT_PATH.$this->path.'common/view.html');
	}

	public function pages($url)
	{
		global $G;
		$link = url::param($G['path']['site'].$G['path']['resource'],'theme',$this->theme);
		if($G['view']){
			$link = url::param($link,'view','true');
		}
		$url = str_replace('url="/pages/home/home"','href="'.$link.'"',$url);
		$url = preg_replace('/url="\/pages\/page\/page\?diypage=(\d+)"/','href="'.url::param(url::param($link,'class','page'),'diypage','\\1').'"',$url);
		foreach(array('news','product','image','download') as $v){
			$url = preg_replace('/url="\/pages\/'.$v.'\/'.$v.'\?items=(\d+)"/','href="'.url::param(url::param($link,'class',$v),'items','\\1').'"',$url);
			$url = preg_replace('/url="\/pages\/'.$v.'_detail\/'.$v.'_detail\?id=(\d+)"/','href="'.url::param(url::param($link,'class',$v.'_detail'),'id','\\1').'"',$url);
			$url = str_replace('url="/pages/'.$v.'_detail/'.$v.'_detail?id={{id}}"','href="'.url::param(url::param($link,'class',$v.'_detail'),'id','{{id}}').'"',$url);
		}
		$url = str_replace('url="/pages/{{class}}_detail/{{class}}_detail?id={{id}}"','href="'.url::param(url::param($link,'class','{{class}}_detail'),'id','{{id}}').'"',$url);
		return $url;
	}

	public function structure($module)
	{
		$html = '';
		$css = '';
		$js = '';
		foreach($module as $v){
			if($v['param']['display_reset']){
				$res = $this->module($v['type'], $v['param']);
				$html .= $res['html']."\n";
				$css .= $res['css']."\n";
				$js .= $res['js']."\n";
			}
		}
		return array(
			'html' => $html,
			'css' => $css,
			'js' => $js
		);
	}

	public function module($type, $param)
	{
		global $G;
		$path = ROOT_PATH.$this->path.'module/'."{$type}/";
		if(is_dir($path)){
			$id = $G['get']['id'];
			$class = $G['get']['class'];
			if(preg_match('/^\w+_detail$/',$class) && is_numeric($id)){
				$table = str_replace('_detail','',$class);
				$G['group'] = into::load_class('extend','miniprogram','miniprogram','new')->group_one($id, $G['pass']['type'][$table]);
			}
			$theme = $this->theme;
			extract($param);
			ob_start();
			$cache = compile::cache($path.$type.'.html');
			require $cache;
			$htmls = ob_get_contents();
			ob_end_clean();
			return array(
				'html' => $htmls,
				'css' => file_get_contents($path.$type.'.css'),
				'js' => file_get_contents($path.$type.'.js')
			);
		}
		
	}
}
?>