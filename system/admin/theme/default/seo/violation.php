<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('seo','violation','add'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=$G['config']; ?>
<section class="main form">
  <aside>
	<div>
	  <h2>
		<strong>违禁词设置</strong>
	  </h2>
	  <dl>
		<dt>
		  <strong>功能状态</strong> 
		</dt>
		<dd>
		  <?php echo form::radio('violation_open',aE('violation_open'),0,$G['option']['open']); ?>
          <cite>是否开启站点内容违禁词替换功能</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>替换词汇</strong> 
		</dt>
		<dd>
		  <?php echo form::input('violation_replace',aE('violation_replace'),'*','text',array('width2','placeholder'=>'请输入替换的词汇或字符等')); ?>
          <cite>站点内容中违禁词会变替换为该词汇</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>违禁词表</strong> 
		</dt>
		<dd>
		  <?php echo form::textarea('violation_table',aE('violation_table'),null,array('param','placeholder'=>'["输入单个违禁词"]','row'=>10)); ?>
          <cite>对站点内容需要替换的违禁词</cite>
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