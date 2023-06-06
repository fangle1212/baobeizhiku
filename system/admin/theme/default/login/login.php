<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<?php if($G['config']['admin_login_bgimg']){ ?>
<section class="background-box">
  <img src="<?php echo $G['config']['admin_login_bgimg']; ?>" />
</section>
<?php } ?>
<section class="login-box">
  <div class="login-body">
    <div class="login-logo">
      <a href="<?php echo quotesFilter($G['config']['admin_login_link']); ?>" target="_blank">
        <img rand src="../system/admin/common/img/logo.png" />
      </a>
    </div>
    <div class="login-form">
      <span>
        <h2><?php echo $G['config']['admin_login_title']; ?></h2>
      </span>
      <form action="<?php echo url::mpf('login','login','check'); ?>" method="post">
        <code class="input" icon>
          <em class="fa fa-user"></em>
          <?php echo form::input('username',null,$data['username'],'text',array('required','placeholder'=>'用户名'),false);?>
        </code>
        <code class="input" icon>
          <em class="fa fa-unlock-alt"></em>
          <?php echo form::input('password',null,null,'password',array('required','placeholder'=>'密码'),false);?>
        </code>
        <?php if($G['config']['admin_login_captcha']){ ?>
        <?php if($G['config']['admin_captcha_type']){ ?>
        <script captchaappid="<?php echo $G['config']['captcha_appid']; ?>" src="https://ssl.captcha.qq.com/TCaptcha.js"></script>
        <?php echo form::input('randstr','',null,'hidden',array(),false); ?>
        <?php echo form::input('ticket','',null,'hidden',array(),false); ?>
        <?php }else{ ?>
        <code class="input" icon captcha>
          <em class="fa fa-shield"></em>
          <?php echo form::input('captcha',null,null,'text',array('required','placeholder'=>'验证码'),false);?>
          <img captcha src="../api/captcha/" />
        </code>
        <?php } ?>
        <?php } ?>
        <code class="checkbox">
          <label class="checkbox"><input name="save" type="checkbox" value="1"><ins>保存账号</ins></label>
        </code>
        <button class="button blue" type="submit">提交</button>
      </form>
    </div>
  </div>
  <div class="login-foot" align="center">
    <p size15><?php echo load::copyright(); ?></p>
  </div>
</section>
<?php load::into('foot'); ?>