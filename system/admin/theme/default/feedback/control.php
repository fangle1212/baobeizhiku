<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('feedback','control','modify'); ?>" method="post" enctype="multipart/form-data">
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
            <th>表单标题</th>
            <th>表单类型</th>
            <th>表单提示</th>
            <th>表单描述</th>
            <th>表单参数</th>
            <th>必填</th>
            <th>操作</th>
          </tr>
          <?php
          foreach($data['list'] as $v){
          ?>
          <tr>
            <td width="33"><?php echo form::checkbox('id',null,null,array($v['id']=>null)); ?></td>
            <td><?php echo form::input('title'.$v['id'],$v['title'],null,'text'); ?></td>
            <td><?php echo form::select('style'.$v['id'],$v['style'],null,$G['option']['form']); ?></td>
            <td><?php echo form::input('prompt'.$v['id'],$v['prompt'],null,'text',null); ?></td>
            <td><?php echo form::input('description'.$v['id'],$v['description'],null,'text',null); ?></td>
            <td width="108">
              <a setup class="button green tfa">
                <em class="fa fa-pencil"></em>
                <font>配置参数</font>
              </a>
              <section class="setup">
                <div class="box W600">
                  <div class="close"><em class="fa fa-times"></em></div>
                  <div class="move"><h2>类型为下拉、单选、多选的参数配置</h2></div>
                  <div class="content">
                    <?php echo form::textarea('param'.$v['id'],$v['param'],null,array('param')); ?>
                  </div>
                </div>
              </section>
            </td>
            <td width="58"><?php echo form::checkbox('must'.$v['id'],$v['must'],null,array(1=>null)); ?></td>
            <td width="155">
              <a class="btnfa blue move">
                <em class="fa fa-arrows" title="移动"></em>
                <?php echo form::input('sort'.$v['id'],$v['sort'],null,'hidden',null,false); ?>
              </a>
              <a class="btnfa red delete" url="<?php echo url::mpf('feedback','control','delete',array('id'=>$v['id'])); ?>">
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
  <a class="button red delcheck" url="<?php echo url::mpf('feedback','control','delete'); ?>">
    <em class="fa fa-trash-o"></em>
    <font>批量删除</font>
  </a>
</section> 
</form>
<table hidden>
  <tbody>
    <tr>
      <td width="33"><?php echo form::checkbox('id',null,null,array('{Rep}'=>null)); ?></td>
      <td><?php echo form::input('title{Rep}',null,null,'text'); ?></td>
      <td><?php echo form::select('style{Rep}',null,null,$G['option']['form']); ?></td>
      <td><?php echo form::input('prompt{Rep}',null,null,'text',null); ?></td>
      <td><?php echo form::input('description{Rep}',null,null,'text',null); ?></td>
      <td width="128">
        <a setup class="button green">
          <em class="fa fa-pencil"></em>
          <font>配置参数</font>
        </a>
        <section class="setup">
          <div class="box W600">
            <div class="close"><em class="fa fa-times"></em></div>
            <div class="move"><h2>类型为下拉、单选、多选的参数配置</h2></div>
            <div class="content">
              <?php echo form::textarea('param{Rep}',null,null,array('param')); ?>
            </div>
          </div>
        </section>
      </td>
      <td width="48"><?php echo form::checkbox('must{Rep}',null,null,array(1=>null)); ?></td>
      <td width="155">
        <a class="btnfa blue move">
          <em class="fa fa-arrows" title="移动"></em>
          <?php echo form::input('sort{Rep}',999,null,'hidden',null,false); ?>
        </a>
        <a class="btnfa red deltr">
          <em class="fa fa-trash-o" title="删除"></em>
        </a>
      </td>
    </tr>
  </tbody>
</table>
<?php load::into('foot'); ?>