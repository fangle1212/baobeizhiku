<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('cache');

class compile
{
	public static $html;
	private static $global='get|post|cookie|home|path|language|config|theme|items|group|groups|member|website';
	
	public static function cache($file)
	{
		global $G;
		$dir = 'compile';
		$name = md5($file);
		$path = cache::get($name, false, $dir);
		if($G['view'] || !is_file($path)){
			cache::remove($name, $dir);
			self::replace($file);
			dir::create($path, self::$html);
		}
		return $path;
	}
	
	public static function replace($file)
	{
		global $php;
		$php = array();
		self::$html = file_get_contents($file);
		
		self::_php();
		self::_include();

		self::$html = preg_replace('/(?<!\?)\?\?\?}/','end'.P.'over',
			preg_replace_callback(
				'/<\?php[\S\s]+?\?>|{nophp}[\S\s]+?{\/nophp}/',
				function($match){
					global $php;
					static $i;
					$i++;
					$str = 'php'.$i.P;
					$php[$str] = $match[0];
					return $str;
				},
				self::$html
			)
		);
		
		if(preg_match('/\.html$/',$file)){
			self::_add();
		}
		
		self::_items();
		self::_banner();
		self::_language();
		self::_feedback();
		self::_complex();
		self::_consult();
		self::_layers();
		self::_assign();
		self::_search();
		self::_group();
		self::_param();
		self::_pages();
		self::_link();
		self::_menu();
		self::_area();
		self::_form();
		self::_both();
		self::_tag();
		self::_register();
		self::_login();

		self::_if();
		self::_for();
		self::_foreach();
		self::_assign();
		self::_var();

		self::$html = arrReplace($php,self::$html);
		self::_nophp();
		
		self::$html = str_replace('end'.P.'over','???}',preg_replace('/(<\?php[\S\s]+?)end'.P.'over([\S\s]+\?>)/','\\1}\\2',self::$html));
	}
	
	/**
	 * 添加编辑模式标签
	 */
	public static function _add()
	{
		global $G;
		if($G['path']['type']=='web'){
			$json = load::ctrl();
			foreach($json as $core=>$arr){
				if(preg_match('/\$'.$core.'\.\w+/',self::$html)){
					$data = value::get($core, 0, 0);
					foreach($data as $key=>$val){
						$G['_corekey'] = "{\${$core}._{$key}}";
						if(!preg_match('/^_/',$key) && preg_match('/{\$'.$core.'\.'.$key.'[}|\|]/',self::$html) && !strstr(self::$html,$G['_corekey'])){
							preg_match('/etype="(\d+)"/',$data['_'.$key],$style);
							switch($style[1]){
								case 0:
								case 1:
								case 2:
									self::$html = preg_replace_callback(
										'/<(\w+)[^>]*?>(?={\$'.$core.'\.'.$key.'[}|\|])[\S\s]*?<\/\\1\s*>/',
										function($match){
											global $G;
											return preg_replace('/^<(\w+)/','<\\1 '.$G['_corekey'],$match[0]);
										},
										self::$html
									);
									break;
								case 6:
									self::$html = preg_replace_callback(
										'/<img[^>]+?src=["|\']*{\$'.$core.'\.'.$key.'[}|\|]/',
										function($match){
											global $G;
											return str_replace('src=',$G['_corekey'].' src=',$match[0]);
										},
										self::$html
									);
									break;
							}
						}
					}
				}
			}
			$common = array('home','language','config','items','group');
			foreach($common as $global){
				foreach($G[$global] as $key=>$val){
					$G['_corekey'] = "{{$global}._{$key}}";
					if(!preg_match('/^_/',$key) && preg_match('/{(\$G\.)?'.$global.'\.'.$key.'[}|\|]/',self::$html) && !preg_match("{(\$G\.)?{$global}\._{$key}}",self::$html)){
						preg_match('/dstyle="(\d+)"/',$G[$global]['_'.$key],$style);
						switch($style[1]){
							case 0:
							case 1:
							case 2:
								self::$html = preg_replace_callback(
									'/<(\w+)[^>]*?>(?={(\$G\.)?'.$global.'\.'.$key.'[}|\|])[\S\s]*?<\/\\1\s*>/',
									function($match){
										global $G;
										return preg_replace('/^<(\w+)/','<\\1 '.$G['_corekey'],$match[0]);
									},
									self::$html
								);
								break;
							case 6:
								self::$html = preg_replace_callback(
									'/<img[^>]+?src=["|\']*{(\$G\.)?'.$global.'\.'.$key.'[}|\|]/',
									function($match){
										global $G;
										return str_replace('src=',$G['_corekey'].' src=',$match[0]);
									},
									self::$html
								);
								break;
						}
					}
				}
			}
			$G['_add'] = array();
			for($i=0;$i<10;$i++){
				if($result = preg_replace_callback(
					array(
						'/{(foreach)\s+(?=data=)[^}]+?}(?:(?!{\/foreach})(?!{foreach\s+((?=data=)[^}]+?}))[\s\S])+?{\/foreach}/',
						'/{(items|group|layers|form|area|tag|complex|language|banner|link|param)\s+(?=class=)[^}]+?}(?:(?!{\/\\1})(?!{\\1\s+((?=class=)[^}]+?}))[\s\S])+?{\/\\1}/'
					),
					function($match){
						global $G;
						if($G['_corekey'] = $match[0]){
							$_add = '___'.mt_rand(100000,99999999).P.'____add_____';
							preg_match('/^{[^}]+?(?=value=["|\']?(\$\w+))[^}]+?}/',$G['_corekey'],$matc);
							$v = $matc[1]?$matc[1]:'$v';
							$G['_corekey'] = preg_replace_callback(
								'/<img[^>]+?src=["|\']*{(\\'.$v.'\.\w+)[}|\|][^>]+?>/',
								function($mat){
									global $G;
									$_v = '{'.str_replace('.','._',$mat[1]).'}';
									if(!strstr($G['_corekey'],$_v)){
										$mat[0] = str_replace('<img','<img '.$_v,$mat[0]);
									}
									return $mat[0];
								},
								$G['_corekey']
							);			
							$G['_corekey'] = preg_replace_callback(
								'/<(\w+)[^>]*?>(?={(\\'.$v.'\.\w+)[}|\|])[\S\s]*?<\/\\1\s*>/',
								function($mat){
									global $G;
									$_v = '{'.str_replace('.','._',$mat[2]).'}';
									if(!strstr($G['_corekey'],$_v)){
										$mat[0] = preg_replace('/<\w+/','\\0 '.$_v,$mat[0]);
									}
									return $mat[0];
								},
								$G['_corekey']
							);
							$G['_add'][$_add] = $G['_corekey'];
							return $_add;
						}
					},
					self::$html
				)){
					self::$html = $result;
				}
			}
			self::$html = arrReplace(array_reverse($G['_add']),self::$html);
			unset($G['_add']);
			unset($G['_corekey']);
		}
	}
	
	/**
	 * 载入文件
	 */
	private static function _include()
	{
		self::$html = preg_replace_callback(
			'/{include\s+[^}]+?}/',
			function($match){
				if($str = $match[0]){
					if($val = self::get($str,'theme')){
						return "<?php include(load::theme('{$val}')); ?>";
					}else if($val = self::get($str,'common')){
						return "<?php include(load::common('{$val}')); ?>";
					}else if($val = self::get($str,'file')){
						return "<?php include({$val}); ?>";
					}
				}
			},
			self::$html
		);
	}
	
	/**
	 * 导航栏目
	 */
	private static function _items()
	{	
		self::$html = preg_replace_callback(
			'/{items\s+[^}]+?}/',
			function($match){
				if($str = $match[0]){
					static $i;
					$i++;
					$data = self::get($str,'data',"\$items{$i}");
					$select = self::get($str,'select',"'*'");
					$where = self::get($str,'where','true');
					$order = self::get($str,'order','null');
					switch(self::get($str,'class')){
						case 'list':
							$id = self::get($str,'id');
							$loop = self::get($str,'loop',0);
							return "<?php {$data} = page::items_list( {$id}, {$loop}, {$select}, {$where}, {$order} ); ?>".self::loop($str,$data);
						break;
						case 'head':
							return "<?php {$data} = page::items_head( ); ?>".self::loop($str,$data);
						break;
						case 'foot':
							return "<?php {$data} = page::items_foot( ); ?>".self::loop($str,$data);
						break;
						case 'sub':
							$type = self::get($str,'type','max');
							return "<?php {$data} = page::items_list( \$G['items']['{$type}'], 0, {$select}, {$where}, {$order} ); ?>".self::loop($str,$data);
						break;
						case 'position':
							return "<?php {$data} = page::items_list( -\$G['items']['id'], 99999, {$select}, {$where}, {$order} ); ?>".self::loop($str,$data);
						break;
						case 'one':
							$id = self::get($str,'id');
							$value = self::get($str,'value',"\$v");
							return "<?php {$data} = page::items_one( {$id}, {$select}, {$where}, {$order} ); ?><?php if( {$data} ){ {$value} = {$data}; ?>";
						break;
					}
				}
			},
			self::preg(self::$html, 'items', 'list|head|foot|sub|position')
		);
		self::$html = preg_replace('/{\/items}/',"<?php } ?>",self::$html);
	}
	
	/**
	 * 新闻、产品、图片、下载
	 */
	private static function _group()
	{
		self::$html = preg_replace_callback(
			'/{group\s+[^}]+?}/',
			function($match){
				if($str = $match[0]){
					static $i;
					$i++;
					$data = self::get($str,'data',"\$group{$i}");
					$rows = self::get($str,'rows','null');
					$pages = self::get($str,'pages','null');
					$btns = self::get($str,'btns','null');
					$url = self::get($str,'url','null');
					$name = self::get($str,'pageKey',"'pages'");
					$select = self::get($str,'select',"'*'");
					$where = self::get($str,'where','null');
					$order = self::get($str,'order','null');
					switch(self::get($str,'class')){
						case 'list':
							$items = self::get($str,'items','null');
							return "<?php {$data} = page::group_list( {$items}, {$rows}, {$pages}, {$btns}, {$url}, {$name}, {$select}, {$where}, {$order} ); ?>".self::loop($str,"{$data}['list']");
						break;
						case 'tag':
							$tag = self::get($str,'tag','null');
							$type = self::get($str,'type','null');
							return "<?php {$data} = page::group_tag( {$tag}, {$type}, {$rows}, {$pages}, {$btns}, {$url}, {$name}, {$select}, {$where}, {$order} ); ?>".self::loop($str,"{$data}['list']");
						break;
						case 'type':
							$type = self::get($str,'type');
							return "<?php {$data} = page::group_type( {$type}, {$rows}, {$pages}, {$btns}, {$url}, {$name}, {$select}, {$where}, {$order} ); ?>".self::loop($str,"{$data}['list']");
						break;
						case 'both':
							$id = self::get($str,'id',"\$G['group']['id']");
							$items = self::get($str,'items',"\$G['items']['id']");
							$type = self::get($str,'type','null');
							$number = self::get($str,'number',1);
							return "<?php {$data} = page::group_both( {$id}, {$items}, {$type}, {$number}, {$select}, {$where}, {$order} ); if( {$data} ){ \$prev = {$data}['prev']; \$next = {$data}['next']; ?>";
						break;
						case 'one':
							$id = self::get($str,'id');
							$type = self::get($str,'type');
							$value = self::get($str,'value',"\$v");
							return "<?php {$data} = page::group_one( {$id}, {$type}, {$select}, {$where}, {$order} ); if( {$data}['id'] ){ {$value} = {$data}; ?>";
						break;
					}
				}
			},
			self::preg(self::$html, 'group', 'list|tag|type')
		);
		self::$html = preg_replace('/{\/group}/',"<?php } ?>",self::$html);
	}
	
	/**
	 * 搜索
	 */
	private static function _search()
	{
		self::$html = preg_replace_callback(
			'/{search\s+[^}]+?}/',
			function($match){
				if($str = $match[0]){
					static $i;
					$i++;
					$data = self::get($str,'data',"\$search{$i}");
					$rows = self::get($str,'rows','null');
					$pages = self::get($str,'pages','null');
					$btns = self::get($str,'btns','null');
					$url = self::get($str,'url','null');
					$name = self::get($str,'name',"'pages'");
					$cid = self::get($str,'cid','null');
					switch(self::get($str,'class')){
						case 'html':
							$items = self::get($str,'items');
							$get = self::get($str,'get','true');
							return "<?php {$data} = html::search( {$items}, {$get} ); if( {$items} ){ \$html = {$data}; ?>";
						break;
						case 'list':
							$items = self::get($str,'items',"\$G['items']['id']");
							$keyword = self::get($str,'keyword',"\$G['keyword']");
							return "<?php {$data} = page::search_list( {$items}, {$keyword}, {$rows}, {$pages}, {$btns}, {$url}, {$name} , {$cid} ); ?>".self::loop($str,"{$data}['list']");
						break;
					}
				}
			},
			self::preg(self::$html, 'search', 'html|list')
		);
		self::$html = preg_replace('/{\/search}/',"<?php } ?>",self::$html);
	}
	
	/**
	 * 内容列表
	 */
	private static function _layers()
	{
		self::$html = preg_replace_callback(
			'/{layers\s+[^}]+?}/',
			function($match){
				if($str = $match[0]){
					static $i;
					$i++;
					$data = self::get($str,'data',"\$layers{$i}");
					switch(self::get($str,'class')){
						case 'list':
							$core = self::get($str,'core');
							$series = self::get($str,'series',1);
							$parent = self::get($str,'parent',0);
							$select = self::get($str,'select',"'*'");
							$where = self::get($str,'where','null');
							$order = self::get($str,'order','null');
							return "<?php {$data} = page::layers_list( {$core}, {$series}, {$parent}, {$select}, {$where}, {$order} ); ?>".self::loop($str,$data);
						break;
					}
				}
			},
			self::preg(self::$html, 'layers', 'list')
		);
		self::$html = preg_replace('/{\/layers}/',"<?php } ?>",self::$html);
	}
	
	/**
	 * 反馈表单
	 */
	private static function _form()
	{
		self::$html = preg_replace_callback(
			'/{form\s+[^}]+?}/',
			function($match){
				if($str = $match[0]){
					static $i;
					$i++;
					$data = self::get($str,'data',"\$form{$i}");
					switch(self::get($str,'class')){
						case 'list':
							$id = self::get($str,'id');
							$where = self::get($str,'where','null');
							$order = self::get($str,'order','null');
							return "<?php {$data} = page::form( {$id}, {$where}, {$order} ); ?>".self::loop($str,"{$data}");
						break;
					}
				}
			},
			self::preg(self::$html, 'form', 'list')
		);
		self::$html = preg_replace('/{\/form}/',"<?php } ?>",self::$html);
	}
	
	/**
	 * 城市分站
	 */
	private static function _area()
	{
		self::$html = preg_replace_callback(
			'/{area\s+[^}]+?}/',
			function($match){
				if($str = $match[0]){
					static $i;
					$i++;
					$data = self::get($str,'data',"\$area{$i}");
					$select = self::get($str,'select',"'*'");
					$where = self::get($str,'where','null');
					$order = self::get($str,'order','null');
					switch(self::get($str,'class')){
						case 'list':
							$items = self::get($str,'items',"\$G['items']['id']");
							$parent = self::get($str,'parent','null');
							return "<?php {$data} = page::area_list( {$items}, {$parent}, {$select}, {$where}, {$order} ); ?>".self::loop($str,$data);
						break;
						case 'one':
							$sign = self::get($str,'sign');
							return "<?php {$data} = page::area_one( {$sign}, {$select}, {$where}, {$order} ); if( {$data} ){ ?>";
						break;
					}
				}
			},
			self::preg(self::$html, 'area', 'list')
		);
		self::$html = preg_replace('/{\/area}/',"<?php } ?>",self::$html);
	}
	
	/**
	 * tag标签
	 */
	private static function _tag()
	{
		self::$html = preg_replace_callback(
			'/{tag\s+[^}]+?}/',
			function($match){
				if($str = $match[0]){
					static $i;
					$i++;
					$data = self::get($str,'data',"\$tag{$i}");
					$select = self::get($str,'select',"'*'");
					$where = self::get($str,'where','null');
					$order = self::get($str,'order','null');
					switch(self::get($str,'class')){
						case 'list':
							$type = self::get($str,'type','null');
							$parent = self::get($str,'parent','null');
							return "<?php {$data} = page::tag_list( {$type}, {$parent}, {$select}, {$where}, {$order} ); ?>".self::loop($str,$data);
						break;
						case 'name':
							$name = self::get($str,'name','null');
							return "<?php {$data} = page::tag_name( {$name}, {$select}, {$where}, {$order} ); if( {$data} ){ ?>";
						break;
						case 'one':
							$id = self::get($str,'id','null');
							return "<?php {$data} = page::tag_one( {$id}, {$select}, {$where}, {$order} ); if( {$data} ){ ?>";
						break;
					}
				}
			},
			self::preg(self::$html, 'tag', 'list')
		);
		self::$html = preg_replace('/{\/tag}/',"<?php } ?>",self::$html);
	}
	
	/**
	 * 反馈
	 */
	private static function _feedback()
	{
		self::$html = preg_replace_callback(
			'/{feedback\s+[^}]+?}/',
			function($match){
				if($str = $match[0]){
					static $i;
					$i++;
					$data = self::get($str,'data',"\$feedback{$i}");
					switch(self::get($str,'class')){
						case 'list':
							$items = self::get($str,'items',"\$G['items']['id']");
							$rows = self::get($str,'rows','null');
							$pages = self::get($str,'pages','null');
							$btns = self::get($str,'btns','null');
							$url = self::get($str,'url','null');
							$name = self::get($str,'name',"'pages'");
							$select = self::get($str,'select',"'*'");
							$where = self::get($str,'where','null');
							$order = self::get($str,'order','null');
							return "<?php {$data} = page::feedback_list( {$items}, {$rows}, {$pages}, {$btns}, {$url}, {$name}, {$select}, {}, {$order} ); ?>".self::loop($str,"{$data}['list']");
						break;
						case 'html':
							$items = self::get($str,'items',"\$G['items']['id']");
							return "<?php {$data} = html::feedback({$items}); if( {$data}['input'] ){ \$html = {$data}['html']; ?>";
						break;
					}
				}
			},
			self::preg(self::$html, 'feedback', 'list|html')
		);
		self::$html = preg_replace('/{\/feedback}/',"<?php } ?>",self::$html);
	}
	
	/**
	 * 参数列表
	 */
	private static function _complex()
	{
		self::$html = preg_replace_callback(
			'/{complex\s+[^}]+?}/',
			function($match){
				if($str = $match[0]){
					static $i;
					$i++;
					$data = self::get($str,'data',"\$complex{$i}");
					switch(self::get($str,'class')){
						case 'list':
							$extent = self::get($str,'extent',"\$G['items']['type']");
							$items = self::get($str,'items',"\$G['group']['items']");
							$core = self::get($str,'core','null');
							$name = self::get($str,'name',"'params'");
							$parent = self::get($str,'parent',0);
							return "<?php {$data} = page::complex_list( {$extent}, {$items}, {$core}, {$name}, {$parent} ); ?>".self::loop($str,$data);
						break;
						case 'one':
							$id = self::get($str,'id','null');
							$select = self::get($str,'select',"'*'");
							$where = self::get($str,'where','null');
							$value = self::get($str,'value',"\$v");
							return "<?php {$data} = page::complex_one( {$id}, {$select}, {$where} ); if( {$data} ){ {$value} = {$data}; ?>";
						break;
					}
				}
			},
			self::preg(self::$html, 'complex', 'list')
		);
		self::$html = preg_replace('/{\/complex}/',"<?php } ?>",self::$html);
	}
	
	/**
	 * 语言列表
	 */
	private static function _language()
	{
		self::$html = preg_replace_callback(
			'/{language\s+[^}]+?}/',
			function($match){
				if($str = $match[0]){
					static $i;
					$i++;
					$data = self::get($str,'data',"\$language{$i}");
					$select = self::get($str,'select',"'*'");
					$where = self::get($str,'where','null');
					$order = self::get($str,'order','null');
					switch(self::get($str,'class')){
						case 'list':
							return "<?php {$data} = page::language_list( {$select}, {$where}, {$order} ); ?>".self::loop($str,"{$data}");
						break;
					}
				}
			},
			self::preg(self::$html, 'language', 'list')
		);
		self::$html = preg_replace('/{\/language}/',"<?php } ?>",self::$html);
	}
	
	/**
	 * 轮播图
	 */
	private static function _banner()
	{
		self::$html = preg_replace_callback(
			'/{banner\s+[^}]+?}/',
			function($match){
				if($str = $match[0]){
					static $i;
					$i++;
					$data = self::get($str,'data',"\$banner{$i}");
					switch(self::get($str,'class')){
						case 'list':
							$items = self::get($str,'items','null');
							$type = self::get($str,'type','null');
							$select = self::get($str,'select',"'*'");
							$where = self::get($str,'where','null');
							$order = self::get($str,'order','null');
							return "<?php {$data} = page::banner_list( {$items}, {$type}, {$select}, {$where}, {$order} ); ?>".self::loop($str,"{$data}");
						break;
					}
				}
			},
			self::preg(self::$html, 'banner', 'list')
		);
		self::$html = preg_replace('/{\/banner}/',"<?php } ?>",self::$html);
	}
	
	/**
	 * 友链
	 */
	private static function _link()
	{
		self::$html = preg_replace_callback(
			'/{link\s+[^}]+?}/',
			function($match){
				if($str = $match[0]){
					static $i;
					$i++;
					$data = self::get($str,'data',"\$link{$i}");
					switch(self::get($str,'class')){
						case 'list':
							$items = self::get($str,'items','null');
							$type = self::get($str,'type','null');
							$select = self::get($str,'select',"'*'");
							$where = self::get($str,'where','null');
							$order = self::get($str,'order','null');
							return "<?php {$data} = page::link_list( {$items}, {$type}, {$select}, {$where}, {$order} ); ?>".self::loop($str,"{$data}");
						break;
					}
				}
			},
			self::preg(self::$html, 'link', 'list')
		);
		self::$html = preg_replace('/{\/link}/',"<?php } ?>",self::$html);
	}
	
	/**
	 * 手机菜单
	 */
	private static function _menu()
	{
		self::$html = preg_replace_callback(
			'/{menu\s+[^}]+?}/',
			function($match){
				if($str = $match[0]){
					static $i;
					$i++;
					$data = self::get($str,'data',"\$menu{$i}");
					$select = self::get($str,'select',"'*'");
					$where = self::get($str,'where','null');
					$order = self::get($str,'order','null');
					switch(self::get($str,'class')){
						case 'list':
							return "<?php {$data} = page::menu_list( {$select}, {$where}, {$order} ); ?>".self::loop($str,"{$data}");
						break;
					}
					
				}
			},
			self::preg(self::$html, 'menu', 'list')
		);
		self::$html = preg_replace('/{\/menu}/',"<?php } ?>",self::$html);
	}
	
	/**
	 * 在线客服
	 */
	private static function _consult()
	{
		self::$html = preg_replace_callback(
			'/{consult\s+[^}]+?}/',
			function($match){
				if($str = $match[0]){
					static $i;
					$i++;
					$data = self::get($str,'data',"\$consult{$i}");
					$select = self::get($str,'select',"'*'");
					$where = self::get($str,'where','null');
					$order = self::get($str,'order','null');
					switch(self::get($str,'class')){
						case 'list':
							return "<?php {$data} = page::consult_list( {$select}, {$where}, {$order} ); ?>".self::loop($str,"{$data}");
						break;
					}
				}
			},
			self::preg(self::$html, 'consult', 'list')
		);
		self::$html = preg_replace('/{\/consult}/',"<?php } ?>",self::$html);
	}
	
	/**
	 * 分页按钮
	 */
	private static function _pages()
	{
		self::$html = preg_replace_callback(
			'/{pages\s+[^}]+?}/',
			function($match){
				if($str = $match[0]){
					static $i;
					$i++;
					$data = self::get($str,'data',"\$pages{$i}");
					switch(self::get($str,'class')){
						case 'html':
							$set = self::get($str,'set');
							$display = self::get($str,'display','false');
							$target = self::get($str,'target','false');
							return "<?php {$data} = html::pages( {$set}, {$display}, {$target} ); if( {$data} ){ \$html = {$data}; ?>";
						break;
					}
				}
			},
			self::preg(self::$html, 'pages', 'html')
		);
		self::$html = preg_replace('/{\/pages}/',"<?php } ?>",self::$html);
	}
	
	/**
	 * 翻页按钮
	 */
	private static function _both()
	{
		self::$html = preg_replace_callback(
			'/{both\s+[^}]+?}/',
			function($match){
				if($str = $match[0]){
					static $i;
					$i++;
					$data = self::get($str,'data',"\$both{$i}");
					$id = self::get($str,'id',"\$G['group']['id']");
					$items = self::get($str,'items',"\$G['items']['id']");
					$type = self::get($str,'type','null');
					switch(self::get($str,'class')){
						case 'html':
							return "<?php {$data} = html::both( {$id}, {$items}, {$type} ); if( {$data} ){ \$html = {$data}; ?>";
						break;
					}
				}
			},
			self::preg(self::$html, 'both', 'html')
		);
		self::$html = preg_replace('/{\/both}/',"<?php } ?>",self::$html);
	}
	
	/** 
	 * 参数
	 */
	private static function _param()
	{
		self::$html = preg_replace_callback(
			'/{param\s+[^}]+?}/',
			function($match){
				if($str = $match[0]){
					static $i;
					$i++;
					$data = self::get($str,'data',"\$param{$i}");
					switch(self::get($str,'class')){
						case 'html':
							$items = self::get($str,'items',"\$G['items']['id']");
							return "<?php {$data} = html::param( {$items} ); if( {$data} ){ \$html = {$data}; ?>";
						break;
						case 'search':
							$items = self::get($str,'items',"\$G['items']['id']");
							return "<?php {$data} = page::search_param( {$items} ); ?>".self::loop($str,"{$data}");
						break;
					}
				}
			},
			self::preg(self::$html, 'param', 'html|search')
		);
		self::$html = preg_replace('/{\/param}/',"<?php } ?>",self::$html);
	}
	
	/**
	 * 会员注册
	 */
	private static function _register()
	{
		self::$html = preg_replace_callback(
			'/{register\s+[^}]+?}/',
			function($match){
				if($str = $match[0]){
					static $i;
					$i++;
					$data = self::get($str,'data',"\$register{$i}");
					switch(self::get($str,'class')){
						case 'html':
							return "<?php {$data} = html::register( ); if( {$data} ){ \$html = {$data}; ?>";
						break;
					}
				}
			},
			self::preg(self::$html, 'register', 'html')
		);
		self::$html = preg_replace('/{\/register}/',"<?php } ?>",self::$html);
	}
	
	/**
	 * 会员登录
	 */
	private static function _login()
	{
		self::$html = preg_replace_callback(
			'/{login\s+[^}]+?}/',
			function($match){
				if($str = $match[0]){
					static $i;
					$i++;
					$data = self::get($str,'data',"\$login{$i}");
					switch(self::get($str,'class')){
						case 'html':
							return "<?php {$data} = html::login( ); if( {$data} ){ \$html = {$data}; ?>";
						break;
					}
				}
			},
			self::preg(self::$html, 'login', 'html')
		);
		self::$html = preg_replace('/{\/login}/',"<?php } ?>",self::$html);
	}
	
	/**
	 * 变量赋值
	 */
	private static function _assign()
	{
		self::$html = preg_replace_callback(
			'/{((?:'.self::$global.'|\$\w+)(?:\.\w+)*\s*=\s*[^}]+?|\$\w(?:\.\w+)*(?:\+\+|\-\-))}/',
			function($match){
				if($str = self::dot($match[1])){
					return "<?php {$str} ; ?>";
				}
			},
			self::$html
		);
	}
	
	/**
	 * 变量
	 */
	private static function _var()
	{
		self::$html = preg_replace_callback(
			'/{(\$\w+(?:\.\w+)*)((?:\|[^\|]+?)*)(!!!(?=}))*}/',
			function($match){
				$result = preg_replace("/\.(\w+)/", "['\\1']", $match[1]);
				if($match[2]){
					$result = str_replace('list'.P.'php','|',self::func(self::dot(preg_replace('/(?<!\?)\?\?\?\|/','list'.P.'php',$match[2])), $result));
				}
				return $match[3]?$result:"<?php echo {$result}; ?>";
			},
			preg_replace(
				'/{('.self::$global.')((?:\.\w+?)+(?:\|[^\|]+?)*)}/',
				'{$G.\\1\\2}',
				self::$html
			)
		);
	}
	
	/**
	 * 循环数字
	 */
	private static function _for()
	{
		self::$html = preg_replace_callback(
			'/{for\s+[^}]+?}/',
			function($match){
				if($str = $match[0]){
					$data = self::get($str,'data',"\$i");
					$start = self::get($str,'start');
					$end = self::get($str,'end');
					return "<?php for( {$data} = {$start} ; {$data} <= {$end} ; ( {$start}<{$end} ? {$data}++ : {$data}-- ) ){ ?>";
				}
			},
			self::$html
		);
		self::$html = preg_replace('/{\/for}/',"<?php } ?>",self::$html);
	}
		
	/**
	 * 循环数组
	 */
	private static function _foreach()
	{
		self::$html = preg_replace_callback(
			'/{foreach\s+[^}]+?}/',
			function($match){
				if($str = $match[0]){
					$data = self::get($str,'data');
					$key = self::get($str,'key');
					$value = self::get($str,'value',"\$v");
					return "<?php foreach( {$data} as ".($key?"{$key} => ":'')."{$value} ){ ?>";
				}
			},
			self::$html
		);
		self::$html = preg_replace('/{\/foreach}/',"<?php } ?>",self::$html);
	}
	
	/**
	 * 判断
	 */
	private static function _if()
	{
		self::$html = preg_replace_callback(
			'/{(?:(else)\s*){0,1}if:\(([\S\s]+?)\)}/',
			function($match){
				$else = $match[1]?'}'.$match[1]:'';
				$str = self::dot($match[2]);
				return "<?php {$else} if( {$str} ){ ?>";
			},
			self::$html
		);
		self::$html = preg_replace('/{else\s*[\/]{0,1}}/',"<?php }else{ ?>",self::$html);
		self::$html = preg_replace('/{\/if}/',"<?php } ?>",self::$html);
	}
	
	/**
	 * 禁止模板编译的区域
	 */
	private static function _nophp()
	{
		self::$html = preg_replace_callback(
			'/{nophp}([\S\s]*?){\/nophp}/',
			function($match){
				return $match[1];
			},
			self::$html
		);
	}
	
	/**
	 * 原生php语句
	 */
	private static function _php()
	{
		self::$html = preg_replace_callback(
			'/{php}([\S\s]*?){\/php}/',
			function($match){
				return $match[1]?"<?php {$match[1]} ?>":'';
			},
			self::$html
		);
	}
	
	/**
	 * 变量后函数
	 */
	public static function func($string, $data)
	{
		/* 简写图片截图函数 */
		$string = str_replace('|thumb=','|cache::thumbnail=',$string);
		preg_match_all('/\|([$\w\->:]+)(?:(?:=)([^\|]+)){0,1}/', $string, $mat);
		foreach($mat[1] as $key=>$val){
			if($str = $mat[2][$key]){
				if(preg_match('/(?<!#)###(?!#)/', $str)){
					$data = str_replace('###', $data, $str);
				}else{
					$data = "{$data},{$str}";
				}
			}
			$data = "{$val}({$data})";
		}
		return $data;
	}
	
	/**
	 * 加点变量转原生变量
	 */
	public static function dot($string)
	{
		return preg_replace_callback(
			'/\$\w+(?:\.\w+)+/',
			function($match){
				return preg_replace("/\.(\w+)/", "['\\1']", $match[0]);
			},
			preg_replace(
				'/(?<!\.|\$|\w)((?:'.self::$global.')(?:\.\w+)+)/',
				'$G.\\1',
				$string
			)
		);
	}
	
	/**
	 * 添加hide和{$html}
	 */
	public static function preg($html, $tag, $class)
	{
		return preg_replace_callback(
			"/({{$tag}(?!\.|\w)[^}]*?class\s*=(['\"]{0,1})({$class})\\2[^}]*?})({\/{$tag}})/",
			function($match){
				if($match[3]=='html'){
					return "{$match[1]}{\$html}{$match[4]}";
				}else{
					return str_replace(" class=", " hide class=", $match[1]).$match[4];
				}
			},
			$html
		);
	}
	
	/**
	 * 添加循环
	 */
	public static function loop($string, $data)
	{
		$key = self::get($string,'key');
		$value = self::get($string,'value',"\$v");
		return  preg_match('/\shide[\s=}]/',$string)?'<?php if(false){ ?>':"{foreach data=\"{$data}\" key='{$key}' value='{$value}'}";
	}
	
	/**
	 * 获取编译标签参数
	 */
	public static function get($string, $needle, $default=null)
	{
		preg_match("/\W{$needle}\s*=(['\"]{0,1})([\S\s]*?)\\1(?=\s|}$)/", $string, $match);
		return isset($match[2])?self::dot($match[2]):$default;
	}
}
?>