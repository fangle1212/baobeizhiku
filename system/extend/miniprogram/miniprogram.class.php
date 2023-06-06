<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('origin');
into::basic_class('cache');

class miniprogram extends origin
{
    public function __construct()
    {
		global $G;
		if(!$G['config']['miniprogram_open'] && !session::get('manager')){
			url::page404();
		}
        url::$domain = $G['config']['domain'];
    }
    
	public function request()
	{
		global $G;
		if($G['get']['action']){
			$file = md5($G['path']['link']).'.json'; 
			if($json = cache::auto($file, 'json', 1)){
				echo $json;
			}else{
				switch($G['get']['action']){
					case 'ctrl':
						$json = $this->ctrl();
						break;
					case 'form':
						$json = $this->form();
						break;
					case 'group_list':
						$json = $this->group_list();
						break;
					case 'group_one':
						$json = $this->group_one();
						break;
					case 'search_list':
						$json = $this->search_list();
						break;
				}
				if($json && $json=json::encode($json,true)){
					cache::set($file, $json, 'json', true);
					echo $json;
				}
			}
		}else{
			into::load_class('extend','miniprogram','view','new')->init();
		}
	}
	
	public function ctrl($theme=false)
	{
		global $G;
		if(!$theme){
			$theme = $G['config']['miniprogram_theme'];
		}
		$ctrl = json::decode(
			arrRoundHandle(
				json::get(ROOT_PATH.'system/admin/miniprogram/templates/'.$theme.'/ctrl.json'), 
				function($s){
					return url::upload($s);
				}
			)
		);
        $standard = json::get(ROOT_PATH.'system/admin/miniprogram/common/standard.json');
		foreach($standard['diypage'] as $k=>$v){
			if($k!='home' && $k!='page'){
				foreach($ctrl['diypage'] as $v2){
					if($v2['class'] == $k){
						$k='';
						break;
					}
				}
				if($k){
					foreach($v['module'] as $k2=>$v2){
						if($res = array_merge(json::get(ROOT_PATH."system/admin/miniprogram/module/{$v2['type']}/{$v2['type']}.json"), json::get(ROOT_PATH.'system/admin/miniprogram/common/global.json'))){
							foreach($res as $val){
								foreach($val['ctrl'] as $v3){
									$v['module'][$k2]['param'][$v3['name']] = $v3['value'];
		
								}
							}
						}
					}
					$ctrl['diypage'][] = $v;
				}
			}
		}
		return $ctrl;
	}
	
	public function form($id=0)
	{
		global $G;
		$data = array();
		if(!$id){
			$id = $G['get']['id'];
		}
	    if(is_numeric($id)){
	        $config = page::config_option($id);
	        if($config['feedback_open']){
    	        $res = page::form($id);
    	        foreach($res as $k=>$v){
    	            $data['list'][$k]['name'] = 'params'.$v['id'];
    	            $data['list'][$k]['style'] = $v['style'];
    	            $data['list'][$k]['title'] = $v['title'];
    	            $data['list'][$k]['description'] = $v['description'];
    	            $data['list'][$k]['prompt'] = $v['prompt'];
    	            $data['list'][$k]['param'] = json::decode($v['param']);
    	            $data['list'][$k]['must'] = $v['must'];
    	            $data['list'][$k]['value'] = '';
    	        }
    	        if($config['feedback_captcha']){
    	            $data['list'][] = array(
    	                'name' => 'captcha',
    	                'style' => 888,
    	                'title' => $config['feedback_captcha_title'],
    	                'description' => '',
    	                'prompt' => $config['feedback_captcha_placeholder'],
    	                'param' => array(),
    	                'must' => '1',
    	                'value' => ''
    	            );
    	        }
	        }
			$data['config'] = array(
				'submit' => $config['feedback_submit'],
				'success' => $config['feedback_success'],
				'quick' => $config['feedback_quick']
			);
	    }
	    return $data;
	}
	
	public function group_one($id=0, $type=0)
	{
	    global $G;
		$data = array();
		if(!$id){
			$id = $G['get']['id'];
		}
		if(!$type){
			$type = $G['get']['type'];
		}
		if(is_numeric($id) && is_numeric($type)){
		    $res = page::group_one($id, $type);
		    $data['id'] = $res['id'];
		    $data['type'] = $res['type'];
		    $data['items'] = $res['items'];
		    $data['name'] = $res['name'];
		    $data['width'] = $res['width'];
		    $data['height'] = $res['height'];
		    $data['ctime'] = date('Y-m-d H:i:s',$res['ctime']);
		    $data['notice'] = $res['notice'];
		    $data['image'] = cache::thumbnail($res['image'],$res['width'],$res['height']);
		    $data['text'] = $res['text'];
		    $data['price'] = $res['price'];
		    $data['url'] = $res['url'];
		    $data['content'] = url::upload($res['content']);
		    if($res['images']){
		        $images = array();
		        foreach($res['imgs'] as $k=>$v){
		            $images[$k] = cache::thumbnail($v,$res['width'],$res['height']);
		        }
		        $data['images'] = $images;
		    }else{
				$data['images'][0] = $data['image'];
			}
		    if($res['contents']){
		        $contents = array();
		        foreach($res['contents'] as $k=>$v){
		            $contents[$k]['title'] = $v['title'];
		            $contents[$k]['content'] = url::upload($v['content']);
		        }
		        $data['contents'] = $contents;
		    }
		    if($res['complex']){
		        $complex = array();
				$k=-1;
		        foreach($res['complex'] as $k=>$v){
		            $complex[$k]['title'] = $v['title'];
		            $complex[$k]['value'] = $v['value'];
		        }
				if($res['type'] == 5){
					$k++;
		            $complex[$k]['title'] = $G['config']['download_size'];
		            $complex[$k]['value'] = floatval(round($res['size']/1024*100)/100).'KB';
				}
		        $data['complex'] = $complex;
		    }
		    if($res['type'] == 5){
    	        $data['file'] = url::upload($res['file']);
		    }
		}
		return $data;
	}
	
	public function group_list($items=0, $rows=null)
	{
	    global $G;
		$data = array();
		if(!$items){
			$items = $G['get']['items'];
		}
		if(!$rows){
			$rows = is_numeric($G['get']['rows'])?$G['get']['rows']:null;
		}
		if(is_numeric($items) && $res=mysql::select_one('*','items',"id='{$items}'")){
		    $url = $G['path']['request'];
		    $data = page::group_pages($res['id'],$res['type'],$rows,null,null,$url);
		    $list = array();
		    foreach($data['list'] as $k=>$v){
		        $list[$k]['id'] = $v['id'];
		        $list[$k]['type'] = $res['type'];
		        $list[$k]['items'] = $v['items'];
		        $list[$k]['name'] = $v['name'];
		        $list[$k]['ctime'] = date('Y-m-d',$v['ctime']);
		        $list[$k]['notice'] = $v['notice'];
		        $list[$k]['image'] = cache::thumbnail($v['image'],$v['width'],$v['height']);
		        $list[$k]['text'] = $v['text'];
		        $list[$k]['price'] = $v['price'];
		        $list[$k]['url'] = $v['url'];
		        if($v['images']){
		            $images = array();
		            $arr = json::decode($v['images']);
		            foreach($arr as $k2=>$v2){
		                $images[$k2] = cache::thumbnail($v2,$v['width'],$v['height']);
		            }
		            $list[$k]['images'] = $images;
		        }
		        if($v['complex']){
		            $complex = array();
		            foreach($v['complex'] as $k2=>$v2){
		                $complex[$k2]['title'] = $v2['title'];
		                $complex[$k2]['value'] = $v2['value'];
		            }
		            $list[$k]['complex'] = $complex;
		        }
		        if($res['type'] == 5){
    		        $list[$k]['size'] = floatval(round($v['size']/1024*100)/100);
    		        $list[$k]['file'] = url::upload($v['file']);
		        }
		    }
		    $data['list'] = $list;
		}
		return $data;
	}
	
	public function search_list($keyword=null, $items=0, $rows=null)
	{
	    global $G;
		$data = array();
		if(!$items){
			$items = $G['get']['items'];
		}
		if(!$rows){
			$rows = is_numeric($G['get']['rows'])?$G['get']['rows']:null;
		}
		if(!$keyword){
			$keyword = $G['get']['keyword'];
		}
		if(is_numeric($items) && $keyword && $res=mysql::select_one('*','items',"id='{$items}' AND type=7")){
		    $url = $G['path']['request'];
		    $data = page::search_list($items,$keyword,$rows,null,null,$url);
		    $list = array();
			$k = 0;
		    foreach($data['list'] as $v){
		        switch($v['type']){
		            case 2:
		                $width = $G['config']['news_thumbnail_width'];
		                $height = $G['config']['news_thumbnail_height'];
						$class = 'news';
		                break;
		            case 3:
		                $width = $G['config']['product_thumbnail_width'];
		                $height = $G['config']['product_thumbnail_height'];
						$class = 'product';
		                break;
		            case 4:
		                $width = $G['config']['image_thumbnail_width'];
		                $height = $G['config']['image_thumbnail_height'];
						$class = 'image';
		                break;
		            case 5:
		                $width = $G['config']['download_thumbnail_width'];
		                $height = $G['config']['download_thumbnail_height'];
						$class = 'download';
		                break;
					default:
						continue 2;
		        }
		        $list[$k]['id'] = $v['id'];
		        $list[$k]['title'] = $v['title'];
		        $list[$k]['type'] = $v['type'];
		        $list[$k]['class'] = $class;
		        $list[$k]['time'] = date('Y-m-d',$v['time']);
		        $list[$k]['text'] = strip_tags($v['text']);
		        $list[$k]['image'] = $v['image']?cache::thumbnail($v['image'],$width,$height):'';
		        $list[$k]['url'] = $v['url'];
				$k++;
		    }
		    $data['list'] = $list;
		}
		return $data;
	}
}
?>