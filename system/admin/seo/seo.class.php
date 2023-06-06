<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class seo extends admin
{
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover();
		$data['robots'] = file_get_contents(ROOT_PATH.'robots.txt');
		echo $this->theme('seo/seo',$data);
	}
	
	public function add()
	{
		global $G;
		$this->cover('seo','M');
		if(isset($G['post'])){
			$data = array(
				'home_title'      => $G['post']['home_title'],
				'keywords'        => $G['post']['keywords'],
				'description'     => $G['post']['description'],
				'title_connector'    => $G['post']['title_connector'],
				'keywords_connector' => $G['post']['keywords_connector']
			);
			foreach($data as $k=>$v){
				mysql::select_set(array('name'=>$k,'value'=>$v,'parent'=>'0','type'=>'0'),'config',array('value'));
			}
			$data = array(
				'sitemap_open'        => $G['post']['sitemap_open'],
				'sitemap_auto_update' => $G['post']['sitemap_auto_update'],
				'sitemap_type'        => $G['post']['sitemap_type']
			);
			foreach($data as $k=>$v){
				mysql::select_set(array('name'=>$k,'value'=>$v,'parent'=>'0','type'=>1,'lang'=>0),'config',array('value'));
			}
			$robots = delFilter($G['post']['robots']);
			if(sha1_file(ROOT_PATH.'robots.txt') != sha1($robots)){
				dir::create(ROOT_PATH.'robots.txt',$robots);
			}
			if(!$G['post']['sitemap_open']){
				dir::delete(ROOT_PATH.'sitemap.xml');
				dir::delete(ROOT_PATH.'sitemap.txt');
			}
			$this->sitemap();
			alert('操作成功', url::mpf('seo','seo','init'));
		}
	}
	
	
	public function show($judge=false)
	{
		global $G;
		if($this->cover('seo','M',$judge) && $G['config']['sitemap_open']){
			if($G['config']['sitemap_type']=='xml'){
				$changefreq = array('always','hourly','daily','weekly','monthly','yearly','never');
				$date = date('Y-m-d',TIME);
				$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset>\n";
			}else if($G['config']['sitemap_type']=='txt'){
				$txt = '';
			}
			$area_xml = $area_txt = '';
			$language = page::language('id,defaults', null, 'defaults DESC, id ASC');
			$G['path']['type']='web';
			$result = mysql::select_all('name,value,lang','config',"FIND_IN_SET(name,'rewrite_open,domain,area_open,area_sitemap_open,area_link_type,area_detail_open,area_link_scheme') AND parent='0' AND type='0' AND lang=lang");
			foreach($result as $v){
				$G['config'][$v['name'].$v['lang']] = $v['value'];
			}
			foreach($language as $lang){
				$lg = $lang['id'];
				url::$domain = $G['config']['domain'.$lg];
				$url = url::home($lg,false);
				if($G['config']['sitemap_type']=='xml'){
					$xml .= $this->url(
						$url, 
						$date, 
						$changefreq[0], 
						'1.0'
					);
				}else if($G['config']['sitemap_type']=='txt'){
					$txt .= $url."\n";
				}
				/* 生成首页分站链接 */
				if($G['config']['area_open'.$lg] && $G['config']['area_sitemap_open'.$lg]){
					$list = page::area(null, '*', "display='1'", null);
					foreach($list as $v){
						$u = url::items(array('id'=>88888),$lg,false,$v);
						if($G['config']['sitemap_type']=='xml'){
							$area_xml .= $this->url(
								$u, 
								$date, 
								$changefreq[0], 
								'0.9'
							);
						}else if($G['config']['sitemap_type']=='txt'){
							$area_txt .= $u."\n";
						}
					}
				}
				$old = array();
				if($lv1 = page::items(0, null, '*', "display='1' AND lang='{$lg}'")){
					foreach($lv1 as $v){
						$url = url::items($v,$lg,false);
						if($v['type']==9){
							preg_match("/^(\.\.\/)\w/",$url,$match);
							if($match[0]){
								$url = preg_replace("/^\.\.\//",url::$domain,$url);
							}
						}
						if($url && !in_array($url, $old)){
							if($G['config']['sitemap_type']=='xml'){
								$xml .= $this->url(
									$url, 
									$date, 
									$changefreq[0], 
									'0.9'
								);
							}else if($G['config']['sitemap_type']=='txt'){
								$txt .= $url."\n";
							}
							$old[] = $url;
						}
						if($v['type']>=2 && $v['type']<=5){
							$group = page::group(null, $v['type'], '*', "items='{$v['id']}' AND display='1' AND lang='{$lang['id']}'");
							foreach($group as $g){
								$url = url::group($v['folder'],$g,$lg,false);
								if(!in_array($url, $old)){
									$time = date('Y-m-d',$g['mtime']);
									if($G['config']['sitemap_type']=='xml'){
										$xml .= $this->url(
											$url, 
											$time, 
											$changefreq[0], 
											'0.8'
										);
									}else if($G['config']['sitemap_type']=='txt'){
										$txt .= $url."\n";
									}
									$old[] = $url;
								}
							}
						}
					}
				}
			}
			if($G['config']['sitemap_type']=='xml'){
				dir::create(ROOT_PATH.'sitemap.xml',str_replace('&','&amp;',$xml.$area_xml)."</urlset>");
			}else if($G['config']['sitemap_type']=='txt'){
				dir::create(ROOT_PATH.'sitemap.txt',$txt.$area_txt);
			}
			if($judge){
				return true;
			}else{
				alert('更新成功', url::mpf('seo','seo','init'));
			}
		}else{
			if($judge){
				return false;
			}else{
				alert('功能没有开启');
			}
		}
	}
	
	public function url($loc, $lastmod, $changefreq='always', $priority='1.0')
	{
		return
		"\t<url>\n".
		"\t\t<loc>{$loc}</loc>\n".
		"\t\t<lastmod>{$lastmod}</lastmod>\n".
		"\t\t<changefreq>{$changefreq}</changefreq>\n".
		"\t\t<priority>{$priority}</priority>\n".
		"\t</url>\n";
	}
}
?>