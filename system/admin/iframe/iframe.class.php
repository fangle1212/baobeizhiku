<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class iframe extends admin
{	
    public function navs()
    {
		global $G;
		into::basic_json('navadm',true);
		$nav = $G['navadm'];
		unset($G['navadm']);
		foreach($nav as $key=>$val){
			foreach($val['child'] as $k=>$v){
				if(!$G['config']['admin_remove_advert']){
					if($v['child'][0]['mold'] == 'software'){
						unset($nav[$key]['child'][$k]['child'][0]);
					}
				}
				if($G['manager']['level']!=1){
					if($v['child']){
						foreach($v['child'] as $l=>$w){
							if(!$this->cover($this->build($w),'R',true)){
								if($ns = into::load_class('admin','manager','manager','new')->isnav($w['mold'],$w['part'])){
									$u = array_shift($ns);
									foreach(array('mold','part','func','param') as $p){
										$nav[$key]['child'][$k]['child'][$l][$p] = $u[$p];
									}
								}else{
									unset($nav[$key]['child'][$k]['child'][$l]);
								}
							}
						}
					}
				}
				if($arr = $nav[$key]['child'][$k]['child']){
					foreach($arr as $l=>$w){
						if($w['mold']=='plugin'){
							$nav[$key]['child'][$k]['child'][$l]['tag'] = $w['tag'].' '.implode(' ',arrOption(page::plugin_list('id,name','must=0'),'id','name'));
						}
					}
				}
				if(!$nav[$key]['child'][$k]['child']){
					unset($nav[$key]['child'][$k]);
				}
			}
			if(!$nav[$key]['child']){
				unset($nav[$key]);
			}
		}
        return $nav;
    }
	
	public function init()
	{
		global $G;
		$G['no_copyright'] = true;		
		$plugin_must = page::plugin_list('*','must=1','id DESC');	
		foreach($plugin_must as $k=>$v){
			$config = load::plugin($v['name']);
			$G['plugin_must'][$k] = array(
				'title' => $config['title'],
				'mold' => $v['name'],
				'check' => $config['check']?$config['check']:'R'
			);
			if(!$this->cover($v['name'],'R',true)){
				if($ns = into::load_class('admin','manager','manager','new')->isnav($v['name'],$v['name'])){
					$u = array_shift($ns);
					foreach(array('mold','part','func','param') as $p){
						$G['plugin_must'][$k][$p] = $u[$p];
					}
				}else{
					unset($G['plugin_must'][$k]);
				}
			}
		}	
		$data = array();
        $data['language'] = page::language_list();
		$data['navs'] = self::navs();
		echo $this->theme('iframe/iframe', $data);
	}
	
	public function bgcolor()
	{
		global $G;
		mysql::select_set(array('name'=>'admin_theme_bgcolor','value'=>$G['config']['admin_theme_bgcolor']?'':'black','parent'=>'0','type'=>'1','lang'=>'0'),'config',array('value'));
		alert('切换成功');
	}
	
	public function update()
	{
		global $G;
		header('content-type:application/json;charset=utf-8');
		into::basic_class('curl');
		$file = ROOT_PATH.'cache/json/bosscms_update.json';
		if(is_file($file)){
			$res = file_get_contents($file);
		}else{
			$res = curl::request('https://api.bosscms.net/rest/version/?version='.$G['config']['version']);
			dir::create($file, $res);
		}
		echo $res;
	}
}
?>