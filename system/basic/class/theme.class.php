<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

class theme
{	
	public static function series($core, $extent=null, $series=null, $name=null)
	{
		$data = array();
		$config = load::ctrl();
		$config = $config[$core];
		if(isset($extent) && isset($series) && isset($name)){
			if(isset($config[$extent][$series][$name])){
				$data = $config[$extent][$series][$name];
			}
		}else if(isset($extent) && isset($series)){
			if(isset($config[$extent][$series])){
				$data = $config[$extent][$series];
			}
		}else if(isset($extent)){
			if(isset($config[$extent])){
				$data = $config[$extent];
			}
		}else{
			$data = $config;
		}
		return $data;
	}
	
	public static function series_list($core, $extent, $series='')
	{
		$data = array();
		$result = self::series($core, $extent);
		foreach($result as $key=>$val){
			if($val['parent'] == $series){
				$data[$key] = $val;
			}
		}
		return $data;
	}
	
	public static function core_series($core=null, $extent, $series=null)
	{
		$data = array();
		if(isset($core)){
			$data[$core] = self::series($core, $extent, $series);
		}else{
			$data = self::series($core, $extent, $series);
		}		
		return $data;
	}
	
	/** 
	 * 获取指定主题区块的控件列表
	 *
	 * @param string $core 指定调用的主题区块名称
	 * @param string $extent 指定控件的应用范围
	 * @param string $series    指定控件组的id
	 */
	public static function ctrl($core, $extent=null, $series=null)
	{
		$data = array();
		if(isset($extent) && isset($series)){
			$result = self::series($core, $extent, $series, 'ctrl');
			foreach($result as $val){
				$data['ctrl'][$val['name']] = $val;
			}
		}else if(isset($extent)){
			$result = self::series($core, $extent);
			foreach($result as $val){
				if(isset($val['ctrl'])){
					foreach($val['ctrl'] as $v){
						$data['ctrl'][$v['name']] = $v;
					}
				}
			}
		}else{
			$result = self::series($core);
			foreach($result as $extent){
				foreach($extent as $series){
					if(isset($series['ctrl'])){
						foreach($series['ctrl'] as $v){
							$data['ctrl'][$v['name']] = $v;
						}
					}
				}
			}
		} 
		return $data;
	}
		
		
	public static function dtag($id, $table, $name, $style=null, $param=null, $json=null)
	{
		global $G;
		return $G['view']?" did=\"{$id}\" dtable=\"{$table}\" dname=\"{$name}\"".(isset($style)?" dstyle=\"{$style}\"":'').(isset($param)?" dparam=\"{$param}\"":'').(isset($json)?" djson=\"{$json}\"":''):'';
	}
}
?>