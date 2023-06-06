<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');
into::basic_class('curl');

class examine extends admin
{
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover();
		echo $this->theme('examine/examine', $data);
	}
	
	public function ssl()
	{
		global $G;
		$G['cover'] = $this->cover('examine');
		if($G['path']['http']=='https://'){
			echo '<p color="green">当前为https网址访问</p>';
		}else if(curl::code(preg_replace('/^http:/','https:',$G['path']['site'])) == 200){
			echo '<p color="green">当前域名支持https访问，建议配置http跳转https访问</p>';
		}else{
			echo '<p color="red">当前域名不支持https访问</p>';
		}
	}
	
	public function permission()
	{
		global $G;
		$G['cover'] = $this->cover('examine');
		$str = '';
		foreach(array('系统缓存'=>'cache/','上传文件'=>'upload/','网站模板'=>'system/web/theme/','应用插件'=>'system/plugin/','数据备份'=>'system/backup/') as $k=>$v){
			$path = ROOT_PATH.$v;
			dir::make($path);
			$str .= '<p>'.$k.'文件夹 '.$v.' ： ';
			if(is_readable($path) && is_writable($path)){
				$str .= '<span color="green">可读写</span>';
			}else if(is_readable($path)){
				$str .= '<span color="red">可读不可写</span>';
			}else if(is_writable($path)){
				$str .= '<span color="red">不可读可写</span>';
			}else{
				$str .= '<span color="red">不可读写</span>';
			}
			$str .= '</p>';
		}
		echo $str;
	}
	
	public function admin()
	{
		global $G;
		$G['cover'] = $this->cover('examine');
		if($G['path']['folder']=='admin'){
			echo '<p color="red">后台文件夹为 admin<br />存在安全隐患，建议<a color="blue" href="'.url::mpf('safe','safe','init').'">【修改】</a>后台目录</p>';
		}else{
			$admin = ROOT_PATH.'admin/index.php';
			if(is_file($admin) && preg_match('/IS_INSIDE.+iframe.+iframe.+init.+enter\.php/is',file_get_contents($admin))){
				echo '<p color="red">后台文件夹为 '.$G['path']['folder'].'<br />存在后台目录 admin，建议<a modify="admin" color="blue" url="'.url::mpf('examine','examine','delete_admin').'">【删除】</a>文件夹</p>';
			}else{
				echo '<p color="green">后台文件夹为 '.$G['path']['folder'].'</p>';
			}
		}
	}
	
	public function install()
	{
		global $G;
		$G['cover'] = $this->cover('examine');
		$folder = ROOT_PATH.'install/';
		if(is_dir($folder)){
			echo '<p color="red">安装文件夹存在<br />为安全考虑，建议<a modify="install" color="blue" url="'.url::mpf('examine','examine','delete_install').'">【删除】</a>安装文件夹</p>';
		}else{
			echo '<p color="green">安装文件夹已删除</p>';
		}
	}
	
	public function database()
	{
		global $G;
		$G['cover'] = $this->cover('examine');
		$str = '';
		into::basic_json('database',true,false);
		foreach($G['database'] as $table=>$arr){
			$table = $G['mysql']['prefix'].$table;
			if(mysql::select("SELECT table_name FROM information_schema.tables WHERE table_schema='{$G['mysql']['database']}' AND table_name='{$table}'",true)){
				foreach($arr as $column=>$attr){
					if($res = mysql::select("SELECT COLUMN_NAME AS column_name,COLUMN_TYPE AS column_type,IS_NULLABLE AS is_nullable,COLUMN_DEFAULT AS column_default,EXTRA AS extra FROM information_schema.columns WHERE table_schema='{$G['mysql']['database']}' AND table_name='{$table}' AND column_name='{$column}'",true)){
						$type = strSubPos($attr,' ');
						if(!($res['column_type']==$type || $res['column_type']==preg_replace('/\(\d+\)/','',$type))){
							$str .= '<p color="red">数据表 '.$table.'， 字段 '.$column.' 类型错误</p>';
						}else if(strstr($attr,'NOT NULL') && $res['is_nullable']=='YES'){
							$str .= '<p color="red">数据表 '.$table.'， 字段 '.$column.' 不能为空</p>';
						}else if(strstr($attr,' DEFAULT ') && $res['is_nullable']=='NO' && (!isset($res['column_default']) || !strstr($attr," DEFAULT '{$res['column_default']}'"))){
							$str .= '<p color="red">数据表 '.$table.'， 字段 '.$column.' 默认值错误</p>';
						}else if(strstr($attr,'AUTO_INCREMENT') && !stristr($res['extra'],'auto_increment')){
							$str .= '<p color="red">数据表 '.$table.'， 字段 '.$column.' 缺少自增值</p>';
						}
					}else{
						$str .= '<p color="red">数据表 '.$table.'， 缺少字段 '.$column.'</p>';
					}
				}
				$result = mysql::select("SELECT COLUMN_NAME AS column_name FROM information_schema.columns WHERE table_schema='{$G['mysql']['database']}' AND table_name='{$table}'");
				foreach($result as $v){
					if(!$arr[$v['column_name']]){
						$str .= '<p color="red">数据表 '.$table.'， 多余字段 '.$v['column_name'].'</p>';
					}
				}
			}else{
				$str .= '<p color="red">缺少数据表 '.$table.'</p>';
			}
		}
		if($str){
			if($this->cover('update','M')){
				echo $str.'<p color="red">建议<a modify="database" color="blue" url="'.url::mpf('examine','examine','edit_database').'">【修复】</a>数据库结构</p>';
			}
		}else{
			echo '<p color="green">结构完整</p>';
		}
	}
	
	public function delete_install()
	{
		global $G;
		$this->cover('examine','M');
		if(dir::remove(ROOT_PATH.'install/')){
			alert('删除成功');
		}
	}
	
	public function delete_admin()
	{
		global $G;
		$this->cover('examine','M');
		if(dir::remove(ROOT_PATH.'admin/')){
			alert('删除成功');
		}
	}
	
	public function edit_database()
	{
		global $G;
		$this->cover('examine','M');
		into::load_class('admin','update','update','new')->database();
		alert('修复完成');
	}
}
?>