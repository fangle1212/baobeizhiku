<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('layers','layers','add'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=isset($data)?$data:null; ?>
<section class="main form">
  <?php if($data['ctrl']){ ?>
  <aside>
	<div>
	  <h2>
		<strong>基础设置</strong>
	  </h2>
	  <dl>
		<dt>
		  <strong>标题名称</strong>
		</dt>
		<dd>
		  <?php echo form::input('name',aE('name'),null,'text',array('required','width8')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>列表排序</strong>
		</dt>
		<dd>
		  <?php echo form::input('sort',aE('sort'),0,'text',array('required','width2')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>是否显示</strong>
		</dt>
		<dd>
		  <?php echo form::radio('display',aE('display'),1,$G['option']['display']); ?>
		</dd>
	  </dl>
	</div>
  </aside>
  
  <aside class="ctrl">
	<?php
	foreach($data['ctrl'] as $core=>$ctrl){
	if($ctrl['ctrl']){
	?>
	<div>
	  <h2>
		<strong>内容设置</strong>
	  </h2>
	  <?php foreach($ctrl['ctrl'] as $v){ ?>
	  <dl>
		<dt>
		  <strong <?php if($v['description']){ ?>data="<?php echo $v['description']; ?>"<?php } ?>><?php echo $v['title']; ?></strong>
		</dt>
		<dd>
          <?php echo ctrl::complex(88, $core, $v, 0, $data); ?>
		</dd>
	  </dl>
	  <?php } ?>
	</div>
	<?php
	}
	}
	?>
  </aside>
  <?php } ?>
</section>

<section class="refer">
  <button class="button ok" type="submit">
    <em class="fa fa-floppy-o"></em>
    <font>保存</font>
  </button>
</section>  
</form>
<?php load::into('foot'); ?>