<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('consult','config','add'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=$G['config']; ?>
<section class="main form">
  <aside>
    <div>
      <h2>
        <strong>功能设置</strong>
      </h2>
      <dl>
        <dt>
          <strong>是否启用</strong>
        </dt>
        <dd>
          <?php echo form::radio('consult_open',aE('consult_open'),0,$G['option']['open'],array('color'=>'green')); ?>
          <cite>是否启用在线客服功能</cite>
        </dd>
      </dl>
      <dl <?php if(count($data['theme'])<=1) echo 'hide'; ?>>
        <dt>
          <strong>主题风格</strong>
        </dt>
        <dd>
          <?php echo form::select('consult_theme',aE('consult_theme'),null,$data['theme'],array('width'=>'20%','first')); ?>
          <cite>选择前台在线客服的主题风格样式</cite>
        </dd>
      </dl>
    </div>
  </aside>
  <aside>
    <div>
      <h2>
        <strong>样式设置</strong>
      </h2>
      <dl>
        <dt>
          <strong>显示位置</strong>
        </dt>
        <dd>
          <?php echo form::radio('consult_side',aE('consult_side'),'right',array('left'=>'左侧','right'=>'右侧'),array('no')); ?>
          <cite>在线客服在网站窗口的位置</cite>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>上方距离</strong>
        </dt>
        <dd>
          <?php echo form::input('consult_top',aE('consult_top'),'30','text',array('width1','placeholder'=>'请输入上方距离')); ?>
          <cite>在线客服距离窗口上方的距离；单位：%</cite>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>侧边距离</strong>
        </dt>
        <dd>
          <?php echo form::input('consult_right',aE('consult_right'),'15','text',array('width1','placeholder'=>'请输入侧边距离')); ?>
          <cite>在线客服距离窗口边框的距离；单位：px</cite>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>字体颜色</strong>
        </dt>
        <dd>
          <?php echo form::textarea('consult_color',aE('consult_color'),'rgb(255,255,255)',array('color')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>背景颜色</strong>
        </dt>
        <dd>
          <?php echo form::textarea('consult_bgcolor',aE('consult_bgcolor'),'rgb(0,185,255)',array('color')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>触发颜色</strong>
        </dt>
        <dd>
          <?php echo form::textarea('consult_hrcolor',aE('consult_hrcolor'),'rgb(0,155,235)',array('color')); ?>
          <cite>鼠标点击到该客服时触发的变化颜色</cite>
        </dd>
      </dl>
	  <dl>
		<dt>
		  <strong>返顶标题</strong> 
		</dt>
		<dd>
		  <?php echo form::input('consult_backtop',aE('consult_backtop'),'返顶','text',array('width2','placeholder'=>'请输入文字')); ?>
          <cite>在线客服等返回顶部的按钮文字；注：留空则不显示返顶按钮</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>联系方式</strong> 
		</dt>
		<dd>
		  <?php echo form::input('consult_title',aE('consult_title'),'联系方式','text',array('width2','placeholder'=>'请输入文字')); ?>
          <cite>默认风格不需要设置此项</cite>
		</dd>
	  </dl>
      <dl>
        <dt>
          <strong>底部内容</strong>
        </dt>
        <dd>
          <?php echo form::textarea('consult_content',aE('consult_content'),null,array('width'=>'70%','height'=>'500','ueditor')); ?>
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