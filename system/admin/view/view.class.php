<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class view extends admin
{	
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover();
		$G['no_copyright'] = true;
		$data['ctrl'] = load::ctrl();
        $data['language'] = page::language_list();
		echo $this->theme('view/view', $data);	
	}
	
	public function edit()
	{
		global $G;
		$G['cover'] = $this->cover('view');
		$data = array();
		$extent = $G['get']['eid'];
		$core = $G['get']['core'];
		$parent = $G['get']['parent'];
		$where = "extent='{$extent}' AND core='{$core}' AND parent='{$parent}'";
		if(isset($G['get']['tname'])){
			$where .= " AND FIND_IN_SET('{$G['get']['tname']}',name)";
		}
		$result = mysql::select_all('core,name,value','theme',$where);
		foreach($result as $v){
			$data[$v['core']][$v['name']] = $v["value"];
		}
		
		$data['ctrl'] = theme::core_series($core, $extent, null);
		if(isset($G['get']['tname'])){
			$ctrl = array();
			$title = '';
			foreach($data['ctrl'][$core] as $key=>$val){			
				foreach($val['ctrl'] as $k=>$v){
					if($v['name'] == $G['get']['tname']){
						$title = $val['title'];
						$ctrl[$k] = $v;
						break;
					}
				}
			}
			$data['ctrl'] = array();
			$data['ctrl'][$core][$key]['title'] = $title;
			$data['ctrl'][$core][$key]['ctrl'] = $ctrl;
		}
		echo $this->theme('view/edit', $data);
	}
	
	public function table_edit()
	{
		global $G;
		$G['cover'] = $this->cover('view');
		$data = array();
		$title = '';
		$did = $G['get']['did'];		
		$dname = $G['get']['dname'];
		$dtable = $G['get']['dtable'];
		$dstyle = arrExist($G['get'],'dstyle');
		$dparam = $G['dparam'] = delFilter(arrExist($G['get'],'dparam'));
		if($dparam){
			$dparam = json::decode(urldecode($dparam));
		}
		$result = mysql::select_one($dname,$dtable,"id='{$did}'");
		if($dtable == 'theme'){
			$result = mysql::select_one("{$dname},name",$dtable,"id='{$did}'");
			preg_match("/\w+,(\d+)$/", $result['name'], $match);
			if($match[1]){
				$res = page::complex_one($match[1]);
				$title = $res['title'];
			}
		}
		if(isset($G['get']['djson'])){
			$data[$dtable][$dname] = arrExist(json::decode($result[$dname]),$G['get']['djson']);
		}else{
			$data[$dtable][$dname] = $result[$dname];
		}
		$data['ctrl'][$dtable][0]['title'] = '单元设置';
		$data['ctrl'][$dtable][0]['ctrl'][0] = array(
			"style" => is_numeric($dstyle)?$dstyle:1,
			"title" => $title?$title:"编辑修改",
			"name" => $dname,
			"value" => "",
			"description" => "",
			"param" => is_array($dparam)?$dparam:array()
		);
		echo $this->theme('view/edit', $data);
	}
	
	public function add()
	{
		global $G;
		$this->cover('view','M');
		if(isset($G['get']['dtable'])){
			$did = $G['get']['did'];
			$dtable = $G['get']['dtable'];
			$dname = $G['get']['dname'];
			$dstyle = $G['get']['dstyle'];
			if(isset($G['post']['tc']) && is_numeric($did)){
				foreach($G['post']['tc'] as $core=>$arr){
					if(isset($G['get']['djson'])){
						$result = mysql::select_one($dname,$dtable,"id='{$did}'");
						$value = json::decode($result[$dname]);
						$value[$G['get']['djson']] = $arr[$dname];
						$arr[$dname] = json::encode($value);
					}
					if(is_array($arr[$dname])){
						$arr[$dname] = json::enfilter($arr[$dname]);
					}
					mysql::update(array($dname=>$arr[$dname]),$dtable,"id='{$did}'");
				}
			}
			alert('操作成功', url::mpf('view','view','table_edit',array('dparam'=>urlencode(delFilter(arrExist($G['get'],'dparam'))))));
		}else if(isset($G['get']['core'])){
			value::set(arrExist($G,'post|tc'), isset($G['get']['parent'])?$G['get']['parent']:0, $G['get']['eid']);
			alert('操作成功', url::mpf('view','view','edit'));
		}
	}
	
	public function page()
	{
		global $G;
		if(session::get("view{$G['language']['id']}")){
			location(url::view(session::get("view{$G['language']['id']}"),false));
		}else{
			location(url::home());
		}
	}
}
?>