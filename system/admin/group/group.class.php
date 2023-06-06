<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class group extends admin
{
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover('content');
		$type = arrExist($G,'get|type');
		$items = arrExist($G,'get|items');
		if(!$type && $items){
			$res = mysql::select_one('type','items',"id='{$items}'");
			if($res){
				$G['get']['type'] = $type = $res['type'];
			}
		}
		if($type){
			if(!$G['get']['column']){
				$G['body_class'] = 'iframe-content';
				$G['navsub'] = into::load_class('admin','items','content','new')->navsub();
			}
			$keyword = arrExist($G,'get|keyword');
			$data = page::group_pages($items, $type, 20, null, null, null, 'pages', '*', $keyword?"(name LIKE '%{$keyword}%' OR text LIKE '%{$keyword}%' OR content LIKE '%{$keyword}%')":'');
			$data['id'] = $items;
			$data['keyword'] = $keyword;
			$data['subarr'] = page::items_option(0,false,array(),false,$type);
			echo $this->theme('group/group', $data);
		}else{
			alert('没有指定栏目类型');
		}
	}
	
	public function modify()
	{
		global $G;
		$this->cover('content','M');
		if(isset($G['post']['id'])){
			$table = array_search($G['get']['type'],$G['pass']['type']);
			$error=array();
			foreach($G['post']['id'] as $id){
				if(isset($G['post']['sort'.$id])){
					$data = array(
						'recommend'=>$G['post']['recommend'.$id],
						'top'=>$G['post']['top'.$id],
						'sort'=>$G['post']['sort'.$id]
					);
					if(!is_numeric(mysql::update($data,$table,"id='{$id}'"))){
						$error[]=$id;
					}
				}
			}
			if($error){
				alert('ID为'.implode(',',$error).'修改失败');
			}else{
				alert('修改成功', url::mpf('group','group','init'));
			}
		}else{
			alert('没有提交信息');
		}
	}
	
	public function edit()
	{
		global $G;
		$G['cover'] = $this->cover('content');
		$items = arrExist($G['get'],'items');
		if($items){
			$table = array_search($G['get']['type'],$G['pass']['type']);
			$data = array();
			$data['items'] = $items;
			$data['ctime'] = $data['mtime'] = date('Y-m-d H:i:s',TIME);
			if(isset($G['get']['id'])){
				$id = $G['get']['id'];
				$data = mysql::select_one('*',$table,"id='{$id}'");
				if($data){
					$data['ctime'] = date('Y-m-d H:i:s',$data['ctime']);
					$data['mtime'] = date('Y-m-d H:i:s',$data['mtime']);
				}
				$data['tag'] = array();
				$tag_list = page::tag($G['get']['type'], $id);
				foreach($tag_list as $v){
					$data['tag'][] = $v['title'];
				}
				$data['tag'] = json::encode($data['tag']);
			}
			
			$config = load::config();
			$data['transfer'] = isset($config['transfer'][$table])?$config['transfer'][$table]:array();
			
			$data['page'] = array();
			$path = load::theme();
			$temp = dir::read("{$path}/html/{$table}_detail");
			foreach($temp['file'] as $v){
				$data['page'][$v] = $v;
			}
			$data['subarr'] = page::items_option(0,false,array(),false,$G['get']['type']);
			echo $this->theme('group/edit', $data);
		}else{
			alert('没有指定栏目');
		}
	}
	
	/* b o s s c m s */
	public function add()
	{	
		global $G;
		$this->cover('content',arrExist($G['get'],'id')?'M':'A');
		if(isset($G['post'])){
			$content = $G['post']['content'];
			$subcon = $content?strSub(addslashes(strip_tags(delFilter($content))),0,100):'';
			$data = array(
				'name'        => $G['post']['name'],
				'items'       => $G['post']['items'],
				'theme'       => $G['post']['theme'],
				'title'       => $G['post']['title'],
				'keywords'    => $G['post']['keywords'],
				'description' => $G['post']['description']?$G['post']['description']:$subcon,
				'alt'         => $G['post']['alt'],
				'target'      => $G['post']['target'],
				'sort'        => $G['post']['sort'],
				'notice'      => $G['post']['notice'],
				'recommend'   => $G['post']['recommend'],
				'top'         => $G['post']['top'],
				'display'     => $G['post']['display'],
				'static'      => arrExist($G['post'],'static'),
				'link'        => $G['post']['link'],
				'image'       => arrExist($G['post'],'image'),
				'text'        => $G['post']['text']?$G['post']['text']:$subcon,
				'ctime'       => $G['post']['ctime']?strtotime($G['post']['ctime']):TIME,
				'mtime'       => $G['post']['mtime']?strtotime($G['post']['mtime']):TIME,
				'content'     => $content,
				'container'   => arrExist($G['post'],'container')
			);
			if(!($type = arrExist($G['get'],'type'))){
				alert('没有指定栏目类型');
			}
			$table = array_search($type,$G['pass']['type']);
			if($type==2 || $type==3 || $type==4){
				$data['text1']    = arrExist($G['post'],'text1');
				$data['text2']    = arrExist($G['post'],'text2');
				$data['text3']    = arrExist($G['post'],'text3');
				$data['image1']   = arrExist($G['post'],'image1');
				$data['image2']   = arrExist($G['post'],'image2');
				$data['image3']   = arrExist($G['post'],'image3');
				$data['images']   = arrExist($G['post'],'images');
			}
			if($type == 2){
				if(!$data['image']){
					preg_match('/<img src="([^"]+)"/',delFilter($data['content']),$match);
					if(isset($match[1])){
						$data['image'] = addslashes($match[1]);
					}
				}
			}
			if($type == 3){
				$data['icon'] = arrExist($G['post'],'icon');
				$data['video'] = arrExist($G['post'],'video');
				$data['content1'] = arrExist($G['post'],'content1');
				$data['content2'] = arrExist($G['post'],'content2');
				$data['content3'] = arrExist($G['post'],'content3');
				$data['content4'] = arrExist($G['post'],'content4');
				$data['price'] = arrExist($G['post'],'price');
			}else if($type == 5){
				$bosscms_ = true;
				$data['file'] = $G['post']['file'];
				$data['size'] = $G['post']['size'];
				$data['icon'] = arrExist($G['post'],'icon');
				if($data['file'] && !$data['size']){
					$data['size'] = @filesize(url::upload($data['file'],'sub',ROOT_PATH));
				}
			}
			
			$items = arrExist($G['get'],'items');
			if($items && mysql::total('items',"id='{$items}'")){
				if($id = arrExist($G['get'],'id')){
					if($result = mysql::select_one('id,mtime',$table,"id='{$id}'")){
						if($result['mtime'] == $data['mtime']){
							$data['mtime'] = TIME;
						}
						mysql::update($data,$table,"id='{$id}'");
					}else{
						alert('没有内容');
					}
				}else{
					$id = mysql::insert($data,$table);
					$this->sitemap();
				}
				
				$tag_list = page::tag($type, $id);
				if($tag = arrExist($G['post'],'tag')){
					$tag = json::defilter($tag);
					foreach($tag as $t){
						if($res = mysql::select_one('*','tag',"type='{$type}' AND title='{$t}'")){
							if(strstr(",{$res['parent']},",",{$id},")){
								foreach($tag_list as $i=>$l){
									if($l['title']==stripslashes($t)){
										unset($tag_list[$i]);
									}
								}
							}else{
								mysql::update(array('parent'=>($res['parent']?$res['parent'].',':'').$id),'tag',"id='{$res['id']}'");
							}
						}else{
							mysql::insert(array('type'=>$type,'title'=>$t,'parent'=>$id,'name'=>'','seo_title'=>'','keywords'=>'','description'=>''),'tag');
						}
					}
				}
				foreach($tag_list as $l){
					mysql::update(array('parent'=>preg_replace("/^{$id}$|^{$id},|,{$id},|,{$id}$/i",'',$l['parent'])),'tag',"id='{$l['id']}'");
				}
				
				if($type==3 || $type==4 || $type==5){
					value::set(arrExist($G['post'],'tc'), $id, $type);
				}
				alert('操作成功', url::mpf('group','group','edit',array('id'=>$id,'success'=>'ok')));
			}else{
				alert('没有指定栏目');
			}
		}else{
			alert('没有提交信息');
		}
	}
	
	public function paste()
	{
		global $G;
		$G['cover'] = $this->cover('content');
		if(preg_match('/^(copys|move)$/',$G['get']['action']) && preg_match('/^(2|3|4|5)$/',$G['get']['type'])){
			$data['action'] = $G['get']['action'];
			$data['subarr'] = page::items_option(0,false,array(),false,$G['get']['type']);
			echo $this->theme('group/paste',$data);
		}
	}
	
	public function copys()
	{
		global $G;
		$this->cover('content','A');
		if(preg_match('/^[\d\,]+$/',$G['get']['id'])){
			if(is_numeric($G['post']['copys'])){
				$cpy = array();
				$arr = explode(',',$G['get']['id']);
				$table = array_search($G['get']['type'],$G['pass']['type']);
				foreach($arr as $id){
					if(is_numeric($id)){
						if($data = mysql::select_one('*',$table,"id='{$id}'")){
							$cpy[$id] = $data;
						}
					}
				}
				if($cpy){
					$error=array();
					foreach($cpy as $id=>$data){
						unset($data['id']);
						$data['items'] = $G['post']['copys'];
						$data['ctime'] = $data['mtime'] = TIME;
						$data['notice'] = 0;
						$data['static'] = '';
						if($nid=mysql::insert($data,$table)){
							$res = mysql::select_all('*','theme',"extent='{$G['get']['type']}' AND parent='{$id}'");
							foreach($res as $val){
								unset($val['id']);
								$val['parent'] = $nid;
								mysql::insert($val,"theme");
							}
						}else{
							$error[]=$id;
						}
					}
					if($error){
						alert('ID为'.implode(',',$error).'复制失败');
					}else{
						$this->sitemap();
						alert('复制成功', url::mpf('group','group','paste',array('action'=>'copys','success'=>'ok')));
					}
				}else{
					alert('没有复制对象');
				}
			}else{
				alert('没有指定栏目');
			}		
		}
		alert('没有提交信息');
	}
	
	public function move()
	{
		global $G;	
		$this->cover('content','M');
		if(preg_match('/^[\d\,]+$/',$G['get']['id'])){
			if(is_numeric($G['post']['move'])){
				$move = array();
				$arr = explode(',',$G['get']['id']);
				$table = array_search($G['get']['type'],$G['pass']['type']);
				foreach($arr as $id){
					if(is_numeric($id)){
						if($data = mysql::select_one('*',$table,"id='{$id}' AND items!='{$G['post']['move']}'")){
							$move[] = $id;
						}
					}
				}
				if($move){
					$error=array();
					foreach($move as $id){
						if(mysql::update(array('items'=>$G['post']['move']),$table,"id='{$id}'")){
							
						}else{
							$error[]=$id;
						}
					}
					if($error){
						alert('ID为'.implode(',',$error).'移动失败');
					}else{
						$this->sitemap();
						alert('移动成功', url::mpf('group','group','paste',array('action'=>'move','success'=>'ok')));
					}
				}else{
					alert('没有移动对象');
				}
			}else{
				alert('没有指定栏目');
			}
		}
		alert('没有提交信息');
	}
	
	public function delete()
	{
		global $G;	
		$this->cover('content','D');
		if(isset($G['post']['url']) && isset($G['get']['id'])){
			$del = array();
			$arr = explode(',',$G['get']['id']);
			$table = array_search($G['get']['type'],$G['pass']['type']);
			foreach($arr as $id){
				if(is_numeric($id)){
					if($result = mysql::select_one('name',$table,"id='{$id}'")){
						$del[$id] = $result['name'];
					}
				}
			}
			if($del){
				$error=array();
				foreach($del as $id=>$name){
					if(is_numeric(mysql::delete($table,"id='{$id}'"))){
						
					}else{
						$error[]=$id;
					}
				}
				if($error){
					alert('ID为'.implode(',',$error).'删除失败');
				}else{
					$this->sitemap();
					alert('删除成功', url::mpf('group','group','init',array('id'=>null)));
				}
			}else{
				alert('没有删除对象');
			}			
		}
		alert('没有提交信息');
	}
}
?>