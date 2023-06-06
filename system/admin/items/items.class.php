<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class items extends admin
{
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover();
		$data = array();
		$config = load::config();
		$data['max'] = isset($config['level'])&&is_numeric($config['level'])?$config['level']:3;
	  	$data['list'] = page::items(0);
		foreach($data['list'] as $v){
			if($v['type']!=9){
				if(!is_file(ROOT_PATH.$v['folder'].'/index.php')){
					$v['has_folder'] = $this->create($v['folder']);
				}
			}
		}
		echo $this->theme('items/items', $data);
	}
	
	public function modify()
	{
		global $G;
		$this->cover('items','M');
		if(isset($G['post']['id'])){
			$error=array();
			foreach($G['post']['id'] as $id){
				if(isset($G['post']['sort'.$id])){
					$data = array(
						'head'=>$G['post']['head'.$id],
						'foot'=>$G['post']['foot'.$id],
						'target'=>$G['post']['target'.$id],
						'display'=>$G['post']['display'.$id],
						'sort'=>$G['post']['sort'.$id]
					);
					if(!is_numeric(mysql::update($data,'items',"id='{$id}'"))){
						$error[]=$id;
					}
				}
			}
			if($error){
				alert('ID为'.implode(',',$error).'修改失败');
			}else{
				$this->sitemap();
				alert('修改成功', url::mpf('items','items','init'));
			}
		}else{
			alert('没有提交信息');
		}
	}
	/* b o s s c m s */
	public function edit()
	{
		global $G;
		$G['cover'] = $this->cover('items');
		$data = $over = array();
		if(isset($G['get']['id'])){
			$id = $over[] = $G['get']['id'];
			$data = mysql::select_one('*','items',"id='{$id}'");
		}
		if(isset($G['get']['parent'])){
			$parent = $data['parent'] = $G['get']['parent'];
			$result = mysql::select_one('type,theme,themes,folder','items',"id='{$parent}'");
			if(isset($result['type'])){
				$data['type'] = $result['type']!=9?$result['type']:'';
				$data['theme'] = $result['theme'];
				$data['themes'] = $result['themes'];
				$data['folder'] = $result['folder'];
			}
		}
		
		$data['page'] = array();
		$path = load::theme().'html/';
		$temp = dir::read($path);
		foreach($temp['dir'] as $dir){
			$res = dir::read($path.'/'.$dir);
			foreach($res['file'] as $v){
				$data['page'][$dir][$v] = $v;
			}
		}
		
		foreach($G['pass']['only'] as $k=>$v){
			if(mysql::total('items',"type='{$k}' AND id!='{$G['get']['id']}'".($v?'':' AND lang=lang'))){
				unset($G['option']['type'][$k]);
			}
		}
		
		$config = load::config();
		$data['transfer'] = isset($config['transfer']['items'])?$config['transfer']['items']:array();
		
		/* 获取栏目列表 */
		$data['subarr'] = page::items_option('0', '设为一级', $over, false);
		echo $this->theme('items/edit',$data);
	}
	
	public function add()
	{
		global $G;
		$id = arrExist($G['get'],'id');
		$this->cover('items',$id?'M':'A');
		if(isset($G['post'])){
			$data = array(
				'name'        => $G['post']['name'],
				'type'        => $G['post']['type'],
				'theme'       => arrExist($G['post'],"theme{$G['post']['type']}"),
				'themes'      => arrExist($G['post'],"themes{$G['post']['type']}"),
				'title'       => arrExist($G['post'],'title'),
				'keywords'    => arrExist($G['post'],'keywords'),
				'description' => arrExist($G['post'],'description'),
				'alt'         => arrExist($G['post'],'alt'),
				'head'        => $G['post']['head'],
				'foot'        => $G['post']['foot'],
				'nofollow'    => $G['post']['nofollow'],
				'target'      => $G['post']['target'],
				'sort'        => $G['post']['sort'],
				'display'     => $G['post']['display'],
				'static'      => arrExist($G['post'],'static'),
				'folder'      => arrExist($G['post'],'folder'),
				'parent'      => arrExist($G['post'],'parent'),
				'link'        => arrExist($G['post'],'link'),
				/* 栏目表保留字段 */
				'icon'        => arrExist($G['post'],'icon'),
				'image'       => arrExist($G['post'],'image'),
				'images'      => arrExist($G['post'],'images'),
				'text'        => arrExist($G['post'],'text'),
				'container'    => arrExist($G['post'],'container'),
				/* 栏目表预留字段 */
				'icon1'       => arrExist($G['post'],'icon1'),
				'image1'      => arrExist($G['post'],'image1'),
				'image2'      => arrExist($G['post'],'image2'),
				'image3'      => arrExist($G['post'],'image3'),
				'text1'       => arrExist($G['post'],'text1'),
				'text2'       => arrExist($G['post'],'text2'),
				'text3'       => arrExist($G['post'],'text3')
			);
			if(is_numeric($data['parent']) && $result=mysql::select_one('level','items',"id='{$data['parent']}'")){
				$data['level'] = $result['level']+1;
				$config = load::config();
				$maxlevel = isset($config['level'])&&is_numeric($config['level'])?$config['level']:3;
				if($maxlevel && $result['level']>=$maxlevel){
					alert("只能设置 {$maxlevel} 级栏目");
				}
			}else{
				$data['parent'] = 0;
				$data['level'] = 1;
			}
			
			if($id){
				if(is_numeric($id) && ($result=mysql::select_one('folder,level,type','items',"id='{$id}'"))){
					if($result['type'] != $data['type']){
						if($data['type']!=9){
							if(!$data['folder']){
								alert('栏目文件夹名称不能为空');
							}else if(!preg_match("/^\w+$/",$data['folder'])){
								alert('栏目文件夹名称必须为英文、数字、下划线等字符');
							}
						}
					}
					if($result['folder']!=$data['folder'] && preg_match("/^\w+$/",$result['folder']) && preg_match("/^\w+$/",$data['folder'])){
						if($data['folder'] && $data['type']!=9){
							$this->create($data['folder']);
						}
						if($result['folder'] && !mysql::total('items',"folder='{$result['folder']}' AND id!='{$id}'")){
							dir::remove(ROOT_PATH.$result['folder']);
						}
					}
					if(mysql::update($data,'items',"id='{$id}'")){					
						$diff = $result['level']-$data['level'];
						if($diff != 0){
							$subset = page::items($id, null, 'id,level');
							if($subset){
								foreach($subset as $v){
									mysql::update(array('level'=>$v['level']-$diff),'items',"id='{$v['id']}'");
								}
							}
						}
					}
				}else{
					alert('没有找到该栏目');
				}
			}else{
				if($data['type']!=9){
					if(!$data['folder']){
						alert('栏目文件夹名称不能为空');
					}else if(!preg_match("/^\w+$/",$data['folder'])){
						alert('栏目文件夹名称必须为英文、数字、下划线等字符');
					}else{
						$this->create($data['folder']);
					}
				}
				$data['issub'] = 0;
				$data['content'] = '';
				$id = mysql::insert($data, 'items');
				$this->sitemap();
				if(empty($id)){
					alert('保存失败');
				}
			}
			alert('操作成功', url::mpf('items','items','edit',array('parent'=>null,'id'=>$id,'success'=>'ok')));
		}else{
			alert('没有提交信息');
		}
	}
	
	public function delete()
	{
		global $G;
		$this->cover('items','D');
		if(isset($G['post']['url']) && isset($G['get']['id'])){
			$del = array();
			$arr = explode(',',$G['get']['id']);
			foreach($arr as $id){
				if(is_numeric($id)){
					if($result = mysql::select_one('folder','items',"id='{$id}'")){
						$del[$id] = $result['folder'];
						$res = page::items($id, null, 'id,folder');
						if($res){
							foreach($res as $v){
								$del[$v['id']] = $v['folder'];
							}
						}
					}
				}
			}
			if($del){
				$error=array();
				foreach($del as $id=>$folder){
					if(is_numeric(mysql::delete('items',"id='{$id}'"))){
						if(preg_match("/^\w+$/",$folder) && !mysql::total('items',"folder='{$folder}' AND lang=lang")){
							$path = ROOT_PATH.$folder.'/';
							if(is_dir($path)){
								dir::remove($path);
							}
						}
					}else{
						$error[]=$id;
					}
				}
				if($error){
					alert('ID为'.implode(',',$error).'删除失败');
				}else{
					$this->sitemap();
					alert('删除成功', url::mpf('items','items','init',array('id'=>null)));
				}
			}else{
				alert('没有删除对象id');
			}			
		}
		alert('没有提交信息');
	}
	
	public function folder()
	{
		global $G;
		$G['cover'] = $this->cover('items');
		$id = arrExist($G['get'],'id');
		$parent = arrExist($G['get'],'parent');
		$folder = arrExist($G['get'],'folder');
		if($folder){
			if( ($id && is_numeric($id)) || ($parent && is_numeric($parent)) ){
				if(!is_numeric($parent)) $parent=$id;
				$subarr = page::items(-$parent, null, 'id');
				$arr = '0';
				foreach($subarr as $v){
					$arr .= ','.$v['id'];
				}
				$subarr = page::items(isset($v['id'])?$v['id']:$parent, null, 'id');
				foreach($subarr as $v){
					$arr .= ','.$v['id'];
				}
				if($res = mysql::select_one('name','items',"folder='{$folder}' AND !FIND_IN_SET(id,'{$arr}') AND parent!='{$parent}'")){
					alert("该栏目目录已被“{$res['name']}”使用，请重新输入");
				}
			}else{
				if($res = mysql::select_one('name','items',"folder='{$folder}'",'level ASC,id ASC')){
					alert("该栏目目录已被“{$res['name']}”使用，请重新输入");
				}
			}
		}
	}
	
	public function create($folder)
	{
		if($folder && preg_match("/^\w+$/",$folder)){
			/* 创建文件内容 */
			$content = "<?php\n/*\n * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.\n * BOSSCMS Content Management System (https://www.bosscms.net/)\n */\nrequire '../index.php';\n?>";
			return dir::create(ROOT_PATH.$folder.'/index.php', $content);
		}
	}
}
?>