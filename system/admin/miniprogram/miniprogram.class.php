<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class miniprogram extends admin
{
	public $path = 'system/admin/miniprogram/';
	
    public function nav()
    {
        global $G;
		return $this->permit(
			array(
				'miniprogram' => array(
					'name' => '模板列表',
					'mold' => 'miniprogram',
					'check' => 'RAMD'
				),
				'interfaces' => array(
					'name' => '接口配置',
					'mold' => 'miniprogram',
					'part' => 'interfaces',
					'check' => 'RM'
				),
				'config' => array(
					'name' => '功能设置',
					'mold' => 'miniprogram',
					'part' => 'config',
					'check' => 'RM'
				)
			)
		);
    }
	
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover();		
		$G['navs1'] = self::nav();
		$G['navs1']['miniprogram']['active'] = true;		
		into::basic_class('pages');
		$pages = $G['get']['pages'];
		$pages = is_numeric($pages)?$pages:1;
		$rows = 20;
		$start = ($pages-1) * $rows;
		$end = $start + $rows;
		$data = array('total'=>0,'list'=>array(),'pages'=>array());
		$list = $this->local();
		foreach($list as $k=>$v){
			if($k>=$start && $k<$end){
				$json = into::load_json(ROOT_PATH.$this->path.'templates/'.$v.'/config.json');
				$data['list'][$v]['path'] = $G['path']['relative'].$this->path.'templates/'.$v.'/';
				$data['list'][$v]['image'] = is_file(ROOT_PATH.$this->path.'templates/'.$v.'/image.png')?$data['list'][$v]['path'].'image.png?'.mt_rand(1000,9999):$G['path']['relative'].'system/admin/common/img/not_img.png';
				$data['list'][$v]['name'] = $v;
				$data['list'][$v]['title'] = $json['title'];
				$data['list'][$v]['version'] = $json['version'];
			}
		}
		$data['total'] = count($list);
		$data['pages'] = pages::btns(ceil($data['total']/$rows), $pages);
		
		echo $this->theme('miniprogram/miniprogram', $data);
	}
	
	public function local()
	{
		global $G;
		$G['cover'] = $this->cover();
		$template = array();
		$list = dir::read(ROOT_PATH.$this->path.'templates/');
		foreach($list['dir'] as $v){
			if(is_file(ROOT_PATH.$this->path.'templates/'.$v.'/config.json')){
				$template[] = $v;
			}
		}
		return $template;
	}

	public function modify()
	{
		global $G;
		$this->face();
		$this->cover('miniprogram','M');
		if(preg_match('/^\w+$/',$G['get']['name'])){
			mysql::update(array('value'=>$G['get']['name']),'config',"name='miniprogram_theme'");
			alert('启用成功！',url::mpf('miniprogram','miniprogram','init',array('name'=>null)));
		}
		alert('启用失败！');
	}

	public function delete()
	{
		global $G;
		$this->face();
		$this->cover('miniprogram','D');
		if(isset($G['post']['url']) && isset($G['get']['name']) && $name=$G['get']['name']){
			if(preg_match('/^\w+$/',$name)){
				dir::remove(ROOT_PATH.$this->path.'templates/'.$name);
				alert('删除成功！',url::mpf('miniprogram','miniprogram','init',array('name'=>null)));
			}
		}
		alert('删除失败！');
	}

	public function edit()
	{
		global $G;
		$G['cover'] = $this->cover('miniprogram');
		$data = array();
		if(isset($G['get']['name']) && $name=$G['get']['name']){
			$path = $G['path']['relative'].$this->path.'templates/'.$name.'/';
			$file = ROOT_PATH.$this->path.'templates/'.$name.'/config.json';
			if(preg_match('/^\w+$/',$name) && file_exists($file)){
				$data = into::load_json($file);
				$data['path'] = $path;
				$data['image'] = $path.'image.png';
				$data['name'] = $name;
			}
		}
		echo $this->theme('miniprogram/edit', $data);
	}
	
	public function add()
	{
		global $G;
		$this->face();
		$new = false;
		$config = array();
		if(isset($G['get']['name']) && $name=$G['get']['name']){
			$this->cover('miniprogram','M');
			$path = ROOT_PATH.$this->path.'templates/'.$name.'/';
			if(isset($G['post']['names']) && $names=$G['post']['names']){
				if(preg_match('/^\w+$/',$name) && preg_match('/^\w+$/',$names)){
					if($name != $names){
						$paths = ROOT_PATH.$this->path.'templates/'.$names.'/';
						if(dir::turn($path,$paths)){
							mysql::update(array('value'=>$names),'config',"name='miniprogram_theme' AND name='{$name}'");
							$path = $paths;
							$name = $names;
						}else{
							alert('文件夹修改错误！');
						}
					}
				}else{
					alert('文件夹名称错误！');
				}
			}
			$config = json::get($path.'config.json');
			$config['title'] = $G['post']['title'];
		}else if(isset($G['post']['names']) && $name=$G['post']['names']){
			$this->cover('miniprogram','A');
			if(preg_match('/^\w+$/',$name)){
				$path = ROOT_PATH.$this->path.'templates/'.$name.'/';
				if(file_exists($path)){
					alert('文件夹已经存在！');
				}else{
					$standard = json::get(ROOT_PATH.$this->path.'common/standard.json');
					dir::create(
						$path.'ctrl.json',
						json::encode(
							array(
								'diypage'=>array($standard['diypage']['home']),
								'top_bar'=>$standard['top_bar'],
								'cut_bar'=>$standard['cut_bar'],
								'tab_bar'=>$standard['tab_bar']
							),
							true
						)
					);
					$config['version'] = 'V1.0';
					$config['title'] = $G['post']['title'];
					$config['serial'] = $G['post']['serial'];
					if(!preg_match('/^\w+$/',$config['serial'])){
						alert('模板型号错误');
					}
					$news = true;
				}
			}else{
				alert('文件夹名称错误');
			}
		}else{
			alert('没有定义文件夹');
		}
		json::put($path.'config.json', delSlashes($config));
		if(isset($G['post']['image']) && $image=$G['post']['image']){
			if(!strstr($image,'/image.png')){
				dir::copyfile(str_replace('../',ROOT_PATH,$image),$path.'image.png');
			}
		}
		if($news){
			die("<script>window.parent.window.location.href='".url::mpf('miniprogram','renovation','init',array('name'=>$name,'diypage'=>0))."#_alert=".urlencode('操作成功').",green';</script>");
		}else{
			alert('操作成功',url::mpf('miniprogram','miniprogram','edit',array('name'=>$name,'success'=>'ok')));
		}
	}

	public function qrcode()
	{
		global $G;
		$this->cover('miniprogram','R');
		if(preg_match('/^\w+$/',$G['get']['name'])){
			require_once ROOT_PATH.'system/extend/qrcode/phpqrcode.php';
			if($G['get']['body']){
				ob_start();
			}
			QRcode::png(urldecode("{$G['config']['domain']}api/miniprogram/?theme={$G['get']['name']}"), false, 'L', 8.8, 1, true);
			if($G['get']['body']){
				$img = 'data:image/jpg;base64,'.base64_encode(ob_get_contents());
				ob_end_clean();
				header('content-type:text/html');
				echo '<body style="margin:0;display:flex;align-items:center;justify-content:center;"><img src="'.$img.'" style="max-width:100%;"></body>';
			}
		}
		die();
	}
}
?>