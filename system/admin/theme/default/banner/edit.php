<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('banner','banner','add'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=isset($data)?$data:null; ?>
<section class="main form tab">
  <aside>
    <div>
      <h2>
        <strong>轮播设置</strong>
      </h2>
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
		  <strong>轮播图片</strong>
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
          <strong>终端屏幕</strong>
        </dt>
        <dd>
          <?php echo form::radio('screen',aE('screen'),null,$G['option']['screen'],array('multiple','no')); ?>
        </dd>
      </dl>
      
      <dl>
        <dt>
          <strong>展示位置</strong>
        </dt>
        <dd>
          <?php echo form::radio('site',aE('site'),null,array('按类型展示','按栏目展示'),array('multiple','no')); ?>
          <cite>该轮播按类型/栏目选择的位置在网站中进行展示</cite>
        </dd>
      </dl>
      <dl hide type>
        <dt>
          <strong>选择类型</strong>
        </dt>
        <dd>
          <?php echo form::select('type',aE('type'),null,$G['type'],array('width'=>'30%','multiple')); ?>
        </dd>
      </dl>
	  <dl hide items>
		<dt>
		  <strong>选择栏目</strong>
		</dt>
		<dd>
		  <?php echo form::select('items',aE('items'),null,$data['subarr'],array('width'=>'60%','multiple')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>目标窗口</strong>
		</dt>
		<dd>
		  <?php echo form::radio('target',aE('target'),0,$G['option']['target']); ?>
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
  
  <aside>
    <div>
      <h2>
        <strong>内容设置</strong>
      </h2>
	  <dl>
		<dt>
		  <strong>编辑内容</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('content',aE('content'),null,array('ueditor','placeholder'=>'请输入编辑内容')); ?>
          <cite>请根据模板轮播图的实际调用情况进行设置</cite>
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