<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class renovation extends admin
{
	public $path = 'system/admin/miniprogram/';
	
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover('miniprogram');
		$G['no_copyright'] = true;
		$name = $G['get']['name'];
		$diypage = $G['get']['diypage']?$G['get']['diypage']:0;
		if(preg_match('/^\w+$/',$name) && preg_match('/^\w+$/',$diypage)){
			$data['name'] = $name;
			$data['diypage'] = $diypage;
			$data['jsonPage'] = json::encode(arrExist(json::get(ROOT_PATH.$this->path.'common/standard.json'),'diypage'));
			$data['jsonCtrl'] = json::encode(json::get(ROOT_PATH.$this->path.'templates/'.$name.'/ctrl.json'));
		}
		echo $this->theme('miniprogram/renovation', $data);
	}
		
	public function module()
	{
		global $G;
		$G['cover'] = $this->cover('miniprogram');
		$key = $G['post']['key'];
		$class = $G['post']['class'];
		$type = $G['post']['type'];
		$param = $G['post']['param'];
		if(is_numeric($key) && preg_match('/^\w+$/',$class) && preg_match('/^\w+$/',$type)){
			$path = ROOT_PATH.$this->path.'module/'."{$type}/";
			if(is_dir($path)){
				$ctrl = json::get($path.$type.'.json');
				if(!preg_match('/_bar$/', $type)){
					$ctrl = array_merge($ctrl, json::get(ROOT_PATH.$this->path.'common/global.json'));
				}
				if($param && $param=json::decode(delFilter($param))){
					extract($param);
				}else{
					$param = array();
					foreach($ctrl as $val){
						foreach($val['ctrl'] as $v){
							$param[$v['name']] = $v['value'];
							extract($param);
						}
					}
				}
				if(preg_match('/^\w+_detail$/',$class)){
					$table = str_replace('_detail','',$class);
					$res = mysql::select_one('id', $table, "display=1", "top DESC, recommend DESC, sort DESC, mtime DESC, id ASC");
					$G['group'] = into::load_class('extend','miniprogram','miniprogram','new')->group_one($res['id'], $G['pass']['type'][$table]);
				}
				into::basic_class('compile');
				ob_start();
				$cache = compile::cache($path.$type.'.html');
				require $cache;
				$htmls = ob_get_contents();
				ob_end_clean();
				$content = file_get_contents($path.$type.'.html');
				foreach($ctrl as $val){
					foreach($val['ctrl'] as $v){
						if(!isset($param[$v['name']])){
							$param[$v['name']] = $v['value'];
						}
						if(!strstr($v['name'],'_reset') && strstr($content,"{\${$v['name']}}")){
							extract(array($v['name']=>"[{$v['name']}]"));
						}
					}
				}
				ob_start();
				require $cache;
				$code = ob_get_contents();
				ob_end_clean();

				echo json::encode(array(
					'key' => $key,
					'class' => $class,
					'type' => $type,
					'html' => $htmls,
					'code' => $code,
					'param' => $param
				));
			}
		}
	}
	
	public function ctrl()
	{
		global $G;
		$G['cover'] = $this->cover('miniprogram');
		$G['no_copyright'] = true;
		$data = array();
		$type = $G['post']['type'];
		$param = $G['post']['param'];
		if(preg_match('/^\w+$/',$type)){
			$data['ctrl'] = json::get(ROOT_PATH.$this->path.'module/'."{$type}/{$type}.json");
			if(!preg_match('/_bar$/',$type)){
				$data['ctrl'] = array_merge($data['ctrl'], json::get(ROOT_PATH.$this->path.'common/global.json'));
			}
			if($param && $param=json::decode(delFilter($param))){
				$data['param'] = $param;
			}
		}
		echo json::encode(array(
			'type' => $type,
			'html' => $this->theme('miniprogram/ctrl', $data)
		));
	}
	
	public function add()
	{
		global $G;
		$this->face();
		$this->cover('miniprogram','M');
		$name = $G['get']['name'];
		$jsonCtrl = $G['post']['jsonCtrl'];
		$imgbase64 = base64_decode(str_replace('data:image/png;base64,','',$G['post']['imgbase64']));
		$state = 0;
		if(preg_match('/^\w+$/',$name) && $jsonCtrl && $jsonCtrl=json::decode(delFilter($jsonCtrl))){
			dir::create(ROOT_PATH.$this->path.'templates/'.$name.'/ctrl.json',json::encode($jsonCtrl,true));
			into::basic_class('cache');
			$dir = cache::get('',false,'css');
			$files = dir::readall($dir);
			foreach($files as $v){
				if(preg_match("/^(diypage|miniprogram)\./",$v)){
					dir::delete($dir.$v);
				}
			}
			$dir = cache::get('',false,'js');
			$files = dir::readall($dir);
			foreach($files as $v){
				if(preg_match("/^(diypage|miniprogram)\./",$v)){
					dir::delete($dir.$v);
				}
			}
			$state = 1;
		}else if($imgbase64 && getimagesizefromstring($imgbase64)){
			dir::create(ROOT_PATH.$this->path.'templates/'.$name.'/image.png',$imgbase64);
			$state = $name;
		}		
		echo json::encode(array(
			'state' => $state
		));
	}
	
	public function bar()
	{
		global $G;
		$G['cover'] = $this->cover('miniprogram');
		$type = $G['post']['type'];
		$param = $G['post']['param'];
		if(preg_match('/^\w+$/',$type)){
			$path = ROOT_PATH.$this->path.'module/'."{$type}/";
			if(is_dir($path)){
				if($param && $param=json::decode(delFilter($param))){
					extract($param);
				}
				into::basic_class('compile');
				ob_start();
				$cache = compile::cache($path.$type.'.html');
				require $cache;
				$html = ob_get_contents();
				ob_end_clean();
				if($ctrl = json::get($path.$type.'.json')){
					$content = file_get_contents($path.$type.'.html');
					foreach($ctrl as $val){
						foreach($val['ctrl'] as $v){
							$param[$v['name']] = $v['value'];
							if(strstr($content,"{\${$v['name']}}")){
								extract(array($v['name']=>"[{$v['name']}]"));
							}
						}
					}
					ob_start();
					require $cache;
					$code = ob_get_contents();
					ob_end_clean();
				}
				echo json::encode(array(
					'type' => $type,
					'html' => $html,
					'code' => $code,
					'param' => $param
				));
			}
		}
	}
	
	public function items()
	{
		global $G;
		$G['cover'] = $this->cover('miniprogram');
		$data = array();
		$items = page::items();
		foreach($items as $v){
			$class = array_search($v['type'],$G['pass']['type']);
			if(preg_match('/^(2|3|4|5)$/',$v['type'])){
				$data[] = array(
					'id' => $v['id'],
					'name' => $v['name'],
					'level' => $v['level'],
					'type' => $v['type'],
					'class' => $class
				);
			}else{
				$data[] = array(
					'id' => $v['id'],
					'name' => $v['name'],
					'level' => $v['level'],
					'type' => $v['type'],
					'class' => ''
				);
			}
		}
		foreach($data as $k=>$v){
			if(!$v['class']){
				if((isset($data[$k+1]) && $v['level']>=$data[$k+1]['level']) || !isset($data[$k+1])){
					unset($data[$k]);
				}
			}
		}
		echo json::encode($data,true);
	}
}
?>