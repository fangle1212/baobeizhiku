<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('seo','rewrite','add'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=$G['config']; ?>
<section class="main form">
  <aside>
	<div>
	  <h2>
		<strong>基础信息</strong>
	  </h2>
      <dl>
        <dt>
          <strong>功能状态</strong>
        </dt>
        <dd>
          <?php echo form::radio('rewrite_open',aE('rewrite_open'),0,$G['option']['open'],null); ?>
          <cite>站点是否启用伪静态模式；启用后根目录下生成覆盖.htaccess文件，关闭则删除</cite>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>伪静态规则</strong>
        </dt>
        <dd>
          <?php echo form::textarea('rewrite_text',aE('rewrite_text'),'',array('disabled',getServer()=='iis'?'height9':'height4')); ?>
          <cite>如果打开伪静态后访问404，则手动复制该伪静态规则到服务器配置</cite>
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