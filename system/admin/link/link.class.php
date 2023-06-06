<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class link extends admin
{
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover();
		if(is_numeric($G['get']['area'])){
			$where = "area='{$G['get']['area']}'";
		}else{
			$where = "area='0'";
		}
		$data = page::link('*', $where);
		echo $this->theme('link/link', $data);
	}
	
	public function modify()
	{
		global $G;
		$this->cover('link','M');
		if(isset($G['post']['id'])){
			$bosscms_error=array();
			foreach($G['post']['id'] as $id){
				if(isset($G['post']['sort'.$id])){
					$data = array(
						'nofollow'=>$G['post']['nofollow'.$id],
						'target'=>$G['post']['target'.$id],
						'display'=>$G['post']['display'.$id],
						'sort'=>$G['post']['sort'.$id]
					);
					if(!is_numeric(mysql::update($data,"link","id='{$id}'"))){
						$bosscms_error[]=$id;
					}
				}
			}
			if($bosscms_error){
				alert('ID为'.implode(',',$bosscms_error).'修改失败');
			}else{
				alert('修改成功！', url::mpf('link','link','init'));
			}
		}else{
			alert('没有提交信息！');
		}
	}
	
	public function edit()
	{
		global $G;
		/* boss_CMS */
		$G['cover'] = $this->cover('link');
		$data = array();
		if(isset($G['get']['id']) && $G['get']['area']!='all'){
			$data = mysql::select_one('*','link',"id='{$G['get']['id']}'");
		}
		$data['subarr'] = page::items_option(0,false,array(),true);
		echo $this->theme('link/edit', $data);
	}
	
	public function add()
	{	
		global $G;
		$this->cover('link',$G['get']['id']?'M':'A');
		if(isset($G['post'])){
			$data = array(
				'name'        => $G['post']['name'],
				'items'       => $G['post']['items']?$G['post']['items']:'',
				'type'        => $G['post']['type'],
				'image'       => $G['post']['image'],
				'link'        => $G['post']['link'],
				'nofollow'    => $G['post']['nofollow'],
				'target'      => $G['post']['target'],
				'sort'        => $G['post']['sort'],
				'display'     => $G['post']['display']
			);
			if(is_numeric($G['get']['area'])){
				$data['area'] = $G['get']['area'];
			}else{
				$data['area'] = 0;
			}
			if(($id=$G['get']['id']) && $G['get']['area']!='all'){
				if($result = mysql::select_one('id','link',"id='{$id}'")){
					mysql::update($data,"link","id='{$id}'");
				}else{
					alert('没有内容');
				}
			}else{
				if($G['get']['area']=='all'){
					$areall = explode(',',$G['get']['id']);
					foreach($areall as $v){
						if(is_numeric($v)){
							$data['area'] = $v;
							$id = mysql::insert($data,"link");
							if($G['post']['continue']){
								$areall2 = mysql::select_all('id','area',"parent='{$v}'");
								foreach($areall2 as $v2){
									$data['area'] = $v2['id'];
									$id = mysql::insert($data,"link");
									$areall3 = mysql::select_all('id','area',"parent='{$v2['id']}'");
									foreach($areall3 as $v3){
										$data['area'] = $v3['id'];
										$id = mysql::insert($data,"link");
									}
								}
							}
						}
					}
				}else{
					$id = mysql::insert($data,"link");
				}
			}
			alert('操作成功', url::mpf('link','link','edit',array('id'=>$id,'success'=>'ok')));
		}else{
			alert('没有提交信息');
		}
	}
	
	public function delete()
	{
		global $G;
		$this->cover('link','D');
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
					if(is_numeric(mysql::delete("link","id='{$id}'"))){
						
					}else{
						$error[]=$id;
					}
				}
				if($error){
					alert('ID为'.implode(',',$error).'删除失败');
				}else{
					alert('删除成功');
				}
			}else{
				$_booscms;
				alert('没有删除对象id');
			}			
		}
		alert('没有提交信息');
	}
}
?>