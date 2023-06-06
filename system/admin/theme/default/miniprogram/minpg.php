<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('miniprogram','interfaces','add'); ?>" method="post" enctype="multipart/form-data">
<section class="main form"> 
  <article class="hint">
    <b>温馨提示:</b>
	<p>1. 登录<a href="https://mp.weixin.qq.com/" rel="nofollow" target="_blank">微信公众平台（mp.weixin.qq.com）</a></p>
	<p>2. 配置服务器域名：开发管理 -> 开发设置 -> 服务器域名； 点击“开始配置”按钮填写本站<a href="./#mpf=site" target="_blank">站点域名</a></p>
    <p>3. 获取API信息： 开发管理 -> 开发设置 -> 开发者ID； 复制其中的AppID、AppSecret到下方选项</p>
  </article>
  <aside>
	<div>
	  <h2>
		<strong>基础设置</strong>
	  </h2>
      <?php if($G['get']['type'] == 'weixin'){ ?>
	  <dl>
		<dt>
		  <strong>AppID：</strong>
		</dt>
		<dd>
		  <?php echo form::input('minpg_wxapiid',$G['config']['minpg_wxapiid'],null,'text',array('width5','placeholder'=>'请输入AppID')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>AppSecret：</strong>
		</dt>
		<dd>
		  <?php echo form::input('minpg_wxapisecret',$G['config']['minpg_wxapisecret'],null,'text',array('width6','placeholder'=>'请输入AppSecret')); ?>
		</dd>
	  </dl>
      <?php } ?>
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