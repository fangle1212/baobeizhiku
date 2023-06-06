<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('manager','manager','add'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=isset($data['manager'])?$data['manager']:null; $id=arrExist($G['get'],'id'); ?>
<section class="main form">
  <aside>
	<div>
	  <h2>
		<strong>账号设置</strong>
	  </h2>
	  <dl>
		<dt>
		  <strong>账号</strong> 
		</dt>
		<dd>
		  <?php echo form::input('username',aE('username'),null,'text',array($id?'readonly':'','width4','required','placeholder'=>'请输入登陆账号')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>密码</strong> 
		</dt>
		<dd>
		  <?php echo form::input('password',null,null,'password',array('width6','autocomplete'=>'new-password','placeholder'=>'请输入登陆密码')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>重确密码</strong> 
		</dt>
		<dd>
		  <?php echo form::input('passwords',null,null,'password',array('width6','placeholder'=>'请再次输入登陆密码')); ?>
          <cite>重复账号密码，必须于上边密码一致</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>所属部门</strong> 
		</dt>
		<dd>
		  <?php echo form::input('department',aE('department'),null,'text',array('width4','placeholder'=>'请输入所属部门')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>是否启用</strong> 
		</dt>
		<dd>
          <?php echo form::radio('open',aE('open'),1,$G['option']['open']); ?>
		</dd>
	  </dl>
    </div>
  </aside>
  <aside>
	<div>
	  <h2>
		<strong>账号信息</strong>
	  </h2>
	  <dl>
		<dt>
		  <strong>头像</strong> 
		</dt>
		<dd>
		  <?php echo form::textarea('image',aE('image'),null,array('image')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>别名</strong> 
		</dt>
		<dd>
		  <?php echo form::input('alias',aE('alias'),null,'text',array('width4','placeholder'=>'请输入管理员的别名')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>邮箱</strong> 
		</dt>
		<dd>
		  <?php echo form::input('email',aE('email'),null,'email',array('width4','placeholder'=>'请输入邮箱地址')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>电话</strong> 
		</dt>
		<dd>
		  <?php echo form::input('phone',aE('phone'),null,'tel',array('width4','placeholder'=>'请输入电话号码')); ?>
		</dd>
	  </dl>
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