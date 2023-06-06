<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

class pages
{
	/**
	 *
	 * @param number $pages  分页总数
	 * @param number $page   当前分页数
	 * @param number $btns   分页按钮最大数
	 * @param string $url    分页按钮链接地址，不设置调用当前页面地址
	 * @param string $name   页面地址的分页参数
	**/
	public static function btns($pages, $page=null, $btns=null, $url=null, $name='pages')
	{
		global $G;
		$data = array();
		if(!$pages){
			$pages = 1;
		}
		if(!isset($btns)){
			$btns = 10;
		}
		$btns = ($btns-1)/2;
		if(!isset($url)){
			$url = $G['path']['url'];
			$domain = '';
		}
		if(isset($page)){
			if($page <= 0){
				$page = 1;
			}
		}else{
			$page = 1;
			if(isset($G['get'][$name]) && is_numeric($G['get'][$name]) && $G['get'][$name]>0){
				$page = ceil($G['get'][$name]);
			}
		}
		if($page > $pages){
			$page = $pages;
		}
		$data[$name] = $page;
		$prev = $page-1;
		if($prev <= 0){
			$prev = 1;
		}
		$data['first'] = array(
			'number' => 1,
			'url' => url::pages($url, 1, $name, true, $domain),
			'current' => 1==$page
		);
		$data['prev'] = array(
			'number' => $prev,
			'url' => url::pages($url, $prev, $name, true, $domain),
			'current' => $prev==$page
		);
		$next = $page+1;
		if($next > $pages){
			$next = $pages;
		}
		$data['next'] = array(
			'number' => $next,
			'url' => url::pages($url, $next, $name, true, $domain),
			'current' => $next==$page
		);
		$data['last'] = array(
			'number' => $pages,
			'url' => url::pages($url, $pages, $name, true, $domain),
			'current' => $pages==$page
		);
		/* 判断分页按钮数量的开始页和结束页 Boss*cms */
		if($page-$btns>=1 && $page+$btns<=$pages){
			$start = ceil($page-$btns);
			$end = ceil($page+$btns);
		}else if($page-$btns >= 1){
			$start = ceil($page-$btns-($btns-($pages-$page)));
			if($start < 1){
				$start = 1;
			}
			$end = $pages;
		}else if($page+$btns <= $pages){
			$start = 1;
			$end = ceil($page+$btns+($btns-($page-1)));
			if($end > $pages){
				$end = $pages;
			}
		}else{
			$start = 1;
			$end = $pages;
		}
		for($i=$start; $i<=$end; $i++){
			$data['list'][] = array(
				'number' => $i,
				'url' => url::pages($url, $i, $name, true, $domain),
				'current' => $page==$i
			);
		}
		$data['display'] = count($data['list'])>1;
		return $data;
	}	
}
?>