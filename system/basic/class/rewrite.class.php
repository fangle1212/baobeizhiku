<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

class rewrite
{
	public static function rule()
	{
		global $G;
		$G['config'] = arrOption(mysql::select_all('name,value','config',"name LIKE 'rule%' AND parent='0' AND type='0' AND lang='0'"));
		$G['language'] = mysql::select_one('*','language',"defaults='1' AND display='1'");
		$rule = false;
		$ruleall = self::json();
		if($G['path']['quest']){
			parse_str($G['path']['quest'],$get);
			$G['get'] = strFilter($get);
		}
		foreach($ruleall as $k=>$v){
			$G['rp'] = array();
			$reg = preg_replace_callback(
				'/\[\w+\]/',
				function($match){
					if($match[0]){
						$m = preg_replace('/^\[|\]$/','',$match[0]);
						global $G;
						static $i;
						$i++;
						$G['rp'][$m] = $i;
						if(preg_match('/^(folder|static|tag)$/',$m)){
							return '([a-zA-Z0-9_^\x00-\xff]+)';
						}else if(preg_match('/^(lang|action|area)$/',$m)){
							return '([a-zA-Z0-9]+?)';
						}else if(preg_match('/^(items|id|pages)$/',$m)){
							return '([0-9]+?)';
						}else{
							return '(.+?)';
						}
					}
				},
				regFilter($v,'[]')
			);
			preg_match('/^'.$reg.'$/',$G['path']['resource'],$match);
			if($match[0]){
				$m = strFilter($match);
				if(preg_match('/^area/',$k)){
					$zq = $m[$G['rp']['area']];
					if(mysql::total('area',"sign='{$zq}'")){
						$G['get']['zq'] = $zq;
						$k = preg_replace('/^area/','',$k);
						if($k==24) $k=2;
						if($k==11) $k=1;
					}
				}
				switch($k){
					case 1:
						$rule = self::rule1();
						break;
					case 10:
						$rule = self::rule10($m[$G['rp']['lang']]);
						break;
					case 2:
						$rule = self::rule2($m[$G['rp']['folder']]);
						break;
					case 20:
						$rule = self::rule20($m[$G['rp']['folder']], $m[$G['rp']['lang']]);
						break;
					case 21:
						$rule = self::rule21($m[$G['rp']['folder']], $m[$G['rp']['pages']]);
						break;
					case 22:
						$rule = self::rule22($m[$G['rp']['folder']], $m[$G['rp']['lang']], $m[$G['rp']['pages']]);
						break;
					case 23:
						$rule = self::rule23($m[$G['rp']['folder']], $m[$G['rp']['pages']]);
						break;
					case 3:
						$rule = self::rule3($m[$G['rp']['folder']], $m[$G['rp']['items']]);
						break;
					case 30:
						$rule = self::rule30($m[$G['rp']['folder']], $m[$G['rp']['items']], $m[$G['rp']['lang']]);
						break;
					case 4:
						$rule = self::rule4($m[$G['rp']['folder']], $m[$G['rp']['items']]);
						break;
					case 40:
						$rule = self::rule40($m[$G['rp']['folder']], $m[$G['rp']['items']], $m[$G['rp']['lang']]);
						break;
					case 41:
						$rule = self::rule41($m[$G['rp']['folder']], $m[$G['rp']['items']], $m[$G['rp']['pages']]);
						break;
					case 42:
						$rule = self::rule42($m[$G['rp']['folder']], $m[$G['rp']['items']], $m[$G['rp']['lang']], $m[$G['rp']['pages']]);
						break;
					case 5:
						$rule = self::rule5($m[$G['rp']['folder']], $m[$G['rp']['id']]);
						break;
					case 50:
						$rule = self::rule50($m[$G['rp']['folder']], $m[$G['rp']['id']], $m[$G['rp']['lang']]);
						break;
					case 6:
						$rule = self::rule6($m[$G['rp']['folder']], $m[$G['rp']['tag']]);
						break;
					case 60:
						$rule = self::rule60($m[$G['rp']['folder']], $m[$G['rp']['tag']], $m[$G['rp']['lang']]);
						break;
					case 61:
						$rule = self::rule61($m[$G['rp']['folder']], $m[$G['rp']['tag']], $m[$G['rp']['pages']]);
						break;
					case 62:
						$rule = self::rule62($m[$G['rp']['folder']], $m[$G['rp']['tag']], $m[$G['rp']['lang']], $m[$G['rp']['pages']]);
						break;
					case 7:
						$rule = self::rule7($m[$G['rp']['folder']], $m[$G['rp']['static']]);
						break;
					case 70:
						$rule = self::rule70($m[$G['rp']['folder']], $m[$G['rp']['static']], $m[$G['rp']['lang']]);
						break;
					case 71:
						$rule = self::rule71($m[$G['rp']['folder']], $m[$G['rp']['static']], $m[$G['rp']['pages']]);
						break;
					case 72:
						$rule = self::rule72($m[$G['rp']['folder']], $m[$G['rp']['static']], $m[$G['rp']['lang']], $m[$G['rp']['pages']]);
						break;
					case 8:
						$rule = self::rule8($m[$G['rp']['folder']], $m[$G['rp']['action']]);
						break;
					case 80:
						$rule = self::rule80($m[$G['rp']['folder']], $m[$G['rp']['action']], $m[$G['rp']['lang']]);
						break;
				}
				if($rule){
					break;
				}
			}
		}
		unset($G['rp']);
		if(mysql::total('config',"name='rewrite_open' AND value='1' AND parent='0' AND type='0' AND lang='{$G['get']['lang']}'")){
			return $rule;
		}
	}
	
	public static function json()
	{
		global $G;
		if(is_file(ROOT_PATH.'cache/rule.json')){
			$ruleall = json::get(ROOT_PATH.'cache/rule.json');
		}else{
			$ruleall = array();
			if($G['config']['rule']){
				$rules = json::decode($G['config']['rule']);
			}else{
				into::basic_json('rule');
				$rules = json::decode($G['rule']);
			}
			foreach($rules as $k=>$v){
				if($k==2){
					$ruleall[$k.'3'] = preg_replace('/[^\/]+$/','',$v). preg_replace('/^[^\w\[]+/','',$G['config']['rule_pages']). $G['config']['rule_extension'];
				}
				if(preg_match('/^(2|4|6|7)$/',$k)){
					$ruleall[$k.'2'] = $v.$G['config']['rule_lang'].$G['config']['rule_pages'].$G['config']['rule_extension'];
					$ruleall[$k.'1'] = $v.$G['config']['rule_pages'].$G['config']['rule_extension'];
				}
				$ruleall[$k.'0'] = $v.$G['config']['rule_lang'].$G['config']['rule_extension'];
				$ruleall[$k] = $v.($k==6?'':$G['config']['rule_extension']);
			}
			if(mysql::total('config',"name='area_open' AND value='1' AND parent='0' AND type='0' AND lang=lang") && mysql::total('config',"name='area_link_type' AND value='0' AND parent='0' AND type='0' AND lang=lang")){
				$config = arrOption(mysql::select_all('name,value','config',"name LIKE 'area_rule%' AND parent='0' AND type='0' AND lang='0'"));
				$rall = array();
				foreach($ruleall as $k=>$v){
					if($k==10){
						$rall['area'.'11'] = $config['area_rule_home'].'/';
					}
					if($k==23){
						$rall['area'.'24'] = $config['area_rule_folder'].'/';
					}
					if(preg_match('/^(1|10)$/',$k)){
						$rall['area'.$k] = $config['area_rule_home'].'/'.$v;
					}else{
						$rall['area'.$k] = str_replace('[folder]',$config['area_rule_folder'],$v);
					}
				}
				$ruleall = $rall+$ruleall;
			}
			json::put(ROOT_PATH.'cache/rule.json',$ruleall);
		}
		return $ruleall;
	}
	
	
	public static function rule1()
	{
		global $G;
		return self::rule10($G['language']['id']);
	}
	public static function rule10($lang)
	{
		global $G;
		if($lang = self::lang($lang)){
			$G['get']['lang'] = $lang;
			$G['path']['home'] = true;
			$G['path']['folder'] = '';
			return true;
		}
	}
	
	public static function rule2($folder)
	{
		global $G;
		return self::rule20($folder, $G['language']['id']);
	}
	public static function rule20($folder, $lang)
	{
		global $G;
		return self::rule22($folder, $lang, null);
	}
	public static function rule21($folder, $pages)
	{
		global $G;
		return self::rule22($folder, $G['language']['id'], $pages);
	}
	public static function rule22($folder, $lang, $pages)
	{
		global $G;
		if($lang = self::lang($lang)){
			if($folder && $res=mysql::select_one('type','items',"folder='{$folder}' AND display='1' AND lang='{$lang}'")){
				if(!$pages){
					$G['get']['lang'] = $lang;
					$G['path']['home'] = false;
					$G['path']['folder'] = $folder;
					return true;
				}else if(preg_match('/^(2|3|4|5|6|7)$/',$res['type']) && $pages>=1){
					$G['get']['pages'] = $pages;
					$G['get']['lang'] = $lang;
					$G['path']['home'] = false;
					$G['path']['folder'] = $folder;
					return true;
				}
			}
		}
	}
	public static function rule23($folder, $pages)
	{
		global $G;
		return self::rule22($folder, $G['language']['id'], $pages);
	}
	
	public static function rule3($folder, $items)
	{
		global $G;
		return self::rule30($folder, $items, $G['language']['id']);
	}
	public static function rule30($folder, $items, $lang)
	{
		global $G;
		if($lang = self::lang($lang)){
			if($folder && mysql::total('items',"folder='{$folder}' AND id='{$items}' AND FIND_IN_SET(type,'1,6,7,8,10') AND display='1' AND lang='{$lang}'")){
				$G['get']['lang'] = $lang;
				$G['get']['items'] = $items;
				$G['path']['home'] = false;
				$G['path']['folder'] = $folder;
				return true;
			}
		}
	}
	
	public static function rule4($folder, $items)
	{
		global $G;
		return self::rule40($folder, $items, $G['language']['id']);
	}
	public static function rule40($folder, $items, $lang)
	{
		global $G;
		return self::rule42($folder, $items, $lang, null);
	}
	public static function rule41($folder, $items, $pages)
	{
		global $G;
		return self::rule42($folder, $items, $G['language']['id'], $pages);
	}
	public static function rule42($folder, $items, $lang, $pages)
	{
		global $G;
		if($lang = self::lang($lang)){
			if(mysql::total('items',"folder='{$folder}' AND id='{$items}' AND FIND_IN_SET(type,'2,3,4,5,6,7') AND display='1' AND lang='{$lang}'")){
				if(!$pages){
					$G['get']['lang'] = $lang;
					$G['get']['items'] = $items;
					$G['path']['home'] = false;
					$G['path']['folder'] = $folder;
					return true;
				}else if($pages>=1){
					$G['get']['pages'] = $pages;
					$G['get']['lang'] = $lang;
					$G['get']['items'] = $items;
					$G['path']['home'] = false;
					$G['path']['folder'] = $folder;
					return true;
				}
			}
		}
	}
	
	public static function rule5($folder, $id)
	{
		global $G;
		return self::rule50($folder, $id, $G['language']['id']);
	}
	public static function rule50($folder, $id, $lang)
	{
		global $G;
		if($lang = self::lang($lang)){
			if($folder && $res=mysql::select_one('type','items',"folder='{$folder}' AND FIND_IN_SET(type,'2,3,4,5') AND display='1' AND lang='{$lang}'")){
				if($id && mysql::total(array_search($res['type'],$G['pass']['type']),"id='{$id}' AND display='1' AND lang='{$lang}'")){
					$G['get']['lang'] = $lang;
					$G['get']['id'] = $id;
					$G['path']['home'] = false;
					$G['path']['folder'] = $folder;
					return true;
				}
			}
		}
	}
	
	public static function rule6($folder, $tag)
	{
		global $G;
		return self::rule60($folder, $tag, $G['language']['id']);
	}
	public static function rule60($folder, $tag, $lang)
	{
		global $G;
		return self::rule62($folder, $tag, $lang, null);
		
	}
	public static function rule61($folder, $tag, $pages)
	{
		global $G;
		return self::rule62($folder, $tag, $G['language']['id'], $pages);
		
	}
	public static function rule62($folder, $tag, $lang, $pages)
	{
		global $G;
		if($lang = self::lang($lang)){
			if($folder && mysql::total('items',"folder='{$folder}' AND FIND_IN_SET(type,'2,3,4,5') AND display='1' AND lang='{$lang}'")){
				if(!$pages){
					$G['get']['lang'] = $lang;
					$G['get']['tag'] = $tag;
					$G['path']['home'] = false;
					$G['path']['folder'] = $folder;
					return true;
				}else if($pages>=1){
					$G['get']['pages'] = $pages;
					$G['get']['lang'] = $lang;
					$G['get']['tag'] = $tag;
					$G['path']['home'] = false;
					$G['path']['folder'] = $folder;
					return true;
				}
			}
		}
	}
	
	public static function rule7($folder, $static)
	{
		global $G;
		return self::rule70($folder, $static, $G['language']['id']);
	}
	public static function rule70($folder, $static, $lang)
	{
		global $G;
		return self::rule72($folder, $static, $lang, null);
		
	}
	public static function rule71($folder, $static, $pages)
	{
		global $G;
		return self::rule72($folder, $static, $G['language']['id'], $pages);
		
	}
	public static function rule72($folder, $static, $lang, $pages)
	{
		global $G;
		if($lang = self::lang($lang)){
			if($res=mysql::select_one('id,type','items',"folder='{$folder}' AND static='{$static}' AND display='1' AND lang='{$lang}'")){
				if(!$pages){
					$G['get']['lang'] = $lang;
					$G['get']['items'] = $res['id'];
					$G['path']['home'] = false;
					$G['path']['folder'] = $folder;
					return true;
				}else if(preg_match('/^(2|3|4|5|6|7)$/',$res['type']) && $pages>=1){
					$G['get']['pages'] = $pages;
					$G['get']['lang'] = $lang;
					$G['get']['items'] = $res['id'];
					$G['path']['home'] = false;
					$G['path']['folder'] = $folder;
					return true;
				}
			}else if(!$pages && $res=mysql::select_one('type','items',"folder='{$folder}' AND FIND_IN_SET(type,'2,3,4,5') AND display='1' AND lang='{$lang}'")){
				if($r=mysql::select_one('id,items',array_search($res['type'],$G['pass']['type']),"static='{$static}' AND display='1' AND lang='{$lang}'")){
					$G['get']['lang'] = $lang;
					$G['get']['id'] = $r['id'];
					$G['get']['items'] = $r['items'];
					$G['path']['home'] = false;
					$G['path']['folder'] = $folder;
					return true;
				}
			}
		}
	}
	
	public static function rule8($folder, $action)
	{
		global $G;
		return self::rule80($folder, $action, $G['language']['id']);
	}
	public static function rule80($folder, $action, $lang)
	{
		global $G;
		if($lang = self::lang($lang)){
			if($folder && mysql::total('items',"folder='{$folder}' AND type='11' AND display='1' AND lang='{$lang}'")){
				$G['get']['lang'] = $lang;
				$G['get']['action'] = $action;
				$G['path']['home'] = false;
				$G['path']['folder'] = $folder;
				return true;
			}
		}
	}
	
	public static function lang($lang)
	{
		global $G;
		if($G['language']['id']==$lang){
			return $G['language']['id'];
		}else{
			$res = mysql::select_one('id','language',(is_numeric($lang)?"id='{$lang}'":"sign='{$lang}'")." AND display='1'");
			return $res?$res['id']:false;
		}
	}
}
?>