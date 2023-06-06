<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('site','state','add'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=$G['config']; ?>
<section class="main form">
  <aside>
	<div>
	  <h2>
		<strong>网站状态</strong>
	  </h2>
	  <dl>
		<dt>
		  <strong>功能状态</strong> 
		</dt>
		<dd>
		  <?php echo form::radio('state_open',aE('state_open'),1,$G['option']['open']); ?> 
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>站点标题</strong> 
		</dt>
		<dd>
		  <?php echo form::input('state_title',aE('state_title'),null,'text',array('placeholder'=>'请输入站点标题')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>站点内容</strong> 
		</dt>
		<dd>
		  <?php echo form::textarea('state_content',aE('state_content'),null,array('ueditor','placeholder'=>'请编辑站点内容')); ?>
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