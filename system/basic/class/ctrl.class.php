<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

class ctrl
{
	public static function form($style, $name, $param=null, $must=null, $explain=null, $value=null, $code=false)
	{
		global $G;
		$attribute = array();
		if(isset($must) && $must){
			$attribute['required'] = 'required';
		}
		if(isset($explain)){
			$attribute['placeholder'] = $explain;
		}
		if(isset($param) && is_string($param)){
			$json = json::decode($param);
			if($json){
				$param = array();
				foreach($json as $v){
					$param[$v] = $v;
				}
			}
		}
		switch($style){
			case 0:
			    return form::input($name, $value, null, 'text', $attribute, $code);
			case 1:
			    return form::input($name, $value, null, 'tel', $attribute, $code);
			case 2:
			    return form::input($name, $value, null, 'email', $attribute, $code);
			case 3:
			    return form::select($name, $value, null, $param, $attribute, $code);
			case 4:
			    return form::textarea($name, $value, null, $attribute, $code);
			case 5:
			    return form::radio($name, $value, null, $param, $attribute, $code);
			case 6:
			    return form::checkbox($name, $value, null, $param, $attribute, $code);
			case 7:
			    return form::files($name, $value, null, 'file', $attribute, $code);
		}
	}
	
	public static function complex($extent, $core, $v, $items, $data, $parent=0, $dstyle=null){
		if($v['style'] == 30){
			$parent = $parent?$parent:null;
			$html = '
			<code class="complex">
			  <ins>
				<a class="button green tfa" easy win="parent2" width="1200" url="'.url::mpf('complex','complex','init',array('extent'=>$extent,'items'=>$items,'core'=>$core,'name'=>$v['name'],'parent'=>$parent,'dstyle'=>$dstyle)).'" target="_blank">
				  <em class="fa fa-pencil"></em>
				  <font>配置项目</font>
				</a>
				<a class="button red tfa complexCheck" url="'.url::mpf('complex','complex','params',array('extent'=>$extent,'items'=>$items,'core'=>$core,'name'=>$v['name'],'parent'=>$parent,'dstyle'=>$dstyle)).'">
				  <em class="fa fa-refresh"></em>
				  <font>刷新</font>
				</a>
				<i>点击“配置项目”设置参数的表单，完成点击“刷新”查看！</i>
			  </ins>
			  <div></div>
			</code>';
		}else{
			$html = ctrl::style($v['style'],"tc[{$core}][{$v['name']}]",arrExist($data,"{$core}|{$v['name']}"),$v['value'],$v['param'],$v['title'],$v['attribute'],$v['ctrl']);
		}
		return $html;
	}
	
	public static function style($style, $name, $value, $default, $param, $title=null, $attribute=array(), $ctrl=null)
	{
		global $G;
		if(!$attribute){
			$attribute = array();
		}
		switch($style){
			case 0:
				if($title && !isset($attribute['placeholder'])){
					$attribute['placeholder'] = "请输入{$title}";
				}
			    $html = form::input($name, $value, $default, 'text', $attribute);
			break;
			case 1:
				if($title && !isset($attribute['placeholder'])){
					$attribute['placeholder'] = "请输入{$title}";
				}
			    $html = form::textarea($name, $value, $default, $attribute);
			break;
			case 2:
				$attribute['ueditor'] = null;
				if($title && !isset($attribute['placeholder'])){
					$attribute['placeholder'] = "请输入{$title}";
				}
			    $html = form::textarea($name, $value, $default, $attribute);
			break;
			case 3:
				if(!array_search('on',$attribute)){
					$attribute['no'] = null;
				}
			    $html = form::radio($name, $value, $default, $param, $attribute);
			break;
			case 4:
				$attribute['default'] = true;
			    $html = form::checkbox($name, $value, $default, $param, $attribute);
			break;
			case 5:
				if($title && !isset($attribute['placeholder'])){
					$attribute['placeholder'] = "请选择{$title}";
				}
			    $html = form::select($name, $value, $default, $param, $attribute);
			break;
			case 6:
				$param['image'] = null;
			    $html = form::textarea($name, $value, $default, array_merge($param, $attribute));
			break;
			case 7:
				$param['images'] = null;
			    $html = form::textarea($name, $value, $default, array_merge($param, $attribute));
			break;
			case 8:
				$param['video'] = null;
			    $html = form::textarea($name, $value, $default, array_merge($param, $attribute));
			break;
			case 9:
				$param['file'] = null;
			    $html = form::textarea($name, $value, $default, array_merge($param, $attribute));
			break;
			case 10:
				$attribute['param'] = null;
				$attribute['placeholder'] = quotesFilter(json::encode($param));
			    $html = form::textarea($name, $value, $default, $attribute);
			break;
			case 11:
				$attribute['params'] = null;
				$attribute['placeholder'] = quotesFilter(json::encode($param));
			    $html = form::textarea($name, $value, $default, $attribute);
			break;
			case 12:
				$param['color'] = null;
			    $html = form::textarea($name, $value, $default, array_merge($param, $attribute));
			break;
			case 13:
				$param['icon'] = null;
			    $html = form::textarea($name, $value, $default, array_merge($param, $attribute));
			break;
			case 14:
				$param['toggle'] = null;
			    $html = form::textarea($name, $value, $default, array_merge($param, $attribute));
			break;
			case 15:
				$date = array();
				foreach(array('Y/m/d','Y/m/d H:i','Y/m/d H:i:s', 'Y-m-d','Y-m-d H:i','Y-m-d H:i:s', 'Y年m月d日','Y年m月d日 H:i','Y年m月d日 H:i:s') as $v){
					$date[$v] = date($v, TIME);
				}
			    $html = form::select($name, $value, $default, $date, array_merge($param, $attribute));
			break;
			case 16:
				$param['seekbar'] = null;
			    $html = form::textarea($name, $value, $default, array_merge($param, $attribute));
			break;
			case 20:
				if(!isset($attribute['placeholder'])){
					$param['placeholder'] = '请选择栏目';
				}
			    $html = form::select($name, $value, $default, page::items_option('0','',array(),true), array_merge($param, $attribute));
			break;
			case 21:
				if(!isset($attribute['placeholder'])){
					$param['placeholder'] = '请选择栏目';
				}
			    $html = form::select($name, $value, $default, page::items_option('0','',array(),false,$param['type']?explode(',',$param['type']):array(2,3,4,5)), array_merge($param, $attribute));
			break;
			case 22:
				if(!isset($attribute['placeholder'])){
					$param['placeholder'] = '请选择栏目';
				}
			    $html = form::select($name, $value, $default, page::items_option('0','',array(),false,6), array_merge($param, $attribute));
			break;
			case 23:
				if(!isset($attribute['placeholder'])){
					$param['placeholder'] = '请选择栏目';
				}
			    $html = form::select($name, $value, $default, page::items_option('0','',array(),false,7), array_merge($param, $attribute));
			break;
			case 24:
				if(!isset($attribute['placeholder'])){
					$param['placeholder'] = '请选择栏目类型';
				}
			    $html = form::select($name, $value, $default, $G['option']['type'], array_merge($param, $attribute));
			break;
			case 31:
				$param['project'] = null;
				if(isset($value)){
					$res = is_array($value)?$value:($value?json::decode($value):array());
				}else{
					$res = json::decode($default);
				}
				if(!preg_match('/\[|\]/',$name)){
					$html = '<code class="project best">';
					$html .= form::textarea($name, is_array($value)?json::encode($value):$value, $default, array_merge($param, $attribute), false);
				}else{
					$html = '<code class="project"><span></span>';
				}
				foreach($res as $key=>$val){
					$html .= '<div class="init"><dfn>'.($param['item']?str_replace('[item]',$key+1,$param['item']):'').'</dfn>';
					foreach($ctrl as $v){
						$html .= '<dl style="width:'.$v['attribute']['dlwidth'].';"><dt><strong>'.$v['title'].'</strong></dt><dd>'.self::style($v['style'], $name.'['.$key.']['.$v['name'].']', $val[$v['name']], $v['value'], $v['param'], $v['title'], $v['attribute'], $v['ctrl']).
								 '<cite>'.$v['description'].'</cite></dd></dl>';
						$html .= $v['attribute']['dlclear']?'<div class="clear"></div>':'';
					}
					$html .= '<del>×</del></div>';
				}
				$data = '<div><dfn></dfn>';
				foreach($ctrl as $v){
					$data .= '<dl style="width:'.$v['attribute']['dlwidth'].';"><dt><strong>'.$v['title'].'</strong></dt><dd>'.self::style($v['style'], $name.'[0]['.$v['name'].']', $v['value'], $v['value'], $v['param'], $v['title'], $v['attribute'], $v['ctrl']).
							 '<cite>'.$v['description'].'</cite></dd></dl>';
					$data .= $v['attribute']['dlclear']?'<div class="clear"></div>':'';
				}
				$data .= '<del>×</del></div>';
				$html .='<a class="add" data="'.strtr(rawurlencode($data),array('%21'=>'!','%2A'=>'*','%27'=>"'",'%28'=>'(','%29'=>')')).'">+ 新增项目</a></code>';
			break;
			case 40:
				$param['linkage'] = null;
			    $html = form::textarea($name, $value, $default, array_merge($param, $attribute));
			break;
		}
		/* BOSS_CMS */
		return $html;
	}
}
?>