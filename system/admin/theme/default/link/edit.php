<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('link','link','add'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=isset($data)?$data:null; ?>
<section class="main form">
  <aside>
    <div>
      <h2>
        <strong>友链设置</strong>
      </h2>
	  <?php if($G['get']['area']){ ?>
	  <?php if($G['get']['area']=='all'){ ?>
	  <dl>
		<dt>
		  <strong>下级续增</strong>
		</dt>
		<dd>
		  <?php echo form::radio('continue',aE('continue'),0,$G['option']['is']); ?>
          <cite>如果该添加友链的城市拥有下级城市，则自动给下级城市续增相同的友链</cite>
		</dd>
	  </dl>
      <?php } ?>
      <?php }else{ ?>
	  <dl>
		<dt>
		  <strong>所属栏目</strong>
		</dt>
		<dd>
		  <?php echo form::select('items',aE('items'),'["88888"]',$data['subarr'],array('width'=>'60%','multiple')); ?>
          <cite>指定该友情链接所属的栏目</cite>
		</dd>
	  </dl>
      <?php } ?>
	  <dl>
		<dt>
		  <strong>标题名称</strong>
		</dt>
		<dd>
		  <?php echo form::input('name',aE('name'),null,'text',array('width4','placeholder'=>'请输入标题名称')); ?>
		</dd>
	  </dl>
      <dl>
		<dt>
		  <strong>友链类型</strong>
		</dt>
		<dd>
		  <?php echo form::radio('type',aE('type'),0,$G['option']['link'],array('no')); ?>
          <cite>设置该条友情链接的展示类型</cite>
		</dd>
      </dl>
	  <dl image>
		<dt>
		  <strong>LOGO图片</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('image',aE('image'),null,array('image')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>链接地址</strong>
		</dt>
		<dd>
		  <?php echo form::input('link',aE('link'),null,'text',array('width8','placeholder'=>'请输入链接地址')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>nofollow权重</strong>
		</dt>
		<dd>
		  <?php echo form::radio('nofollow',aE('nofollow'),0,$G['option']['open']); ?>
		  <cite>设置该友情链接是否启用 rel='nofollow' 属性屏蔽权重传递</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>目标窗口</strong>
		</dt>
		<dd>
		  <?php echo form::radio('target',aE('target'),1,$G['option']['target'],array('no')); ?>
          <cite>是否新窗口打开友链</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>是否显示</strong>
		</dt>
		<dd>
		  <?php echo form::radio('display',aE('display'),1,$G['option']['display'],array('color'=>'green')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>列表排序</strong>
		</dt>
		<dd>
		  <?php echo form::input('sort',aE('sort'),0,'text',array('width1','placeholder'=>'请输入列表排序')); ?>
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