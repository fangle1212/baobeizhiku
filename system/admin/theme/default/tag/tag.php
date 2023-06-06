<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('tag','tag','modify'); ?>" method="post" enctype="multipart/form-data">
<section class="main table">
  <aside>
    <div>
      <div class="head">
        <a class="button green" easy width="800" height="430" url="<?php echo url::mpf('tag','tag','edit'); ?>">
          <em class="fa fa-plus"></em>
          <font>添加标签</font>
        </a>
      </div>
      <table>
        <tbody>
          <tr>
            <th><?php echo form::checkbox(null,null,null,array(null)); ?></th>
            <th>标签名称</th>
            <th>路径名称</th>
            <th>操作</th>
          </tr>
          <?php
          foreach($data['list'] as $v){
          ?>
          <tr>
            <td width="33"><?php echo form::checkbox('id',null,null,array($v['id']=>null)); ?></td>
            <td><?php echo $v['title']; ?></td>
            <td><?php echo $v['name']?$v['name']:$v['id']; ?></td>
            <td width="155">
              <a class="btnfa blue" easy name="修改标签" width="800" height="430" url="<?php echo url::mpf('tag','tag','edit',array('id'=>$v['id'])); ?>">
                <em class="fa fa-pencil" title="修改"></em>
              </a>
              <a class="btnfa red delete" url="<?php echo url::mpf('tag','tag','delete',array('id'=>$v['id'])); ?>">
                <em class="fa fa-trash-o" title="删除"></em>
              </a>
            </td>
          </tr>
          <?php
          }
          ?>
          <tr>
            <td colspan="8">
              <ol class="pages">
                <li><a href="<?php echo $data['pages']['first']['url']; ?>"><i class="fa fa-angle-double-left"></i></a></li>
                <li><a href="<?php echo $data['pages']['prev']['url']; ?>"><i class="fa fa-angle-left"></i></a></li>
                <?php foreach($data['pages']['list'] as $v){ ?>
                <li><a href="<?php echo $v['url']; ?>" <?php echo $v['current']?' class="on"':''; ?>><?php echo $v['number']; ?></a></li>
                <?php } ?>
                <li><a href="<?php echo $data['pages']['next']['url']; ?>"><i class="fa fa-angle-right"></i></a></li>
                <li><a href="<?php echo $data['pages']['last']['url']; ?>"><i class="fa fa-angle-double-right"></i></a></li>
              </ol>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </aside>
</section>

<section class="refer">
  <a class="button red delcheck" url="<?php echo url::mpf('tag','tag','delete'); ?>">
    <em class="fa fa-trash-o"></em>
    <font>批量删除</font>
  </a>
</section> 
</form>
<?php load::into('foot'); ?>