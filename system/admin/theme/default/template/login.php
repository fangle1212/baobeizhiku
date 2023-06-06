<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('template','market','hello'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=$G['config']; ?>
<section class="main form">
  <aside>
	<div>
	  <dl>
		<dt>
		  <strong>手机号</strong> 
		</dt>
		<dd>
		  <?php echo form::input('tel',aE('tel'),'','text',array('required','placeholder'=>'请输入手机号','width9')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>密码</strong> 
		</dt>
		<dd>
		  <?php echo form::input('password',aE('password'),'','password',array('required','placeholder'=>'请输入密码','width9')); ?>
		</dd>
	  </dl>
	</div>
  </aside>
</section>
<section class="refer">
  <button class="button ok" type="submit">
    <font>立即登录</font>
  </button>
  <a href="https://www.bosscms.net/login/forget.php" target="_blank">忘记密码？点我找回！</a>
</section>
</form>
<?php load::into('foot'); ?>