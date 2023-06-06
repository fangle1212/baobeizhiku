<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class update extends admin
{
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover();
		echo $this->theme('update/update');
	}
	
	public function download()
	{
		global $G;
		$this->cover('update','M');
		$version = arrExist($G['get'],'version');
		if($version && preg_match('/^V[\d\.]+$/',$version) && $version>=$G['config']['version']){
			into::basic_class('curl');
			$name = $version.'.update.zip';
			$path = ROOT_PATH.'cache/'.$name;
			dir::delete($path);
			dir::create($path,'');
			curl::files('https://storage.bosscms.net/file/download/patch/'.$name, $path);
			into::basic_class('zip');
			if(zip::unzip($path, ROOT_PATH)){
				echo 'ok';
			}
		}
	}
	
	public function install()
	{
		global $G;
		$this->cover('update','M');
		if(is_file(ROOT_PATH.'system/admin/update/install.class.php')){
			into::load_class('admin','update','install');
			install::update();
		}
	}
	
	public function database($data=null)
	{
		global $G;
		$this->cover('update','M');
		if(!isset($data)){
			into::basic_class('cache');
			dir::remove(cache::get('',false,'json'), false);
			into::basic_json('database',true);
			$data = $G['database'];
		}
		foreach($data as $table=>$arr){
			/* 查询数据表是否存在 */
			$table = $G['mysql']['prefix'].$table;
			if(mysql::select("SELECT table_name FROM information_schema.tables WHERE table_schema='{$G['mysql']['database']}' AND table_name='{$table}'",true)){
				foreach($arr as $column=>$attr){
					if($res = mysql::select("SELECT COLUMN_NAME AS column_name,COLUMN_TYPE AS column_type,IS_NULLABLE AS is_nullable,COLUMN_DEFAULT AS column_default,EXTRA AS extra FROM information_schema.columns WHERE table_schema='{$G['mysql']['database']}' AND table_name='{$table}' AND column_name='{$column}'",true)){
						$type = strSubPos($attr,' ');
						if(!($res['column_type']==$type || $res['column_type']==preg_replace('/\(\d+\)/','',$type))){
							mysql::query("ALTER TABLE `{$table}` MODIFY COLUMN `{$column}` {$attr}");
						}else if(strstr($attr,'NOT NULL') && $res['is_nullable']=='YES'){
							mysql::query("ALTER TABLE `{$table}` MODIFY COLUMN `{$column}` {$attr}");
						}else if(strstr($attr,' DEFAULT ') && $res['is_nullable']=='NO' && (!isset($res['column_default']) || !strstr($attr," DEFAULT '{$res['column_default']}'"))){
							mysql::query("ALTER TABLE `{$table}` MODIFY COLUMN `{$column}` {$attr}");
						}else if(strstr($attr,'AUTO_INCREMENT') && !stristr($res['extra'],'auto_increment')){
							mysql::query("ALTER TABLE `{$table}` MODIFY COLUMN `{$column}` {$attr}");
						}
					}else{
						mysql::query("ALTER TABLE `{$table}` ADD `{$column}` {$attr}".(strstr($attr,'AUTO_INCREMENT')?' PRIMARY key':''));
					}
				}
				$result = mysql::select("SELECT COLUMN_NAME AS column_name FROM information_schema.columns WHERE table_schema='{$G['mysql']['database']}' AND table_name='{$table}'");
				foreach($result as $v){
					if(!$arr[$v['column_name']]){
						mysql::query("ALTER TABLE `{$table}` DROP `{$v['column_name']}`");
					}
				}
			}else{
				$sql = "CREATE TABLE IF NOT EXISTS `{$table}` (";
				foreach($arr as $column=>$attr){
					$sql .= "`{$column}` {$attr},";
				}
				$sql .= "PRIMARY KEY (`id`) ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
				mysql::query($sql);
			}
		}
	}
}
?>