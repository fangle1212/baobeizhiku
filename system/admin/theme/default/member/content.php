<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('member','config','content_add'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=$G['config']; ?>
<section class="main form tab">
  <aside>
    <div>
      <h2>
        <strong>基础设置</strong>
      </h2>
      <dl>
        <dt>
          <strong>用户名</strong>
        </dt>
        <dd>
          <?php echo form::input('member_username',aE('member_username'),'用户名','text',array('required','width4')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>密码</strong>
        </dt>
        <dd>
          <?php echo form::input('member_password',aE('member_password'),'密码','text',array('required','width4')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>重复密码</strong>
        </dt>
        <dd>
          <?php echo form::input('member_passwords',aE('member_passwords'),'重复密码','text',array('required','width4')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>验证码</strong>
        </dt>
        <dd>
          <?php echo form::input('member_code',aE('member_code'),'验证码','text',array('required','width4')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>邮箱</strong>
        </dt>
        <dd>
          <?php echo form::input('member_email',aE('member_email'),'邮箱','text',array('required','width4')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>手机</strong>
        </dt>
        <dd>
          <?php echo form::input('member_phone',aE('member_phone'),'手机','text',array('required','width4')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>登录按钮文字</strong>
        </dt>
        <dd>
          <?php echo form::input('member_login_button',aE('member_login_button'),'登录注册','text',array('required','width4')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>注册按钮文字</strong>
        </dt>
        <dd>
          <?php echo form::input('member_register_button',aE('member_register_button'),'立即注册','text',array('required','width4')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>手机验证码</strong>
        </dt>
        <dd>
          <?php echo form::input('member_phone_code',aE('member_phone_code'),'手机验证码','text',array('required','width6')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>获取验证码</strong>
        </dt>
        <dd>
          <?php echo form::input('member_phone_button',aE('member_phone_button'),'获取验证码','text',array('required','width6')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>重新发送</strong>
        </dt>
        <dd>
          <?php echo form::input('member_phone_retime',aE('member_phone_retime'),'重新发送([time]s)','text',array('required','width6')); ?>
          <cite>请使用 [time] 代替发送倒计时秒数</cite>
        </dd>
      </dl>
    </div>
  </aside>
  <aside>
    <div>
      <h2>
        <strong>提示设置</strong>
      </h2>
      <dl>
        <dt>
          <strong>未读协议提示</strong>
        </dt>
        <dd>
          <?php echo form::input('member_agreement_error',aE('member_agreement_error'),'请阅读并同意协议','text',array('required','width6')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>验证码错误</strong>
        </dt>
        <dd>
          <?php echo form::input('member_code_error',aE('member_code_error'),'验证码错误','text',array('required','width5')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>登录成功</strong>
        </dt>
        <dd>
          <?php echo form::input('member_login_success',aE('member_login_success'),'登录成功','text',array('required','width5')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>提交信息错误</strong>
        </dt>
        <dd>
          <?php echo form::input('member_post_error',aE('member_post_error'),'没有提交信息','text',array('required','width5')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>账号密码错误</strong>
        </dt>
        <dd>
          <?php echo form::input('member_login_error',aE('member_login_error'),'账号或密码错误','text',array('required','width5')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>密码格式错误</strong>
        </dt>
        <dd>
          <?php echo form::input('member_password_error',aE('member_password_error'),'密码必须含有英文字母和数字，且长度大于6位字符','text',array('required','width8')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>重复密码错误</strong>
        </dt>
        <dd>
          <?php echo form::input('member_passwords_error',aE('member_passwords_error'),'两次密码输入不同，请重新输入','text',array('required','width7')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>图片错误</strong>
        </dt>
        <dd>
          <?php echo form::input('member_avatar_error',aE('member_avatar_error'),'图片错误','text',array('required','width4')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>图片大小错误</strong>
        </dt>
        <dd>
          <?php echo form::input('member_avatar_size_error',aE('member_avatar_size_error'),'上传图片大小不能超过','text',array('required','width6')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>账号修改成功</strong>
        </dt>
        <dd>
          <?php echo form::input('member_information_success',aE('member_information_success'),'账号信息修改成功','text',array('required','width6')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>账号修改失败</strong>
        </dt>
        <dd>
          <?php echo form::input('member_information_error',aE('member_information_error'),'账号信息修改失败','text',array('required','width6')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>邮件链接失效</strong>
        </dt>
        <dd>
          <?php echo form::input('member_email_link_error',aE('member_email_link_error'),'邮件验证链接已失效','text',array('required','width6')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>注册成功</strong>
        </dt>
        <dd>
          <?php echo form::input('member_register_success',aE('member_register_success'),'注册成功','text',array('required','width4')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>注册失败</strong>
        </dt>
        <dd>
          <?php echo form::input('member_register_error',aE('member_register_error'),'注册失败','text',array('required','width4')); ?>
        </dd>
      </dl> 
      <dl>
        <dt>
          <strong>注册待审核</strong>
        </dt>
        <dd>
          <?php echo form::input('member_register_success_check',aE('member_register_success_check'),'注册成功，请等待审核结果','text',array('required','width5')); ?>
        </dd>
      </dl>
      
      <dl>
        <dt>
          <strong>手机号错误</strong>
        </dt>
        <dd>
          <?php echo form::input('member_phone_error',aE('member_phone_error'),'手机号错误','text',array('required','width4')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>手机验证限制</strong>
        </dt>
        <dd>
          <?php echo form::input('member_phone_rdtime_min',aE('member_phone_rdtime_min'),'秒后才能发送验证码','text',array('required','width5')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>手机验证码错误</strong>
        </dt>
        <dd>
          <?php echo form::input('member_phone_code_error',aE('member_phone_code_error'),'手机验证码错误','text',array('required','width5')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>短信发送成功</strong>
        </dt>
        <dd>
          <?php echo form::input('member_phone_sms_success',aE('member_phone_sms_success'),'手机验证码已发送','text',array('required','width5')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>短信发送失败</strong>
        </dt>
        <dd>
          <?php echo form::input('member_phone_sms_error',aE('member_phone_sms_error'),'手机验证码发送失败','text',array('required','width5')); ?>
        </dd>
      </dl>
      
      <dl>
        <dt>
          <strong>账号名称错误</strong>
        </dt>
        <dd>
          <?php echo form::input('member_username_error',aE('member_username_error'),'账户名称必须大于2个字符','text',array('required','width6')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>账号名已存在</strong>
        </dt>
        <dd>
          <?php echo form::input('member_username_has_error',aE('member_username_has_error'),'该账号已经存在，请重新输入','text',array('required','width6')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>邮箱格式错误</strong>
        </dt>
        <dd>
          <?php echo form::input('member_email_error',aE('member_email_error'),'邮箱格式错误','text',array('required','width5')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>邮件发送成功</strong>
        </dt>
        <dd>
          <?php echo form::input('member_email_send_success',aE('member_email_send_success'),'注册验证邮件已发送','text',array('required','width6')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>邮件发送失败</strong>
        </dt>
        <dd>
          <?php echo form::input('member_email_send_error',aE('member_email_send_error'),'邮件发送失败','text',array('required','width5')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>登出成功</strong>
        </dt>
        <dd>
          <?php echo form::input('member_logout_success',aE('member_logout_success'),'登出成功','text',array('required','width4')); ?>
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