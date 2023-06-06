<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class params extends admin
{	
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover();
		echo $this->theme('template/params');
	}
	
	public function add()
	{
		global $G;
		$this->cover('template&params','M');
		if(isset($G['post'])){
			$data = array(
				'product_content_number' => $G['post']['product_content_number'],
				'product_content_title'  => $G['post']['product_content_title'],
				'product_content_title1' => $G['post']['product_content_title1'],
				'product_content_title2' => $G['post']['product_content_title2'],
				'product_content_title3' => $G['post']['product_content_title3'],
				'product_content_title4' => $G['post']['product_content_title4'],
				
				'news_thumbnail_width'      => $G['post']['news_thumbnail_width'],
				'news_thumbnail_height'     => $G['post']['news_thumbnail_height'],
				'product_thumbnail_width'   => $G['post']['product_thumbnail_width'],
				'product_thumbnail_height'  => $G['post']['product_thumbnail_height'],
				'image_thumbnail_width'     => $G['post']['image_thumbnail_width'],
				'image_thumbnail_height'    => $G['post']['image_thumbnail_height'],
				'download_thumbnail_width'  => $G['post']['download_thumbnail_width'],
				'download_thumbnail_height' => $G['post']['download_thumbnail_height'],
				
				'both_type' => $G['post']['both_type'],
				
				'thumbnail_size'       => $G['post']['thumbnail_size'],
				'thumbnail_horizontal' => $G['post']['thumbnail_horizontal'],
				'thumbnail_vertical'   => $G['post']['thumbnail_vertical'],
				
				'news_number'     => $G['post']['news_number'],
				'product_number'  => $G['post']['product_number'],
				'image_number'    => $G['post']['image_number'],
				'download_number' => $G['post']['download_number'],
				'feedback_number' => $G['post']['feedback_number'],
				'search_number'   => $G['post']['search_number'],
				
				'home'            => $G['post']['home'],
				'page_first'      => $G['post']['page_first'],
				'page_prev'       => $G['post']['page_prev'],
				'page_next'       => $G['post']['page_next'],
				'page_number'     => $G['post']['page_number'],
				'page_last'       => $G['post']['page_last'],
				'page_before'     => $G['post']['page_before'],
				'page_after'      => $G['post']['page_after'],
				'page_none'       => $G['post']['page_none'],
				'link_title'      => $G['post']['link_title'],
				'group_time'      => $G['post']['group_time'],
				'group_notice'    => $G['post']['group_notice'],
				'download_file'   => $G['post']['download_file'],
				'download_size'   => $G['post']['download_size'],
				'all'             => $G['post']['all']
			);
			foreach($data as $k=>$v){
				mysql::select_set(array('name'=>$k,'value'=>$v,'parent'=>'0','type'=>'0'),'config',array('value'));
			}
			alert('操作成功', url::mpf('template','params','init'));
		}
	}
}
?>