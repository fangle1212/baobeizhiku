<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('consult','consult','add'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=isset($data)?$data:null; ?>
<section class="main form">
  <aside>
    <div>
      <h2>
        <strong>客服设置</strong>
      </h2>
	  <dl>
		<dt>
		  <strong>客服标题</strong>
		</dt>
		<dd>
		  <?php echo form::input('name',aE('name'),null,'text',array('required','width4','placeholder'=>'客服标题')); ?>
		</dd>
	  </dl>
      <dl>
        <dt>
          <strong>客服类型</strong>
        </dt>
        <dd>
          <?php echo form::select('type',aE('type'),null,$G['option']['consult'],array('required','width'=>'30%','placeholder'=>'请选择客服类型')); ?>
          <cite>选择需要设置的客服类型，会有对应的设置项目</cite>
        </dd>
      </dl>
      <dl hide type=0>
        <dt>
          <strong>微信二维码</strong>
        </dt>
        <dd>
          <?php echo form::textarea('value0',aE('value0'),null,array('image')); ?>
        </dd>
      </dl>
      <dl hide type=1>
        <dt>
          <strong>QQ号码</strong>
        </dt>
        <dd>
          <?php echo form::input('value1',aE('value1'),null,'text',array('width4','placeholder'=>'请输入QQ号码')); ?>
        </dd>
      </dl>
      <dl hide type=2>
        <dt>
          <strong>电话号码</strong>
        </dt>
        <dd>
          <?php echo form::input('value2',aE('value2'),null,'tel',array('width4','placeholder'=>'请输入电话号码')); ?>
        </dd>
      </dl>
      <dl hide type=3>
        <dt>
          <strong>邮箱账号</strong>
        </dt>
        <dd>
          <?php echo form::input('value3',aE('value3'),null,'email',array('width4','placeholder'=>'请输入邮箱账号')); ?>
        </dd>
      </dl>
      <dl hide type=99>
        <dt>
          <strong>代码内容</strong>
        </dt>
        <dd>
          <?php echo form::textarea('value99',aE('value99'),null,array('placeholder'=>'请输入第三方客服JS调取代码')); ?>
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
	  <dl>
		<dt>
		  <strong>列表排序</strong>
		</dt>
		<dd>
		  <?php echo form::input('sort',aE('sort'),0,'text',array('width1')); ?>
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