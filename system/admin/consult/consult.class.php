<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class consult extends admin
{
    public function nav()
    {
        global $G;
		return $this->permit(
			array(
				'consult' => array(
					'name' => '客服列表',
					'mold' => 'consult',
					'check' => 'RAMD'
				),
				'config' => array(
					'name' => '客服设置',
					'mold' => 'consult',
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
		$boss_cms = true;
		$G['navs1'] = self::nav();
		$G['navs1']['consult']['active'] = true;
		$data = page::consult();
		echo $this->theme('consult/consult', $data);
	}
	
	/* bosss c m s */
	public function modify()
	{
		global $G;
		$this->face();
		$this->cover('consult','M');
		if(isset($G['post']['id'])){
			$error=array();
			foreach($G['post']['id'] as $id){
				if(isset($G['post']['sort'.$id])){
					$data = array(
						'display'=>$G['post']['display'.$id],
						'sort'=>$G['post']['sort'.$id]
					);
					if(!is_numeric(mysql::update($data,"consult","id='{$id}'"))){
						$error[]=$id;
					}
				}
			}
			if($error){
				alert('ID为'.implode(',',$error).'修改失败');
			}else{
				alert('修改成功！', url::mpf('consult','consult','init'));
			}
		}else{
			alert('没有提交信息！');
		}
	}
	
	
	public function edit()
	{
		global $G;
		$G['cover'] = $this->cover('consult');
		$data = array();
		if(isset($G['get']['id'])){
			$data = mysql::select_one('*','consult',"id='{$G['get']['id']}'");
			$data["value{$data['type']}"] = $data["value"];
		}
		echo $this->theme('consult/edit', $data);
	}
	
	public function add()
	{	
		global $G;
		$this->face();
		$this->cover('consult',$G['get']['id']?'M':'A');
		if(isset($G['post']['type'])){
			$data = array(
				'name'        => $G['post']['name'],
				'type'        => $G['post']['type'],
				'value'       => $G['post']["value{$G['post']['type']}"],
				'sort'        => $G['post']['sort'],
				'display'     => $G['post']['display']
			);
			if($id = $G['get']['id']){
				if($result = mysql::select_one('id','consult',"id='{$id}'")){
					mysql::update($data,"consult","id='{$id}'");
				}else{
					alert('没有内容');
				}
			}else{
				$id = mysql::insert($data,"consult");
			}
			alert('操作成功', url::mpf('consult','consult','edit',array('id'=>$id,'success'=>'ok')));
		}else{
			alert('没有提交信息！');
		}
	}
	
	
	
	 
	public function delete()
	{
		global $G;
		$this->face();
		$this->cover('consult','D');
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
					if(is_numeric(mysql::delete("consult","id='{$id}'"))){
						
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
				alert('没有删除对象id！');
			}			
		}
		alert('没有提交信息！');
	}
}
?>