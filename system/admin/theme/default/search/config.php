<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('search','config','add'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=$data['config']; ?>
<section class="main form">
  <aside>
    <div>
      <h2>
        <strong>基础设置</strong>
      </h2>
      <dl>
        <dt>
          <strong>是否启用</strong>
        </dt>
        <dd>
          <?php echo form::radio('search_open',aE('search_open'),0,$G['option']['open']); ?>
          <cite>是否搜索功能</cite>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>搜索栏目</strong>
        </dt>
        <dd>
          <?php echo form::select('search_items',aE('search_items'),null,$data['subarr'],array('multiple')); ?>
          <cite>指定能够搜索内容的栏目</cite>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>搜索提示</strong> 
        </dt>
        <dd>
          <?php echo form::input('search_placeholder',aE('search_placeholder'),'请输入搜索关键词','text',array('width3','placeholder'=>'请输入搜索提示文字')); ?>
          <cite>搜索表单的搜索框内提示文字</cite>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>关键词字段</strong> 
        </dt>
        <dd>
          <?php echo form::input('search_keyword',aE('search_keyword'),'keyword','text',array('width2','placeholder'=>'请输入关键词字段')); ?>
          <cite>搜索表单搜索词汇的文本框字段名</cite>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>无结果提示</strong> 
        </dt>
        <dd>
          <?php echo form::input('search_null',aE('search_null'),'没有找到关于[keyword]的内容','text',array('width4','placeholder'=>'请输入提示语句')); ?>
          <cite>表单提交搜索后无结果的提示；在文本框输入[keyword]可被替换为搜索的关键词</cite>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>记录搜索</strong>
        </dt>
        <dd>
          <?php echo form::radio('search_record',aE('search_record'),0,$G['option']['open']); ?>
          <cite>是否开启记录用户的搜索历史</cite>
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