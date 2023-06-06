<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class backup extends admin
{
	public $sql = 'backup/sql/';

	public function nav()
	{
		return $this->permit(
			array(
				'backup' => array(
					'name' => '数据备份',
					'mold' => 'safe',
					'part' => 'backup',
					'func' => 'init',
					'check' => 'RA'
				),
				'table' => array(
					'name' => '备份列表',
					'mold' => 'safe',
					'part' => 'backup',
					'func' => 'table',
					'check' => 'RMD'
				)
			)
		);
	}
	
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover();
		$G['navs1'] = self::nav();
		$G['navs1']['backup']['active'] = true;
		
		$data = array();
		$data['list'] = array();
		$language = page::language();
		$data['all_language'] = array();
		foreach($language as $v){
			$data['all_language'][] = $v['id'];
			$data['list'][$v['id']] = $v['name'];
		}
		$data['database'] = array();
		$data['all_database'] = array();
		foreach($G['database'] as $k=>$v){
			$data['all_database'][] = $k;
			$data['database'][$k] = $G['mysql']['prefix'].$k;
		}
		$data['all_database'] = json::encode($data['all_database']);
		echo $this->theme('safe/backup',$data);
	}
	
	public function table()
	{
		global $G;
		$G['cover'] = $this->cover('safe&backup&table');
		$G['navs1'] = self::nav();
		$G['navs1']['table']['active'] = true;
		
		$data = array();
		$dir = SYSTEM_PATH.$this->sql;
		$list = dir::read($dir);
		$n = 99;
		foreach($list['file'] as $k=>$v){
			if($mtime = filemtime($dir.$v)){
				$data[$mtime.$n]['name'] = $v;
				$data[$mtime.$n]['mtime'] = date('Y-m-d H:i:s',$mtime);
				$size = filesize($dir.$v);
				if($size<1000){
					$data[$mtime.$n]['size'] = $size.' B';
				}else if($size<1000000){
					$data[$mtime.$n]['size'] = ($size/1000).' KB';
				}else{
					$data[$mtime.$n]['size'] = ($size/1000000).' MB';
				}
				$n--;
			}
		}
		krsort($data);
		$list = $data;
		
		into::basic_class('pages');
		$pages = $G['get']['pages'];
		$pages = is_numeric($pages)?$pages:1;
		$rows = 20;
		$start = ($pages-1) * $rows;
		$end = $start+$rows;
		$data = array('total'=>0,'list'=>array(),'pages'=>array());
		$k = 0;
		foreach($list as $v){
			if($k>=$start && $k<$end){
				$data['list'][] = $v;
			}
			$k++;
		}
		$data['total'] = count($list);
		$data['pages'] = pages::btns(ceil($data['total']/$rows), $pages);
		echo $this->theme('safe/table',$data);
	}
	
	public function download()
	{
		global $G;
		$this->cover('safe&backup&table');
		if(isset($G['get']['id'])){
			$file = SYSTEM_PATH.$this->sql.$G['get']['id'];
			if(preg_match('/^\w+\.sql$/',$G['get']['id']) && is_file($file)){
				header("Content-type:application/octet-stream");
				header("Content-Disposition:attachment;filename = ".$G['get']['id']);
				header("Accept-ranges:bytes");
				header("Accept-length:".filesize($file));
				readfile($file);
			}else{
				alert('没有找到该文件');
			}
		}else{
			alert('没有提交下载信息');
		}
	}
	
	public function import()
	{
		global $G;
		$this->cover('safe&backup&table','M');
		if(isset($G['get']['id'])){
			$file = SYSTEM_PATH.$this->sql.$G['get']['id'];
			if(preg_match('/^\w+\.sql$/',$G['get']['id']) && is_file($file)){
				if($text = file_get_contents($file)){
					@set_time_limit(0);
					$cfg = mysql::select_all('*','config',"(name='domain' OR name='domain_mobile') AND lang=lang");
					preg_match("/\/\* database_prefix: (\w+) \*\//", substr($text,strpos($text,'/* database_prefix: '),58), $prefix);
					if(isset($prefix[1]) && $prefix[1] && $G['mysql']['prefix']!=$prefix[1]){
						$text = str_replace(' EXISTS `'.$prefix[1], ' EXISTS `'.$G['mysql']['prefix'], $text);
						$text = str_replace('INSERT INTO `'.$prefix[1], 'INSERT INTO `'.$G['mysql']['prefix'], $text);
					}
					if(!$cover=arrExist($G['get'],'cover')){
						$manager = mysql::select_all('*','manager');
					}
					$err = 0;
					while($text){
						$text = substr($text, $this->dci($text, $G['mysql']['prefix']));
						$s2 = $this->dci(substr($text,1), $G['mysql']['prefix']);
						if(is_numeric($s2)){
							if(!mysql::query(substr($text, 0, $s2))){
								$err++;
							}
							$text = substr($text,$s2);
						}else{
							if(!mysql::query($text)){
								$err++;
							}
							$text = false;
						}
					}
					if(!$cover){
						foreach($manager as $v){
							if($res = mysql::select_one('*','manager',"username='{$v['username']}'")){
								if($res['password']!=$v['password']){
									mysql::update(array('password'=>$v['password']),'manager');
								}
							}else{
								unset($v['id']);
								mysql::insert($v,'manager');
							}
						}
					}
					if($err){
						alert('有'.$err.'行导入失败');
					}else{
						foreach($cfg as $v){
							mysql::update(array('value'=>$v['value']),'config',"name='{$v['name']}' AND lang='{$v['lang']}'");
						}
						alert('导入成功', url::mpf('safe','backup','table'));
					}
				}else{
					alert('文件为空');
				}
			}else{
				alert('没有找到该文件');
			}
		}else{
			alert('没有提交导入信息');
		}
	}

	public function set()
	{
		global $G;
		$this->cover('safe&backup','A');
		if(isset($G['post'])){
			if($G['post']['database'] && $G['post']['language']){
				set_time_limit(0);
				$database = json::defilter($G['post']['database']);
				$language = json::defilter($G['post']['language']);
				$lang = "AND ( lang='0'";
				foreach($language as $l){
					$lang .= " OR lang='{$l}'";
				}
				$lang .= ')';
				$sql = '/* Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved. */'."\n".
				       '/* BOSSCMS Content Management System (https://www.bosscms.net/) */'."\n".
					   '/* database_prefix: '.$G['mysql']['prefix'].' */';
				foreach($G['database'] as $name=>$arr){
					if(in_array($name,$database)){
						$_name = $G['mysql']['prefix'].$name;
						$sql .= "\n\n\nDROP TABLE IF EXISTS `{$_name}`;";
						$sql .= "\nCREATE TABLE IF NOT EXISTS `{$_name}` (";
						$primary = '';
						$column = '';
						$int = array();
						foreach($arr as $key=>$val){
							$int[$key] = strstr($val,'int(')?true:false;
							$column .= ($column==''?'':"`,`").$key;
							$sql .= "\n  `{$key}` {$val},";
							if(strstr($val,'AUTO_INCREMENT')) $primary=$key;
						}
						if($primary) $sql .= "\n\tPRIMARY KEY (`{$primary}`)";
						$rel = mysql::select("SELECT MAX(`{$primary}`) AS number FROM `{$_name}`");
						$max = arrExist($rel,'0|number')+1;
						$sql .= "\n) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT={$max};";
						
						$start = 0;
						$rows = 100;
						$larn = isset($arr['lang'])?$lang:'';
						while($rel = mysql::select("SELECT `{$column}` FROM `{$_name}` WHERE 1 {$larn} LIMIT {$start},{$rows}")){
							$sql .= "\nINSERT INTO `{$_name}` (`{$column}`) VALUES";
							foreach($rel as $v){
								$value = '';
								foreach($v as $b=>$c){
									if($int[$b]){
										$value .= $c.',';
									}else{
										$value .= "'".addslashes($c)."',";
									}
								}
								$value = preg_replace('/,$/','',$value);
								$sql .= "\n({$value}),";
							}
							$sql = preg_replace('/,$/',";\n",$sql);
							$start += $rows;
						}
					}
				}
				dir::create(SYSTEM_PATH.$this->sql.date('YmdHis',TIME).strRand(6).'.sql',$sql);
				alert('操作成功', url::mpf('safe','backup','table'));
			}else{
				alert('必须选择一项语言');
			}
		}else{
			alert('没有提交信息');
		}
	}
	
	public function delete()
	{
		global $G;	
		$this->cover('safe&backup&table','D');
		if(isset($G['post']['url']) && isset($G['get']['id'])){
			$del = array();
			$arr = explode(',',$G['get']['id']);
			foreach($arr as $id){
				if(preg_match('/^\w+\.sql$/',$id)){
					$file = SYSTEM_PATH.$this->sql.str_replace(P,',',$id);
					if(is_file($file)){
						$del[$id] = $file;
					}
				}
			}
			if($del){
				$error=array();
				foreach($del as $id=>$file){
					if(dir::delete($file)){
						
					}else{
						$error[]=$id;
					}
				}
				if($error){
					alert('文件名为'.implode(',',$error).'删除失败');
				}else{
					alert('删除成功', url::mpf('safe','backup','table',array('id'=>null)));
				}
			}else{
				alert('没有删除对象');
			}			
		}
		alert('没有提交信息');
	}
	
	public function dci($text, $prefix)
	{
		$d = strpos($text,'DROP TABLE IF EXISTS `'.$prefix);
		$c = strpos($text,'CREATE TABLE IF NOT EXISTS `'.$prefix);
		$i = strpos($text,'INSERT INTO `'.$prefix);
		$s = false;
		if(is_numeric($d) && is_numeric($c) && is_numeric($i)){ 
			$s = min($d, $c, $i);
		}else if(is_numeric($d) && is_numeric($c)){ 
			$s = min($d, $c);
		}else if(is_numeric($d) && is_numeric($i)){ 
			$s = min($d, $i);
		}else if(is_numeric($c) && is_numeric($i)){ 
			$s = min($c, $i);
		}else if(is_numeric($d)){ 
			$s = $d;
		}else if(is_numeric($c)){ 
			$s = $c;
		}else if(is_numeric($i)){ 
			$s = $i;
		}
		return $s;
	}
}
?>