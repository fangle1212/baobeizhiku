<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('member','config','add'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=$G['config']; ?>
<section class="main form tab">
  <aside>
    <div>
      <h2>
        <strong>登录设置</strong>
      </h2>
      <dl>
        <dt>
          <strong>功能状态</strong>
        </dt>
        <dd>
          <?php echo form::radio('member_open',aE('member_open'),0,$G['option']['open']); ?>
          <cite>设置是否启用会员功能</cite>
        </dd>
      </dl>
      <?php url::$domain = $G['path']['site']; ?>
      <dl>
        <dt>
          <strong>登录地址</strong>
        </dt>
        <dd>
          <?php echo form::input('',url::member(null,'login'),null,'text',array('readonly'=>'no')); ?>
          <cite>会员登录地址，可复制至栏目管理中添加</cite>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>注册地址</strong>
        </dt>
        <dd>
          <?php echo form::input('',url::member(null,'registor'),null,'text',array('readonly'=>'no')); ?>
          <cite>会员注册地址，可复制至栏目管理中添加</cite>
        </dd>
      </dl>
    </div>
    <div> 
      <dl>
        <dt>
          <strong>登录验证码</strong>
        </dt>
        <dd>
          <?php echo form::radio('member_login_captcha',aE('member_login_captcha'),0,$G['option']['open']); ?>
          <cite>登录表单是否启用验证码</cite>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>登陆过期秒数</strong>
        </dt>
        <dd>
          <?php echo form::input('member_logout_time',aE('member_logout_time'),28888,'text',array('width2','required','placeholder'=>'请输入登陆过期秒数')); ?>
          <cite>设置登陆会员后多少秒过期自动退出登陆；最低为60秒，默认为28888秒即8小时</cite>
        </dd>
      </dl>
    </div>
  </aside>
  <aside>
    <div>
      <h2>
        <strong>注册设置</strong>
      </h2>
      <dl>
        <dt>
          <strong>注册验证码</strong>
        </dt>
        <dd>
          <?php echo form::radio('member_register_captcha',aE('member_register_captcha'),0,$G['option']['open']); ?>
          <cite>注册表单是否启用验证码</cite>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>注册审核</strong>
        </dt>
        <dd>
          <?php echo form::radio('member_register_check',aE('member_register_check'),0,array('自动审核','手动审核'),array('no')); ?>
          <cite>用户注册提交后是否需要经过审核才能启用账号</cite>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>注册验证</strong>
        </dt>
        <dd>
          <?php echo form::radio('member_captcha_type',aE('member_captcha_type'),0,array('无需验证','手机验证','邮箱验证')); ?>
          <cite>设置是否开启手机或邮箱验证注册</cite>
        </dd>
      </dl>
	  <dl>
		<dt>
		  <strong>短信模板</strong> 
		</dt>
		<dd>
		  <?php echo form::input('member_sms_template',aE('member_sms_template'),null,'text',array('width4','placeholder'=>'请输入注册短信模板的CODE')); ?>
          <cite>注册短信验证码的模板CODE，验证码参数名请使用“code”</cite>
		</dd>
	  </dl>
      <dl>
        <dt>
          <strong>邮件标题</strong>
        </dt>
        <dd>
          <?php echo form::input('member_mail_title',aE('member_mail_title'),'会员注册验证','text',array('width8','placeholder'=>'请输入邮件标题')); ?>
          <cite>注册验证邮件的标题</cite>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>邮件内容</strong>
        </dt>
        <dd>
          <?php echo form::textarea('member_mail_content',aE('member_mail_content'),'&lt;p&gt;请点击链接 [url] 完成会员注册！注意：注册验证链接30分钟内有效！&lt;/p&gt;',array('height'=>'288','ueditor')); ?>
          <cite>注册验证邮件的正文内容，其中请使用“[url]”标签表示跳转链接</cite>
        </dd>
      </dl>
    </div>
    <div>
      <dl>
        <dt>
          <strong>启用协议</strong>
        </dt>
        <dd>
          <?php echo form::radio('member_agreement_open',aE('member_agreement_open'),0,$G['option']['open']); ?>
          <cite>设置是否在注册时需要展示并确认协议</cite>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>协议链接</strong>
        </dt>
        <dd>
          <?php echo form::input('member_agreement_link',aE('member_agreement_link'),'','text',array('width6','placeholder'=>'请输入邮件标题')); ?>
          <cite>设置注册时展示的协议链接地址</cite>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>阅读同意协议</strong>
        </dt>
        <dd>
          <?php echo form::input('member_agreement_yes',aE('member_agreement_yes'),'我已阅读并同意','text'); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>协议名称</strong>
        </dt>
        <dd>
          <?php echo form::input('member_agreement_name',aE('member_agreement_name'),'《用户协议》','text'); ?>
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