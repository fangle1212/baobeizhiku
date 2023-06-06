<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('complex','complex','modify'); ?>" method="post" enctype="multipart/form-data">
<section class="main table">
  <aside>
    <div>
      <div class="head">      
        <a class="button green add">
          <em class="fa fa-plus"></em>
          <font>添加表单</font>
        </a>
      </div>
      <table>
        <tbody>
          <tr>
            <th><?php echo form::checkbox(null,null,null,array(null)); ?></th> 
            <th>项目标题</th>
            <th>表单类型</th>
            <th>项目说明</th>
            <?php if($data['subarr']){ ?>
			<th>所属栏目</th>
            <?php } ?>
            <th>参数</th>
            <th>操作</th>
          </tr>
          <?php
          foreach($data['list'] as $v){
          ?>
          <tr>
            <td width="33"><?php echo form::checkbox('id',null,null,array($v['id']=>null)); ?></td>
            <td width="188"><?php echo form::input('title'.$v['id'],$v['title'],null,'text',array('required','placeholder'=>'请输入项目标题')); ?></td>
            <td width="188"><?php echo form::select('style'.$v['id'],$v['style'],null,$data['style'],array('first')); ?></td>
            <td><?php echo form::input('description'.$v['id'],$v['description'],null,'text',array('placeholder'=>'请输入项目说明')); ?></td>
            <?php if($data['subarr']){ ?>
            <td width="188"><?php echo form::select('items'.$v['id'],$v['items'],null,$data['subarr'],array()); ?></td>
            <?php } ?>
            <td width="78">
              <a setup class="button green tfa">
                <em class="fa fa-pencil"></em>
                <font>配置</font>
              </a>
              <section class="setup">
                <div class="box W600">
                  <div class="close"><em class="fa fa-times"></em></div>
                  <div class="move"><h2>表单类型为单选、多选的参数配置</h2></div>
                  <div class="content">
                    <?php echo form::textarea('param'.$v['id'],$v['param'],null,array('param')); ?>
                  </div>
                </div>
              </section>
            </td>
            <td width="155">
              <a class="btnfa blue move">
                <em class="fa fa-arrows" title="移动"></em>
                <?php echo form::input('sort'.$v['id'],$v['sort'],null,'hidden',null,false); ?>
              </a>
              <a class="btnfa red delete" url="<?php echo url::mpf('complex','complex','delete',array('id'=>$v['id'])); ?>">
                <em class="fa fa-trash-o" title="删除"></em>
              </a>
            </td>
          </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </aside>
</section>
<section class="refer">
  <button class="button ok" type="submit">
    <em class="fa fa-floppy-o"></em>
    <font>保存</font>
  </button>
  <a class="button red delcheck" url="<?php echo url::mpf('complex','complex','delete'); ?>">
    <em class="fa fa-trash-o"></em>
    <font>批量删除</font>
  </a>
</section> 
</form>
<table hidden>
  <tbody>
    <tr>
      <td width="33"><?php echo form::checkbox('id',null,null,array('{Rep}'=>null)); ?></td>
      <td width="188"><?php echo form::input('title{Rep}',null,null,'text',array('required','placeholder'=>'请输入项目标题')); ?></td>
      <td width="188"><?php echo form::select('style{Rep}',null,null,$data['style'],array('first')); ?></td>
      <td><?php echo form::input('description{Rep}',null,null,'text',array('placeholder'=>'请输入项目说明')); ?></td>
      <?php if($data['subarr']){ ?>
	  <td width="188"><?php echo form::select('items{Rep}',$G['get']['items'],null,$data['subarr'],array()); ?></td>
      <?php } ?>
      <td width="78">
        <a setup class="button green tfa">
          <em class="fa fa-pencil"></em>
          <font>配置</font>
        </a>
        <section class="setup">
          <div class="box W600">
            <div class="close"><em class="fa fa-times"></em></div>
            <div class="move"><h2>表单类型为单选、多选的参数配置</h2></div>
            <div class="content">
              <?php echo form::textarea('param{Rep}',null,null,array('param')); ?>
            </div>
          </div>
        </section>
      </td>
      <td width="155">
        <a class="btnfa blue move">
          <em class="fa fa-arrows" title="移动"></em>
          <?php echo form::input('sort{Rep}',999,null,'hidden',null,false); ?>
        </a>
        <a class="btnfa red deltr" >
          <em class="fa fa-trash-o" title="删除"></em>
        </a>
      </td>
    </tr>
  </tbody>
</table>
<?php load::into('foot'); ?>