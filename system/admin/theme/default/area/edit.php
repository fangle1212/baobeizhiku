<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('area','area','add'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=isset($data)?$data:null; ?>
<section class="main form tab">
  <aside>
    <div>
      <h2>
        <strong>地区设置</strong>
      </h2>
	  <dl>
		<dt>
		  <strong>地域编号</strong>
		</dt>
		<dd>
		  <?php echo form::input('sign',aE('sign'),null,'text',array('width3','placeholder'=>'请输入地域编号')); ?>
          <cite>填写内容必须为英文字母或数字</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>地域名称</strong>
		</dt>
		<dd>
		  <?php echo form::input('name',aE('name'),null,'text',array('width2','placeholder'=>'请输入地域名称')); ?>
          <cite></cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>域名前缀</strong>
		</dt>
		<dd>
		  <?php echo form::input('prefix',aE('prefix'),null,'text',array('width3','placeholder'=>'请输入二级域名前缀')); ?>
          <cite>该城市分站二级域名的前缀，不填写则使用地域编号作为前缀</cite>
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
  <aside>
	<div>
	  <h2>
		<strong>SEO设置</strong>
	  </h2>
	  <dl>
		<dt>
		  <strong>标题</strong>
		</dt>
		<dd>
		  <?php echo form::input('title',aE('title'),null,'text',array('placeholder'=>'请输入网页标题','width9')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>关键词</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('keywords',aE('keywords'),null,array('param','row'=>6,'cut'=>':','off'=>'|','placeholder'=>'["请输入网页关键词"]')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>描述</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('description',aE('description'),null,array('placeholder'=>'请输入网页描述','height2')); ?>
		</dd>
	  </dl>
    </div>
  </aside>
  <aside>
    <div> 
	  <h2>
		<strong>内容设置</strong>
	  </h2>
      <dl>
        <dt>编辑内容</dt>
        <dd><?php echo form::textarea('content',aE('content'),null,array('ueditor')); ?></dd>
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