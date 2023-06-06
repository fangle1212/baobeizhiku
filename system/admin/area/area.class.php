<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class area extends admin
{
    public function nav()
    {
        global $G;
		return $this->permit(
			array(
				'area' => array(
					'name' => '分站列表',
					'mold' => 'area',
					'check' => 'RAMD'
				),
				'config' => array(
					'name' => '分站设置',
					'mold' => 'area',
					'part' => 'config',
					'check' => 'RM'
				)
			)
		);
    }
	
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover();
		$G['navs1'] = self::nav();
		$G['navs1']['area']['active'] = true;
		$items = 88888;
		$parent = is_numeric($G['get']['parent'])?$G['get']['parent']:0;
		$oldurl = url::$domain;
		url::$domain = $G['config']['domain'];
		$G['path']['type']='web';
		$it = page::items_one($items);
		$data = page::area_pages($items, $parent);
		foreach($data['list'] as $k=>$v){
			$r = page::area($v['id'],'count(*) AS _total');
			$data['list'][$k]['child'] = $r[0]['_total'];
			$data['list'][$k]['domain'] = url::items($it,null,null,$v);
		}
		
		url::$domain = $oldurl;
		$G['path']['type']='admin';
		echo $this->theme('area/area', $data);
	}
	
	public function modify()
	{
		global $G;
		$this->face();
		$this->cover('area','M');
		if(isset($G['post']['id'])){
			$bosscms_error=array();
			foreach($G['post']['id'] as $id){
				if(isset($G['post']['display'.$id])){
					$data = array(
						'display'=>$G['post']['display'.$id]
					);
					if(!is_numeric(mysql::update($data,"area","id='{$id}'"))){
						$bosscms_error[]=$id;
					}
				}
			}
			if($bosscms_error){
				alert('ID为'.implode(',',$bosscms_error).'修改失败');
			}else{
				alert('修改成功', url::mpf('area','area','init'));
			}
		}else{
			alert('没有提交信息');
		}
	}
		
	public function edit()
	{
		global $G;
		$G['cover'] = $this->cover('area');
		$data = array();
		if(isset($G['get']['id'])){
			$data = mysql::select_one('*','area',"id='{$G['get']['id']}'");
		}
		echo $this->theme('area/edit', $data);
	}
	
	public function add()
	{	
		global $G;
		$this->face();
		$this->cover('area','M');
		if(isset($G['post'])){
			if(!$id = arrExist($G,'get|id')){
				alert('没有指定修改城市id');
			}
			$data = array(
				'sign'         => $G['post']['sign'],
				'name'         => $G['post']['name'],
				'prefix'       => $G['post']['prefix'],
				'display'      => $G['post']['display'],
				'title'        => $G['post']['title'],
				'keywords'     => $G['post']['keywords'],
				'description'  => $G['post']['description'],
				'content'      => $G['post']['content']
			);
			if($result = mysql::select_one('id','area',"id='{$id}'")){
				mysql::update($data,"area","id='{$id}'");
				alert('操作成功', url::mpf('area','area','edit',array('id'=>$id,'success'=>'ok')));
			}else{
				alert('没有找到对应城市id');
			}
		}else{
			alert('没有提交信息');
		}
	}
	
	public function import()
	{
		global $G;
		$G['cover'] = $this->cover('area');
		$data = array();
		into::basic_json('area');
		$data['id'] = array();
		foreach($G['area'] as $v){
			$sl = $v['sign'].','.$v['level'];
			if(strstr($v['level'],'1')){
				$data['area'][$sl] = $v['name'];
				$data['id'][] = $sl;
			}
			if($v['level']==2){
				$data['area'][$sl] = '&nbsp;&nbsp;&#10551;&nbsp;'.$v['name'];
				$data['id'][] = $sl;
			}
			if(strstr($v['level'],'3')){
				$data['area'][$sl] = '&emsp;&nbsp;&#10551;&nbsp;'.$v['name'];
			}
		}
		echo $this->theme('area/import', $data);
	}
	
	public function put()
	{
		global $G;
		$this->face();
		$this->cover('area','A');
		into::basic_json('area');
		if(isset($G['post']['area'])){
			$area = json::defilter($G['post']['area']);
			foreach($G['area'] as $v){
				if(in_array($v['sign'].','.$v['level'],$area)){
					if($v['parent']){
						$res = mysql::select_one('id','area',"sign='{$v['parent']}'");
						$v['parent'] = $res['id']?$res['id']:0;
					}
					$data = array( 
						'sign' => $v['sign'],
						'parent' => $v['parent'],
						'name' => $v['name'],
						'prefix' => $v['prefix'],
						'display' => 1,
						'title' => '',
						'keywords' => '',
						'description' => '',
						'content' => ''
					);
					if(!mysql::total('area',"sign='{$data['sign']}'")){
						mysql::insert($data,'area');
					}
				}
			}
			$this->sitemap();
			alert('导入成功',url::mpf('area','area','import',array('success'=>'ok')));
		}else{
			alert('没有提交信息');
		}
	}
	
	public function delete()
	{
		global $G;
		$this->face();
		$this->cover('area','D');
		if(isset($G['post']['url']) && isset($G['get']['id'])){
			$del = array();
			$arr = explode(',',$G['get']['id']);
			foreach($arr as $id){
				if(is_numeric($id)){
					$del[$id] = $id;
				}
			}
			if($del){
				$error=array();
				foreach($del as $id=>$name){
					if(is_numeric(mysql::delete("area","id='{$id}'"))){
						mysql::delete("link","area='{$id}'");
						$all = mysql::select_all('id','area',"parent='{$id}'");
						foreach($all as $v){
							$all2 = mysql::select_all('id','area',"parent='{$v['id']}'");
							if(is_numeric(mysql::delete("area","parent='{$v['id']}'"))){
								mysql::delete("link","FIND_IN_SET(area,'".implode(',',arrOption($all2,'id','id'))."')");
							}
						}
						if(is_numeric(mysql::delete("area","parent='{$id}'"))){
							mysql::delete("link","FIND_IN_SET(area,'".implode(',',arrOption($all,'id','id'))."')");
						}
					}else{
						$error[]=$id;
					}
				}
				if($error){
					alert('ID为'.implode(',',$error).'删除失败');
				}else{
					$this->sitemap();
					alert('删除成功');
				}
			}else{
				alert('没有删除对象id');
			}			
		}
		alert('没有提交信息');
	}
}
?>