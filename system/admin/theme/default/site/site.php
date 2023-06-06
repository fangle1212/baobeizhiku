<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('site','site','add'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=$G['config']; ?>
<section class="main form">
  <aside>
	<div>
	  <h2>
		<strong>基础信息</strong>
	  </h2>
	  <dl>
		<dt>
		  <strong>站点标题</strong>
		</dt>
		<dd>
		  <?php echo form::input('title',aE('title'),null,'text',array('placeholder'=>'请输入站点标题','width6')); ?>
          <cite>设置站点标题后网站所有页面调用副标题，不设置则不调用。</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong data="注意：域名前缀需注意填写http://或https://">站点域名</strong> 
		</dt>
		<dd>
		  <?php echo form::input('domain',aE('domain'),null,'text',array('placeholder'=>'请输入站点的访问域名','width4')); ?>
          <cite>如果未设置站点域名，网站将无法访问。</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong data="注意：手机端域名必须为站点域名的二级域名，域名前缀需注意填写http://或https://">手机域名</strong> 
		</dt>
		<dd>
		  <?php echo form::input('domain_mobile',aE('domain_mobile'),null,'text',array('placeholder'=>'请输入手机端访问域名','width4')); ?>
          <cite>如果设置手机域名，手机端访问站点域名时将自动301跳到该手机域名。</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>网站LOGO</strong> 
		</dt>
		<dd>
		  <?php echo form::textarea('logo',aE('logo'),null,array('image')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>手机LOGO</strong> 
		</dt>
		<dd>
		  <?php echo form::textarea('logo_mobile',aE('logo_mobile'),null,array('image')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>站点图标</strong> 
		</dt>
		<dd>
		  <?php echo form::textarea('icon',aE('icon'),null,array('image')); ?>
          <cite>该图片使用于浏览器标签区的小图标，建议为.ico格式</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>默认图片</strong> 
		</dt>
		<dd>
		  <?php echo form::textarea('image',aE('image'),null,array('image')); ?>
          <cite>站点生成缩略图时没有图片则调用的默认图片</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>网站备案号</strong> 
		</dt>
		<dd>
		  <?php echo form::textarea('miit_beian',aE('miit_beian'),null,array('width'=>'70%','toggle'=>'<a href="https://beian.miit.gov.cn/" title="网站备案号" rel="nofollow" target="_blank">[miit_beian]</a>','placeholder'=>'请输入网站备案号')); ?>
          <cite>网站备案号会自动添加[beian.miit.gov.cn]官方链接地址</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>联网备案号</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('beian',aE('beian'),null,array('width'=>'70%','toggle'=>'<a href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=" title="联网备案号" rel="nofollow" target="_blank"><img src="../upload/photo/image/beian.png" alt="联网备案号" />[beian]</a>','placeholder'=>'请输入联网备案号')); ?>
          <cite>联网备案号会自动添加[www.beian.gov.cn]官方链接地址</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>底部信息</strong> 
		</dt>
		<dd>
		  <?php echo form::textarea('foot',aE('foot'),null,array('ueditor','height'=>'188','placeholder'=>'请编辑网站的底部信息内容')); ?>
		</dd>
	  </dl>
	</div>
  </aside>
</section>

<section class="refer">
  <button class="button ok" type="submit">
    <em class="fa fa-floppy-o"></em>
    <font>保存</font>
  </button>
</section>
</form>
<?php load::into('foot'); ?>