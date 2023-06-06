<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<section class="main">
  <article class="hint">
    <i class="fa fa-info-circle"></i>
    <p>完成付款后，请根据您的情况点击下方链接！</p>
  </article>
  <aside>
	<div class="order">
      <dl><a class="red" href="<?php echo url::mpf('template','market','pay',array('orders'=>$G['get']['orders'],'name'=>null)); ?>" target="_blank">没有跳转付款界面？点我支付</a></dl>
      <dl><a class="green install" href="<?php echo url::mpf('template','market','install',array('name'=>$G['get']['name'],'referer'=>'[url]')); ?>" target="_parent">已完成付款！立即安装</a></dl>
	</div>
  </aside>
</section>
<?php load::into('foot'); ?>