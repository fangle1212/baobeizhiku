<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('tag','tag','add'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=isset($data)?$data:null; ?>
<section class="main form <?php if(arrExist($G['get'],'id')){ ?>tab<?php } ?>">  
  <aside>
    <div>
      <h2>
        <strong>TAG标签设置</strong>
      </h2>
      
      <?php if(arrExist($G['get'],'id')){ ?>
	  <dl>
		<dt>
		  <strong>标签名称</strong>
		</dt>
		<dd>
		  <?php echo form::input('title',aE('title'),null,'text',array('width3','placeholder'=>'请输入标签名称')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>路径名称</strong>
		</dt>
		<dd>
		  <?php echo form::input('name',aE('name'),null,'text',array('width4','placeholder'=>'请输入路径名称')); ?>
          <cite>标签不填写则使用id作为标签默认路径值；如要修改，建议用纯英文或英文开头夹数字的名称来组合</cite>
		</dd>
	  </dl>
      <?php }else{ ?>
	  <dl>
		<dt>
		  <strong>栏目类型</strong>
		</dt>
		<dd>
		  <?php echo form::select('type',aE('type'),$G['get']['type'],$G['type'],array('width'=>'20%')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>标签名称</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('title',aE('title'),null,array('param','placeholder'=>'["请输入标签名称"]')); ?>
          <cite>新增标签时可以进行批量添加</cite>
		</dd>
	  </dl>
      <?php } ?>
      
    </div>
  </aside>
  
  <?php if(arrExist($G['get'],'id')){ ?>
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
		  <?php echo form::input('seo_title',aE('seo_title'),null,'text',array('placeholder'=>'请输入网页标题','width9')); ?>
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