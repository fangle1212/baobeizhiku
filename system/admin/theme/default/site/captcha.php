<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<section class="main form">  
<form id="config" action="<?php echo url::mpf('site','captcha','add'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=$G['config']; ?>
  <article class="hint">
    <i class="fa fa-info-circle"></i>
    <p>该功能使用的是腾讯云验证码中的图形验证</p>
  </article>
  <aside>
	<div>
	  <h2>
		<strong>验证配置</strong>
	  </h2>
	  <dl>
		<dt>
		  <strong>SecretId</strong> 
		</dt>
		<dd>
		  <?php echo form::input('captcha_id',aE('captcha_id'),null,'text',array('width6','placeholder'=>'请输入 SecretId')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>SecretKey</strong> 
		</dt>
		<dd>
		  <?php echo form::input('captcha_key',aE('captcha_key'),null,'text',array('width6','placeholder'=>'请输入 SecretKey')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>CaptchaAppId</strong> 
		</dt>
		<dd>
		  <?php echo form::input('captcha_appid',aE('captcha_appid'),null,'text',array('width3','placeholder'=>'请输入 CaptchaAppId')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>AppSecretKey</strong> 
		</dt>
		<dd>
		  <?php echo form::input('captcha_appkey',aE('captcha_appkey'),null,'text',array('width4','placeholder'=>'请输入 AppSecretKey')); ?>
		</dd>
	  </dl>
	</div>
  </aside>
</section>

<section class="refer">
  <button class="button blue" type="submit">
    <em class="fa fa-floppy-o"></em>
    <font>保存</font>
  </button>
</section>
</form>
<?php load::into('foot'); ?>