<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('admin');

class rewrite extends admin
{
    public function nav()
    {
        global $G;
		return $this->permit(
			array(
				'rewrite'=>array(
					'name' => '伪静态',
					'mold' => 'seo',
					'part' => 'rewrite',
					'check' => 'RM',
					'tag' => 'seo_rewrite'
				),
				'rule'=>array(
					'name' => 'URL规则',
					'mold' => 'seo',
					'part' => 'rule',
					'check' => 'RM',
					'tag' => 'seo_rule'
				),
			)
		);
    }
	
	public function init()
	{
		global $G;
		$G['cover'] = $this->cover();
		$G['navs1'] = self::nav();
		$G['navs1']['rewrite']['active'] = true;
		
		$server = getServer();
		$G['config']['rewrite_text'] = $this->rule($server);
		echo $this->theme('seo/rewrite');
	}
	
	public function add()
	{
		global $G;
		$this->cover('seo&rewrite','M');
		if(isset($G['post'])){
			$data = array(
				'rewrite_open' => $G['post']['rewrite_open']
			);
			foreach($data as $k=>$v){
				mysql::select_set(array('name'=>$k,'value'=>$v,'parent'=>'0','type'=>'0'),'config',array('value'));
			}
			if($data['rewrite_open'] != $G['config']['rewrite_open']){
				$server = getServer();
				$file = false;
				if($server=='apache'){
					$file = '.htaccess';
				}else if($server=='nginx'){
					$file = '.htaccess';
				}else if($server=='iis'){
					$file = 'web.config';
				}
				if($file){
					if($data['rewrite_open']){
						dir::create(ROOT_PATH.$file, $this->rule($server));
					}else if(!mysql::total('config',"name='rewrite_open' AND parent='0' AND type='0' AND value='1' AND lang=lang")){
						dir::delete(ROOT_PATH.$file);
					}
				}
			}
			$this->sitemap();
			alert('操作成功', url::mpf('seo','rewrite','init'));
		}
	}
	
	public function rule($server){
		global $G;
		switch($server){
			case 'apache': return 
'RewriteEngine on
RewriteBase '.$G['path']['aisle'].'

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?bosscmsrewrite=1 [L]';
			case 'nginx': return 
'location '.$G['path']['aisle'].' {
	if (!-e $request_filename) {
		rewrite ^(.*)$ '.$G['path']['aisle'].'index.php?bosscmsrewrite=1 last;
	}
}';
			case 'iis': return 
'<?xml version="1.0" encoding="UTF-8"?>
<configuration>
	<system.webServer>
		<rewrite>
			<rules>
				<rule name="rule" stopProcessing="true">
					<match url="^(.*)$" />
						<conditions logicalGrouping="MatchAll">
							<add input="{HTTP_HOST}" pattern="^(.*)$" />
							<add input="{REQUEST_FILENAME}" matchType="IsFile" negate="true" />
							<add input="{REQUEST_FILENAME}" matchType="IsDirectory" negate="true" />
						</conditions>
					<action type="Rewrite" url="index.php?bosscmsrewrite=1" appendQueryString="true" />
				</rule>
			</rules>
		</rewrite>
	</system.webServer>
</configuration>';
		}
	}
}
?>