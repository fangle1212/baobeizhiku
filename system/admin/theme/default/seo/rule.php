<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('seo','rule','add'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=$G['config']; ?>
<section class="main form tab">
  <aside>
	<div>
	  <h2>
		<strong>URL设置</strong>
	  </h2>
      <dl>
        <dt>
          <strong>静态后缀</strong>
        </dt>
        <dd>
          <?php echo form::input('rule_extension',aE('rule_extension'),'.html','text',array('required','width1')); ?>
          <cite>开启伪静态后，网站地址静态文件的后缀名称</cite>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>分页规则</strong>
        </dt>
        <dd>
          <?php echo form::input('rule_pages',aE('rule_pages'),'-page[pages]','text',array('required','width2')); ?>
          <cite>开启伪静态后，站点页面地址中分页标签部分的替换规则</cite>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>语言规则</strong>
        </dt>
        <dd>
          <?php echo form::input('rule_lang',aE('rule_lang'),'-[lang]','text',array('required','width2')); ?>
          <cite>开启伪静态后，站点页面地址中语言标签部分的替换规则</cite>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>语言标识</strong>
        </dt>
        <dd>
          <?php echo form::radio('rule_lang_sign',aE('rule_lang_sign'),0,$G['option']['open']); ?>
          <cite>开启伪静态后，站点页面地址中语言标签部分是否使用各语言的“语言标识”</cite>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>根栏目名</strong>
        </dt>
        <dd>
          <?php echo form::radio('rule_filename',aE('rule_filename'),0,$G['option']['open']); ?>
          <cite>开启伪静态后，根栏目（栏目地址以/斜杆为结尾）是否需要带文件名；例：/a/ 会展示为 /a/index.html</cite>
        </dd>
      </dl>
	</div>
  </aside>
  
  <aside class="rule">
	<div>
	  <h2>
		<strong>URL规则</strong>
	  </h2>
      <dl<?php if($data[1]!=$G['rule'][1]) echo ' class="on"'; ?>>
        <dt>
          <strong data="首页页面">首页</strong>
        </dt>
        <dd>
          <a class="rule" href="javascript:;" data="<?php echo quotesFilter($G['rule'][1]); ?>">恢复默认</a>
          <?php echo form::input('rule[1]',$data[1],null,'text'); ?>
          <cite>站点首页伪静态文件名称</cite>
        </dd>
      </dl>
      <dl<?php if($data[2]!=$G['rule'][2]) echo ' class="on"'; ?>>
        <dt>
          <strong data="栏目地址以/斜杆为结尾的，不含文件名或参数的栏目页面">栏目页</strong>
        </dt>
        <dd>
          <a class="rule" href="javascript:;" data="<?php echo quotesFilter($G['rule'][2]); ?>">恢复默认</a>
          <?php echo form::input('rule[2]',$data[2],null,'text'); ?>
          <cite>规则参数：栏目文件夹 [folder]</cite>
        </dd>
      </dl>
      <dl<?php if($data[3]!=$G['rule'][3]) echo ' class="on"'; ?>>
        <dt>
          <strong data="简介、反馈、自定义模块的单页面">单页</strong>
        </dt>
        <dd>
          <a class="rule" href="javascript:;" data="<?php echo quotesFilter($G['rule'][3]); ?>">恢复默认</a>
          <?php echo form::input('rule[3]',$data[3],null,'text'); ?>
          <cite>规则参数：栏目文件夹 [folder] 、 栏目序号 [items]</cite>
        </dd>
      </dl>
      <dl<?php if($data[4]!=$G['rule'][4]) echo ' class="on"'; ?>>
        <dt>
          <strong data="新闻、产品、图片、下载模块的内容列表页面">列表页</strong>
        </dt>
        <dd>
          <a class="rule" href="javascript:;" data="<?php echo quotesFilter($G['rule'][4]); ?>">恢复默认</a>
          <?php echo form::input('rule[4]',$data[4],null,'text'); ?>
          <cite>规则参数：栏目文件夹 [folder] 、 栏目序号 [items]</cite>
        </dd>
      </dl>
      <dl<?php if($data[5]!=$G['rule'][5]) echo ' class="on"'; ?>>
        <dt>
          <strong data="新闻、产品、图片、下载模块的内容详情页面">详情页</strong>
        </dt>
        <dd>
          <a class="rule" href="javascript:;" data="<?php echo quotesFilter($G['rule'][5]); ?>">恢复默认</a>
          <?php echo form::input('rule[5]',$data[5],null,'text'); ?>
          <cite>规则参数：栏目文件夹 [folder] 、 内容序号 [id]</cite>
        </dd>
      </dl>
      <dl<?php if($data[6]!=$G['rule'][6]) echo ' class="on"'; ?>>
        <dt>
          <strong data="单个tag标签的列表展示页面">标签页</strong>
        </dt>
        <dd>
          <a class="rule" href="javascript:;" data="<?php echo quotesFilter($G['rule'][6]); ?>">恢复默认</a>
          <?php echo form::input('rule[6]',$data[6],null,'text'); ?>
          <cite>规则参数：栏目文件夹 [folder] 、 Tag标签 [tag]</cite>
        </dd>
      </dl>
      <dl<?php if($data[7]!=$G['rule'][7]) echo ' class="on"'; ?>>
        <dt>
          <strong data="定义静态名称的各模块栏目和新闻、产品、图片、下载模块的内容详情页面">静态页</strong>
        </dt>
        <dd>
          <a class="rule" href="javascript:;" data="<?php echo quotesFilter($G['rule'][7]); ?>">恢复默认</a>
          <?php echo form::input('rule[7]',$data[7],null,'text'); ?>
          <cite>规则参数：栏目文件夹 [folder] 、 静态名称 [static]</cite>
        </dd>
      </dl>
      <dl<?php if($data[8]!=$G['rule'][8]) echo ' class="on"'; ?>>
        <dt>
          <strong data="会员中心的登录页面和注册页面">登录页</strong>
        </dt>
        <dd>
          <a class="rule" href="javascript:;" data="<?php echo quotesFilter($G['rule'][8]); ?>">恢复默认</a>
          <?php echo form::input('rule[8]',$data[8],null,'text'); ?>
          <cite>规则参数：栏目文件夹 [folder] 、 类型名称 [action]</cite>
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