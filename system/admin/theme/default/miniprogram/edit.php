<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('miniprogram','miniprogram','add'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=isset($data)?$data:null; ?>
<section class="main form"> 
  <aside>
	<div>
	  <h2>
		<strong>基础设置</strong>
	  </h2>
	  <dl>
		<dt>
		  <strong>目录名称</strong>
		</dt>
		<dd>
		  <?php echo form::input('names',aE('name'),null,'text',array('width5','placeholder'=>'请输入文件夹名称')); ?>
		</dd>
	  </dl> 
	  <dl>
		<dt>
		  <strong>封面图片</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('image',aE('image'),null,array('image')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>模板名称</strong>
		</dt>
		<dd>
		  <?php echo form::input('title',aE('title'),null,'text',array('width7','placeholder'=>'请输入模板名称')); ?>
		</dd>
	  </dl>  
	  <dl>
		<dt>
		  <strong>模板型号</strong>
		</dt>
		<dd>
		  <?php echo form::input('serial',aE('serial'),null,'text',array('width5','placeholder'=>'请输入模板型号',$G['get']['name']?'readonly':'')); ?>
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