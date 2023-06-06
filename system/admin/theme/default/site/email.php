<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<section class="main form">  
<form id="config" action="<?php echo url::mpf('site','email','add'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=$G['config']; ?>
  <aside>
	<div>
	  <h2>
		<strong>邮箱配置</strong>
	  </h2>
	  <dl>
		<dt>
		  <strong>邮箱账号</strong> 
		</dt>
		<dd>
		  <?php echo form::input('mail_user',aE('mail_user'),null,'text',array('width4','placeholder'=>'请输入邮箱账户')); ?>
          <cite>填写邮件发送SMTP的账号；例：abc123@163.com（该账号当时作为发送者邮件账号）</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>邮箱密码</strong> 
		</dt>
		<dd>
		  <?php echo form::input('mail_password',aE('mail_password'),null,'password',array('width3','autocomplete'=>'new-password','placeholder'=>'请输入邮箱密码')); ?>
          <cite>填写邮件发送SMTP的密码</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>邮箱服务器</strong> 
		</dt>
		<dd>
		  <?php echo form::input('mail_host',aE('mail_host'),null,'text',array('width5','placeholder'=>'请输入邮箱服务器地址')); ?>
          <cite>填写服务器的SMTP地址；例：smtp.163.com</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>邮箱端口</strong> 
		</dt>
		<dd>
		  <?php echo form::input('mail_port',aE('mail_port'),25,'text',array('width2','placeholder'=>'请输入邮箱端口')); ?>
          <cite>填写邮箱端口，默认为：25，如果使用SSL协议，端口一般默认为：465</cite>
		</dd>
	  </dl>
    </div>
  </aside>
  <aside>
	<div>
	  <h2>
		<strong>发送邮件</strong>
	  </h2>
	  <dl>
		<dt>
		  <strong>接收邮箱</strong> 
		</dt>
		<dd>
		  <?php echo form::input('mail_recipient',aE('mail_recipient'),null,'email',array('width4','placeholder'=>'请输入接收邮箱的账号地址')); ?>
          <cite>设置好上方邮箱配置内容后才可测试发送邮件</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>邮件标题</strong> 
		</dt>
		<dd>
		  <?php echo form::input('mail_title',aE('mail_title'),null,'text',array('width8','placeholder'=>'请输入邮件标题')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>邮件内容</strong> 
		</dt>
		<dd>
		  <?php echo form::textarea('mail_content',aE('mail_content'),null,array('ueditor','placeholder'=>'请编辑邮件内容')); ?>
		</dd>
	  </dl>
	</div>
  </aside>
</section>
</form>

<section class="refer">
  <button form="config" class="button blue" type="submit">
    <em class="fa fa-floppy-o"></em>
    <font>保存</font>
  </button>
  <a class="button green tfa" href="<?php echo url::mpf('site','email','send'); ?>">
    <em class="fa fa-envelope-o"></em>
    <font>邮箱发送</font>
  </a>
</section>
<?php load::into('foot'); ?>