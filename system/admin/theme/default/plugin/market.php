<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<section class="main">
  <aside>
	<div class="order">
      <dl><a class="green install" href="<?php echo url::mpf('plugin','market','install',array('name'=>$G['get']['name'],'referer'=>'[url]')); ?>" target="_parent">购买成功！立即安装</a></dl>
	</div>
  </aside>
</section>
<?php load::into('foot'); ?>