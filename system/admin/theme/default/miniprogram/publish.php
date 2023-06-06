<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>

<?php
switch($data['state']){
	case 0:
		location($data['url'].'?referer='.urlencode($G['path']['site'].'system/admin/miniprogram/common/redirect.html'));
		break;
    case 1:
?>
<section class="main">
  <aside class="status">
	<div class="import">
		<u class="<?php echo 's'.$data['status']; ?>"><i class="fa fa-exclamation"></i><i class="fa fa-check"></i></u>
		<h2>微信官方审核提示： <b><?php echo $data['msg']; ?></b></h2>
		<?php if($data['status'] == 0){ ?>
		<div><?php echo $data['reason']; ?><p>小程序已通过微信官方审核，可点击下方按钮立即发布到小程序。</p></div>
		<p><a class="button green" href="<?php echo url::mpf('miniprogram','interfaces','release',array('type'=>'weixin')); ?>">立即发布</a></p>
		<?php }else if($data['status'] == 888){ ?>
		<div><?php echo $data['reason']; ?><p>小程序已通过微信官方审核并且发布到线上。</p></div>
		<p><a class="button blue" href="<?php echo url::mpf('miniprogram','interfaces','process',array('type'=>'weixin')); ?>">重新发布</a></p>
		<?php }else if($data['status'] == 2 || $data['status'] == 4){ ?>
		<div>
			<?php if(is_file(ROOT_PATH.'cache/img/miniprogram/demo.jpg')){ ?>
			<ins><img rand check src="<?php echo $G['path']['relative'].'cache/img/miniprogram/demo.jpg'; ?>">体验版</ins>
			<?php } ?>
			<?php echo $data['reason']; ?><p>微信官方审核时间为7个工作日内；请耐心等待审核结果！</p><p>审核结束后微信官方会发送审核结果至小程序平台及管理员账号。</p>
		</div>
		<p><a class="button green" easy-close>关闭窗口</a></p>
		<?php }else{ ?>
		<?php if($data['status'] == 1){ ?>
		<div><?php echo $data['reason']; ?></div>
		<?php } ?>
		<p><a class="button blue" href="<?php echo url::mpf('miniprogram','interfaces','process',array('type'=>'weixin')); ?>">重新发布</a></p>
		<?php } ?>
	</div>
 </aside>
</section>
<?php 
		break;
	case 2:
?>
<section class="main">
  <aside class="status">
	<div class="import">
		<?php if($data['check']){ ?>
		<u class="s0"><i class="fa fa-check"></i></u>
		<h2><b><?php echo $data['msg']; ?></b></h2>
		<?php }else{ ?>
		<u class="error"><i class="fa fa-close"></i></u>
		<h2>错误提示： <b><?php echo $data['msg']; ?></b></h2>
		<?php } ?>
		<p><a class="button green" easy-close>关闭窗口</a></p>
	</div>
  </aside>
</section>
<?php 
		break;
	case 3:
?>
<section class="main">
	<aside class="status">
	<div class="import">
		<?php if($data['auditid']){ ?>
		<u class="s0"><i class="fa fa-check"></i></u>
		<h2><b><?php echo $data['msg']; ?></b></h2>
		<div>
			<?php if(is_file(ROOT_PATH.'cache/img/miniprogram/demo.jpg')){ ?>
			<ins><img rand check src="<?php echo $G['path']['relative'].'cache/img/miniprogram/demo.jpg'; ?>">体验版</ins>
			<?php } ?>
			<p>微信官方审核时间为7个工作日内；请耐心等待！<br/>审核结束后会发送信息至微信小程序平台及管理员账号。</p>
	    </div>
		<p><a class="button green" easy-close>关闭窗口</a></p>
		<?php }else{ ?>
		<u class="error"><i class="fa fa-close"></i></u>
		<h2>错误提示： <b><?php echo $data['msg']; ?></b></h2>
		<p><a class="button blue" href="<?php echo url::mpf('miniprogram','interfaces','audit_edit',array('type'=>'weixin')); ?>">重新提交</a></p>
		<?php } ?>
	</div>
	</aside>
</section>
<?php 
		break;
	case 4:
?>
<section class="main">
	<aside class="status">
	<div class="import">
		<?php if($data['check']){ ?>
		<u class="s0"><i class="fa fa-check"></i></u>
		<h2><b><?php echo $data['msg']; ?></b></h2>
		<?php }else{ ?>
		<u class="error"><i class="fa fa-close"></i></u>
		<h2>错误提示： <b><?php echo $data['msg']; ?></b></h2>
		<div>
			<p>请将您的“<a href="./#mpf=site" target="_blank">站点域名</a>(https://<?php echo arrExist(parse_url($G['config']['domain']),'host'); ?>)”添加到微信小程序的服务器域名中；</p>
			<p>步骤：登录微信公众平台 > 开发管理 > 开发设置 > 服务器域名 > 开始配置 > 填写域名</p>
		</div>
		<?php } ?>
		<p><a class="button green" href="https://mp.weixin.qq.com/" target="_blank">前往配置</a></p>
	</div>
	</aside>
</section>
<?php 
		break;
	case 6:
		dir::create(ROOT_PATH.'cache/img/miniprogram/demo.jpg',base64_decode(str_replace('data:image/jpg;base64,','',$data['imgsrc'])));
?>
<section class="main">
  <aside class="status">
  <div class="commit">
	<img src="<?php echo $data['imgsrc']; ?>" >
	<p>扫一扫，查看体验版</p>
	<p>请使用小程序的管理员账号扫码体验，<br>确认信息无误再提交审核！</p>
    <a class="button green" href="<?php echo url::mpf('miniprogram','interfaces','audit_edit',array('type'=>'weixin')); ?>">提交审核</a>
  </div>
  </aside>
</section>
<?php 
		break;
	case 8:
?>
<form action="<?php echo url::mpf('miniprogram','interfaces','audit'); ?>" method="post" enctype="multipart/form-data">
<section class="main form">
  <article class="hint">
    <i class="fa fa-info-circle"></i>
    <p>认真填写审核项目内容，确保所填内容真实有效；至少填写一组审核内容。</p>
	<p>审核项示例：</p>
	<p>标题：某建站公司首页；<br>标签：企业建站 SEO优化 页面设计；<br>页面：pages/home/home；<br>类目：商业服务 软件/建站/技术开发</p>
  </article>
  <aside>
	<div>
	  <?php foreach($data['ctrl'] as $v){ ?>
	  <dl>
		<dt><strong><?php echo $v['title']; ?></strong></dt>
		<dd>
			<?php echo ctrl::style($v['style'],$v['name'],null,$v['value'],$v['param'],$v['title'],$v['attribute'],$v['ctrl']); ?>
			<cite><?php echo $v['description']; ?></cite>
		</dd>
	  </dl>
	  <?php } ?>
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
<?php 
		break;
}
?>
<?php load::into('foot'); ?>