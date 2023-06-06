<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('site','code','add'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=$G['config']; ?>
<section class="main form tab">
  <aside>
	<div>
	  <h2>
		<strong>电脑端配置</strong>
	  </h2>
	  <dl>
		<dt>
		  <strong>头部代码</strong> 
		</dt>
		<dd>
		  <?php echo form::textarea('head_code',aE('head_code'),null,array('height5','placeholder'=>'请输入电脑端头部代码')); ?>
          <cite>网站头部&lt;/head&gt;代码部分前插入该头部代码</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>底部代码</strong> 
		</dt>
		<dd>
		  <?php echo form::textarea('foot_code',aE('foot_code'),null,array('height5','placeholder'=>'请输入电脑端底部代码')); ?>
          <cite>网站底部&lt;/body&gt;代码部分前插入该底部代码</cite>
		</dd>
	  </dl>
	</div>
  </aside>
  <aside>
	<div>
	  <h2>
		<strong>手机端配置</strong>
	  </h2>
	  <dl>
		<dt>
		  <strong>头部代码</strong> 
		</dt>
		<dd>
		  <?php echo form::textarea('head_mobile_code',aE('head_mobile_code'),null,array('height5','placeholder'=>'请输入手机端头部代码')); ?>
          <cite>网站头部&lt;/head&gt;代码部分前插入该头部代码</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>底部代码</strong> 
		</dt>
		<dd>
		  <?php echo form::textarea('foot_mobile_code',aE('foot_mobile_code'),null,array('height5','placeholder'=>'请输入手机端底部代码')); ?>
          <cite>网站底部&lt;/body&gt;代码部分前插入该底部代码</cite>
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