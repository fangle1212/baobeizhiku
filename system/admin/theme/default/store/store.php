<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('store','store','add'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=$G['config']; ?>
<section class="main form">
  <article class="hint">
    <b>温馨提示:</b>
    <p>本地存储：上传的图片、视频、压缩包等文件都直接存放于网站程序所在服务器空间中；</p>
    <p>外部存储：各种上传的文件会通过第三方存储平台oss进行网上存储和调用，不会占用服务器的容量。</p>
  </article>
  <aside>
	<div>
	  <h2>
		<strong>存储设置</strong>
	  </h2>
	  <dl>
		<dt>
		  <strong>存储方式</strong> 
		</dt>
		<dd>
		  <?php echo form::radio('store_type',aE('store_type'),0,array('本地存储','外部存储'),array('no')); ?> 
		</dd>
	  </dl>
	  <dl hide platforms>
		<dt>
		  <strong>存储平台</strong> 
		</dt>
		<dd>
		  <?php echo form::select('store_platform',aE('store_platform'),0,$G['option']['platform'],array('width'=>'20%','placeholder'=>'请选择存储平台')); ?>
		</dd>
	  </dl>
      <dl hide platforms platform=0>
        <dt>
          <strong>AccessKeyId</strong>
        </dt>
        <dd>
          <?php echo form::input('store_id0',aE('store_id0'),null,'text',array('width6','placeholder'=>'请输入AccessKeyId')); ?>
        </dd>
      </dl>
      <dl hide platforms platform=0>
        <dt>
          <strong>AccessKeySecret</strong>
        </dt>
        <dd>
          <?php echo form::input('store_key0',aE('store_key0'),null,'text',array('width6','placeholder'=>'请输入AccessKeySecret')); ?>
        </dd>
      </dl>
      <dl hide platforms platform=0>
        <dt>
          <strong>Bucket</strong>
        </dt>
        <dd>
          <?php echo form::input('store_bucket0',aE('store_bucket0'),null,'text',array('width5','placeholder'=>'请输入存储空间名称')); ?>
        </dd>
      </dl>
      <dl hide platforms platform=0>
        <dt>
          <strong>存储地域</strong>
        </dt>
        <dd>
		  <?php echo form::input('store_region0',aE('store_region0'),null,'text',array('width5','placeholder'=>'请输入存储地域')); ?>
        </dd>
      </dl>
      <dl hide platforms platform=0>
        <dt>
          <strong>访问域名</strong>
        </dt>
        <dd>
          <?php echo form::input('store_domain0',aE('store_domain0'),null,'text',array('width5','placeholder'=>'请输入存储空间绑定的访问域名')); ?>
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