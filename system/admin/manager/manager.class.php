<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class manager extends admin
{
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover();
		$data['list'] = array(
			mysql::select_one('*','manager',"id={$G['manager']['id']}")
		);
		if($list = mysql::select_all('*','manager',"level>{$G['manager']['level']}",'id ASC')){
			$data['list'] = array_merge($data['list'], $list);
		}
		$data['add'] = $this->cover('manager','A',true);
		echo $this->theme('manager/manager',$data);
	}
	
	public function per($check=false)
	{
		global $G;
		$nav = into::load_class('admin','iframe','iframe','new')->navs();
		$permit = array();
		$has = true;
		foreach($nav as $key=>$value){
			foreach($value['child'] as $ke=>$val){
				if(!$check){
					if(!$has){
						unset($permit[($key-1).$ke]);
					}
					$permit[$key.$ke] = array(
						'level'=>1,
						'name'=>$val['name']
					);
					$has = false;
				}
				foreach($val['child'] as $k=>$v){
					if($v['check']){
						if($check){
							$permit[$this->build($v)]=$v['check'];
						}else{
							$has = true;
							$permit[$key.$ke.$k] = array(
								'level'=>2,
								'name'=>$v['name'],
								'mold'=>$v['mold'],
								'part'=>$v['part'],
								'func'=>$v['func'],
								'param'=>$v['param'],
								'check'=>$v['check'],
								'input'=>$this->build($v)
							);
						}
						if($na = $this->isnav($v['mold'], $v['part'])){
							foreach($na as $m=>$n){
								if($check){
									$permit[$this->build($n)]=$n['check'];
								}else{
									$permit[$key.$ke.$k.$m] = array(
										'level'=>3,
										'name'=>$n['name'],
										'mold'=>$n['mold'],
										'part'=>$n['part'],
										'func'=>$n['func'],
										'param'=>$n['param'],
										'check'=>$n['check'],
										'input'=>$this->build($n)
									);
								}
							}
							if(!$check){
								unset($permit[$key.$ke.$k]['check']);
							}
						}
					}
				}
			}
		}
		$mager = mysql::select_one('permit','manager',"id='{$G['manager']['id']}'");
		if($G['manager']['level']==1 || preg_match('/\"view[\"\-]/',$mager['permit'])){
			$permit['view'] = array(
				'level'=>1,
				'name'=>'编辑功能'
			);
			$permit['view_'] = array(
				'level'=>2,
				'name'=>'编辑站点',
				'mold'=>'view',
				'check'=>'RM',
				'input'=>'view'
			);
		}
		if($plist = page::plugin_list()){
			$permit['plugin'] = array(
				'level'=>1,
				'name'=>'应用插件'
			);
			$pn = 0;
			foreach($plist as $v){
				if($G['manager']['level']==1 || preg_match('/\"'.$v['name'].'[\"\-]/',$mager['permit'])){
					$pn++;
					$config = load::plugin($v['name']);
					$permit[$v['name']] = array(
						'level'=>2,
						'name'=>$config['title'],
						'mold'=>$v['name'],
						'check'=>$config['check']?$config['check']:'R',
						'input'=>$v['name']
					);
					if($na = $this->isnav($v['name'], $v['name'])){
						foreach($na as $m=>$n){
							$permit[$v['name'].'_'.$m] = array(
								'level'=>3,
								'name'=>$n['name'],
								'mold'=>$n['mold'],
								'part'=>$n['part'],
								'func'=>$n['func'],
								'param'=>$n['param'],
								'check'=>$n['check'],
								'input'=>$this->build($n)
							);
						}
						unset($permit[$v['name']]['check']);
					}
				}
			}
			if($pn){
				$permit['plugin']['rows'] = $pn;
			}else{
				unset($permit['plugin']);
			}
		}
		return $permit;
	}
	
	public function isnav($mold, $part){
		$part = $part?$part:$mold;
		if(class_exists($part)){
			if(preg_match('/^\w+$/',$mold.$part)){
				$new = $part.rand(100,999);
				if($code = preg_replace('/^<\?php|\?>$/','',preg_replace("/class\s+{$part}(?=\s|\{)/i","class {$new}",file_get_contents(ROOT_PATH.'system/admin/'.$mold.'/'.$part.'.class.php')))){
					if(preg_match('/function\s+nav\(\)/',$code)){
						eval($code);
						$class = new $new();
					}
				}
			}
		}else{
			$class = into::load_class('admin', $mold, $part, 'new');
		}
		if($class && method_exists($class, 'nav')){
			return $class->nav();
		}	
	}
	
	public function check()
	{
		global $G;
		$data = array();
		if(is_numeric($G['get']['id'])){
			$res = mysql::select_one('*','manager',"id='{$G['get']['id']}' AND level!=1");
			if($G['manager']['level']==1 || $G['manager']['level']<$res['level']){
				$G['permit'] = $this->per();
				if($G['manager']['level']!=1){
					$me = mysql::select_one('*','manager',"id='{$G['manager']['id']}'");
					$data['pe'] = array();
					$permit = json::decode($me['permit']);
					foreach($permit as $v){
						$p = explode('-',$v);
						$data['pe'][$p[0]] = str_split($p[1]?$p[1]:'RAMD');
					}
				}
				$data['permit'] = array();
				$permit = json::decode($res['permit']);
				foreach($permit as $v){
					$p = explode('-',$v);
					$data['permit'][$p[0]] = str_split($p[1]?$p[1]:'RAMD');
				}
			}else{
				alert('没有权限修改该管理员');
			}
		}else{
			alert('没有提交信息');
		}
		echo $this->theme('manager/check',$data);
	}
	
	public function check_add()
	{
		global $G;
		if(is_numeric($G['get']['id'])){
			$res=mysql::select_one('*','manager',"id='{$G['get']['id']}' AND level!=1");
			if($G['manager']['level']==1 || $G['manager']['level']<$res['level']){
				$check = $this->per(true);
				$permit = array();
				if($G['post']){
					if($G['manager']['level']!=1){
						$me = mysql::select_one('*','manager',"id='{$G['manager']['id']}'");
						$pe = array();
						$arr = json::decode($me['permit']);
						foreach($arr as $v){
							$p = explode('-',$v);
							$pe[$p[0]] = str_split($p[1]?$p[1]:'RAMD');
						}
					}
					foreach($G['post'] as $k=>$v){
						if($G['manager']['level']==1 || $pe[$k]){
							if($k && preg_match('/^[\w\&]+$/',$k)){
								if($G['manager']['level']!=1){
									$v = array_intersect($pe[$k],$v);
								}
								$str = implode('',$v);
								if(preg_match('/^[RAMD]+$/',$str)){
									$permit[] = $k.(($str==$check[$k])?'':"-{$str}");
								}
							}
						}
					}
					mysql::update(array('permit'=>json::encode($permit)),'manager',"id='{$G['get']['id']}'");
					alert('保存成功',url::mpf('manager','manager','check',array('id'=>$G['get']['id'],'success'=>'ok')));
				}else{
					alert('操作失败');
				}
			}else{
				alert('没有权限修改该管理员');
			}
		}else{
			alert('没有提交信息');
		}
	}
	
	public function edit()
	{
		global $G;
		$G['cover'] = $this->cover('manager');
		$data = array();
		if(isset($G['get']['id'])){
			$data['manager'] = mysql::select_one('*','manager',"id='{$G['get']['id']}'");
			if($G['manager']['level']>$data['manager']['level']){
				alert('没有权限修改该管理员');
			}
		}
		echo $this->theme('manager/edit',$data);
	}
	
	public function add()
	{
		global $G;
		if(isset($G['post'])){
			$id = arrExist($G,'get|id');
			$this->cover('manager',$id?'M':'A');
			$data = array(
				'image'      => $G['post']['image'],
				'username'   => $G['post']['username'],
				'department' => $G['post']['department'],
				'alias'      => $G['post']['alias'],
				'email'      => $G['post']['email'],
				'phone'      => $G['post']['phone'],
				'open'       => $G['post']['open']
			);
			if($G['post']['password']!='' && $G['post']['passwords']!=''){
				if($G['post']['password']==$G['post']['passwords']){
					$data['password'] = md5(stripslashes($G['post']['password']));
				}else{
					alert('新密码和重确密码不同');
				}
			}
			if($id){
				if(is_numeric($id)){
					if($id == $G['manager']['id']){
						if(!$data['open']){
							alert('当前登录账号不能关闭');
						}
					}
					if($res = mysql::select_one('level','manager',"id='{$id}'")){
						if($G['manager']['level'] > $res['level']){
							alert('没有权限修改该管理员');
						}else{
							mysql::update($data,'manager',"id='{$id}'");
						}
					}
				}else{
					alert('操作失败');
				}
			}else{
				$data['level'] = $G['manager']['level']+1;
				$data['permit'] = '[]';
				if(!$data['password']){
					alert('密码不能为空');
				}
				if(mysql::total('manager',"username='{$data['username']}'")){
					alert('该账号已经存在');
				}
				$data['ctime'] = TIME;
				$data['ltime'] = 0;
				$data['ip'] = '';
				$id = mysql::insert($data,'manager');
			}
			alert('保存成功',url::mpf('manager','manager','edit',array('id'=>$id,'success'=>'ok')));
		}else{
			alert('没有提交信息');
		}
	}
	
	public function delete()
	{
		global $G;
		$this->cover('manager','D');
		if(isset($G['post']['url']) && isset($G['get']['id'])){
			$id = $G['get']['id'];
			if(is_numeric($id) && $res=mysql::select_one('level','manager',"id='{$id}'")){
				if($res['level']<=$G['manager']['level']){
					alert('不能删除该账号');
				}
				if(is_numeric(mysql::delete('manager',"id='{$id}'"))){
					alert('删除成功',url::mpf('manager','manager','init',array('id'=>null)));
				}else{
					alert('删除失败');
				}
			}else{
				alert('没有删除对象id');
			}			
		}
		alert('没有提交信息');
	}
}
?>