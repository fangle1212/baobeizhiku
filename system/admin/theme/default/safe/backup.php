<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('safe','backup','set'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=$G['config']; ?>
<section class="main form">
  <aside>
	<div>
	  <h2>
		<strong>备份站点</strong>
	  </h2>
	  <dl>
		<dt>
		  <strong>备份数据表</strong> 
		</dt>
		<dd>
		  <?php echo form::select('database',$data['all_database'],null,$data['database'],array('width'=>'60%','multiple')); ?>
          <cite>选择站点需要备份的数据表</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>备份语言</strong> 
		</dt>
		<dd>
          <?php echo form::checkbox('language',$data['all_language'],null,$data['list']); ?>
          <cite>选择站点需要备份的前台语言</cite>
		</dd>
	  </dl>
	</div>
  </aside>
</section>

<section class="refer">
  <button class="button ok" type="submit">
    <em class="fa fa-database"></em>
    <font>备份</font>
  </button>
</section>
</form>
<?php load::into('foot'); ?>