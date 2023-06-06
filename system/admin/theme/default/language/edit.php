<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('language','language','add'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=isset($data)?$data:null; ?>
<section class="main form"> 
  <aside>
	<div>
	  <h2>
		<strong>站点语言</strong>
	  </h2>
	  <dl>
		<dt>
		  <strong>语言标题</strong>
		</dt>
		<dd>
		  <?php echo form::input('name',aE('name'),null,'text',array('width3','required','placeholder'=>'请输入语言标题')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>语言图标</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('image',aE('image'),null,array('image')); ?>
          <cite>用于标示该语言的国旗图标图片，前台会按需调用该图片</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong data="语言的英文缩写编码可对html进行语言标识及伪静态语言标识">语言标识</strong>
		</dt>
		<dd>
		  <?php echo form::input('sign',aE('sign'),null,'text',array('width2','required','placeholder'=>'请输入语言标识')); ?>
          <cite>建议按“<a href="https://www.baidu.com/s?wd=ISO%20639-1" target="_blank">ISO 639-1</a>”国际语言编码填写。</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>语言默认</strong>
		</dt>
		<dd>
		  <?php echo form::radio('defaults',aE('defaults'),0,$G['option']['is'],array('color'=>'green')); ?>
          <cite>是否设置该语言为默认语言；即网址不带有语言标识时调用的语言</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>目标窗口</strong>
		</dt>
		<dd>
		  <?php echo form::radio('target',aE('target'),0,$G['option']['target'],null); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>语言状态</strong>
		</dt>
		<dd>
		  <?php echo form::radio('display',aE('display'),1,$G['option']['open'],null); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>语言描述</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('description',aE('description'),null,array('placeholder'=>'请输入语言描述')); ?>
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