<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('safe','safe','add'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=$G['config']; ?>
<section class="main form">
  <aside>
	<div>
	  <h2>
		<strong>安全设置</strong>
		<span></span>
	  </h2>
	  <dl>
		<dt>
		  <strong>后台目录</strong> 
		</dt>
		<dd>
		  <?php echo form::input('admin_folder',$G['path']['folder'],'manage','text',array('required','width3','placeholder'=>'请输入后台目录名称')); ?>
          <cite>设置站点后台管理登陆文件夹的目录名称</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>登陆验证</strong> 
		</dt>
		<dd>
		  <?php echo form::radio('admin_login_captcha',aE('admin_login_captcha'),1,$G['option']['open'],null); ?>
          <cite>设置登陆站点的后台管理时是否需要验证码验证</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>验证码类型</strong> 
		</dt>
		<dd>
		  <?php echo form::radio('admin_captcha_type',aE('admin_captcha_type'),0,array('普通验证','图形验证'),array('no')); ?>
          <cite>设置登陆站点的后台管理时验证码类型，图形验证需要“<a href="<?php echo url::mpf('site','captcha','init'); ?>">配置接口</a>”</cite>
          <?php if($G['config']['captcha_id'] && $G['config']['captcha_key'] && $G['config']['captcha_appid'] && $G['config']['captcha_appkey']){ ?>
          <script captchaappid="<?php echo $G['config']['captcha_appid']; ?>" src="https://ssl.captcha.qq.com/TCaptcha.js"></script>
          <?php } ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>登陆过期秒数</strong> 
		</dt>
		<dd>
		  <?php echo form::input('admin_logout_time',aE('admin_logout_time'),28888,'text',array('required','width2','placeholder'=>'请输入登陆过期秒数')); ?>
          <cite>设置登陆站点的后台管理后多少秒过期自动退出登陆；最低为60秒，默认为28888秒即8小时</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong data="登录失败到达次数后会被限制登录">登陆失败次数</strong> 
		</dt>
		<dd>
		  <?php echo form::input('admin_login_errnum',aE('admin_login_errnum'),6,'text',array('required','width1','placeholder'=>'请输入登陆失败次数')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>失败限制时间</strong> 
		</dt>
		<dd>
		  <?php echo form::input('admin_login_errtime',aE('admin_login_errtime'),3600,'text',array('required','width2','placeholder'=>'请输入失败限制时间')); ?>
          <cite>登录失败到达次数后会被限制登录；该处设置限制登录的秒数时间</cite>
		</dd>
	  </dl>
	</div>
  </aside>

  <aside>
	<div>
	  <h2>
		<strong>网站状态</strong>
		<span></span>
	  </h2>
	  <dl>
		<dt>
		  <strong>默认全屏弹窗</strong> 
		</dt>
		<dd>
		  <?php echo form::radio('window_full',aE('window_full'),0,$G['option']['is']); ?>
		  <cite>设置后台弹窗默认是否需要全屏显示</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>文件重命名</strong> 
		</dt>
		<dd>
		  <?php echo form::radio('upload_rename',aE('upload_rename'),1,$G['option']['open']); ?>
		  <cite>设置上传的文件是否要重命名</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>文件最大限制</strong> 
		</dt>
		<dd>
		  <?php echo form::input('upload_maxsize',aE('upload_maxsize'),2,'text',array('required','width1')); ?>
		  <cite>设置可上传文件最大限制大小；单位：MB</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>允许上传类型</strong> 
		</dt>
		<dd>
		  <?php echo form::textarea('upload_extension',aE('upload_extension'),null,array('param','placeholder'=>'["输入文件类型的后缀名"]','row'=>5)); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>前台上传权限</strong> 
		</dt>
		<dd>
		  <?php echo form::radio('upload_web_allow',aE('upload_web_allow'),0,$G['option']['open']); ?>
		  <cite>设置是否允许前台上传文件</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>防止重复上传</strong> 
		</dt>
		<dd>
		  <?php echo form::radio('upload_repeat',aE('upload_repeat'),0,$G['option']['open']); ?>
		  <cite>判断上传文件是否存在，如已存在则不上传文件且返回已存在文件路径地址<br />注：该功能只对本地存储文件有效，对oss存储无效</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>页面缓存秒数</strong> 
		</dt>
		<dd>
		  <?php echo form::input('page_cache_time',aE('page_cache_time'),0,'text',array('required','width2','placeholder'=>'请输入页面缓存秒数')); ?>
          <cite>前台访问后页面被缓存多少秒，过期后调取数据重新生成；配置为0秒则不缓存页面</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>远程下载</strong> 
		</dt>
		<dd>
		  <?php echo form::radio('ueditor_catchimage',aE('ueditor_catchimage'),1,$G['option']['open']); ?>
		  <cite>设置ueditor编辑器是否开启远程下载图片功能；即从其他站点复制文章到ueditor编辑器粘贴后，内容中的图片是否自动下载到服务器。<br />说明：使用者即表明同意承担使用本功能下载内容的相关法律责任。</cite>
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