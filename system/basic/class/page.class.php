<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

class page
{
	public static function config($id, $select='*', $where=null, $order=null)
	{
		global $G;
		if(!$where){
			$where = 1;
		}
		if(isset($id)){
			$where = "id='{$id}' AND {$where}";
		}
		if(!isset($order)){
			$order = "id ASC";
		}
		$data = mysql::select_all($select, 'config', $where, $order);
		return $data;
	}
	
	public static function config_option($parent=0, $type=0)
	{
		global $G;
		$data = array();
		$where = 1;
		if(isset($parent)){
			$where = "parent='{$parent}' AND {$where}";
		}
		if(isset($type)){
			$where = "type='{$type}' AND {$where}";
		}
		$result = self::config(null, 'id,name,value', "{$where} AND (lang='{$G['language']['id']}' OR lang='0')");
		$data = arrOption($result);
		if(isset($data['admin_foot'])){
			$data['admin_foot'] = str_replace('[TIME]',date('Y',TIME),$data['admin_foot']);
		}
		if($G['path']['type']=='web'){
			$chars = array(
				'beian',
				'miit_beian',
				'foot',
				'state_content',
				'consult_content',
				'area_insert',
				'area_foot_insert'
			);
			$tag = array(
				'home'=>0,
				'logo'=>6,
				'logo_mobile'=>6,
				'beian'=>1,
				'miit_beian'=>1,
				'foot'=>2,
				'page_first'=>0,
				'page_prev'=>0,
				'page_next'=>0,
				'page_last'=>0,
				'page_before'=>0,
				'page_after'=>0,
				'page_none'=>0,
				'state_title'=>0,
				'state_content'=>2,
				'consult_content'=>2,
				'consult_title'=>0,
				'consult_backtop'=>0,
				'product_content_title'=>0,
				'product_content_title1'=>0,
				'product_content_title2'=>0,
				'product_content_title3'=>0,
				'product_content_title4'=>0,
				'search_placeholder'=>0,
				'feedback_submit'=>0,
				'feedback_captcha_title'=>0,
				'feedback_captcha_placeholder'=>0,
				'feedback_captcha_error'=>0,
				'feedback_success'=>0,
				'feedback_quick'=>0,
				'link_title'=>0,
				'group_time'=>0,
				'group_notice'=>0,
				'download_size'=>0,
				'download_file'=>0,
				'all'=>0,
				'tags'=>0,
				'member_username'=>0,
				'member_password'=>0,
				'member_passwords'=>0,
				'member_code'=>0,
				'member_email'=>0,
				'member_phone'=>0,
				'member_phone_code'=>0,
				'member_phone_button'=>0,
				'member_phone_retime'=>0,
				'member_agreement_yes'=>0,
				'member_agreement_name'=>0,
				'member_login_button'=>0,
				'member_register_button'=>0
			);
			foreach($result as $v){
				if(in_array($v['name'], $chars)){
					$data[$v['name']] = delHtmlspecial($v['value']);
				}
				if(isset($tag[$v['name']])){
					$data['_'.$v['name']] = theme::dtag($v['id'],'config','value',$tag[$v['name']]);
				}
			}
			if(isset($data['logo'])){
				$data['logo_pc'] = $data['logo'];
				$data['_logo_pc'] = $data['_logo'];
				if(isMobile()){
					$data['logo'] = $data['logo_mobile'];
					$data['_logo'] = $data['_logo_mobile'];
				}
			}
		}
		return $data;
	}
	
	
	public static function group($items, $type=null, $select='*', $where=null, $order=null, $limit=null)
	{
		global $G;
		$data = array();
		if(!$where){
			$where = 1;
		}
		if($items){
			$items_list = $items;
			if(is_array($items)){
				$items_list = implode(',',$items);
				$items = array_shift($items);
			}
			if(!$type){
				if($arr = mysql::select_one('type','items',"id='{$items}'")){
					$type = $arr['type'];
				}
			}
			if(is_numeric($type)){
				$table = array_search($type,$G['pass']['type']);
				$where .= " AND FIND_IN_SET(items,'{$items_list}";
				$res = self::items($items,null,'id');
				foreach($res as $v){
					$where .= ','.$v['id'];
				}
				$where .= "')";
			}
		}else if(is_numeric($type)){
			$table = array_search($type,$G['pass']['type']);
		}
		if(!$table || $type<2 || $type>5){
		    return array();
		}
		if(!isset($order)){
			$order = "top DESC, recommend DESC, sort DESC, mtime DESC, id ASC";
		}
		$data = mysql::select_all($select, $table, $where, $order, $limit);
		return $data;
	}
	
	public static function group_both($id, $items, $type=null, $number=1, $select='*', $where=null, $order=null, $limit=null)
	{
		global $G;
		$data = array();
		if(!$where){
			$where = 1;
		}
		if(!$type){
			$arr = mysql::select_one('type','items',"id='{$items}'");
			$type = $arr['type'];
		}
		if($G['config']['both_type']){
			$parent_items = self::items(-$items);
			foreach($parent_items as $v){
				if($v['type'] == $type){
					$items = $v['id'];
				}else{
					break;
				}
			}
		}
		$list = self::group($items, $type, 'id', $where, $order, $limit);
		$loc = array_search(array('id'=>$id), $list);
		$data['prev'] = array();
		$data['next'] = array();
		for($i=1; $i<=$number; $i++){
			if(isset($list[$loc-$i])){
				$data['prev'][] = self::group_one($list[$loc-$i]['id'], $type);
			}
			if(isset($list[$loc+$i])){
				$data['next'][] = self::group_one($list[$loc+$i]['id'], $type);
			}
		}
		return $data;
	}
	
	public static function group_pages($items, $type=null, $rows=null, $pages=null, $btns=null, $url=null, $name='pages', $select='*', $where=null, $order=null)
	{
		global $G;
		$data = array();
		if(!$where){
			$where = 1;
		}
		if(arrExist($G['get'],'search') == 'param'){
			$sql = '';
			preg_match_all("/(?:\?|&)(\w+,\d+)=/", str_replace($name,'',$G['path']['link']), $match);
			if($match[1]){
				foreach($match[1] as $v){
					if(isset($G['get'][$v])){
						$jn = $G['get'][$v]?strFilter(preg_replace('/^\[(.+)\]$/','\\1',json::encode(array(delFilter($G['get'][$v]))))):'';
						$res = mysql::select_all('parent','theme',"name='{$v}' AND ( value='{$G['get'][$v]}' OR LOCATE('{$jn}',value) ) ");
						$s = array();
						foreach($res as $r){
							$s[] = $r['parent'];
						}
						$sql .= " AND FIND_IN_SET(id,'".implode(',',$s)."')";
					}
				}
			}
			if($sql){
				$where .= $sql;
			}
		}
		if($items){
			$itemsarr = mysql::select_one('*','items',"id='{$items}'");
			$folder = $itemsarr['folder'];
			$type = $itemsarr['type'];
		}else if(!$type){
			return array();
		}
		$table = array_search($type,$G['pass']['type']);
		if(!$table || $type<2 || $type>5){
			return array();
		}
		if(!isset($rows)){
			$rows = $G['config'][$table.'_number'];
			if(!is_numeric($rows)){
				$rows = 20;
			}
		}
		$res = self::group($items, $type, 'COUNT(*) AS _total', $where);
		$data['total'] = $res[0]['_total'];
		into::basic_class('pages');
		$data['pages'] = pages::btns(ceil($data['total']/$rows), $pages, $btns, $url, $name);
		$pages = $data['pages'][$name];
		$start = ($pages-1) * $rows;
		$transfer = arrExist(load::config(),"transfer|{$table}");
		$transfer = $transfer?$transfer:array();
		$tf = array(
			'text1'=>1,'text2'=>1,'text3'=>1,
			'image1'=>6,'image2'=>6,'image3'=>6,
			'video'=>8,'icon'=>13,'container'=>2
		);
		if($select == '*'){
			$select = preg_replace('/,content\d?(?=,|$)/','',$G['database_column'][$table]);
			foreach($tf as $k=>$v){
				if(!in_array($k,$transfer)){
					$select = preg_replace('/,'.$k.'(?=,|$)/','',$select);
				}
			}
		}
		$data['list'] = self::group($items, $type, $select, $where, $order, "{$start},{$rows}");
		$width = $G['config']["{$table}_thumbnail_width"];
		$height = $G['config']["{$table}_thumbnail_height"];
		$complex = array();
		$tf['image'] = 6;
		$tf['images'] = 7;
		foreach($data['list'] as $k=>$v){
			$data['list'][$k]['width'] = $width;
			$data['list'][$k]['height'] = $height;
			if(!isset($folder) || is_array($items) || $items!=$v['items']){
				$r = mysql::select_one('folder','items',"id='{$v['items']}'");
				$folder = $r['folder'];
			}
			$data['list'][$k]['folder'] = $folder;
			$data['list'][$k]['url'] = url::group($folder, $v);
			$data['list'][$k]['target'] = $v['target']?'target="_blank"':'';
			$data['list'][$k]['content'] = delHtmlspecial($v['content']);
			if(isset($v['container'])){
				$data['list'][$k]['container'] = delHtmlspecial($v['container']);
			}
			if($v['id']){
				if($type==2){
					$data['list'][$k]['_image'] = theme::dtag($v['id'],$table,'image',6);
				}else if($type==3){
					$data['list'][$k]['_image'] = theme::dtag($v['id'],$table,'image',6);
					$data['list'][$k]['_images'] = theme::dtag($v['id'],$table,'images',7);
					$data['list'][$k]['_content1'] = theme::dtag($v['id'],$table,'content1',2);
					$data['list'][$k]['_content2'] = theme::dtag($v['id'],$table,'content2',2);
					$data['list'][$k]['_content3'] = theme::dtag($v['id'],$table,'content3',2);
					$data['list'][$k]['_content4'] = theme::dtag($v['id'],$table,'content4',2);
					$data['list'][$k]['_price'] = theme::dtag($v['id'],$table,'price',0);
				}else if($type==4){
					$data['list'][$k]['_image'] = theme::dtag($v['id'],$table,'image',6);
					$data['list'][$k]['_images'] = theme::dtag($v['id'],$table,'images',7);
				}else if($type==5){
					$data['list'][$k]['_file'] = theme::dtag($v['id'],$table,'file',9);
					$data['list'][$k]['_size'] = theme::dtag($v['id'],$table,'size',0);
					if(!$v['size']){
						$data['list'][$k]['size'] = 0;
					}
				}
				$data['list'][$k]['_name'] = theme::dtag($v['id'],$table,'name',0);
				$data['list'][$k]['_text'] = theme::dtag($v['id'],$table,'text',1);
				$data['list'][$k]['_content'] = theme::dtag($v['id'],$table,'content',2);
				foreach($transfer as $tr){
					$data['list'][$k]['_'.$tr] = theme::dtag($v['id'],$table,$tr,$tf[$tr]);
				}
				if($type!=2){
					$res = value::get(null,$v['id'],$type,null,false);
					if($res){
						foreach($res as $n=>$p){
							$data['list'][$k][$n] = preg_match('/^\[".+"\]$/',$p)?implode(',',json::decode($p)):$p;	
						}
						if(preg_match('/^_params,(\d+)$/',$n)){
							if(!isset($complex[$v['id']])){
								$complex[$v['id']] = self::complex_list($type, $v['items'], null, 'params');
							}
							foreach($complex[$v['id']] as $c){
								$c['value'] = $data['list'][$k]['params,'.$c['id']];
								$c['_value'] = $data['list'][$k]['_params,'.$c['id']];
								$data['list'][$k]['complex'][] = $c;
							}
						}
					}

				}
			}
		}
		return $data;
	}

	public static function group_list($items=null, $rows=null, $pages=null, $btns=null, $url=null, $name='pages', $select='*', $where=null, $order=null)
	{
		global $G;
		if(!$where){
			$where = 1;
		}
		if(!isset($items)){
			$items = $G['items']['id'];
		}
		if(!isset($url) && !$G['view'] && $G['config']['rewrite_open']){
			$itemsarr = mysql::select_one('*','items',"id='{$items}'");
			$url = url::items($itemsarr,null,null,null,false);
		}
		$where = "display='1' AND {$where}";
		$data = self::group_pages($items, null, $rows, $pages, $btns, $url, $name, $select, $where, $order);
		if(isset($G['area']) && preg_match('/"(3|4)"/',$G['config']['area_name_type'])){
			foreach($data['list'] as $k=>$v){
				if($v['name'] && preg_match('/"3"/',$G['config']['area_name_type'])){
					$data['list'][$k]['name'] = $G['area']['name'].$v['name'];
				}
				if($v['text'] && preg_match('/"4"/',$G['config']['area_name_type'])){
					$data['list'][$k]['text'] = $G['area']['name'].$v['text'];
				}
			}
		}
		return $data;
	}

	public static function group_tag($tag=null, $type=null, $rows=null, $pages=null, $btns=null, $url=null, $name='pages', $select='*', $where=null, $order=null)
	{
		global $G;
		if(!$where){
			$where = 1;
		}
		if(!isset($tag)){
			$tag = $G['get']['tag'];
		}
		$res = self::tag_name($tag,'parent');	
		if(!isset($type)){
			$type = $G['items']['type'];
		}
		if(!isset($url) && !$G['view'] && $G['config']['rewrite_open']){
			$itemsarr = mysql::select_one('folder','items',"type='{$type}'",'sort DESC, id ASC');
			$url = url::tag($itemsarr['folder'],array('name'=>$tag),null,null,null,false);
		}
		$where = "FIND_IN_SET(id,'{$res['parent']}') AND display='1' AND {$where}";
		$data = self::group_pages(null, $type, $rows, $pages, $btns, $url, $name, $select, $where, $order);
		if(isset($G['area']) && preg_match('/"(3|4)"/',$G['config']['area_name_type'])){
			foreach($data['list'] as $k=>$v){
				if($v['name'] && preg_match('/"3"/',$G['config']['area_name_type'])){
					$data['list'][$k]['name'] = $G['area']['name'].$v['name'];
				}
				if($v['text'] && preg_match('/"4"/',$G['config']['area_name_type'])){
					$data['list'][$k]['text'] = $G['area']['name'].$v['text'];
				}
			}
		}
		return $data;
	}
	
	public static function group_type($type, $rows=null, $pages=null, $btns=null, $url=null, $name='pages', $select='*', $where=null, $order=null)
	{
		if(!$where){
			$where = 1;
		}
		if(!isset($url) && !$G['view'] && $G['config']['rewrite_open']){
			$itemsarr = mysql::select_one('folder','items',"type='{$type}'",'sort DESC, id ASC');
			$url = url::items($itemsarr,null,null,null,false);
		}
		$where = "display='1' AND {$where}";
		$data = self::group_pages(null, $type, $rows, $pages, $btns, $url, $name, $select, $where, $order);
		if(isset($G['area']) && preg_match('/"(3|4)"/',$G['config']['area_name_type'])){
			foreach($data['list'] as $k=>$v){
				if($v['name'] && preg_match('/"3"/',$G['config']['area_name_type'])){
					$data['list'][$k]['name'] = $G['area']['name'].$v['name'];
				}
				if($v['text'] && preg_match('/"4"/',$G['config']['area_name_type'])){
					$data['list'][$k]['text'] = $G['area']['name'].$v['text'];
				}
			}
		}
		return $data;
	}

	public static function group_one($id, $type, $select='*', $where=null, $order=null)
	{
		global $G;
		if(!$where){
			$where = 1;
		}
		$table = array_search($type,$G['pass']['type']);
		if(!$table || $type<2 || $type>5){
			return array();
		}
		if(is_numeric($id)){
			$where = "id='{$id}' AND {$where}";
		}
		$where = "display='1' AND {$where}";
		if(!isset($order)){
			$order = "top DESC, recommend DESC, sort DESC, mtime DESC, id ASC";
		}
		$data = mysql::select_one($select, $table, $where, $order);
		if(isset($data['id'])){
			$data['_name'] = theme::dtag($data['id'],$table,'name',0);
			$data['_text'] = theme::dtag($data['id'],$table,'text',1);
			$data['_content'] = theme::dtag($data['id'],$table,'content',2);
			$transfer = arrExist(load::config(),"transfer|{$table}");
			$transfer = $transfer?$transfer:array();
			$tf = array(
				'text1'=>1,'text2'=>1,'text3'=>1,
				'image'=>6,'image1'=>6,'image2'=>6,'image3'=>6,'images'=>7,
				'video'=>8,'icon'=>13,'container'=>2
			);
			if($type==2){
				$data['_image'] = theme::dtag($data['id'],$table,'image',6);
			}else if($type==3){
				$data['_image'] = theme::dtag($data['id'],$table,'image',6);
				$data['_images'] = theme::dtag($data['id'],$table,'images',7);
				$data['_price'] = theme::dtag($data['id'],$table,'price',0);
				for($i=0; $i<$G['config']['product_content_number']; $i++){
					$k=$i?$i:'';
					if($k){
						$data['content'.$k] = delHtmlspecial($data['content'.$k]);
						$data['_content'.$k] = theme::dtag($data['id'],$table,'content'.$k,2);
					}
					$data['contents'][$i] = array(
						'title' => $G['config']['product_content_title'.$k],
						'_title' => $G['config']['_product_content_title'.$k],
						'content' => delHtmlspecial($data['content'.$k]),
						'_content' => $data['_content'.$k]
					);
				}
			}else if($type==4){
				$data['_image'] = theme::dtag($data['id'],$table,'image',6);
				$data['_images'] = theme::dtag($data['id'],$table,'images',7);
			}else if($type==5){
				$data['_file'] = theme::dtag($data['id'],$table,'file',9);
				$data['_size'] = theme::dtag($data['id'],$table,'size',0);
				if(!$data['size']){
					$data['size'] = 0;
				}
			}
			foreach($transfer as $tr){
				$data['_'.$tr] = theme::dtag($data['id'],$table,$tr,$tf[$tr]);
			}
			if($type!=2){
				$res = value::get(null,$data['id'],$type,null,false);
				if($res){
					foreach($res as $k=>$v){
						$data[$k] = preg_match('/^\[".+"\]$/',$v)?implode(',',json::decode($v)):$v;
					}
					if(preg_match('/^_params,(\d+)$/',$k)){
						$comp = self::complex_list($type, $data['items'], null, 'params');
						foreach($comp as $c){
							$c['value'] = $data['params,'.$c['id']];
							$c['_value'] = $data['_params,'.$c['id']];
							$data['complex'][] = $c;
						}
					}
				}
			}
		}
		$res = mysql::select_one('folder','items',"id='{$data['items']}'");
		if($images = arrExist($data,'images')){
			$data['imgs'] = json::decode($images);
		}else{
			if($image = arrExist($data,'image')){
				$data['imgs'][0] = $image;
			}else{
				$data['imgs'] = array();
			}
		}
		$data['tag'] = self::tag_list($type, $id);
		$data['folder'] = $res['folder'];
		$data['width'] = $G['config']["{$table}_thumbnail_width"];
		$data['height'] = $G['config']["{$table}_thumbnail_height"];
		$data['url'] = url::group($res['folder'], $data);
		$data['target'] = $data['target']?'target="_blank"':'';
		$data['content'] = delHtmlspecial($data['content']);	
		if(isset($data['container'])){
			$data['container'] = delHtmlspecial($data['container']);
		}
		$data['type'] = $type;
		if(isset($G['area']) && preg_match('/"(3|4|5)"/',$G['config']['area_name_type'])){
			if($data['name'] && preg_match('/"3"/',$G['config']['area_name_type'])){
				$data['name'] = $G['area']['name'].$data['name'];
			}
			if($data['text'] && preg_match('/"4"/',$G['config']['area_name_type'])){
				$data['text'] = $G['area']['name'].$data['text'];
			}
			if(preg_match('/"5"/',$G['config']['area_name_type'])){
				$data['content'] = RepHtmlStr($data['content'],$G['area']['name']);
				$data['content1'] = RepHtmlStr($data['content1'],$G['area']['name']);
				$data['content2'] = RepHtmlStr($data['content2'],$G['area']['name']);
				$data['content3'] = RepHtmlStr($data['content3'],$G['area']['name']);
				$data['content4'] = RepHtmlStr($data['content4'],$G['area']['name']);
			}
		}
		return $data;
	}

	

	public static function tag_list($type=null, $parent=null, $select='*', $where=null, $order=null)
	{
		global $G;
		if(!$where){
			$where = 1;
		}
		$folder = array();
		if(isset($type)){
			$res = mysql::select_one('folder','items',"type='{$type}'",'sort DESC, id ASC');
			$folder[$type] = $res['folder'];
		}else{
			foreach(array(2,3,4,5) as $v){
				$res = mysql::select_one('folder','items',"type='{$v}'",'sort DESC, id ASC');
				$folder[$v] = $res['folder'];
			}
		}
		$data = self::tag($type, $parent, $select, $where, $order);
		foreach($data as $k=>$v){
			$data[$k]['_title'] = theme::dtag($v['id'],"tag","title",0);
			$data[$k]['url'] = url::tag($folder[$v['type']], $v);
		}
		return $data;
	}
	
	public static function tag_name($name, $select='*', $where=null, $order=null)
	{
		if(!$where){
			$where = 1;
		}
		if(is_numeric($name)){
			$data = self::tag_one($name, $select, $where, $order);
		}else{
			$where = "name='{$name}' AND {$where}";
			$data = self::tag_one(null, $select, $where, $order);
		}
		return $data;
	}
	
	public static function tag_one($id=null, $select='*', $where=null, $order=null)
	{
		if(!$where){
			$where = 1;
		}
		if(isset($id)){
			$where = "id='{$id}'";
		}
		if(!isset($order)){
			$order = "id ASC";
		}
		$data = mysql::select_one($select, 'tag', $where, $order);
		return $data;
	}
	
	public static function tag_pages($type=null, $parent=null, $rows=null, $pages=null, $btns=null, $url=null, $name='pages', $select='*', $where=null, $order=null)
	{
		global $G;
		$data = array();
		if(!isset($rows)){
			$rows = 20;
		}
		$res = self::tag($type, $parent, 'COUNT(*) AS _total', $where);
		$data['total'] = $res[0]['_total'];
		into::basic_class('pages');
		$data['pages'] = pages::btns(ceil($data['total']/$rows), $pages, $btns, $url, $name);
		$pages = $data['pages'][$name];
		$start = ($pages-1) * $rows;
		$data['list'] = self::tag($type, $parent, $select, $where, $order, "{$start},{$rows}");
		return $data;
	}
	
	public static function tag($type, $parent, $select='*', $where=null, $order=null, $limit=null)
	{
		if(!$where){
			$where = 1;
		}
		if(isset($type)){
			$where = "type='{$type}' AND {$where}";
		}
		if(isset($parent)){
			$where = "FIND_IN_SET('{$parent}',parent) AND {$where}";
		}
		if(!isset($order)){
			$order = "id ASC";
		}
		$data = mysql::select_all($select, 'tag', $where, $order, $limit);
		return $data;
	}

	public static function member_one($id=null, $select='*', $where=null, $order=null)
	{
		if(!$where){
			$where = 1;
		}
		if(isset($id)){
			$where = "id='{$id}'";
		}
		if(!isset($order)){
			$order = "id ASC";
		}
		$data = mysql::select_one($select, 'member', $where, $order);
		return $data;
	}
	
	public static function member_pages($rows=null, $pages=null, $btns=null, $url=null, $name='pages', $select='*', $where=null, $order=null)
	{
		global $G;
		$data = array();
		if(!isset($rows)){
			$rows = 20;
		}
		$res = self::member('COUNT(*) AS _total', $where);
		$data['total'] = $res[0]['_total'];
		into::basic_class('pages');
		$data['pages'] = pages::btns(ceil($data['total']/$rows), $pages, $btns, $url, $name);
		$pages = $data['pages'][$name];
		$start = ($pages-1) * $rows;
		$data['list'] = self::member($select, $where, $order, "{$start},{$rows}");
		return $data;
	}
	
	public static function member($select='*', $where=null, $order=null, $limit=null)
	{
		if(!$where){
			$where = 1;
		}
		if(!isset($order)){
			$order = "ctime DESC,id DESC";
		}
		$data = mysql::select_all($select, 'member', $where, $order, $limit);
		return $data;
	}
	

	public static function plugin_list($select='*', $where=null, $order=null)
	{
		global $G;
		if(!$where){
			$where = 1;
		}
		$where = "display='1' AND {$where}";
		$data = self::plugin($select, $where, $order);
		foreach($data as $k=>$v){
            $data[$k]['target'] = $v['target']?' target="_blank"':'';
		}
		return $data;
	}
    
	public static function plugin($select='*', $where=null, $order=null)
	{
		if(!$where){
			$where = 1;
		}
		if(!isset($order)){
			$order = "sort DESC, id ASC";
		}
		$data = mysql::select_all($select, 'plugin', $where, $order);
		return $data;
	}
	
	
	public static function area_one($sign, $select='*', $where=null, $order=null)
	{
		global $G;
		if(!$where){
			$where = 1;
		}
		if(isset($sign)){
			$where = "sign='{$sign}' AND {$where}";
		}
		if(!isset($order)){
			$order = "id ASC";
		}
		$where = "display='1' AND {$where}";
		$data = mysql::select_one($select, 'area', $where, $order);
		if($data['id']){
			$data['content'] = delHtmlspecial($data['content']);
			$data['_content'] = theme::dtag($data['id'],"area","content",2);
		}
		return $data;
	}
	
	public static function area_pages($items=null, $parent=null, $rows=null, $pages=null, $btns=null, $url=null, $name='pages', $select='*', $where=null, $order=null)
	{
		global $G;
		$data = array();
		if(!isset($rows)){
			$rows = 100;
		}
		$res = self::area($parent, 'COUNT(*) AS _total', $where);
		$data['total'] = $res[0]['_total'];
		into::basic_class('pages');
		$data['pages'] = pages::btns(ceil($data['total']/$rows), $pages, $btns, $url, $name);
		$pages = $data['pages'][$name];
		$start = ($pages-1) * $rows;
		$data['list'] = self::area($parent, $select, $where, $order, "{$start},{$rows}");
		return $data;
	}
	
	public static function area_list($items, $parent=null, $select='*', $where=null, $order=null)
	{
		global $G;
		if(!$where){
			$where = 1;
		}
		$where = "display='1' AND {$where}";
		$data = self::area($parent, $select, $where, $order);
		$it = self::items_one($items);
		foreach($data as $k=>$v){
			if($G['group']){
				$data[$k]['url'] = url::group($it['folder'],$G['group'],null,null,$v);
			}else{
				$data[$k]['url'] = url::items($it,null,null,$v);
			}
			if($v['id']){
				$data[$k]['_name'] = theme::dtag($v['id'],"area","name",0);
			}
		}
		return $data;
	}
 
	public static function area($parent=null, $select='*', $where=null, $order=null, $limit=null)
	{
		if(!$where){
			$where = 1;
		}
		if(isset($parent)){
			$where = "parent='{$parent}' AND {$where}";
		}
		if(!isset($order)){
			$order = "id ASC";
		}
		$data = mysql::select_all($select, 'area', $where, $order, $limit);
		return $data;
	}

	
	public static function language_one($id, $select='*', $where=null, $order=null)
	{
		global $G;
		if(!$where){
			$where = 1;
		}
		if(is_numeric($id)){
			$where = "id='{$id}' AND {$where}";
		}
		$where = "display='1' AND {$where}";
		$data = mysql::select_one($select, 'language', $where, $order);
		$data['url'] = url::home($data['id']);
		$data['target'] = $data['target']?' target="_blank"':'';
		$data['_image'] = theme::dtag($data['id'],"language","image",6);
		$data['_name'] = theme::dtag($data['id'],"language","name",0);
		return $data;
	}
	
	public static function language_list($select='*', $where=null, $order=null)
	{
		global $G;
		if(!$where){
			$where = 1;
		}
		$where = "display='1' AND {$where}";
		$data = self::language($select, $where, $order);
		foreach($data as $k=>$v){
			$data[$k]['url'] = url::home($v['id']);
            $data[$k]['target'] = $v['target']?' target="_blank"':'';
			if($v['id']){
				$data[$k]['_image'] = theme::dtag($v['id'],"language","image",6);
				$data[$k]['_name'] = theme::dtag($v['id'],"language","name",0);
			}
		}
		return $data;
	}

	public static function language($select='*', $where=null, $order=null)
	{
		if(!$where){
			$where = 1;
		}
		if(!isset($order)){
			$order = "sort DESC, id ASC";
		}
		$data = mysql::select_all($select, 'language', $where, $order);
		return $data;
	}
	
	
	public static function banner_list($items=null, $type=null, $select='*', $where=null, $order=null)
	{
		global $G;
		if(!$where){
			$where = 1;
		}
		if(!isset($type)){
			$type = $G['items']['type'];
		}
		if(!isset($items)){
			$items = $G['items']['id'];
		}
		$screen = isMobile()?1:0;
		$where = "((type!='' AND LOCATE('\"{$type}\"',type)>0) OR (items!='' AND LOCATE('\"{$items}\"',items)>0)) AND screen='{$screen}' AND display='1' AND {$where}";
		$data = self::banner($select, $where, $order);
		foreach($data as $k=>$v){
			$data[$k]['content'] = delHtmlspecial($v['content']);
            $data[$k]['target'] = $v['target']?' target="_blank"':'';
			$data[$k]['_name'] = theme::dtag($v['id'],"banner","name",0);
			$data[$k]['_image'] = theme::dtag($v['id'],"banner","image",6);
			$data[$k]['_content'] = theme::dtag($v['id'],"banner","content",2);
		}
		return $data;
	}
	
	public static function banner($select='*', $where=null, $order=null)
	{
		if(!$where){
			$where = 1;
		}
		if(!isset($order)){
			$order = "sort DESC, id ASC";
		}
		$data = mysql::select_all($select, 'banner', $where, $order);
		return $data;
	}
	
	
	public static function link_list($items=null, $type=null, $select='*', $where=null, $order=null)
	{
		global $G;
		if(!$where){
			$where = 1;
		}
		if(isset($type)){
			$where .= " AND type='{$type}' ";
		}
		if(is_numeric($G['area']['id'])){
			$where .= " AND area='{$G['area']['id']}' ";
		}else{
			if(!$items){
				$items = $G['items']['id'];
			}
			$where .= " AND LOCATE('\"{$items}\"',items)>0 AND area='0' ";
		}
		$where = "display='1' AND {$where}";
		$data = self::link($select, $where, $order);
		foreach($data as $k=>$v){
            $data[$k]['nofollow'] = $v['nofollow']?' rel="nofollow"':'';
            $data[$k]['target'] = $v['target']?' target="_blank"':'';
			$data[$k]['_name'] = theme::dtag($v['id'],"link","name",0);
			$data[$k]['_image'] = theme::dtag($v['id'],"link","image",6);
		}
		return $data;
	}
	
	public static function link($select='*', $where=null, $order=null)
	{
		if(!$where){
			$where = 1;
		}
		if(!isset($order)){
			$order = "sort DESC, id ASC";
		}
		$data = mysql::select_all($select, 'link', $where, $order);
		return $data;
	}
	
	/* B O S S C M S */
	public static function consult_list($select='*', $where=null, $order=null)
	{
		global $G;
		if(!$where){
			$where = 1;
		}
		$where = "display='1' AND {$where}";
		$data = self::consult($select, $where, $order);
		foreach($data as $k=>$v){
			$data[$k]['_name'] = theme::dtag($v['id'],"consult","name",0);
			$data[$k]['_value'] = theme::dtag($v['id'],"consult","value");
		}
		return $data;
	}
	
	public static function consult($select='*', $where=null, $order=null)
	{
		if(!$where){
			$where = 1;
		}
		if(!isset($order)){
			$order = "sort DESC, id ASC";
		}
		$data = mysql::select_all($select, 'consult', $where, $order);
		return $data;
	}
	
	
	
	public static function menu_list($select='*', $where=null, $order=null)
	{
		global $G;
		if(!$where){
			$where = 1;
		}
		$where = "display='1' AND {$where}";
		$data = self::menu($select, $where, $order);
		foreach($data as $k=>$v){
            $data[$k]['target'] = $v['target']?' target="_blank"':'';
			$data[$k]['_name'] = theme::dtag($v['id'],"menu","name",0);
			$data[$k]['_icon'] = theme::dtag($v['id'],"menu","icon",13);
		}
		return $data;
	}
	
	public static function menu($select='*', $where=null, $order=null)
	{
		if(!$where){
			$where = 1;
		}
		if(!isset($order)){
			$order = "sort DESC, id ASC";
		}
		$data = mysql::select_all($select, 'menu', $where, $order);
		return $data;
	}


	public static function layers_series($core, $series='', $parent=0, $level=1)
	{
		$data = array();
		if($series){
			$list = self::layers($core, $series, $parent);
			foreach($list as $key=>$val){
				$val['level'] = $level;
				$data[] = $val;
				$result = theme::series_list($core, 88, $series);
				foreach($result as $k=>$v){
					$v['level'] = $level+1;
					$v['id'] = $k;
					$v['series'] = $series;
					$data[] = $v;
					$res = self::layers_series($core, $k, $val['id'], $v['level']+1);
					$data = array_merge($data, $res);
				}
			}
		}else{
			$result = theme::series_list($core, 88, $series);
			foreach($result as $k=>$v){
				$v['level'] = $level;
				$v['id'] = $k;
				$v['series'] = $series;
				$data[] = $v;
				$res = self::layers_series($core, $k, $parent, $v['level']+1);
				$data = array_merge($data, $res);
			}
		}
		return $data;
	}
	
	public static function layers_list($core, $series=1, $parent=0, $select='*', $where=null, $order=null)
	{
		global $G;
		if(!$where){
			$where = 1;
		}
		$where = "display='1' AND {$where}";
		$data = self::layers($core, $series, $parent, $select, $where, $order);
		foreach($data as $k=>$v){
			$value = value::get($core, $v['id'], 88, $series);
			foreach($value as $name=>$info){
				$data[$k][$name] = $info;
			}
			$data[$k]['_name'] = theme::dtag($v['id'],"layers","name",0);
			if(isset($G['area']) && $data[$k]['name'] && preg_match('/"6"/',$G['config']['area_name_type'])){
				$data[$k]['name'] = $G['area']['name'].$data[$k]['name'];
			}
		}
		return $data;
	}
	
	public static function layers($core, $series=1, $parent=0, $select='*', $where=null, $order=null)
	{
		if(!$where){
			$where = 1;
		}
		$where = "parent='{$parent}' AND core='{$core}' AND series='{$series}' AND {$where}";
		if(!isset($order)){
			$order = "sort DESC, id ASC";
		}
		$data = mysql::select_all($select, 'layers', $where, $order);
		return $data;
	}
	

    public static function complex($extent, $items, $core, $name, $parent=0)
	{
		global $G;
		/* BOSS—CMS */
		if($extent>1 && $extent<6){
			$sql = "FIND_IN_SET(items,'{$items}";
			$res = self::items(-$items, null, 'id', "type='{$extent}'");
			foreach($res as $v){
				$sql .= ','.$v['id'];
			}
			$sql .= "')";
		}else{
			$sql = "items='{$items}'";
		}
		$where = "extent='{$extent}' AND core='{$core}' AND name='{$name}' AND parent='{$parent}' AND {$sql}";
		$order = 'sort ASC, id ASC';
		$data = mysql::select_all('*', 'complex', $where, $order);
		return $data;
	}

    public static function complex_list($extent, $items, $core, $name, $parent=0)
	{
		global $G;		
		$data = self::complex($extent, $items, $core, $name, $parent);
		foreach($data as $k=>$v){
			$data[$k]['_title'] = theme::dtag($v['id'],'complex','title',0);
		}
		return $data;
	}

	public static function complex_one($id=null, $select='*', $where=null)
	{
		global $G;
		if(!$where){
			$where = 1;
		}
		if(isset($id)){
			$where = "id='{$id}' AND {$where}";
		}
		$data = mysql::select_one($select, 'complex', $where);
		if(isset($data['id'])){
			$data['_title'] = theme::dtag($data['id'],'complex','title',0);
		}
		return $data;
	}


    public static function form($id, $where=null, $order=null)
	{
		global $G;
		$data = array();
		if(!$where){
			$where = 1;
		}
		if(isset($id)){
			$where = "parent='{$id}' AND {$where}";
		}
		if(!isset($order)){
			$order = 'sort ASC, id ASC';
		}
		$result = mysql::select_all('*', 'form', $where, $order);
		foreach($result as $k=>$v){
			$data[$k] = $v;
			$data[$k]['form'] = ctrl::form($v['style'],'params'.$v['id'],$v['param'],$v['must'],$v['prompt']);
			if(isset($v['id'])){
				$data[$k]['_title'] = theme::dtag($v['id'],"form","title",0);
				$data[$k]['_prompt'] = theme::dtag($v['id'],"form","prompt",0);
				$data[$k]['_description'] = theme::dtag($v['id'],"form","description",0);
			}
		}
		return $data;
	}


	public static function feedback($items, $rows=null, $pages=null, $btns=null, $url=null, $name='pages', $select='*', $where=null, $order=null)
	{
		global $G;
		$data = array();
		if(!isset($rows)){
			$rows = $G['config']['feedback_number'];
		}
		if(!$where){
			$where = 1;
		}
		if($items){
			$where = "parent='{$items}' AND {$where}";
		}
		$data['total'] = mysql::total('feedback', $where);
		into::basic_class('pages');
		if(!isset($url) && !$G['view'] && $G['config']['rewrite_open']){
			$itemsarr = mysql::select_one('*','items',"id='{$items}'");
			$url = url::items($itemsarr,null,null,null,false);
		}
		$data['pages'] = pages::btns(ceil($data['total']/$rows), $pages, $btns, $url, $name);
		$pages = $data['pages'][$name];
		$start = ($pages-1) * $rows;
		if(!isset($order)){
			$order = 'ctime DESC, id ASC';
		}
		$data['list'] = mysql::select_all($select, 'feedback', $where, $order, "{$start},{$rows}");
		return $data;
	}

	public static function feedback_list($items, $rows=null, $pages=null, $btns=null, $url=null, $name='pages', $select='*', $where=null, $order=null)
	{
		if(!$where){
			$where = 1;
		}
		$res = mysql::select_one('value','config',"name='feedback_display' AND parent='{$items}'");
		$where = $res['value']?"display='1' AND {$where}":' 0 ';
		$data = self::feedback($items, $rows, $pages, $btns, $url, $name, $select, $where, $order);
		foreach($data['list'] as $k=>$v){
			$data['list'][$k]['param'] = json::decode($v['param']);
			$data['list'][$k]['_reply'] = theme::dtag($v['id'],"feedback","reply",1);
		}
		return $data;
	}
	
	
	public static function search($items, $rows=null, $pages=null, $btns=null, $url=null, $name='pages', $select='*', $where=null, $order=null)
	{
		global $G;
		$data = array();
		if(!isset($rows)){
			$rows = 20;
		}
		if(!$where){
			$where = 1;
		}
		if($items){
			$where = "parent='{$items}' AND {$where}";
		}
		$data['total'] = mysql::total('search', $where);
		into::basic_class('pages');
		$data['pages'] = pages::btns(ceil($data['total']/$rows), $pages, $btns, $url, $name);
		$pages = $data['pages'][$name];
		$start = ($pages-1) * $rows;
		if(!isset($order)){
			$order = "ctime DESC, id ASC";
		}
		$data['list'] = mysql::select_all($select, 'search', $where, $order, "{$start},{$rows}");
		return $data;
	}
	
	public static function search_list($items=null, $keyword=null, $rows=null, $pages=null, $btns=null, $url=null, $name='pages', $cid=null)
	{
		global $G;
		$data = array();
		if(!isset($items)){
			$items = $G['items']['id'];
		}
		$config = self::config_option($items,0);
		if(!isset($keyword)){
			$keyword = arrExist($G,"get|{$config['search_keyword']}");
		}
		if($keyword!=='' && arrExist($config,'search_open') && $search_items=json::decode($config['search_items'])){
			$search = array();
			if(isset($cid)){
				$search_items = array($cid);
			}
			foreach($search_items as $id){
				$its = self::items_one($id);

				if($its['type']==1){
					if(mysql::total('items',"id='{$its['id']}' AND (name LIKE '%{$keyword}%' OR text LIKE '%{$keyword}%' OR content LIKE '%{$keyword}%')")){
						$search[$its['type']][$id] = array(
							'id' => $its['id'],
							'url' => $its['url'],
							'title' => $its['name'],
							'image' => $its['image'],
							'time' => 0,
							'text' => delHtmlspecial($its['content']),
							'type' => $its['type']
						);
					}
				}else if($its['type']>1 && $its['type']<6){
					$sql = '';
					if($its['type']==3){
						$sql = " OR content1 LIKE '%{$keyword}%' OR content2 LIKE '%{$keyword}%' OR content3 LIKE '%{$keyword}%' OR content4 LIKE '%{$keyword}%'";
					}
					$where = "(name LIKE '%{$keyword}%' OR text LIKE '%{$keyword}%' OR content LIKE '%{$keyword}%' {$sql})";
					$res = self::group_list($its['id'], 9999999, 1, null, null, 'pages', '*', $where, null);
					if($res['list']){
						foreach($res['list'] as $v){
							$search[$its['type']][$v['id']] = array(
								'id' => $v['id'],
								'url' => $v['url'],
								'title' => $v['name'],
								'image' => $v['image'],
								'time' => $v['ctime'],
								'text' => $v['text'],
								'type' => $its['type']
							);
						}
					}
				}
			}
			$list = array();
			foreach($search as $arr){
				foreach($arr as $v){
					$list[] = $v;
				}
			}
			if(!isset($rows)){
				$rows = $G['config']['search_number'];
			}
			$data['total'] = $total = count($list);
			into::basic_class('pages');
			$data['pages'] = pages::btns(ceil($total/$rows), $pages, $btns, $url, $name);
			$pages = $data['pages']['pages'];
			$data['list'] = array();
			$start = ($pages - 1) * $rows;
			$end = $pages * $rows;
			foreach($list as $k=>$v){
				if($k>=$start && $k<$end){
					$data['list'][] = $v;
				}
			}
		}
		return $data;
	}
	
	
	public static function search_param($items)
	{
		global $G;
		$data = array();
		$arr = mysql::select_one('type','items',"id='{$items}'");
		$result = self::complex_list($arr['type'], $items, null, 'params');
		foreach($result as $v){
			if($v['style']==3 || $v['style']==4 || $v['style']==5){
				$name = $v['name'].','.$v['id'];
				$data[$name]['title'] = $v['title'];
				$data[$name]['_title'] = theme::dtag($v['id'],"complex","title",0);
				preg_match("/\w+,\d+=/", str_replace($name,'',$G['path']['link']), $match);
				$data[$name]['list'][] = array(
					'url' =>  url::param(url::param(null, 'search',  $match[0]?'param':null), $name, null),
					'title' => $G['config']['all'],
					'_title' => $G['config']['_all'],
					'active' => isset($G['get'][$name])?false:true,
					'all' => true
				);
				$rgb = false;
				$param = json::decode($v['param']);
				foreach($param as $k=>$m){
					preg_match('/^rgb[a]*\([\d,\s]*+\)[;]*$/', $m, $match);
					if($match[0]){
						$rgb = true;
					}
					$data[$name]['list'][] = array(
						'url' =>  url::param(url::param(null,'search','param'), $name, $m),
						'title' => $m,
						'_title' => theme::dtag($v['id'],"complex","param",0,'',$k),
						'rgb' => $match[0]?true:false,
						'active' => arrExist($G['get'],$name)==$m?true:false,
						'all' => false
					);
				}
				$data[$name]['rgb'] = $rgb;
			}
		}
		return $data;
	}
	
	
	public static function items_one($id=0, $select='*', $where=true, $order=null)
	{
		global $G;
		$items = arrExist($G,'items|id');
		if($id == 88888){
			$data = array(
				'id' => $id,
				'name' => $G['config']['home'],
				'_name' => $G['config']['_home'],
				'type' => 0,
				'theme' => 'home.html',
				'parent' => 0,
				'display' => 1,
				'target' => '',
				'text' => '',
				'level' => 1,
				'static' => '',
				'children' => 0,
				'on' => $G['path']['home']?'on':''
			);
		}else{
			$sql = $id?"id='{$id}'":'1';
			$data = isset($G['items'])&&is_numeric($items)&&$id==$items?$G['items']:(mysql::select_one($select, 'items', "{$sql} AND display='1' AND {$where}", $order));
			$data['on'] = $id==$items?'on':'';
		}
		$data['url'] = url::items($data);
		if($data && $id!=88888){
			$transfer = arrExist(load::config(),"transfer|items");
			$transfer = $transfer?$transfer:array();
			$tf = array(
				'text1'=>1,'text2'=>1,'text3'=>1,
				'image1'=>6,'image2'=>6,'image3'=>6,'images'=>7,
				'icon1'=>13,'container'=>2
			);
			$data['children'] = mysql::total('items', "parent='{$data['id']}' AND display='1'");
			$data['target'] = ($data['target']?'target="_blank"':'').($data['nofollow']?' rel="nofollow"':'');
			$data['content'] = delHtmlspecial($data['content']);
			if(isset($data['container'])){
				$data['container'] = delHtmlspecial($data['container']);
			}
			if(isset($data['id'])){
				$data['_name'] = theme::dtag($data['id'],'items','name',0);
				$data['_text'] = theme::dtag($data['id'],'items','text',1);
				$data['_icon'] = theme::dtag($data['id'],'items','icon',13);
				$data['_image'] = theme::dtag($data['id'],'items','image',6);
				$data['_images'] = theme::dtag($data['id'],'items','images',7);
				$data['_content'] = theme::dtag($data['id'],'items','content',2);
				$data['_container'] = theme::dtag($data['id'],'items','container',2);
				foreach($transfer as $tr){
					$data['_'.$tr] = theme::dtag($data['id'],'items',$tr,$tf[$tr]);
				}
			}
		}
		if(isset($G['area'])){
			if($data['name'] && preg_match('/"0"/',$G['config']['area_name_type'])){
				$data['name'] = $G['area']['name'].$data['name'];
			}
			if($data['text'] && preg_match('/"1"/',$G['config']['area_name_type'])){
				$data['text'] = $G['area']['name'].$data['text'];
			}
			if($data['content'] && preg_match('/"2"/',$G['config']['area_name_type'])){
				$data['content'] = RepHtmlStr($data['content'],$G['area']['name']);
			}
		}
		return $data;
	}
	
	public static function items_head()
	{
		return self::items_list(null, 0, '*', "head='1'");
	}
	
	public static function items_foot()
	{
		return self::items_list(null, 0, '*', "foot='1'");
	}

	public static function items_list($id=0, $loop=0, $select='*', $where=true, $order=null)
	{
		global $G;
		$nowid = arrExist($G,'items|id');
		$parents = array();
		if(isset($G['items']['parent_list'])){
			foreach($G['items']['parent_list'] as $k=>$v){
				$parents[] = $v['id'];
			}
		}
		$data = self::items($id, $loop, $select, "display='1' AND {$where}", $order);
		if($id < 0){
			$data = array_reverse($data);
		}
		$transfer = arrExist(load::config(),"transfer|items");
		$transfer = $transfer?$transfer:array();
		$tf = array(
			'text1'=>1,'text2'=>1,'text3'=>1,
			'image1'=>6,'image2'=>6,'image3'=>6,'images'=>7,
			'icon1'=>13,'container'=>2
		);
		foreach($data as $k=>$v){
			$data[$k]['on'] = $v['id']==$nowid?'on':($parents&&in_array($v['id'],$parents)?'on pn':'');
			$data[$k]['url'] = url::items($v);
			$data[$k]['children'] = mysql::total('items', "parent='{$v['id']}' AND display='1'");
			$data[$k]['target'] = ($v['target']?'target="_blank"':'').($v['nofollow']?' rel="nofollow"':'');			
			$data[$k]['content'] = delHtmlspecial($v['content']);
			if(isset($v['container'])){
				$data[$k]['container'] = delHtmlspecial($v['container']);
			}
			if($v['id']){
				$data[$k]['_name'] = theme::dtag($v['id'],'items','name',0);
				$data[$k]['_text'] = theme::dtag($v['id'],'items','text',1);
				$data[$k]['_icon'] = theme::dtag($v['id'],'items','icon',13);
				$data[$k]['_image'] = theme::dtag($v['id'],'items','image',6);
				$data[$k]['_content'] = theme::dtag($v['id'],'items','content',2);
				foreach($transfer as $tr){
					$data[$k]['_'.$tr] = theme::dtag($v['id'],'items',$tr,$tf[$tr]);
				}
			}
			if(isset($G['area']) && preg_match('/"(0|1)"/',$G['config']['area_name_type'])){
				if($v['name'] && preg_match('/"0"/',$G['config']['area_name_type'])){
					$data[$k]['name'] = $G['area']['name'].$v['name'];
				}
				if($v['text'] && preg_match('/"1"/',$G['config']['area_name_type'])){
					$data[$k]['text'] = $G['area']['name'].$v['text'];
				}
			}
		}
		return $data;
	}
	
	public static function items_option($id=0, $top=false, $over=array(), $home=false, $type=null)
	{
		global $G;
		$data = array();
		if($top){
			$data[0] = $top;
		}
		$where = ' 1';
		if($over){
			$over = implode(',',$over);
			$where .= " AND !FIND_IN_SET(parent,'{$over}') AND !FIND_IN_SET(id,'{$over}')";
		}
		if($home){
			$data[88888] = $G['config']['home'];
		}
		$subset = self::items($id, null, 'id,level,name,parent,type', $where);
		if($subset){
			foreach($subset as $v){
				if(!$type || (is_array($type)?in_array($v['type'],$type):$v['type']==$type)){ 
					$r = '';
					for($i=($top?1:2); $i<=$v['level']; $i++){
						if($i==$v['level']) $r.='<font>&nbsp;&nbsp;&#10551;&nbsp;</font>'; else $r.='<font>&emsp;&nbsp;</font>';
					}
					$data[$v['id']] = $r.$v['name'];
				}
			}
		}
		return $data;
	}
	
	public static function items($parent=0, $loop=null, $select='*', $where=true, $order=null)
	{
		/* BOSS_CMS */
		$data = array();
		if(isset($parent) && is_numeric($parent)){
			if($parent<0){
				$set = " id='".abs($parent)."' AND ";
			}else{
				$set = " parent='{$parent}' AND ";
			}
		}
		if(!strstr($select,'parent')){
			$select .= ',parent,id';
		}
		if(is_numeric($loop)){
			$loop = $loop-1;
		}
		if(!isset($order)){
			$order = 'sort DESC, id ASC';
		}
		if($result = mysql::select_all($select, 'items', $set.$where, $order)){
			foreach($result as $val){
				$data[$val['id']] = $val;
				if((!isset($loop) || $loop>=0) && ($parent>=0 || ($parent<0&&$val['parent'])) && $res=self::items($parent<0?-$val['parent']:$val['id'], $loop, $select, $where, $order)){
					foreach($res as $v){
						$data[$v['id']] = $v;
					}
				}
			}
			return $data;
		}
		return array();
	}
}
?>