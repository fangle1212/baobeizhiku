<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('menu','menu','add'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=isset($data)?$data:null; ?>
<section class="main form">
  <aside>
    <div>
      <h2>
        <strong>菜单设置</strong>
      </h2>
	  <dl>
		<dt>
		  <strong>菜单标题</strong>
		</dt>
		<dd>
		  <?php echo form::input('name',aE('name'),null,'text',array('width3','placeholder'=>'请输入菜单标题')); ?>
		</dd>
	  </dl>
      <dl>
        <dt>
          <strong>菜单类型</strong>
        </dt>
        <dd>
          <?php echo form::select('type',aE('type'),null,$G['option']['menu'],array('width'=>'30%','placeholder'=>'请选择菜单类型')); ?>
          <cite>选择需要设置的菜单类型，会有对应的设置项目</cite>
        </dd>
      </dl>
	  <dl hide type=0>
		<dt>
		  <strong>栏目选择</strong>
		</dt>
		<dd>
		  <?php echo form::select('value0',aE('value0'),null,$data['subarr'],array('width'=>'40%','placeholder'=>'请选择链接的栏目')); ?>
          <cite>该菜单链接的栏目</cite>
		</dd>
	  </dl>
	  <dl hide type=1>
		<dt>
		  <strong>链接地址</strong>
		</dt>
		<dd>
		  <?php echo form::input('value1',aE('value1'),null,'text',array('width8','placeholder'=>'请输入链接地址')); ?>
          <cite>该菜单的链接地址</cite>
		</dd>
	  </dl>
      <dl hide type=2>
        <dt>
          <strong>图片选择</strong>
        </dt>
        <dd>
          <?php echo form::textarea('value2',aE('value2'),null,array('image')); ?>
          <cite>点击该菜单弹出的图片</cite>
        </dd>
      </dl>
	  <dl hide type=3>
		<dt>
		  <strong>JS代码</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('value3',aE('value3'),null,array('placeholder'=>'请输入执行的JS代码')); ?>
          <cite>点击该菜单执行的JS代码，代码形式：&lt;a onclick='【执行的JS代码】' &gt;&lt;/a&gt;</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>图标选择</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('icon',aE('icon'),null,array('icon')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>字体颜色</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('color',aE('color'),'rgb(255,255,255)',array('color')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>背景颜色</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('bgcolor',aE('bgcolor'),'rgb(0,185,255)',array('color')); ?>
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
		  <?php echo form::radio('display',aE('display'),1,$G['option']['display']); ?>
		</dd>
	  </dl>
	  <dl bosscms>
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