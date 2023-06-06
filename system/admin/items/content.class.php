<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class content extends admin
{
	public function edit()
	{
		global $G;
		$G['cover'] = $this->cover('content');
		$id = arrExist($G['get'],'id');
		if($id){
			if(!$G['get']['column']){
				$G['body_class'] = 'iframe-content';
				$G['navsub'] = $this->navsub();
			}
			$data = mysql::select_one('*','items',"id='{$id}'");
			echo $this->theme('items/content',$data);
		}else{
			alert('没有指定栏目');
		}
	}
	
	public function add()
	{
		global $G;
		$this->cover('content','M');
		$bosscms=true;
		if(isset($G['post'])){
			$id = arrExist($G['get'],'id');
			if(is_numeric($id)){
				$data = array(
					'issub'       => arrExist($G['post'],'issub'),
					'content'     => arrExist($G['post'],'content')
				);
				if(!mysql::update($data,'items',"id='{$id}'")){
					alert('操作失败');
				}
			}
			alert('操作成功', url::mpf('items','content','edit'));
		}else{
			alert('没有提交信息');
		}
	}
	
	public function navsub()
	{
		global $G;
		$G['cover'] = $this->cover('content');
		$data = array();
		$items = page::items();
		$first = true;
		foreach($items as $v){
			if($v['type']==1){
				$data[] = array(
					'name' => $v['name'],
					'level' => $v['level']+1,
					'id' => $v['id'],
					'on' => $G['get']['id']==$v['id']?'on':'',
					'url' => url::mpf('items','content','edit',array('id'=>$v['id'],'items'=>null,'type'=>null))
				);
			}else if($v['type']>1 && $v['type']<6){
				$data[] = array(
					'name' => $v['name'],
					'level' => $v['level']+1,
					'id' => $v['id'],
					'on' => $G['get']['items']==$v['id']?'on':'',
					'url' => url::mpf('group','group','init',array('items'=>$v['id'],'type'=>$v['type'],'id'=>null))
				);
			}else{
				$data[] = array(
					'name' => $v['name'],
					'level' => $v['level']+1,
					'id' => $v['id'],
					'on' => '',
					'url' => 'javascript:;'
				);
			}
		}
		foreach($data as $k=>$v){
			if($v['url']=='javascript:;'){
				if((isset($data[$k+1]) && $v['level']>=$data[$k+1]['level']) || !isset($data[$k+1])){
					unset($data[$k]);
				}
			}
		}
		return $this->theme('content/content', $data);
	}
}
?>