<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
into::basic_class('web');

class items extends web
{
	public function init()
	{
		global $G;
		if($G['area'] = $this->area()){
			$G['home'] = page::items_one(88888);
		}
		$G['items'] = $this->column();
		$G['tag'] = $this->tag();
		if(!isset($G['theme']['path'])){
			$G['theme']['path'] = $this->type($G['items']['type']);
		}
		echo $this->theme($G['theme']['path']);
	}
	
	public function area()
	{
		global $G;
		$area = null;
		$zq = arrExist($G,'get|zq');
		if($G['config']['area_open']){
			if($G['config']['area_link_type']){
				$prefix = str_replace('.'.preg_replace('/^www\./','',arrExist(parse_url($G['config']['domain']),'host')),'',$G['path']['host']);
				if(preg_match('/^[\w\-]+$/',$prefix) && ($res=page::area_one(null,'*',"(prefix='{$prefix}' OR sign='{$prefix}')"))){
					$area = $res;
				}
			}else{
				if($zq && ($res=page::area_one($zq))){
					$area = $res;
				}
			}
		}else if($zq){
			url::page404();
		}
		return $area;
	}
	
	public function tag()
	{
		global $G;
		$tag = null;
		if($t = arrExist($G,'get|tag')){
			if($res = page::tag_name($t)){
				$tag = $res;
			}
		}
		return $tag;
	}
	
	public function column()
	{
		global $G;
		if($G['path']['home']){
			$items = $G['home'];
		}else{
			$items = page::items_one(arrExist($G,'get|items'), '*', "folder='{$G['path']['folder']}'", "level ASC,id ASC");
		}
		if($items){
			$items['parents'] = /* 该栏目的父级 */
			$items['max'] = /* 最大的父级栏目id（不考虑类型和模板主题风格） */
			$items['max_parent'] = /* 最大的拥有同样类型的父级栏目id */
			$items['max_parents'] =  /* 最大的拥有同样类型且模板主题风格一样的父级栏目id */
			$items['id'];
			if($items['parent']){
				$items['parent_list'] = page::items('-'.$items['parent']);
				if($items['parent_list']){
					$items['parents'] = $items['parent'];
					$max_parent = $max_parents = true;
					foreach($items['parent_list'] as $k=>$v){
						if($max_parents && $v['type']==$items['type'] && $v['theme']==$items['theme']){
							$items['max_parents'] = $v['id'];
						}else{
							$max_parents = false;
						}
						if($max_parent && $v['type']==$items['type']){
							$items['max_parent'] = $v['id'];
						}else{
							$max_parent = false;
						}
						$items['max'] = $v['id'];
					}
				}
			}
			$items['children'] = mysql::total('items',"parent='{$items['id']}' AND display='1'");
			$data = page::config_option($items['id'],0);
			if($data){
				$G['config'] = array_merge($data, $G['config']);
			}
		}else{
			url::page404();
		}
		return $items;
	}
	
	public function type($number)
	{
		global $G;
		$table = array_search($number,$G['pass']['type']);
		$name = '';
		if(preg_match('/^(0|10)$/',$number)){
			$name = $G['items']['theme']?$G['items']['theme']:$table.'.html';
		}else if(preg_match('/^(2|3|4|5)$/',$number)){	
			if(isset($G['get']['id'])){
				if($G['group'] = page::group_one($G['get']['id'],$G['items']['type'])){
					if($G['group']['items']!=$G['items']['id'] && mysql::total('items',"id='{$G['group']['items']}'")){
						$G['get']['items'] = $G['group']['items'];
						$G['items'] = $this->column();
						$G['group'] = page::group_one($G['group']['id'],$G['items']['type']);
					}
				}else{
					url::page404();
				}
			}
			if(isset($G['group'])){
				if($G['area'] && !$G['config']['area_detail_open']){
					url::page404();
				}
				if($G['group']['theme']){
					$name = $table.'_detail/'.$G['group']['theme'];
				}else{
					$name = $table.'_detail/'.($G['items']['themes']?$G['items']['themes']:$table.'_detail.html');
				}
			}else{
				$name = $table.'/'.($G['items']['theme']?$G['items']['theme']:$table.'.html');
				if($tag = arrExist($G,'get|tag')){
					$G['groups'] = page::group_tag($tag,$G['items']['type']);
				}else{
					$G['groups'] = page::group_list($G['items']['id']);
				}
			}
		}else if(preg_match('/^(1|6|7|8)$/',$number)){	
			if($number==7){
				if(arrExist($G['config'],'search_open')){
					$G['keyword'] = $keyword = arrExist($G,"get|{$G['config']['search_keyword']}");
					if(isset($keyword) && $keyword!==''){
						$G['config']['search_null'] = str_replace('[keyword]','[<strong>'.stripslashes($keyword).'</strong>]',$G['config']['search_null']);
						if($G['config']['search_record']){
							$ip = getIP();
							$time = TIME;
							if($sear = mysql::select_one('id','search',"parent='{$G['items']['id']}' AND keyword='{$keyword}' AND ip='{$ip}' AND ctime>{$time}-3600")){
								mysql::update(array('ctime'=>$time),'search',"id='{$sear['id']}'");
							}else{
								mysql::insert(array('parent'=>$G['items']['id'],'keyword'=>$keyword,'ip'=>$ip,'ctime'=>$time),'search');
							}
						}
					}
				}else{
					url::page404();
				}
			}
			$name = $table.'/'.($G['items']['theme']?$G['items']['theme']:$table.'.html');
		}else if($number==11){
			if(arrExist($G['config'],'member_open')){
				$action = arrExist($G['get'],'action');
				if($action == 'login'){
					$name = 'member/login.html';
				}else if($action == 'register'){
					$name = 'member/register.html';
				}else{
					if($G['member']){
						$name = 'member/home.html';
					}else{
						session::clear('member');
						location(url::member($G['items']['folder'],'login'));
					}
				}
			}else{
				url::page404();
			}
		}
		return $name;
	}
}
?>