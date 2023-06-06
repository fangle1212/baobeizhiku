<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');
into::basic_class('user');

class detect extends admin
{
	public function init()
	{
		$G['cover'] = $this->cover();
		echo $this->theme('detect/detect', $data);
	}
	
	public function remote()
	{
		global $G;
		$G['cover'] = $this->cover('detect');
		into::basic_class('cache');
		if(!$res = cache::auto('detect.json','json',60)){
			$res = curl::request('https://detect.bosscms.net/file/download/detect/'.$G['config']['version'].'/files.json');
			cache::set('detect.json',$json,'json',true);
		}
		echo '{"list":'.$res.',"rows":88}';
	}
	
	public function check()
	{
		global $G;
		$G['cover'] = $this->cover('detect');
		if(is_numeric($G['get']['page']) && $G['get']['page']>0){
			ob_start();
			$this->remote();
			$res = json::decode(ob_get_contents());
			ob_end_clean();
			$arr = array_slice($res['list'],ceil($G['get']['page']-1)*$res['rows'],$res['rows']);
			foreach($arr as $k=>$v){
				$arr[$k] = sha1_file(ROOT_PATH.$k)==$v?1:0;
			}
			echo json::encode($arr);
		}
	}
	
	public function update()
	{
		global $G;
		$this->cover('detect','M');
		$msg = 'error';
		$path = $G['get']['path'];
		if($path){
			ob_start();
			$this->remote();
			$res = json::decode(ob_get_contents());
			ob_end_clean();
			if($res['list'][$path]){
				$file = 'https://detect.bosscms.net/file/download/detect/'.$G['config']['version'].'/'.$path;
				into::basic_class('curl');
				if(curl::code($file) == 200){
					curl::files($file, ROOT_PATH.$path);
					$msg = 'success';
				}
			}
		}
		echo json::encode(array(
			'msg' => $msg,
			'path' => $path
		));
	}
}
?>