<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('group','group',$data['action']); ?>" method="post" enctype="multipart/form-data">
<section class="main form">
  <aside>
	<div>
	  <dl>
		<dt>
		  <strong>所属栏目</strong>
		</dt>
		<dd>
		  <?php echo form::select($data['action'],null,false,$data['subarr'],array('width'=>'60%','placeholder'=>'请选择'.($data['action']=='copys'?'复制':'移动').'栏目')); ?>
          <cite>选择<?php echo $data['action']=='copys'?'复制':'移动'; ?>列表到的栏目</cite>
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