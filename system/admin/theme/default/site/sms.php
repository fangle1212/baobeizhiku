<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<section class="main form">  
<form id="config" action="<?php echo url::mpf('site','sms','add'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=$G['config']; ?>
  <article class="hint">
    <i class="fa fa-info-circle"></i>
    <p>该短信平台使用的是阿里云的短信api接口进行短信发送！</p>
  </article>
  <aside>
	<div>
	  <h2>
		<strong>短信配置</strong>
	  </h2>
	  <dl>
		<dt>
		  <strong>AccessKey ID</strong> 
		</dt>
		<dd>
		  <?php echo form::input('sms_id',aE('sms_id'),null,'text',array('width6','placeholder'=>'请输入 AccessKey ID')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>AccessKey Secret</strong> 
		</dt>
		<dd>
		  <?php echo form::input('sms_key',aE('sms_key'),null,'text',array('width6','placeholder'=>'请输入 AccessKey Secret')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>短信签名</strong> 
		</dt>
		<dd>
		  <?php echo form::input('sms_sign',aE('sms_sign'),null,'text',array('width4','placeholder'=>'请输入短信签名')); ?>
		</dd>
	  </dl>
    </div>
  </aside>
  <aside>
	<div>
	  <h2>
		<strong>测试发送</strong>
	  </h2>
	  <dl>
		<dt>
		  <strong>模板CODE</strong> 
		</dt>
		<dd>
		  <?php echo form::input('sms_template',aE('sms_template'),null,'text',array('width4','placeholder'=>'请输入短信模板的CODE')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>手机号码</strong> 
		</dt>
		<dd>
		  <?php echo form::input('sms_tel',aE('sms_tel'),null,'text',array('width4','placeholder'=>'请输入测试接收短信的手机号码')); ?>
		  <cite>此处手机号码只用于测试验证码短信是否发送成功</cite>
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
  <a class="button green tfa" href="<?php echo url::mpf('site','sms','send'); ?>">
    <em class="fa fa-envelope-o"></em>
    <font>短信发送</font>
  </a>
</section>
</form>
<?php load::into('foot'); ?>