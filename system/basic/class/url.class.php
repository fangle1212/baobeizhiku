<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

class url
{
	public static $domain=false;
	
	public static function replace($url)
	{
		return rtrim(rtrim(str_replace('?&','?',str_replace('&&','&',$url)),'?'),'&');
	}
	
	public static function relative($domain=null)
	{
		global $G;
		if(!isset($domain)){
			$domain = self::$domain;
		}
		$url = $domain===''?'':($domain?$domain:$G['path']['relative']);
		return $url;
	}
	
	public static function items($data, $lang=null, $view=null, $area=null, $rule=true)
	{
		global $G;
		if($data['type']==9){
			return $data['link'];
		}else if($data['issub']){
			if($res = mysql::select_one('*','items',"parent='{$data['id']}' AND display='1'",'sort DESC,id ASC')){
				return self::items($res, $lang, $view, $area, $rule);
			}else{
				return '';
			}
		}else{
			$url = '';
			if($data['id']==88888){
				if(!$G['view'] && !$view && $G['config']['rewrite_open'.$lang] && isset($rule)){
					$url .= '?ruletype=1';
				}
			}else{
				$res = mysql::select_one('id,type','items',"folder='{$data['folder']}'",'level ASC,id ASC');
				if(!$G['view'] && !$view && $G['config']['rewrite_open'.$lang] && isset($rule)){
					if($data['static']){
						$url .= '?ruletype=7&folder='.$data['folder'].'&static='.urlencode($data['static']);
					}else if($data['id']!=$res['id']){
						$url .= '?ruletype='.(preg_match('/^(2|3|4|5)$/',$data['type'])?4:($data['type']==11?8:3)).'&folder='.$data['folder'].'&items='.$data['id'];
					}else{
						$url .= '?ruletype=2&folder='.$data['folder'];
					}
				}else if($data['id']!=$res['id']){
					$url .= $data['folder'].'/?items='.$data['id'];
				}else{
					$url .= $data['folder'].'/';
				}
			}
			$url = self::lang($url, $lang);
			$url = self::view($url, $view);
			$url = self::area($url, $area, $lang, $rule);
			return $url;
		}
	}
	
	public static function home($lang=null, $view=null, $area=null, $rule=true)
	{
		global $G;
		return self::items(array('id'=>88888), $lang, $view, $area, $rule);
	}
	
	public static function member($folder=null, $action=null, $lang=null, $view=null, $area=null, $rule=true)
	{
		global $G;
		if(!isset($folder)){
			if($res = mysql::select_one('folder','items',"type='11'")){
				$folder = $res['folder'];
			}
		}
		$url = '';
		if(!$G['view'] && !$view && $G['config']['rewrite_open'.$lang] && isset($rule) && $folder!='api/member' && preg_match('/^(login|register)$/',$action)){
			$url .= '?ruletype=8&folder='.$folder.'&action='.$action;
		}else{
			$url .= $folder.'/'.($action?'?action='.$action:'');
		}
		$url = self::lang($url, $lang);
		$url = self::view($url, $view);
		$url = self::area($url, $area, $lang, $rule);
		return $url;
	}
	
	public static function tag($folder, $data, $lang=null, $view=null, $area=null, $rule=true)
	{
		global $G;
		$tag = $data['name']?$data['name']:$data['id'];
		$url = '';
		if(!$G['view'] && !$view && $G['config']['rewrite_open'.$lang] && isset($rule)){
			$url .= '?ruletype=6&folder='.$folder.'&tag='.$tag;
		}else{
			$url .= $folder.'/?tag='.$tag;
		}
		$url = self::lang($url, $lang);
		$url = self::view($url, $view);
		$url = self::area($url, $area, $lang, $rule);
		return $url;
	}
	
	public static function group($folder, $data, $lang=null, $view=null, $area=null, $rule=true)
	{
		global $G;
		if($data['link']){
			return $data['link'];
		}
		if(!isset($folder)){
			if($res = mysql::select_one('folder','items',"id='{$data['items']}'")){
				$folder = $res['folder'];
			}
		}
		$url = '';
		if(!$G['view'] && !$view && $G['config']['rewrite_open'.$lang] && isset($rule)){
			if($data['static']){
				$url .= '?ruletype=7&folder='.$folder.'&static='.urldecode($data['static']);
			}else{
				$url .= '?ruletype=5&folder='.$folder.'&id='.$data['id'];
			}
		}else{
			$url .= $folder.'/?id='.$data['id'];
		}
		$url = self::lang($url, $lang);
		$url = self::view($url, $view);
		$url = self::area($url, $area, $lang, $rule);
		return $url;
	}
	
	public static function area($url, $area=null, $lang=null, $rule=true)
	{
		global $G;
		if(!isset($area)){
			$area = $G['area'];
		}
		if($G['config']['area_link_type'.$lang]){
			if($area){
				if($G['config']['area_detail_open'.$lang] || !(preg_match('/ruletype\=(5|7)&/',$url) || preg_match('/\/\?id\=\d+/',$url))){
					if($area['id'] != $G['area']['id']){
						$dn = parse_url($G['config']['domain'.$lang]);
						$scheme = $G['config']['area_link_scheme'.$lang]?$G['config']['area_link_scheme'.$lang]:'http';
						$domain = $scheme.'://'.($area['prefix']?$area['prefix']:$area['sign']).'.'.preg_replace('/^www\./','',$dn['host']).$dn['path'];
					}
				}else{
					$domain = $G['config']['domain'.$lang];
				}
			}
			$url = self::rule($url, $lang, $rule, $domain);
		}else{
			$url = self::param($url, 'zq', $area?$area['sign']:null, false);
			$url = self::rule($url, $lang, $rule);
		}
		return $url;
	}
	
	public static function pages($url, $number, $name='pages', $rule=true, $domain=null)
	{
		global $G;
		if(strstr($url,'?')){
			if(strstr($url,"?{$name}=")){
				$url = preg_replace("/\?{$name}\=\d*/is",'',$url);
				if($number>1){
					$url = $url."?{$name}=".$number;
				}
			}else{				
				$url = preg_replace("/\&{$name}\=\d*/is",'',$url);
				if($number>1){
					$url = $url."&{$name}=".$number;
				}
			}
		}else{
			if($number>1){
				$url = $url."?{$name}=".$number;
			}
		}
		if($name=='pages'){
			$url = self::rule($url, $lang, $rule, $domain);
		}
		return $url;
	}
	
	public static function lang($url, $lang=null)
	{
		global $G;
		if(isset($lang)){
			$url = self::param($url, 'lang', mysql::total('language',"id='{$lang}' AND defaults='1' AND display='1'")?null:$lang);
		}else{
			if(isset($G['get']['lang'])){
				if(!$G['view'] && $G['language']['defaults']){
					$url = self::param($url, 'lang', null);
				}else{
					$url = self::param($url, 'lang', $G['language']['id']);
				}
			}
		}
		return $url;
	}
	
	public static function rule($url, $lang=null, $rule=true, $domain=null)
	{
		global $G;
		if($rule){
			preg_match('/^([^\?]*?)\?(.+)$/',$url,$match);
			if($match[2]){
				parse_str($match[2],$param);
				if(is_numeric($param['ruletype'])){
					if($G['config']['rule']){
						$rules = json::decode($G['config']['rule']);
					}else{
						into::basic_json('rule');
						$rules = json::decode($G['rule']);
					}
					if($param['zq'] && !$G['config']['area_link_type'.$lang] && ($G['config']['area_detail_open'.$lang] || !preg_match('/^(5|7)$/',$param['ruletype']))){
						if(preg_match('/^(1|10)$/',$param['ruletype'])){
							$url = $match[1].$G['config']['area_rule_home'.$lang].'/'.$rules[$param['ruletype']];
						}else {
							$url = $match[1].str_replace('[folder]',$G['config']['area_rule_folder'.$lang],$rules[$param['ruletype']]);
						}
					}else{
						$url = $match[1].$rules[$param['ruletype']];
					}
					$rule_pages = $G['config']['rule_pages'];
					$rule_extension = $G['config']['rule_extension'];
					if(isset($param['lang'])){
						if($G['config']['rule_lang_sign']){
							$res = mysql::select_one('sign','language',"id='{$param['lang']}'");
							$param['lang'] = $res['sign'];
						}
						$url .= $G['config']['rule_lang'];
					}else if(preg_match('/^(1|2)$/',$param['ruletype']) && !$G['config']['rule_filename']){
						$url = preg_replace('/[^\/]+$/','',$url);
						$rule_pages = preg_replace('/^[^\w\[]+/','',$rule_pages);
						if(!isset($param['pages'])){
							$rule_extension = '';
						}
					}
					if(isset($param['pages'])){
						$url .= $rule_pages;
					}
					if($rule_extension && !($param['ruletype']==6 && !isset($param['lang']) && !isset($param['pages']))){
						$url .= $rule_extension;
					}
					$param['area'] = $param['zq'];
					foreach($param as $k=>$v){
						$url = str_replace("[{$k}]",$v,$url);
					}
				}
			}
			$url = self::relative($domain).$url;
			$url = (preg_match('/^\?/',$url)||!$url?'./':'').$url;
		}
		return $url;
	}
	
	public static function view($url, $view=true)
	{
		global $G;
		if((isset($view) && $view) || (!isset($view) && $G['view'])){
			$url = self::param($url, 'view', 'true');
			$url = strReplace('/?', '/index.php?', $url, 1);
		}else{
			$url = self::param($url, 'view', null);
		}
		$url = self::replace($url);
		return $url;
	}
	
	public static function param($url, $name, $value, $site=true)
	{
		global $G;
		if(!isset($url)){
			$url = $G['path']['link'];
		}
		if(strstr($url,'?')){
			preg_match("/(?:\?|&){$name}(?==|&|$)*/", $url, $match);
			if($match){
				if(isset($value)){
					$url = preg_replace("/((?:\?|&){$name})(?==|&|$)[^&]*/", "\\1".(($value==='')?'':"={$value}"), $url);
				}else{
					$url = preg_replace("/(\?|&){$name}(?==|&|$)[^&]*/", "\\1", $url);
				}
			}else{
				if(isset($value)){
					if($site){
						$url .= "&{$name}".(($value==='')?'':"={$value}");
					}else{
						$url = strReplace('?',"?{$name}".(($value==='')?'':"={$value}").'&',$url,1);
					}
				}
			}	
		}else{
			if(isset($value)){
				$url .= "?{$name}".(($value==='')?'':"={$value}");
			}
		}
		$url = self::replace($url);
		return $url;
	}
	
	
	
	
	
	/**
	 * 判断是否调用oss远程存储地址
	 * B_OSS_CMS
	 * @param strong $url 文件地址
	 * @return strong 返回文件地址
	 */
	public static function oss($url=false){
		global $G;
		return $G['config']['store_type']?$G['config']["store_domain"]:($url?$url:self::relative());
	}
	
	/**
	 * 判断文件地址域名还是相对域名
	 * boss_cms
	 * @param strong $url 文件地址
	 * @param strong $type 操作类型  sub：替换为域名或相对路径  del：删除替换标签
	 * @return strong 返回文件地址
	 */
	public static function upload($url='..//upload/', $type='sub', $param=false){
		global $G;
		switch($type){
			case 'sub':
				$str = self::oss($param).'upload/';
			break;
			case 'del':
				$str = 'upload/';
			break;
			default:
				$str = dir::replace($type.'/upload/');
			break;
		}
		return str_replace('..//upload/', $str, $url);
	}
		
	/**
	 * 系统带参数跳转
	 *
	 * @param strong $mold 模块
	 * @param strong $part 文件名及类名
	 * @param strong $func 方法名
	 * @param array  $param 网址更多参数的数组
	 * @return strong 返回后台地址
	 */
	public static function mpf($mold, $part, $func, $param=array()){
		global $G;
		$url = "?mold={$mold}&part={$part}&func={$func}";
		$keyword = array(
			'navs','navs0','navs1','column','lang',
			'id','name','parent','items','type',
			'model','series','extent','tname',
			'core','eid','area',
			'did','dtable','dname','dstyle','djson');
		foreach($keyword as $v){
			if(!array_key_exists($v, $param)){
				$param[$v] = arrExist($G,"get|{$v}");
			}
		}
		ksort($param);
		foreach($param as $k=>$v){
			$url = self::param($url, $k, $v);
		}
		$url = self::lang($url);
		$url = self::replace($url);
		$url = str_replace('\"','\&quot;',$url);
		$url = str_replace("\'",'\&apos;',$url);
		return $url;
	}
	
	/**
	 * 系统跳转到404页面
	 *
	 * @param bool $jump 是否进行301跳转
	 * @return strong|301 返回地址或301跳转
	 */
	public static function page404($jump=true){
		global $G;
		$url = $G['path']['relative'].'404.html';
		if($jump){
			location($url,301);
		}else{
			return $url;
		}
	}
}
?>