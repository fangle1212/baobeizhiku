<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('safe','backup','modify'); ?>" method="post" enctype="multipart/form-data">
<section class="main table">
  <aside>
    <div>
      <table>
        <tbody>
          <tr>
            <th><?php echo form::checkbox(null,null,null,array(null)); ?></th>
            <th>文件</th>
            <th>大小</th>
            <th>时间</th>
            <th>操作</th>
          </tr>
          <?php
          foreach($data['list'] as $v){
          ?>
          <tr>
            <td width="33"><?php echo form::checkbox('id',null,null,array(str_replace(',',P,$v['name'])=>null)); ?></td>
            <td><?php echo $v['name']; ?></td>
            <td width="188"><?php echo $v['size']; ?></td>
            <td width="188"><?php echo $v['mtime']; ?></td>
            <td width="225">
              <a class="btnfa green import" url="<?php echo url::mpf('safe','backup','import',array('id'=>$v['name'])); ?>">
                <em class="fa fa-upload" title="导入"></em>
              </a>
              <a target="_blank" class="btnfa ok" href="<?php echo url::mpf('safe','backup','download',array('id'=>$v['name'])); ?>">
                <em class="fa fa-download" title="下载"></em>
              </a>
              <a class="btnfa red delete" url="<?php echo url::mpf('safe','backup','delete',array('id'=>$v['name'])); ?>">
                <em class="fa fa-trash-o" title="删除"></em>
              </a>
            </td>
          </tr>
          <?php
          }
          ?>
          <tr>
            <td colspan="5">
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
  <a class="button red delcheck" url="<?php echo url::mpf('safe','backup','delete'); ?>">
    <em class="fa fa-trash-o"></em>
    <font>批量删除</font>
  </a>
</section> 
</form>
<?php load::into('foot'); ?>