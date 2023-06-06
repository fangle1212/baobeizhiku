<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('miniprogram','config','add'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=$G['config']; ?>
<section class="main form">
  <aside>
    <div>
      <h2>
        <strong>功能设置</strong>
      </h2>
      <dl>
        <dt>
          <strong>是否启用</strong>
        </dt>
        <dd>
          <?php echo form::radio('miniprogram_open',aE('miniprogram_open'),0,$G['option']['open'],array('color'=>'green')); ?>
          <cite>是否启用小程序功能</cite>
        </dd>
      </dl>
      <?php if($G['authorize']['oem']){ ?>
      <dl>
        <dt>
          <strong>Token</strong>
        </dt>
        <dd>
          <?php echo form::input('miniprogram_token',aE('miniprogram_token'),null,'text',array('width6','placeholder'=>'请输入Token')); ?>
          <cite>需提供账号Token才能进行发布</cite>
        </dd>
      </dl>
      <?php } ?>
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