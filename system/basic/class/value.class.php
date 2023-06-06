<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

class value
{	
	public static function get($core, $parent, $extent=0, $series=null, $ctrl=true)
	{
		global $G;
		$data = $style = array();
		if($ctrl){
			$result = theme::ctrl($core, $extent, $series);
			if(isset($result['ctrl'])){
				foreach($result['ctrl'] as $v){
					$style[$v['name']] = $v['style'];
					$data[$v['name']] = $v['style']==2?delHtmlspecial($v['value']):$v['value'];
					$data['_'.$v['name']] = $G['view']?" core=\"{$core}\" eid=\"{$extent}\" tname=\"{$v['name']}\" etype=\"{$v['style']}\" parent=\"{$parent}\"":'';
				}
			}
		}
		$result = mysql::select_all('id,name,value','theme',"parent='{$parent}' AND core='{$core}' AND extent='{$extent}'");
		if(isset($result)){
			foreach($result as $v){
				$data[$v['name']] = $style[$v['name']]==2?delHtmlspecial($v['value']):$v['value'];
				if(!isset($data['_'.$v['name']])){
					preg_match("/\w+,(\d+)$/", $v['name'], $match);
					$dstyle = $dparam = '';
					if($match[1]){
						$res = page::complex_one($match[1]);
						$dstyle = $res['style'];
						$param = json::decode($res['param']);
						$arr = array();
						foreach($param as $p){
							$arr[$p] = $p;
						}
						$dparam = $arr?urlencode(json::encode($arr)):null;
					}
					$data['_'.$v['name']] = theme::dtag($v['id'],"theme","value",$dstyle,$dparam);
				}
			}
		} 
		if(isset($G['area']) && preg_match('/"6"/',$G['config']['area_name_type'])){
			foreach($data as $k=>$v){
				if(preg_match('/[\x7f-\xff]/',$v) && !strstr($k,'_noarea')){
					if($style[$k]==0 || $style[$k]==1){
						$data[$k] = $G['area']['name'].$v;
					}else if($style[$k]==2){
						$data[$k] = RepHtmlStr($v,$G['area']['name']);
					}
				}
			}
		}
		return $data;
	}
	
	public static function set($tc, $parent, $extent=0)
	{
		global $G;
		$bosscms =true;
		if(isset($tc) && is_numeric($parent)){
			foreach($tc as $core=>$arr){
				/* 是否为数字，是则表示后台产品，图片，下载的栏目参数 */
				if(is_numeric($core)){
					$data = array(
						'extent' => $extent,
						'parent' => $parent,
						'core' => ''
					);
					foreach($arr as $k=>$v){
						$v = is_array($v)?json::enfilter($v):$v;
						if($v === ''){
							mysql::delete('theme',"extent='{$extent}' AND core='' AND parent='{$parent}' AND name='{$k}'");
						}else{
							$data['name'] = $k;
							$data['value'] = $v;
							mysql::select_set($data,'theme',array('value'));
						}
					}
				}else{
					$data = array(
						'extent' => $extent,
						'parent' => $parent,
						'core' => $core
					);
					$res = array();
					$result = theme::ctrl($core, $extent);
					if(isset($result['ctrl'])){
						foreach($result['ctrl'] as $c){
							$res[$c['name']] = $c['value'];
						}
					}
					foreach($arr as $k=>$v){
						$v = is_array($v)?json::enfilter($v):$v;
						if($res[$k] == $v){
							mysql::delete('theme',"extent='{$extent}' AND core='{$core}' AND parent='{$parent}' AND name='{$k}'");
						}else{
							$data['name'] = $k;
							$data['value'] = $v;
							mysql::select_set($data,'theme',array('value'));
						}
					}
				}
			}
		}
	}
}
?>