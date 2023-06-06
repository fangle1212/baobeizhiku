<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('anchor','anchor','add'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=isset($data)?$data:null; ?>
<section class="main form">
  <aside>
    <div>
      <h2>
        <strong>锚文本设置</strong>
      </h2>
      
	  <dl>
		<dt>
		  <strong>原文本</strong>
		</dt>
		<dd>
		  <?php echo form::input('old',aE('old'),null,'text',array('width4','placeholder'=>'请输入原版文本内容')); ?>
          <cite>锚文本的原版文本内容</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>替换为</strong>
		</dt>
		<dd>
		  <?php echo form::input('new',aE('new'),null,'text',array('width4','placeholder'=>'请输入新版替换内容')); ?>
          <cite>锚文本的新版替换文本内容</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>title</strong>
		</dt>
		<dd>
		  <?php echo form::input('title',aE('title'),null,'text',array('width4','placeholder'=>'请输入title属性内容')); ?>
          <cite>锚文本链接的title属性，不填则调用替换文本内容</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>链接地址</strong>
		</dt>
		<dd>
		  <?php echo form::input('link',aE('link'),null,'text',array('width8','placeholder'=>'请输入链接地址')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>nofollow权重</strong>
		</dt>
		<dd>
		  <?php echo form::radio('nofollow',aE('nofollow'),0,$G['option']['open']); ?>
          <cite>该锚文本是否启用rel=nofollow属性屏蔽权重传递</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>目标窗口</strong>
		</dt>
		<dd>
		  <?php echo form::radio('target',aE('target'),1,$G['option']['target'],array('no')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>是否启用</strong>
		</dt>
		<dd>
		  <?php echo form::radio('open',aE('open'),1,$G['option']['open'],array('color'=>'green')); ?>
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