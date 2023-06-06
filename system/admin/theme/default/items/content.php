<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<?php echo $G['navsub']; ?>
<form action="<?php echo url::mpf('items','content','add'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=isset($data)?$data:null; $type=aE('type'); ?>
<section class="main form">
  <aside>
	<div>
	  <h2>
		<strong>内容设置</strong>
	  </h2>
	  <dl>
		<dt>
		  <strong>编辑内容</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('content',aE('content'),null,array('ueditor')); ?>
          <cite>请根据模板实际调用进行配置</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>跳转下级</strong>
		</dt>
		<dd>
		  <?php echo form::radio('issub',aE('issub'),0,$G['option']['is']); ?>
          <cite>点击该栏目链接是否直接跳转展示下级第一个栏目</cite>
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