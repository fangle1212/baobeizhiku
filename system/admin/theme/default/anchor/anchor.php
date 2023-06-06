<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('anchor','anchor','modify'); ?>" method="post" enctype="multipart/form-data">
<section class="main table">
  <aside>
    <div>
      <div class="head">      
        <a class="button green" easy url="<?php echo url::mpf('anchor','anchor','edit'); ?>">
          <em class="fa fa-plus"></em>
          <font>添加内容</font>
        </a>
      </div>
      <table>
        <tbody>
          <tr>
            <th><?php echo form::checkbox(null,null,null,array(null)); ?></th>
            <th>原文本</th>
            <th>替换为</th>
            <th>title</th>
            <th>链接地址</th>
            <th>nofollow</th>
            <th>新窗口</th>
            <th>启用</th> 
            <th>操作</th>
          </tr>
          <?php
          foreach($data as $v){
          ?>
          <tr>
            <td width="33"><?php echo form::checkbox('id',null,null,array($v['id']=>null)); ?></td>
            <td><?php echo $v['old']; ?></td>
            <td><?php echo $v['new']; ?></td>
            <td><?php echo $v['title']; ?></td>
            <td><?php echo $v['link']; ?></td>
            <td width="88">
			  <?php echo form::radio("nofollow{$v['id']}",$v['nofollow'],1,$G['option']['is'],array('color'=>'red')); ?>
            </td>
            <td width="88">
			  <?php echo form::radio("target{$v['id']}",$v['target'],0,$G['option']['is']); ?>
            </td>
            <td width="88">
			  <?php echo form::radio("open{$v['id']}",$v['open'],1,$G['option']['is'],array('color'=>'green')); ?>
            </td>
            <td width="155">
              <a class="btnfa blue" easy url="<?php echo url::mpf('anchor','anchor','edit',array('id'=>$v['id'])); ?>">
                <em class="fa fa-pencil" title="修改"></em>
              </a>
              <a class="btnfa red delete" url="<?php echo url::mpf('anchor','anchor','delete',array('id'=>$v['id'])); ?>">
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
  <a class="button red delcheck" url="<?php echo url::mpf('anchor','anchor','delete'); ?>">
    <em class="fa fa-trash-o"></em>
    <font>批量删除</font>
  </a>
</section> 
</form>
<?php load::into('foot'); ?>