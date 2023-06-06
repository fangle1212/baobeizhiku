<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

class seo
{	
	public static $title;
	public static $keywords;
	public static $description;
	public static $alt;
	
	public static function title()
	{
		global $G;
		self::$title = '';
		if($G['path']['home']){
			if($G['config']['home_title']){
				self::$title = self::affix($G['config']['home_title']);
			}else{
				self::$title = $G['config']['title'];
			}
			if(isset($G['area'])){
				if($G['area']['title']){
					self::$title = $G['area']['title'];
				}else{
					self::$title = $G['area']['name'].self::$title;
				}
			}
		}else{
			if(isset($G['group'])){
				if($G['group']['title']){
					if($G['config']['title']){
						self::$title = self::affix($G['group']['title']).$G['config']['title_connector'].$G['config']['title'];
					}else{
						self::$title = self::affix($G['group']['title']);
					}
					if(isset($G['area'])){
						self::$title = $G['area']['name'].self::$title;
					}
				}else{
					if($G['config']['title']){
						self::$title = $G['group']['name'].$G['config']['title_connector'].$G['config']['title'];
					}else{
						self::$title = $G['group']['name'];
					}
				}
			}else{
				if(isset($G['tag'])){
					if($G['tag']['seo_title']){
						if($G['config']['title']){
							self::$title = $G['tag']['seo_title'].$G['config']['title_connector'].$G['config']['title'];
						}else{
							self::$title = $G['tag']['seo_title'];
						}
					}else if($G['config']['title']){
						self::$title = $G['tag']['title'].$G['config']['title_connector'].$G['config']['title'];
					}else{
						self::$title = $G['tag']['title'];
					}
				}else if($G['items']['title']){
					if($G['config']['title']){
						self::$title = self::affix($G['items']['title']).$G['config']['title_connector'].$G['config']['title'];
					}else{
						self::$title = self::affix($G['items']['title']);
					}
				}else{
					if($G['config']['title']){
						self::$title = $G['items']['name'].$G['config']['title_connector'].$G['config']['title'];
					}else{
						self::$title = $G['items']['name'];
					}
				}
				if(isset($G['area'])){
					self::$title = $G['area']['name'].self::$title;
				}
				if(is_numeric($G['get']['pages']) && $G['get']['pages']>1 && $G['config']['page_number']){
					self::$title = str_replace('[n]',$G['get']['pages'],$G['config']['page_number']).$G['config']['title_connector'].self::$title;
				}
			}
		}
		return self::$title;
	}
	
	public static function keywords($bosscms=true)
	{
		global $G;
		self::$keywords = '';
		if($G['path']['home']){
			if(isset($G['area']) && $G['area']['keywords']){
				self::$keywords = self::json($G['area']['keywords']);
			}else{
				self::$keywords = self::json($G['config']['keywords']);
			}
		}else{
			if(isset($G['group'])){
				self::$keywords = self::json($G['group']['keywords']);
			}else if(isset($G['tag']) && $G['tag']['keywords']){
				self::$keywords = self::json($G['tag']['keywords']);
			}else{
				self::$keywords = self::json($G['items']['keywords']);
			}
		}
		return self::$keywords;
	}
	
	public static function description()
	{
		global $G;
		self::$description = '';
		if($G['path']['home']){
			if(isset($G['area']) && $G['area']['description']){
				self::$description = $G['area']['description'];
			}else{
				self::$description = $G['config']['description'];
			}
		}else{
			if(isset($G['group'])){
				self::$description = $G['group']['description'];
			}else if(isset($G['tag']) && $G['tag']['description']){
				self::$description = $G['tag']['description'];
			}else{
				self::$description = $G['items']['description'];
			}
		}
		return self::$description;
	}
	
	public static function alt()
	{
		global $G;
		if($G['path']['home']){
			if($G['config']['title']){
				self::$alt = $G['config']['title'];
			}else{
				self::$alt = $G['config']['home_title'];
			}
		}else{
			if(isset($G['group'])){
				if($G['group']['alt']){
					self::$alt = $G['group']['alt'];
				}else{
					self::$alt = $G['group']['name'];
				}
			}else{
				if($G['items']['alt']){
					self::$alt = $G['items']['alt'];
				}else{
					self::$alt = $G['items']['name'];
				}
			}
		}
		return self::$alt;
	}
	
	public static function json($str)
	{
		global $G;
		if($str){
			if(preg_match('/^(\[\]|\[\".+\"\])$/',$str)){
				return implode($G['config']['keywords_connector'],json::decode($str));
			}else{
				return $str;
			}
		}else{
			return '';
		}
	}
	
	public static function affix($title)
	{
		global $G;
		if(isset($G['area']['name'])){
			$title = str_replace('，','AREAAFFIX,',$title);
			$title = str_replace('、','AFFIXAREA,',$title);
			$title =  preg_replace("/([\-\|\_\,]\s*)/",'\\1'.$G['area']['name'],$title,1);
			$title = str_replace('AREAAFFIX,','，',$title);
			$title = str_replace('AFFIXAREA,','、',$title);
		}
		return $title;
	}
	
	public static function replace($html)
	{
		global $G;
		if(!self::$description){
			preg_match("/<h1[^>]*>[\s\S]+?<\/h1>/",$html,$h1);
			if($h1){
				$description = trim(strip_tags($h1[0]));
			}else{
				preg_match_all("/<h2[^>]*>[\s\S]+?<\/h2>|<p[^>]*>[\s\S]+?<\/p>/",$html,$hp);
				$description = '';
				foreach($hp[0] as $v){
					if($v){
						$description .= trim(strip_tags($v)).'|';
					}
				}
				if($description){
					$description = strSub($description,0,100);
				}else{
					preg_match("/<body[^>]*>[\s\S]+?<\/body>/",$html,$body);
					$description = trim(strip_tags($body[0]));
				}
			}
			$description = preg_replace('/\s+/',' ',str_replace("\n",'',quotesFilter($description)));
			$html = str_replace('<meta name="description" content="" />','<meta name="description" content="'.$description.'" />',$html);
		}/* BOSS_CMS */
		preg_match_all("/<img\s[^>]*>/",$html,$img);
		if($img){
			self::alt();
			foreach($img[0] as $v){
				if(strstr($v, 'alt=')){
					$html = str_replace($v, str_replace(array('alt=""',"alt=''"),'alt="'.self::$alt.'"',$v), $html);
				}else{
					$html = str_replace($v, str_replace('<img ','<img alt="'.self::$alt.'" ',$v), $html);
				}
			}
		}
		return $html;
	}
}
?>