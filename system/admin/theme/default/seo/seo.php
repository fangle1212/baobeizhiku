<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form id="sitemap" action="<?php echo url::mpf('seo','seo','add'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=$G['config']; ?>
<section class="main form">
  <aside>
	<div>
	  <h2>
		<strong>基础信息</strong>
	  </h2>
	  <dl>
		<dt>
		  <strong>首页标题</strong> 
		</dt>
		<dd>
		  <?php echo form::input('home_title',aE('home_title'),null,'text',array('width8','placeholder'=>'请输入首页标题')); ?>
          <cite>站点的首页独立标题，如果没有设置则首页显示“站点标题”</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>网站关键词</strong> 
		</dt>
		<dd>
		  <?php echo form::textarea('keywords',aE('keywords'),null,array('param','row'=>6,'cut'=>':','off'=>'|','placeholder'=>'["请输入网站关键词"]')); ?>
          <cite>站点的网页默认关键词，如果各页面没有设置独立网页关键词则调用该站点关键词</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>网站描述</strong> 
		</dt>
		<dd>
		  <?php echo form::textarea('description',aE('description'),null,array('height2','placeholder'=>'请输入网站描述')); ?>
          <cite>站点的网页默认描述，如果各页面没有设置独立网页描述则调用该站点描述</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>标题连接符</strong> 
		</dt>
		<dd>
		  <?php echo form::input('title_connector',aE('title_connector'),' - ','text',array('width1')); ?>
          <cite>站点的网页标题是由“页面标题[连接符]站点标题”组成</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>关键词连接符</strong> 
		</dt>
		<dd>
		  <?php echo form::input('keywords_connector',aE('keywords_connector'),'|','text',array('width1')); ?>
          <cite>站点的网页关键词是由“关键词一[连接符]关键词二”组成</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>robots配置</strong> 
		</dt>
		<dd>
		  <?php echo form::textarea('robots',$data['robots'],null,array('height4','placeholder'=>'请输入robots内容')); ?>
          <cite>编辑修改根目录下robots.txt文件内容；robots是用来告诉搜索引擎不索引网站的哪些内容</cite>
		</dd>
	  </dl>
	</div>
  </aside>
  
  <aside>
	<div>
	  <h2>
		<strong>SiteMap配置</strong>
	  </h2>
	  <dl>
		<dt>
		  <strong>功能状态</strong> 
		</dt>
		<dd>
		  <?php echo form::radio('sitemap_open',aE('sitemap_open'),0,$G['option']['open']); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>生成类型</strong> 
		</dt>
		<dd>
		  <?php echo form::radio('sitemap_type',aE('sitemap_type'),'xml',array('xml'=>'XML类型','txt'=>'TXT类型'),array('no')); ?>
          <cite>
            XML类型链接：<a target="_blank" href="<?php echo $G['path']['site']; ?>sitemap.xml"><?php echo $G['path']['site']; ?>sitemap.xml</a>
            <br />
            TXT类型链接：<a target="_blank" href="<?php echo $G['path']['site']; ?>sitemap.txt"><?php echo $G['path']['site']; ?>sitemap.txt</a>
          </cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>自动更新</strong> 
		</dt>
		<dd>
		  <?php echo form::radio('sitemap_auto_update',aE('sitemap_auto_update'),0,$G['option']['open'],array('color'=>'green')); ?>
          <cite>设置编辑站点内容时是否自动更新网站地图</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>立即更新</strong> 
		</dt>
		<dd>
          <code>
            <a class="button green tfa" href="<?php echo url::mpf('seo','seo','show'); ?>">
              <em class="fa fa-wrench"></em>
              <font>更新 SiteMap</font>
            </a>
          </code>
          <cite>配置需要先进行保存才会进行更新sitemap内容</cite>
		</dd>
	  </dl>
	</div>
  </aside>
</section>
</form>

<section class="refer">
  <button form="sitemap" class="button ok" type="submit">
    <em class="fa fa-floppy-o"></em>
    <font>保存</font>
  </button>
</section>
<?php load::into('foot'); ?>