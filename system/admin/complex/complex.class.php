<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class complex extends admin
{
		
	public function init()
	{
		global $G;
		$core = $G['get']['core'];
		$extent = $G['get']['extent'];
		$name = $G['get']['name'];
		$items = $G['get']['items'];
		$parent = arrExist($G['get'],'parent');
		$dstyle = arrExist($G['get'],'dstyle');
		$data['list'] = page::complex($extent, $items, $core, $name, $parent);
		$data['style'] = $data['subarr'] = array();
		if($parent){
			$result = page::complex_one($parent);
			$param = json::decode($result['param']);
			foreach($param as $p){
				$data['style'][$p] = $G['option']['style'][$p];
			}
		}else{
			if($extent==3 || $extent==4 || $extent==5){
				foreach(array(0,1,3,4) as $i){
					$data['style'][$i] = $G['option']['style'][$i];
				}
				$data['subarr'] = page::items_option('0','',array(),false,$extent);
			}else if($extent==88){
				$result = theme::ctrl($core, $extent);
				if(isset($result['ctrl'])){
					foreach($result['ctrl'] as $v){
						if($v['name'] == $name){
							foreach($v['param'] as $p){
								$data['style'][$p] = $G['option']['style'][$p];
							}
							break;
						}
					}
				}
			}else if(isset($dstyle)){
				$dstyle = explode(',',$dstyle);
				foreach($dstyle as $i){
					$data['style'][$i] = $G['option']['style'][$i];
				}
			}
		}
		$data['items'] = $items;
		echo $this->theme('complex/complex', $data);
	}
	/* b o s s c m s */
	public function modify()
	{
		global $G;
		if(isset($G['post']['id'])){
			foreach($G['post']['id'] as $k=>$v){
				$data = array(
					'id'     => $v,
					'extent' => $G['get']['extent'],
					'name'   => $G['get']['name'],
					'parent' => isset($G['get']['parent'])?$G['get']['parent']:0,
					'core'   => arrExist($G['get'],'core'),
					'items'  => isset($G['post']['items'.$v])?$G['post']['items'.$v]:0,
					'style'  => $G['post']['style'.$v],
					'title'  => $G['post']['title'.$v],
					'description' => $G['post']['description'.$v],
					'param' => $G['post']['param'.$v],
					'sort' => $G['post']['sort'.$v]
				);
				mysql::select_set($data, 'complex', array('extent','items','style','core','name','param','title','description','sort'));
			}
			alert('保存成功！',url::mpf('complex','complex','init'));
		}else{
			alert('没有提交信息！');
		}
	}
	
	 
	public function delete()
	{
		global $G;	
		if(isset($G['post']['url']) && isset($G['get']['id'])){
			$del = $theme = array();
			$arr = explode(',',$G['get']['id']);
			foreach($arr as $id){
				if(is_numeric($id)){
					$theme[] = $del[$id] = mysql::select_one('*',"complex","id='{$id}'");
				}
			}
			if($del){
				$error=array();
				foreach($del as $id=>$com){
					if(is_numeric(mysql::delete("complex","id='{$id}'"))){
						while($id && $res=mysql::select_all('id','complex',"FIND_IN_SET(parent,'{$id}')")){
							$id = '';
							foreach($res as $v){
								$theme[] = $v;
								$id .= ($id==''?'':',').$v['id'];
								mysql::delete('complex',"id='{$v['id']}'");
							}
						}
					}else{
						$error[]=$id;
					}
				}
				foreach($theme as $v){
					mysql::delete('theme',"extent='{$v['extent']}' AND name='{$v['name']},{$v['id']}'");
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
	
	
	public function params()
	{
		global $G;
		$extent = arrExist($G['get'],'extent');
		$items  = isset($G['get']['items'])?$G['get']['items']:0;
		$core   = arrExist($G['get'],'core');
		$name   = arrExist($G['get'],'name');
		$parent = arrExist($G['get'],'parent');
		$id     = arrExist($G['get'],'id');
		$style  = arrExist($G['get'],'style');
		if($result = page::complex($extent, $items, $core, $name, $parent)){
			$html = '';
			$data[$core?$core:$items] = value::get($core, $id, $extent, null, false);
			foreach($result as $ks=>$vs){
				$html .= '
				<dl>
				  <dt>
					<strong>'.$vs['title'].'</strong>
				  </dt>
				  <dd>';
				if($vs['style'] == 30){
					$html .= ctrl::complex($extent, $core, $vs, $items, $data, $vs['id'], $style);
				}else{
					$html .= ctrl::style(
						$vs['style'], 
						'tc['.($core?$core:$items).']['.$vs['name'].','.$vs['id'].']', 
						arrExist($data,($core?$core:$items)."|{$vs['name']},{$vs['id']}"), 
						null, 
						arrSetKey(json::decode($vs['param'])),
						$vs['title'],
						$vs['attribute'],
						$vs['ctrl']
					);
				}
				$html .= '
				  <cite>'.$vs['description'].'</cite>
				  </dd>
				</dl>';
			}
			echo $html;
		}
	}
}
?>