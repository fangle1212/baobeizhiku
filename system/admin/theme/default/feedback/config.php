<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('feedback','config','add'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=$data['config']; ?>
<section class="main form tab">
  <aside>
    <div>
      <h2>
        <strong>前台设置</strong>
      </h2>
      <dl>
        <dt>
          <strong>是否启用</strong>
        </dt>
        <dd>
          <?php echo form::radio('feedback_open',aE('feedback_open'),0,$G['option']['open']); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>列表名称</strong>
        </dt>
        <dd>
          <?php echo form::select('feedback_name',aE('feedback_name'),null,arrExist($data,'name'),array('width'=>'40%','placeholder'=>'请选择名称、称呼、姓名的展示字段')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>列表内容</strong>
        </dt>
        <dd>
          <?php echo form::select('feedback_show',json::decode(aE('feedback_show')),null,arrExist($data,'show'),array('width'=>'40%','multiple')); ?>
          <cite>反馈列表内容所能展示的字段，每个字段单独一行</cite>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>验证码开关</strong>
        </dt>
        <dd>
          <?php echo form::radio('feedback_captcha',aE('feedback_captcha'),1,$G['option']['open']); ?>
          <cite>是否开启前台反馈表单的验证码功能</cite>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>验证码标题</strong> 
        </dt>
        <dd>
          <?php echo form::input('feedback_captcha_title',aE('feedback_captcha_title'),'验证码','text',array('width2','placeholder'=>'请输入验证码标题')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>验证码提示</strong> 
        </dt>
        <dd>
          <?php echo form::input('feedback_captcha_placeholder',aE('feedback_captcha_placeholder'),'请输入验证码！','text',array('width3','placeholder'=>'请输入验证码提示')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>验证码错误</strong> 
        </dt>
        <dd>
          <?php echo form::input('feedback_captcha_error',aE('feedback_captcha_error'),'验证码错误！','text',array('width3','placeholder'=>'请输入验证码错误时提示')); ?>
          <cite>前台访客提交反馈后，检测验证码错误时所提示的内容</cite>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>显示反馈</strong>
        </dt>
        <dd>
          <?php echo form::radio('feedback_display',aE('feedback_display'),1,$G['option']['display']); ?>
          <cite>是否在前台显示访客提交的反馈信息</cite>
        </dd>
      </dl>
	  <dl>
		<dt>
		  <strong>反馈按钮</strong> 
		</dt>
		<dd>
		  <?php echo form::input('feedback_submit',aE('feedback_submit'),'提交','text',array('width1','placeholder'=>'请输入反馈按钮文字')); ?>
          <cite>反馈表单的提交按钮文字</cite>
		</dd>
	  </dl>
      <dl>
        <dt>
          <strong>添加成功提示</strong> 
        </dt>
        <dd>
          <?php echo form::input('feedback_success',aE('feedback_success'),'反馈提交成功！','text',array('width3','placeholder'=>'请输入提交成功后的提示')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>提交过快提示</strong> 
        </dt>
        <dd>
          <?php echo form::input('feedback_quick',aE('feedback_quick'),'您刚刚已经提交反馈，请一分钟后再提交！','text',array('width7','placeholder'=>'请输入提交过快提示')); ?>
          <cite>反馈提交成功后必须间隔一分钟才可继续提交新反馈，该提示为提交过快时的提示</cite>
        </dd>
      </dl>
    </div>
  </aside>
  <aside>
    <div>
      <h2>
        <strong>后台设置</strong>
      </h2>
      <dl>
        <dt>
          <strong>显示字段</strong>
        </dt>
        <dd>
          <?php echo form::checkbox('feedback_form',json::decode(aE('feedback_form')),null,arrExist($data,'form'),array('default'=>true)); ?>
          <cite>设置后台反馈列表显示的字段</cite>
        </dd>
      </dl>    
      <dl>
        <dt>
          <strong>邮箱开关</strong>
        </dt>
        <dd>
          <?php echo form::radio('feedback_mail',aE('feedback_mail'),0,$G['option']['open']); ?>
          <cite>是否开启访客提交留言后将内容发送邮件至指定邮箱</cite>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>接收账号</strong>
        </dt>
        <dd>
          <?php echo form::input('feedback_recipient',aE('feedback_recipient'),null,'text',array('width4','placeholder'=>'请输入接收的邮箱账号')); ?>
          <cite>设置访客提交的反馈内容转发到该邮箱</cite>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>邮件标题</strong>
        </dt>
        <dd>
          <?php echo form::input('feedback_title',aE('feedback_title'),'您的网站收到访客留言，请及时查看！','text',array('width7','placeholder'=>'请输入邮件标题')); ?>
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